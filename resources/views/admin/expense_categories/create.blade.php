@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('Data Laporan Masyarakat')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('Berita Bencana Alam')
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
                            <th>@lang('Waktu Pelaporan')</th>
                            <td>
                                @if(isset($laporan['timestamp']))
                                    {{ \Carbon\Carbon::parse($laporan['timestamp'])->format('Y-m-d H:i:s') }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Formulir untuk membuat berita -->
            <div class="row">
                <div class="col-md-6">
                    <h4>@lang('Buat Berita')</h4>
                    <form action="{{ route('admin.expense_categories.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="laporan_id" value="{{ $laporan['id'] }}">

                        <!-- Deskripsi Berita -->
                        <div class="form-group">
                            <label for="deskripsi_berita">@lang('Deskripsi Berita')</label>
                            <textarea name="deskripsi_berita" id="deskripsi_berita" class="form-control" required>{{ old('deskripsi_berita') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">@lang('Buat Berita')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
