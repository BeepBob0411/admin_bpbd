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
<<<<<<< HEAD
                        <th>@lang('quickadmin.income.fields.nama_bencana')</th>
                        <th>@lang('quickadmin.income.fields.isi_peringatan')</th>
                        <th>@lang('quickadmin.income.fields.waktu_peringatan')</th>
                        <th>@lang('quickadmin.qa_action')</th>
=======
                        <th>Nama Bencana</th>
                        <th>Isi Peringatan</th>
                        <th>Waktu Peringatan</th>
                        <th>Aksi</th>
>>>>>>> 3137c255b27f34c4bb5b759e27ed1ad6f2b4dbb7
                    </tr>
                </thead>
                <tbody>
<<<<<<< HEAD
                    @forelse ($incomes as $income)
                        <tr>
                            <td>{{ $income->nama_bencana }}</td>
                            <td>{{ $income->isi_peringatan }}</td>
                            <td>{{ $income->waktu_peringatan }}</td>
                            <td>
                                <a href="{{ route('admin.incomes.edit', $income->id) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                <a href="{{ route('admin.incomes.show', $income->id) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['admin.incomes.destroy', $income->id], 'style' => 'display:inline']) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), ['class' => 'btn btn-xs btn-danger', 'onclick' => "return confirm('".trans('quickadmin.qa_are_you_sure')."')"]) !!}
                                {!! Form::close() !!}
=======
                    @forelse ($peringatanData as $peringatan)
                        <tr>
                            <td>{{ $peringatan['nama_bencana'] }}</td>
                            <td>{{ $peringatan['isi_peringatan'] }}</td>
                            <td>{{ $peringatan['waktu_peringatan']->toDate()->format('F j, Y \a\t h:i:s A') }}</td>
                            <td>
                                <!-- Tambahkan aksi sesuai kebutuhan -->
>>>>>>> 3137c255b27f34c4bb5b759e27ed1ad6f2b4dbb7
                            </td>
                        </tr>
                    @empty
                        <tr>
<<<<<<< HEAD
                            <td colspan="4">@lang('quickadmin.qa_no_entries_in_table')</td>
=======
                            <td colspan="4">Tidak ada peringatan.</td>
>>>>>>> 3137c255b27f34c4bb5b759e27ed1ad6f2b4dbb7
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
