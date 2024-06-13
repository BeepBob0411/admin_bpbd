@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.income.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>@lang('quickadmin.income.fields.nama_bencana')</th>
                        <th>@lang('quickadmin.income.fields.isi_peringatan')</th>
                        <th>@lang('quickadmin.income.fields.waktu_peringatan')</th>
                        <th>@lang('quickadmin.qa_action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($incomes as $income)
                        <tr>
                            <td>{{ $income->nama_bencana }}</td>
                            <td>{{ $income->isi_peringatan }}</td>
                            <td>{{ $income->waktu_peringatan }}</td>
                            <td>
                                <a href="{{ route('admin.incomes.edit', $income->id) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                <a href="{{ route('admin.incomes.show', $income->id) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['admin.incomes.destroy', $income->id], 'style' => 'display:inline']) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), ['class' => 'btn btn-xs btn-danger', 'onclick' => "return confirm('".trans('quickadmin.qa_are_you_sure')."')"]) !!}
                                {!! Form::close() !!}
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
@stop
