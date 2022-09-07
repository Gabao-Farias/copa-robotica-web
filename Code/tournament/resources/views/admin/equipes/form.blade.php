<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
    <label for="nome" class="col-md-4 control-label">Nome da Equipe</label>

    <div class="col-md-6">
        {!! Form::text('nome', null, ['class' => 'form-control', 'required', 'autofocus', 'placeholder' => 'Nome da equipe.', 'autocomplete' => 'off']) !!}

        @if ($errors->has('nome'))
        <span class="help-block">
            <strong>{{ $errors->first('nome') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('escola_id') ? ' has-error' : '' }}">
    <label for="text" class="col-md-4 control-label">Nome da Escola</label>

    <div class="col-md-6">
        {!! Form::select('escola_id', $escolas, null, ['class' => 'form-control', 'required']) !!}

        @if ($errors->has('escola_id'))
        <span class="help-block">
            <strong>{{ $errors->first('escola_id') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('presente') ? ' has-error' : '' }}">
    <label for="text" class="col-md-4 control-label">Presente</label>

    <div class="col-md-6">
        {!! Form::select('presente', [1 => 'Sim', 0 => 'Não'], null, ['class' => 'form-control']) !!}
        <p class="text-muted">Indica se a escola está presente no torneio</p>

        @if ($errors->has('presente'))
        <span class="help-block">
            <strong>{{ $errors->first('presente') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('foto_equipe_path') ? ' has-error' : '' }}">
    <label for="foto" class="col-md-4 control-label">Foto da Equipe</label>

    <div class="col-md-6">
        {!! Form::hidden('foto_equipe_path', null, ['id' => 'foto_equipe_path']) !!}

        <button class="btn btn-info fileinput-button upload-foto-equipe" id="equipe">
            <i class="glyphicon glyphicon-upload"></i>
            <span>Upload</span>
            
            {!! Form::file('upload-foto-file') !!}
        </button>
        
        <div id="progress-equipe" class="progress" style="margin-top: 5px; display: none;">
            <div class="progress-bar progress-bar-info"></div>
        </div>

        <div id="upload-status-equipe" style="display: none;">
            
        </div>

        <div class="foto-preview-equipe"></div>

        @if ($errors->has('foto_equipe_path'))
            <span class="help-block">
                <strong>{{ $errors->first('foto_equipe_path') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('foto_robo_path') ? ' has-error' : '' }}">
    <label for="foto" class="col-md-4 control-label">Foto do Robô</label>

    <div class="col-md-6">
        {!! Form::hidden('foto_robo_path', null, ['id' => 'foto_robo_path']) !!}

        <button class="btn btn-info fileinput-button upload-foto-robo">
            <i class="glyphicon glyphicon-upload"></i>
            <span>Upload</span>

            {!! Form::file('upload-foto-file') !!}
        </button>

        <div id="progress-robo" class="progress" style="margin-top: 5px; display: none;">
            <div class="progress-bar progress-bar-info"></div>
        </div>

        <div id="upload-status-robo" style="display: none;">

        </div>

        <div class="foto-preview-robo"></div>

        @if ($errors->has('foto_robo_path'))
            <span class="help-block">
                <strong>{{ $errors->first('foto_robo_path') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="text" class="col-md-4 control-label">Integrantes da Equipe</label>

    <div class="col-md-6">
        <div id="integrantes-container">
            @for ($i = 0; $i < max($countIntegrantes, 1); $i++)
                <div class="integrante">
                    <div class="row">
                        <div class="col-xs-7">
                            @if ($mode == 'edit')
                                {!! Form::hidden('integrantes[' . $i . '][id]', null, ['class' => 'integrante-id']) !!}
                            @endif
                            {!! Form::text('integrantes[' . $i . '][nome]', null, ['class' => 'form-control integrante-input', 'placeholder' => 'Digite o nome do integrante...', 'autocomplete' => 'off']) !!}
                        </div>
                        <div class="col-xs-3">
                            <label name="capitao">
                                {!! Form::radio('integrantes[' . $i . '][capitao]', 1, (int)$mode == 'create', ['class' => 'set-capitao']) !!}
                                Capitão
                            </label>
                        </div>
                        <div class="col-xs-2">
                            <span class="glyphicon glyphicon-remove text-danger remove-integrante" title="Remover" data-toggle="tooltip"></span>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <div class="form-group text-center" style="margin-top: 10px;">
            <button type="button" class="btn btn-info" id="adicionar-integrante">
                <span class="glyphicon glyphicon-plus"></span> 
                Adicionar Integrante
            </button>
        </div>
    </div>
</div>

<div class="form-group text-center">
    <button type="submit" class="btn btn-primary">
        {{ isset($button) ? $button : 'Cadastrar' }}
    </button>
</div>