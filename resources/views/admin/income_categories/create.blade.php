@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.income-category.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.income_categories.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('nama_bencana', trans('quickadmin.income-category.fields.nama_bencana').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('nama_bencana', old('nama_bencana'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('nama_bencana'))
                        <p class="help-block">
                            {{ $errors->first('nama_bencana') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('tanggal_kejadian', trans('quickadmin.income-category.fields.tanggal_kejadian').'*', ['class' => 'control-label']) !!}
                    {!! Form::date('tanggal_kejadian', old('tanggal_kejadian'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('tanggal_kejadian'))
                        <p class="help-block">
                            {{ $errors->first('tanggal_kejadian') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('waktu_kejadian', trans('quickadmin.income-category.fields.waktu_kejadian').'*', ['class' => 'control-label']) !!}
                    {!! Form::time('waktu_kejadian', old('waktu_kejadian'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('waktu_kejadian'))
                        <p class="help-block">
                            {{ $errors->first('waktu_kejadian') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('lokasi_kejadian', trans('quickadmin.income-category.fields.lokasi_kejadian').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('lokasi_kejadian', old('lokasi_kejadian'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('lokasi_kejadian'))
                        <p class="help-block">
                            {{ $errors->first('lokasi_kejadian') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('gambar_berita', trans('quickadmin.income-category.fields.gambar_berita'), ['class' => 'control-label']) !!}
                    {!! Form::text('gambar_berita', old('gambar_berita'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('gambar_berita'))
                        <p class="help-block">
                            {{ $errors->first('gambar_berita') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('deskripsi_berita', trans('quickadmin.income-category.fields.deskripsi_berita'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('deskripsi_berita', old('deskripsi_berita'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('deskripsi_berita'))
                        <p class="help-block">
                            {{ $errors->first('deskripsi_berita') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop
