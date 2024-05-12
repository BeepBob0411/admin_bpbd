@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.expense.title')</h3>
    @can('expense_create')
    <p>
        <a href="{{ route('admin.expenses.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>@lang('name')</th>
                            <th>@lang('nomor_darurat')</th>
                            <th>@lang('gambar')</th>
                            <th>@lang('aksi')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->nama }}</td>
                                <td>{{ $expense->nomor_darurat }}</td>
                                <td>
                                    @if($expense->gambar)
                                        <a href="{{ asset('uploads/' . $expense->gambar) }}" target="_blank">
                                            <img src="{{ asset('uploads/thumb/' . $expense->gambar) }}" style="max-width: 100px;">
                                        </a>
                                    @else
                                        {{ trans('quickadmin.qa_no_file') }}
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @can('expense_view')
                                            <a href="{{ route('admin.expenses.show', $expense->id) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                        @endcan
                                        @can('expense_edit')
                                            <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                        @endcan
                                        @can('expense_delete')
                                            {!! Form::open(['route' => ['admin.expenses.destroy', $expense->id], 'method' => 'DELETE', 'style' => 'display:inline']) !!}
                                                {!! Form::submit(trans('quickadmin.qa_delete'), ['class' => 'btn btn-xs btn-danger', 'onclick' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');"]) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">@lang('quickadmin.qa_no_entries_in_table')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
