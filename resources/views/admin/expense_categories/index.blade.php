@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('Data Laporan Masyarakat')</h3>

    @can('income_category_create')
        <p>
            <a href="{{ route('admin.expense_categories.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>
        <div class="panel-body">
            <div id="laporan-container">
                <table class="table table-bordered table-striped {{ count($laporanData) > 0 ? 'datatable' : '' }} @can('income_category_delete') dt-select @endcan">
                    <thead>
                        <tr>
                            @can('income_category_delete')
                                <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                            @endcan
                            <th>@lang('Jenis Bencana')</th>
                            <th>@lang('Gambar')</th>
                            <th>@lang('Keterangan')</th>
                            <th>@lang('Latitude')</th>
                            <th>@lang('Longitude')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Waktu Pelaporan')</th>
                            <th>@lang('Pelapor')</th>
                            <th>@lang('Status Berita')</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporanData as $laporan)
                            <tr data-entry-id="{{ $laporan['id'] }}">
                                @can('income_category_delete')
                                    <td></td>
                                @endcan
                                <td>{{ $laporan['disasterType'] ?? '' }}</td>
                                <td>
                                    @if(isset($laporan['imageUrl']) && !empty($laporan['imageUrl']))
                                        <img src="{{ $laporan['imageUrl'] }}" alt="Report Image" style="max-width: 100px; height: auto;">
                                    @else
                                        <span>No Image Available</span>
                                    @endif
                                </td>
                                <td>{{ $laporan['description'] ?? '' }}</td>
                                <td>{{ $laporan['location']->latitude() ?? '' }}</td>
                                <td>{{ $laporan['location']->longitude() ?? '' }}</td>
                                <td>{{ $laporan['status'] ?? '' }}</td>
                                <td>
                                    @if(isset($laporan['timestamp']) && $laporan['timestamp'] instanceof \Google\Cloud\Core\Timestamp)
                                        {{ $laporan['timestamp']->get()->format('Y-m-d H:i:s') }}
                                    @else
                                        <span>Not Available</span>
                                    @endif
                                </td>
                                <td>{{ $laporan['userId'] ?? '' }}</td>
                                <td>
                                    @if(isset($laporan['berita_created']) && $laporan['berita_created'])
                                        <span class="badge bg-success">Sudah Dibuat Berita</span>
                                    @else
                                        <span class="badge bg-danger">Belum Dibuat Berita</span>
                                    @endif
                                </td>
                                <td>
                                    @can('income_category_view')
                                        <a href="{{ route('admin.expense_categories.show', $laporan['id']) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('income_category_edit')
                                        <a href="{{ route('admin.expense_categories.edit', $laporan['id']) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('income_category_delete')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.expense_categories.destroy', $laporan['id']], 'style' => 'display:inline-block;', 'onsubmit' => "return confirm('".trans('quickadmin.qa_are_you_sure')."');"]) !!}
                                        {!! Form::submit(trans('quickadmin.qa_delete'), ['class' => 'btn btn-xs btn-danger']) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">@lang('quickadmin.qa_no_entries_in_table')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($nextStartAfter)
                <a href="#" id="load-more-laporan" class="btn btn-primary">Load More Laporan</a>
            @endif
        </div>
    </div>

    @if ($nextStartAfter)
        <script>
            function loadMoreLaporan(page) {
                $.ajax({
    url: "{{ route('admin.expense_categories.loadMoreLaporan') }}?page=" + page,
    type: 'GET',
    success: function (data) {
        $('#laporan-container table tbody').append(data);
    }
});

            }

            $(document).ready(function () {
                var page = 1;
                $('#load-more-laporan').click(function (e) {
                    e.preventDefault();
                    page++;
                    loadMoreLaporan(page);
                });
            });
        </script>
    @endif

@endsection
