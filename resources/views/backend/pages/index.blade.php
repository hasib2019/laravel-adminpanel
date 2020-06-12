@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.pages.management'))

@section('breadcrumb-links')
    @include('backend.pages.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                {{ __('labels.backend.access.pages.management') }} <small class="text-muted">{{ __('labels.backend.access.pages.active') }}</small>
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.pages.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table id="pages-table" class="table">
                        <thead>
                            <tr>
                                <th>{{ trans('labels.backend.access.pages.table.name') }}</th>
                                <th>{{ trans('labels.backend.access.pages.table.status') }}</th>
                                <th>{{ trans('labels.backend.access.pages.table.createdby') }}</th>
                                <th>{{ trans('labels.backend.access.pages.table.createdat') }}</th>
                                <th>{{ trans('labels.general.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        
    </div><!--card-body-->
</div><!--card-->
@endsection

@section('pagescript')

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#pages-table').dataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.pages.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'title', name: 'pages.title'},
                    {data: 'status', name: 'pages.status'},
                    {data: 'created_by', name: 'pages.user_name'},
                    {data: 'created_at', name: 'pages.created_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[1, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }}
                    ]
                },
                "createdRow": function( row, data, dataIndex){
                    Common.Utils.DataTables.CreateRow(row, data, dataIndex);
                }
                // language: {
                //     @lang('datatable.strings')
                // }
            });

        });
    </script>
@endsection
