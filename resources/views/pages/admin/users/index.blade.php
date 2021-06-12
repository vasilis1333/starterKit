@extends('layouts.master')

@section('title') @lang('translation.Data_Tables') @endsection

@section('css')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Tables @endslot
        @slot('title') Data Tables @endslot
    @endcomponent



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Buttons example</h4>
                    <p class="card-title-desc">The Buttons extension for DataTables
                        provides a common set of options, API methods and styling to display
                        buttons on a page that will interact with a DataTable. The core library
                        provides the based framework upon which plug-ins can built.
                    </p>

                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>

                            <th>Salary</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>


    <!-- Datatable init  -->
    <script>
        $(document).ready(function () {


            var table = $('#datatable-buttons').DataTable({
                dom: 'lBfrtip',
                processing: true,
                serverSide: true,
                lengthChange: false,
                buttons: ['copy', 'excel'],
                columnDefs: [ {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0
                } ],
                select: {
                    style:    'os',
                    selector: 'td:first-child'
                },
                order: [[ 1, 'asc' ]],
                "ajax": {
                    "url": '{{ route('users.datatables')  }}',
                    "type": "POST",
                    "data":
                        {
                            "_token": '{{csrf_token()}}',
                        }

                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'avatar', name: 'avatar'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},

                    {data: 'status', name: 'status'},
                    {data: 'action2', name: 'action2', orderable: false, searchable: false},
                ],
            });
            // table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            // $(".dataTables_length select").addClass('form-select form-select-sm');
        });
    </script>
@endsection
