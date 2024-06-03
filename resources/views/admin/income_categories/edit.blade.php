@extends('layouts.app')

@section('content')

<h3 class="page-title">@lang('quickadmin.income-category.title')</h3>

{!! Form::model($berita, ['method' => 'PUT', 'route' => ['admin.income_categories.update', $berita['id']]]) !!}

<div class="panel panel-default">
    <div class="panel-heading">
        @lang('quickadmin.qa_edit')
    </div>

    <div class="panel-body">

        <div class="row">
            <div class="col-xs-12 form-group">
                {!! Form::label('deskripsi_berita', trans('quickadmin.income-category.fields.deskripsi_berita'), ['class' => 'control-label']) !!}
                {!! Form::textarea('deskripsi_berita', old('deskripsi_berita', isset($berita['deskripsi_berita']) ? $berita['deskripsi_berita'] : ''), ['class' => 'form-control', 'placeholder' => '']) !!}
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


{!! Form::model($berita, ['method' => 'PATCH', 'route' => ['admin.income_categories.update', $berita['id']]]) !!}
{!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!}

@endsection
