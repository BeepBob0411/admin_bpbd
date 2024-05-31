@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('Data Laporan Masyarakat')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('List')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>@lang('Jenis Bencana')</th>
                        <th>@lang('Gambar')</th>
                        <th>@lang('Keterangan')</th>
                        <th>@lang('Latitude')</th>
                        <th>@lang('Longitude')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Waktu Pelaporan')</th>
                        <th>@lang('Pelapor')</th>
                        <th>@lang('Lihat Detail')</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($laporanData) && !empty($laporanData))
                        @foreach($laporanData as $report)
                            <tr>
                                <td>{{ $report['disasterType'] }}</td>
                                <td>
                                    @if(isset($report['imageUrl']) && !empty($report['imageUrl']))
                                        <img src="{{ $report['imageUrl'] }}" alt="Report Image" style="max-width: 100px; height: auto;">
                                    @else
                                        <span>No Image Available</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($report['description']))
                                        {{ $report['description'] }}
                                    @else
                                        <span>No Description Available</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($report['location']))
                                        {{ $report['location']->latitude() }}
                                    @else
                                        <span>Not Available</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($report['location']))
                                        {{ $report['location']->longitude() }}
                                    @else
                                        <span>Not Available</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($report['status']))
                                        {{ $report['status'] }}
                                    @else
                                        <span>Not Available</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($report['timestamp']) && $report['timestamp'] instanceof \Google\Cloud\Core\Timestamp)
                                        {{ $report['timestamp']->get()->format('Y-m-d H:i:s') }}
                                    @else
                                        <span>Not Available</span>
                                    @endif
                                </td>
                                <td>{{ $report['userId'] }}</td>
                                <td>
                                    <a href="{{ route('admin.expense_categories.show', $report['id']) }}" class="btn btn-info">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('No data available')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
