<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadFotoRequest;

class UploadFotoController extends Controller
{
    public function upload($type, UploadFotoRequest $request)
    {
    	$foto = $request->file('upload-foto-file');

    	$clientName = str_replace($foto->getClientOriginalExtension(), "", $foto->getClientOriginalName());
    	$newFotoName = str_slug($clientName, '_') . '-' . time() . '.' . $foto->getClientOriginalExtension();
    	$tempPath = public_path() . '/uploads/temp/fotos';

        if ($type == 'equipe') {
            $tempPath .= '/equipes';
        } else {
            $tempPath .= '/robos';
        }

    	$fullPath = $tempPath . '/' . $newFotoName;
    	$publicPath = str_replace(public_path(), "", $fullPath);
    	File::move($foto->path(), $fullPath);

    	return response([
    	    'foto_public_path' => $publicPath
        ], 200);
    }
}
