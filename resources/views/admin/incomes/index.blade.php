@extends('layouts.app')

@section('content')
    <h3 class="page-title">Daftar Peringatan</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            Daftar Peringatan
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama Bencana</th>
                        <th>Isi Peringatan</th>
                        <th>Waktu Peringatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                
                <tbody>
                    @forelse ($peringatanData as $peringatan)
                        <tr>
                            <td>{{ $peringatan['nama_bencana'] }}</td>
                            <td>{{ $peringatan['isi_peringatan'] }}</td>
                            <td>{{ $peringatan['waktu_peringatan']->toDate()->format('F j, Y \a\t h:i:s A') }}</td>
                            <td>
                                <!-- Tambahkan aksi sesuai kebutuhan -->
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Tidak ada peringatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
