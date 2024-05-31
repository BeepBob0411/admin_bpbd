@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.income-category.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.income-category.fields.nama_bencana')</th>
                            <td>{{ $income_category['nama_bencana'] }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income-category.fields.tanggal_kejadian')</th>
                            <td>{{ $income_category['tanggal_kejadian'] }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income-category.fields.waktu_kejadian')</th>
                            <td>{{ $income_category['waktu_kejadian'] }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income-category.fields.lokasi_kejadian')</th>
                            <td>{{ $income_category['lokasi_kejadian'] }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income-category.fields.gambar_berita')</th>
                            <td>{{ $income_category['gambar_berita'] }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income-category.fields.deskripsi_berita')</th>
                            <td>{{ $income_category['deskripsi_berita'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <p>&nbsp;</p>
            <a href="{{ route('admin.income_categories.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop
