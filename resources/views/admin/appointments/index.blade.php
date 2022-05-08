@extends('admin.layouts.master')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">New Appointments List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">New Appointments List</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                    <tr>
                        <th>S.I</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Token No</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    
                    <tbody>

                    @foreach ($appoitments as $appoitment)
                    <tr>
                        <td>{{ $loop->index +1 }}</td>
                        <td>{{ $appoitment->patient->first_name.' '.$appoitment->patient->last_name }}</td>
                        <td>{{ $appoitment->patient->email }}</td>
                        <td>{{ $appoitment->patient->phone }}</td>
                        <td>
                            {{ Carbon\carbon::parse($appoitment->date)->format('d-m-Y') }}
                            <span class="badge bg-primary">
                                {{ Carbon\carbon::parse($appoitment->date)->format('D') }}
                            </span>
                        </td>
                        <td>{{ $appoitment->token_no }}</td>
                        <td>
                            @if ($appoitment->payment_status == 'unpaid')
                            <span class="badge bg-danger">Unpaid</span>
                            @elseif ($appoitment->payment_status == 'paid')
                            <span class="badge bg-success">Paid</span>
                            @endif
                        </td>
                        <td>
                            @can('appointment_view')
                            <a href="{{ route('appointment.show',$appoitment->id) }}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('appointment_edit')
                            <a href="{{ route('appointment.edit',$appoitment->id) }}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('appointment_delete')
                            <form method="POST" action="{{ route('appointment.destroy',$appoitment->id) }}">
                            @csrf
                            @method('delete')
                                <button class="btn btn-danger btn-sm warning" data-id={{$appoitment->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                   
                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection

<script>
	$('.warning').on('click', function (e) {
	
		var form=$(this).closest('form');
		var dataID=$(this).data('id');
	
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
		}, function (isConfirm) {
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
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('script')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script> 
@endpush