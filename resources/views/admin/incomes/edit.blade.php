@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.income.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
<<<<<<< HEAD
                <div class="col-md-6">
                    {!! Form::model($income, ['method' => 'PUT', 'route' => ['admin.incomes.update', $income->id]]) !!}

                    <div class="form-group">
                        {!! Form::label('nama_bencana', trans('quickadmin.income.fields.nama_bencana').'*', ['class' => 'control-label']) !!}
                        {!! Form::text('nama_bencana', old('nama_bencana', $income->nama_bencana), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('nama_bencana'))
                            <p class="help-block">
                                {{ $errors->first('nama_bencana') }}
                            </p>
                        @endif
                    </div>

                    <div class="form-group">
                        {!! Form::label('isi_peringatan', trans('quickadmin.income.fields.isi_peringatan').'*', ['class' => 'control-label']) !!}
                        {!! Form::textarea('isi_peringatan', old('isi_peringatan', $income->isi_peringatan), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('isi_peringatan'))
                            <p class="help-block">
                                {{ $errors->first('isi_peringatan') }}
                            </p>
                        @endif
                    </div>

                    <div class="form-group">
                        {!! Form::label('waktu_peringatan', trans('quickadmin.income.fields.waktu_peringatan').'*', ['class' => 'control-label']) !!}
                        {!! Form::text('waktu_peringatan', old('waktu_peringatan', $income->waktu_peringatan), ['class' => 'form-control datetime', 'placeholder' => '', 'required' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('waktu_peringatan'))
                            <p class="help-block">
                                {{ $errors->first('waktu_peringatan') }}
                            </p>
                        @endif
                    </div>

                    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
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
=======
                <div class="col-xs-12 form-group">
                    <label for="nama_bencana">@lang('Nama Bencana')</label>
                    <input type="text" id="nama_bencana" name="nama_bencana" class="form-control" value="{{ $peringatan['nama_bencana'] ?? '' }}" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label for="isi_peringatan">@lang('Isi Peringatan')</label>
                    <textarea id="isi_peringatan" name="isi_peringatan" class="form-control" disabled>{{ $peringatan['isi_peringatan'] ?? '' }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label for="waktu_peringatan">@lang('Waktu Peringatan')</label>
                    <input type="text" id="waktu_peringatan" name="waktu_peringatan" class="form-control" value="{{ $peringatan['waktu_peringatan'] ?? '' }}" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <a href="{{ route('admin.peringatan.index') }}" class="btn btn-default">@lang('Back to list')</a>
                </div>
            </div>
        </div>
    </div>
>>>>>>> 3137c255b27f34c4bb5b759e27ed1ad6f2b4dbb7
@endsection
