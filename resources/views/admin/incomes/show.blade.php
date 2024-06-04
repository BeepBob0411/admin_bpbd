@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('Detail Peringatan')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('Detail Peringatan')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Nama Bencana</th>
                            <td>{{ $peringatan['nama_bencana'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Isi Peringatan</th>
                            <td>{{ $peringatan['isi_peringatan'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Waktu Peringatan</th>
                            <td>{{ $peringatan['waktu_peringatan'] ?? '' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.peringatan.index') }}" class="btn btn-default">@lang('Kembali ke Daftar')</a>
        </div>
    </div>
@stop
