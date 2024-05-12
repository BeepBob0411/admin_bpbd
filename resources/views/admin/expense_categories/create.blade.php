@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.expense-category.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.expense_categories.store'], 'enctype' => 'multipart/form-data']) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('nama', trans('quickadmin.expense-category.fields.nama').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('nama', old('nama'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('nama'))
                        <p class="help-block">
                            {{ $errors->first('nama') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('telepon', trans('quickadmin.expense-category.fields.telepon').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('telepon', old('telepon'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('telepon'))
                        <p class="help-block">
                            {{ $errors->first('telepon') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('nama_pelapor', trans('quickadmin.expense-category.fields.nama_pelapor').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('nama_pelapor', old('nama_pelapor'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('nama_pelapor'))
                        <p class="help-block">
                            {{ $errors->first('nama_pelapor') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('foto_bencana', trans('quickadmin.expense-category.fields.foto_bencana').'*', ['class' => 'control-label']) !!}
                    {!! Form::file('foto_bencana', ['class' => 'form-control', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('foto_bencana'))
                        <p class="help-block">
                            {{ $errors->first('foto_bencana') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('jenis_bencana', trans('quickadmin.expense-category.fields.jenis_bencana').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('jenis_bencana', old('jenis_bencana'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('jenis_bencana'))
                        <p class="help-block">
                            {{ $errors->first('jenis_bencana') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('lokasi_bencana', trans('quickadmin.expense-category.fields.lokasi_bencana').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('lokasi_bencana', old('lokasi_bencana'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('lokasi_bencana'))
                        <p class="help-block">
                            {{ $errors->first('lokasi_bencana') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('keterangn_bencana', trans('quickadmin.expense-category.fields.keterangn_bencana').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('keterangn_bencana', old('keterangn_bencana'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('keterangn_bencana'))
                        <p class="help-block">
                            {{ $errors->first('keterangn_bencana') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('waktu_pengriman_laporan', trans('quickadmin.expense-category.fields.waktu_pengriman_laporan').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('waktu_pengriman_laporan', old('waktu_pengriman_laporan'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('waktu_pengriman_laporan'))
                        <p class="help-block">
                            {{ $errors->first('waktu_pengriman_laporan') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop
