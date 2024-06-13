@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.income.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
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
        </div>
    </div>
@endsection
