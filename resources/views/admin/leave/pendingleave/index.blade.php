@extends('admin.layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Pending Leave</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pending Leave</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                        <tr role="row">
                            <th>S.I</th>
                            <th>Name</th>
                            <th>Leave Type</th>
                            <th>From Date</th>
                            <th>TO Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $items)
                            @if ($items->status == null)
                                <tr>
                                    <td class="sorting_1">{{ $loop->index + 1}}</td>
                                    <td>{{ $items->user->first_name.' '.$items->user->last_name }}</td>
                                    <td>{{ $items->type->Leavetype }}</td>
                                    <td>{{ $items->Fromdate }}</td>
                                    <td>{{ $items->Todate }}</td>
                                    <td>
                                        <a href="{{ route('pendingleaves.show', $items->id) }}"
                                            class="btn btn-warning btn-sm float-left mr-1"
                                            style="height:30px; width:30px;border-radius:50%"
                                            data-toggle="tooltip" title="edit"
                                            data-placement="bottom"><i class="fas fa-eye"></i>
                                        </a>
                                        <form method="POST"
                                            action="{{ route('leaveapprove.destroy', $items->id) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm warning"
                                                data-id={{ $items->id }}
                                                style="height:30px; width:30px;border-radius:50%"
                                                data-toggle="tooltip" data-placement="bottom"
                                                title="Delete"><i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    $('.warning').on('click', function(e) {

        var form = $(this).closest('form');
        var dataID = $(this).data('id');

        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it",
            cancelButtonText: "No, cancel it",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm) {
            if (isConfirm) {
                form.submit();
                swal("Deleted!", "Your file has been deleted.", "success");
            } else {
                swal("Cancelled", "Your file is safe :)", "error");
            }
        });
    });
</script>

@push('style')
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
@endpush

@push('script')
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endpush

