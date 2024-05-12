@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('Data Laporan Masyarakat')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($expense_categories) > 0 ? 'datatable' : '' }} @can('expense_category_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('expense_category_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('nama')</th>
                        <th>@lang('telepon')</th>
                        <th>@lang('nama_pelapor')</th>
                        <th>@lang('foto_bencana')</th>
                        <th>@lang('jenis_bencana')</th>
                        <th>@lang('lokasi_bencana')</th>
                        <th>@lang('keterangan_bencana')</th>
                        <th>@lang('waktu_pengiriman_laporan')</th>
                        <th>&nbsp;</th>

                    </tr>
                </thead>
                
                <tbody>
                    @if (count($expense_categories) > 0)
                        @foreach ($expense_categories as $expense_category)
                            <tr data-entry-id="{{ $expense_category->id }}">
                                @can('expense_category_delete')
                                    <td></td>
                                @endcan

                                <td field-key='name'>{{ $expense_category->name }}</td>
                                <td field-key='telepon'>{{ $expense_category->telepon }}</td>
                                <td field-key='nama_pelapor'>{{ $expense_category->nama_pelapor }}</td>
                                <td field-key='foto_bencana'>{{ $expense_category->foto_bencana }}</td>
                                <td field-key='jenis_bencana'>{{ $expense_category->jenis_bencana }}</td>
                                <td field-key='lokasi_bencana'>{{ $expense_category->lokasi_bencana }}</td>
                                <td field-key='keterangan_bencana'>{{ $expense_category->keterangan_bencana }}</td>
                                <td field-key='tanggal_jam_pengiriman_laporan'>{{ $expense_category->waktu_pengiriman_laporan }}</td>
                                <td>
                                    @can('expense_category_view')
                                    <a href="{{ route('admin.expense_categories.show',[$expense_category->id]) }}" class="btn btn-xs btn-primary">@lang('view')</a>
                                    @endcan
                                    @can('expense_category_edit')
                                    <a href="{{ route('admin.expense_categories.edit',[$expense_category->id]) }}" class="btn btn-xs btn-info">@lang('edit')</a>
                                    @endcan
                                    @can('expense_category_delete')
                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("are_you_sure")."');",
                                        'route' => ['admin.expense_categories.destroy', $expense_category->id])) !!}
                                        {!! Form::submit(trans('delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10">@lang('no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('expense_category_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.expense_categories.mass_destroy') }}';
        @endcan

    </script>
@endsection
