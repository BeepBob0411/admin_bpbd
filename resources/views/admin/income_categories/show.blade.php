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
                    @if (!empty($berita))
                        <tr>
                            <th>@lang('quickadmin.income-category.fields.nama_bencana')</th>
                            <td>{{ $berita['nama_bencana'] }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income-category.fields.tanggal_kejadian')</th>
                            <td>{{ $berita['tanggal_kejadian'] }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income-category.fields.waktu_kejadian')</th>
                            <td>{{ $berita['waktu_kejadian'] }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income-category.fields.lokasi_kejadian')</th>
                            <td>{{ $berita['lokasi_kejadian'] }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income-category.fields.gambar_berita')</th>
                            <td>{{ $berita['gambar_berita'] ?? 'No image available' }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="2">No data available</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
