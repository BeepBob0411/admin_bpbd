@extends('layouts.app')

@section('content')

    <h3 class="page-title">@lang('quickadmin.income-category.title')</h3>

    @can('income_category_create')
        <p>
            <a href="{{ route('admin.income_categories.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>
        <div class="panel-body">
            <div id="berita-container">
                <table class="table table-bordered table-striped {{ $beritaPaginator->total() > 0 ? 'datatable' : '' }} @can('income_category_delete') dt-select @endcan">
                    <thead>
                        <tr>
                            @can('income_category_delete')
                                <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                            @endcan
                            <th>@lang('Jenis Bencana')</th>
                            <th>@lang('Tanggal Kejadian')</th>
                            <th>@lang('Waktu Kejadian')</th>
                            <th>@lang('Lokasi Kejadian')</th>
                            <th>@lang('Deskripsi Berita')</th>
                            <th>@lang('Gambar')</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($beritaPaginator->total() > 0)
                            @foreach ($beritaPaginator as $berita)
                                <tr data-entry-id="{{ $berita['id'] }}">
                                    @can('income_category_delete')
                                        <td></td>
                                    @endcan
                                    <td>{{ $berita['jenis_bencana'] ?? '' }}</td>
                                    <td>{{ isset($berita['waktu_pelaporan']) ? \Carbon\Carbon::parse($berita['waktu_pelaporan'])->format('Y-m-d') : '' }}</td>
                                    <td>{{ isset($berita['waktu_pelaporan']) ? \Carbon\Carbon::parse($berita['waktu_pelaporan'])->format('H:i:s') : '' }}</td>
                                    <td>{{ $berita['lokasi_kejadian'] ?? '' }}</td>
                                    <td>{{ $berita['deskripsi'] ?? '' }}</td>
                                    <td>
                                        @if(isset($berita['gambar']))
                                            <img src="{{ $berita['gambar'] }}" alt="Report Image" style="max-width: 100px; height: auto;">
                                        @else
                                            <span>@lang('quickadmin.income-category.fields.image')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('income_category_view')
                                            <a href="{{ route('admin.income_categories.show',[$berita['id']]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                        @endcan
                                        @can('income_category_edit')
                                            <a href="{{ route('admin.income_categories.edit',[$berita['id']]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                        @endcan
                                        @can('income_category_delete')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.income_categories.destroy', $berita['id']], 'style' => 'display:inline-block;', 'onsubmit' => "return confirm('".trans('quickadmin.qa_are_you_sure')."');"]) !!}
                                            {!! Form::submit(trans('quickadmin.qa_delete'), ['class' => 'btn btn-xs btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">@lang('quickadmin.qa_no_entries_in_table')</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <a href="#" id="load-more-berita" class="btn btn-primary">Load More Berita</a>
        </div>
    </div>

    <script>
        function loadMoreBerita(page) {
            $.ajax({
                url: "{{ route('admin.income_categories.loadMoreBerita') }}?page=" + page,
                type: 'GET',
                success: function (data) {
                    $('#berita-container table tbody').append(data);
                }
            });
        }

        $(document).ready(function () {
            var page = 1;
            $('#load-more-berita').click(function (e) {
                e.preventDefault();
                page++;
                loadMoreBerita(page);
            });
        });
    </script>

@endsection
