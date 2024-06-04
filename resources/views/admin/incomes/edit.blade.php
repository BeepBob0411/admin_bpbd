@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.income.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
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
@endsection
