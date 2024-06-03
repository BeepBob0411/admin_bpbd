@foreach ($berita as $item)
    <tr data-entry-id="{{ $item['id'] }}">
        @can('income_category_delete')
            <td></td>
        @endcan
        <td>{{ $item['jenis_bencana'] ?? '' }}</td>
        <td>{{ isset($item['waktu_pelaporan']) ? \Carbon\Carbon::parse($item['waktu_pelaporan'])->format('Y-m-d') : '' }}</td>
        <td>{{ isset($item['waktu_pelaporan']) ? \Carbon\Carbon::parse($item['waktu_pelaporan'])->format('H:i:s') : '' }}</td>
        <td>{{ $item['lokasi_kejadian'] ?? '' }}</td>
        <td>{{ $item['deskripsi'] ?? '' }}</td>
        <td>
            @if(isset($item['gambar']))
                <img src="{{ $item['gambar'] }}" alt="Report Image" style="max-width: 100px; height: auto;">
            @else
                <span>@lang('quickadmin.income-category.fields.image')</span>
            @endif
        </td>
        <td>
            @can('income_category_view')
                <a href="{{ route('admin.income_categories.show',[$item['id']]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
            @endcan
            @can('income_category_edit')
                <a href="{{ route('admin.income_categories.edit',[$item['id']]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
            @endcan
            @can('income_category_delete')
                {!! Form::open(['method' => 'DELETE', 'route' => ['admin.income_categories.destroy', $item['id']], 'style' => 'display:inline-block;', 'onsubmit' => "return confirm('".trans('quickadmin.qa_are_you_sure')."');"]) !!}
                {!! Form::submit(trans('quickadmin.qa_delete'), ['class' => 'btn btn-xs btn-danger']) !!}
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
@endforeach
