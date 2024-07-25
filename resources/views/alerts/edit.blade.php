@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="content">
        <div class="container-fluid">
            @include('partials.alerts')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <form method="post" role="form" action="{{ route('alert.patch', $alert->id) }}" data-parsley-validate>
                            <div class="card-body">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Nome</label>
                                    <input type="text" value="{{$alert->name}}" class="form-control" id="name" name="name"
                                        placeholder="Nome" required>
                                    @if ($errors->has('name'))
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="row"> 
                                    <div class="col-2">
                                        <div class="form-group{{ $errors->has('param') ? ' has-error' : '' }}">
                                            <label for="param">Parâmetro</label>
                                            <select class="form-control" id="param" name="param" required>
                                            @foreach($params as $param)
                                            <option value="{{$param->id}}" @if($param->id == $alert->param->id) selected @endif>{{$param->name}}</option>
                                            @endforeach
                                            </select>
                                            @if ($errors->has('param'))
                                                <p class="text-danger">{{ $errors->first('param') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group{{ $errors->has('min') ? ' has-error' : '' }}">
                                            <label for="min">Valor Mínimo</label>
                                            <input type="text" value="{{$alert->min}}" class="form-control" id="min" name="min"
                                                placeholder="Valor Minimo">
                                            @if ($errors->has('min'))
                                                <p class="text-danger">{{ $errors->first('min') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group{{ $errors->has('max') ? ' has-error' : '' }}">
                                            <label for="max">Valor Máximo</label>
                                            <input type="text" value="{{$alert->max}}" class="form-control" id="max" name="max"
                                                placeholder="Valor Maximo">
                                            @if ($errors->has('max'))
                                                <p class="text-danger">{{ $errors->first('max') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group{{ $errors->has('downtime') ? ' has-error' : '' }}">
                                            <label for="downtime">Downtime(minutos)</label>
                                            <input type="text" value="{{$alert->downtime}}" class="form-control" id="downtime" name="downtime" placeholder="Downtime">
                                            @if ($errors->has('downtime'))
                                                <p class="text-danger">{{ $errors->first('downtime') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-6">
                                        <div class="form-check{{ $errors->has('enabled') ? ' has-error' : '' }}">
                                            <input type="checkbox"class="form-check-input" id="enabled" name="enabled" value="1" @if($alert->enabled) checked @endif>
                                            <label class="form-check-label" for="enabled">Ativo</label>
                                            <small id="emailHelp" class="form-text text-muted">Define o estado do alerta</small>
                                            @if ($errors->has('enabled'))
                                                <p class="text-danger">{{ $errors->first('enabled') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <small id="emailHelp" class="form-text text-muted">Os valores mínimos e máximos podem ter até duas casas decimais</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                @csrf
                                @method('PATCH')
                                <button id="submit" type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
