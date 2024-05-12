@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.expense.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.expenses.store'], 'id' => 'expense']) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('nama', 'Nama*', ['class' => 'control-label']) !!}
                    {!! Form::text('nama', old('nama'), ['class' => 'form-control', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('nama'))
                        <p class="text-danger">
                            {{ $errors->first('nama') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('nomor_darurat', 'Nomor Darurat*', ['class' => 'control-label']) !!}
                    {!! Form::text('nomor_darurat', old('nomor_darurat'), ['class' => 'form-control', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('nomor_darurat'))
                        <p class="text-danger">
                            {{ $errors->first('nomor_darurat') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('gambar', 'Gambar*', ['class' => 'control-label']) !!}
                    {!! Form::file('gambar', ['class' => 'form-control', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('gambar'))
                        <p class="text-danger">
                            {{ $errors->first('gambar') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    <script>
        $('.date').datepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}"
        });
    </script>

@stop
