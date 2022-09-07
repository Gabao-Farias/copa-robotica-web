<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Equipe;
use App\Escola;
use App\Integrante;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditarEquipeRequest;
use App\Http\Requests\Admin\CadastrarEquipeRequest;

class EquipesController extends Controller
{
    public function index()
    {
        $equipes = Equipe::orderBy('nome', 'asc')->paginate(5);

        $links = $equipes->links();

        return view('admin.equipes.index', [
            'equipes' => $equipes,
            'links' => $links
        ]);
    }

    public function buscar($busca)
    {
        $equipes = Equipe::where('nome', 'like', '%'.$busca.'%')
                ->orWhereHas('escola', function($query) use ($busca) {
                    $query->where('nome', 'like', '%'.$busca.'%');
                })
                ->orWhereHas('integrantes', function($query) use ($busca) {
                    $query->where('nome', 'like', '%'.$busca.'%');
                })
                ->orderBy('nome', 'asc')
                ->paginate(5);

        $links = $equipes->links();

        return view('admin.equipes.index', compact('equipes', 'links', 'busca'));
    }

    public function create()
    {
        $countIntegrantes = count(old('integrantes'));
        $escolas = Escola::orderBy('nome', 'asc')->get()->pluck('nome', 'id');

        return view('admin.equipes.create', compact('countIntegrantes', 'escolas'));
    }

    public function store(CadastrarEquipeRequest $request)
    {
        $nome = $request->input('nome');

        if ($request->has('foto_equipe_path')) {
            $fotoEquipePath = $this->resolveUploadedFile($request->input('foto_equipe_path'), 'equipe');
        } else {
            $fotoEquipePath = null;
        }

        if ($request->has('foto_robo_path')) {
            $fotoRoboPath = $this->resolveUploadedFile($request->input('foto_robo_path'), 'robo');
        } else {
            $fotoRoboPath = null;
        }

        $lastCodigo = (int) Equipe::orderBy('codigo', 'desc')->first()->codigo;

        $equipe = Equipe::create([
            'nome' => $nome,
            'escola_id' => $request->input('escola_id'),
            'presente' => $request->input('presente'),
            'foto_equipe_path' => $fotoEquipePath,
            'foto_robo_path' => $fotoRoboPath,
            'codigo' => ++$lastCodigo
        ]);

        $integrantes = $request->input('integrantes');

        foreach ($integrantes as $integrante)
        {
            $equipe->integrantes()->save(new Integrante([
                'nome' => $integrante['nome'],
                'capitao' => array_key_exists('capitao', $integrante)
            ]));
        }

        flash()->success("A equipe <strong>{$nome}</strong> foi cadastrada com sucesso!");

        return redirect(url('admin/equipes'));
    }

    public function edit(Equipe $equipe)
    {
        $countIntegrantes = $equipe->integrantes->count();
        $escolas = Escola::orderBy('nome', 'asc')->get()->pluck('nome', 'id');

        return view('admin.equipes.edit', compact('equipe', 'countIntegrantes', 'escolas'));
    }

    public function update(EditarEquipeRequest $request, Equipe $equipe)
    {
        $countIntegrantes = count(old('integrantes'));
        
        $nome = $request->input('nome');

        $fotoEquipePath = $equipe->foto_equipe_path;
        $fotoRoboPath = $equipe->foto_robo_path;

        if (preg_match('/\/temp\//', $request->input('foto_equipe_path'))) {
            $fotoEquipePath = $this->resolveUploadedFile($request->input('foto_equipe_path'), 'equipe');
        }

        if (preg_match('/\/temp\//', $request->input('foto_robo_path'))) {
            $fotoRoboPath = $this->resolveUploadedFile($request->input('foto_robo_path'), 'robo');
        }

        $equipe->update([
            'nome' => $nome,
            'escola_id' => $request->input('escola_id'),
            'presente' => $request->input('presente'),
            'foto_equipe_path' => $fotoEquipePath,
            'foto_robo_path' => $fotoRoboPath
        ]);

        $integrantesCadastrados = $equipe->integrantes;
        $integrantesForm = collect($request->input('integrantes'));

        //Deletar integrantes que não estão mais presentes
        foreach ($integrantesCadastrados as $integrante)
        {
            if (! in_array($integrante['id'], $integrantesForm->pluck('id')->toArray())) {
                $integrante->delete();
            }
        }

        //Editar dados dos integrantes
        foreach ($integrantesForm->toArray() as $integrante)
        {
            //Ja foi cadastrado?
            if (empty($integrante['id'])) {
                $equipe->integrantes()->save(new Integrante([
                    'nome' => $integrante['nome'],
                    'capitao' => array_key_exists('capitao', $integrante)
                ]));
            } else {
                Integrante::where('id', $integrante['id'])->update([
                    'nome' => $integrante['nome'],
                    'capitao' => array_key_exists('capitao', $integrante)
                ]);
            }
        }

        flash()->success("Os dados da equipe <strong>{$equipe->nome}</strong> foram atualizados com sucesso!");
        return redirect(url('admin/equipes'));
    }

    public function delete(Equipe $equipe)
    {
        $equipeBackup = $equipe;
        $equipe->delete();

        $pathFotoEquipe = public_path() . '/' . $equipeBackup->foto_equipe_path;
        $pathFotoRobo = public_path() . '/' . $equipeBackup->foto_robo_path;

        if (! is_null($pathFotoEquipe) && file_exists(public_path().'/'.$pathFotoEquipe)) {
            unlink($pathFotoEquipe);
        }

        if (! is_null($pathFotoEquipe) && file_exists(public_path().'/'.$pathFotoEquipe)) {
            unlink($pathFotoRobo);
        }

        flash()->success("A equipe <strong>{$equipeBackup->nome}</strong> foi deletada com sucesso!");

        return redirect(url('admin/equipes'));
    }

    protected function resolveUploadedFile($path, $type)
    {
        $baseName = basename($path);
        $dir = ($type == 'equipe') ? 'equipes' : 'robos';
        $newPath = 'uploads/fotos/' . $dir . '/' . $baseName;
        File::move(public_path() . $path, public_path() . '/' . $newPath);

        return $newPath;
    }
}
