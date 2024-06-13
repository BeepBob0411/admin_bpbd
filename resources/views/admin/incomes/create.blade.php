@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.income.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>

        <div class="panel-body">
            {!! Form::open(['method' => 'POST', 'route' => 'admin.incomes.store']) !!}
            
            <div class="form-group">
                {!! Form::label('nama_bencana', trans('quickadmin.income.fields.nama_bencana').'*', ['class' => 'control-label']) !!}
                {!! Form::text('nama_bencana', old('nama_bencana'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('nama_bencana'))
                    <p class="help-block">
                        {{ $errors->first('nama_bencana') }}
                    </p>
                @endif
            </div>

            <div class="form-group">
                {!! Form::label('isi_peringatan', trans('quickadmin.income.fields.isi_peringatan').'*', ['class' => 'control-label']) !!}
                {!! Form::textarea('isi_peringatan', old('isi_peringatan'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('isi_peringatan'))
                    <p class="help-block">
                        {{ $errors->first('isi_peringatan') }}
                    </p>
                @endif
            </div>

            <div class="form-group">
                {!! Form::label('waktu_peringatan', trans('quickadmin.income.fields.waktu_peringatan').'*', ['class' => 'control-label']) !!}
                {!! Form::text('waktu_peringatan', old('waktu_peringatan'), ['class' => 'form-control datetime', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('waktu_peringatan'))
                    <p class="help-block">
                        {{ $errors->first('waktu_peringatan') }}
                    </p>
                @endif
            </div>

            {!! Form::submit(trans('quickadmin.qa_create'), ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $('.datetime').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        });
    </script>
@endsection
