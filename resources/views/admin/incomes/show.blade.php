@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('Detail Peringatan')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('Detail Peringatan')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
<<<<<<< HEAD
                        <tbody>
                            <tr>
                                <th>@lang('quickadmin.income.fields.nama_bencana')</th>
                                <td>{{ $income->nama_bencana }}</td>
                            </tr>
                            <tr>
                                <th>@lang('quickadmin.income.fields.isi_peringatan')</th>
                                <td>{{ $income->isi_peringatan }}</td>
                            </tr>
                            <tr>
                                <th>@lang('quickadmin.income.fields.waktu_peringatan')</th>
                                <td>{{ $income->waktu_peringatan->format('F j, Y \a\t h:i:s A T') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
=======
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
>>>>>>> 3137c255b27f34c4bb5b759e27ed1ad6f2b4dbb7
        </div>
    </div>
@endsection
