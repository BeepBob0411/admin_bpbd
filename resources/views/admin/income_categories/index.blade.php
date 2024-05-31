@inject('request', 'Illuminate\Http\Request')
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

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($income_categories) > 0 ? 'datatable' : '' }} @can('income_category_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('income_category_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.income-category.fields.name')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($income_categories) > 0)
                        @foreach ($income_categories as $income_category)
                            <tr data-entry-id="{{ $income_category['id'] }}">
                                @can('income_category_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $income_category['nama_bencana'] }}</td>
                                <td>
                                    @can('income_category_view')
                                    <a href="{{ route('admin.income_categories.show', $income_category['id']) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('income_category_edit')
                                    <a href="{{ route('admin.income_categories.edit', $income_category['id']) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('income_category_delete')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.income_categories.destroy', $income_category['id']], 'style' => 'display:inline']) !!}
                                        {!! Form::submit(trans('quickadmin.qa_delete'), ['class' => 'btn btn-xs btn-danger', 'onclick' => "return confirm('".trans('quickadmin.qa_are_you_sure')."')"]) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('income_category_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.income_categories.mass_destroy') }}';
        @endcan
    </script>
@endsection
