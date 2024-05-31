@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('Data Laporan Masyarakat')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('Detail Laporan')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th>@lang('Jenis Bencana')</th>
                            <td>{{ $laporan['disasterType'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Image')</th>
                            <td>
                                @if(isset($laporan['imageUrl']))
                                    <img src="{{ $laporan['imageUrl'] }}" alt="Report Image" style="max-width: 100px; height: auto;">
                                @else
                                    <span>@lang('No Image Available')</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('Keterangan')</th>
                            <td>{{ $laporan['description'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Latitude')</th>
                            <td>{{ isset($laporan['location']) ? $laporan['location']->latitude() : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Longitude')</th>
                            <td>{{ isset($laporan['location']) ? $laporan['location']->longitude() : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Status')</th>
                            <td>{{ $laporan['status'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Waktu Pelaporan')</th>
                            <td>
                                @if(isset($laporan['timestamp']))
                                    {{ $laporan['timestamp']->formatAsString() }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('Pelapor')</th>
                            <td>{{ $laporan['userId'] ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
