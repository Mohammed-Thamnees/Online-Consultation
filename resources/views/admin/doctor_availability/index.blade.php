@extends('admin.layouts.master')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Doctor Availability List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Doctor Availability List</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<div class="card-header py-3">
    @can('doctor_availability_create')
    <a href="{{ route('availability.create') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Add Banners"><i class="fas fa-plus"></i> Add Doctor Availability</a>
    @endcan
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                    <tr>
                        <th>S.I</th>
                        <th>Doctor Name</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Sit Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>

                    @foreach ($availables as $available)
                    <tr>
                        <td>{{ $loop->index +1 }}</td>
                        <td>{{ $available->doctor->doctordetails->first_name.' '.$available->doctor->doctordetails->last_name }}</td>
                        <td>
                            @if ($available->day == 'Mon')
                                Monday
                            @elseif ($available->day == 'Tue')
                                Tuesday
                            @elseif ($available->day == 'Wed')
                                Wednesday
                            @elseif ($available->day == 'Thu')
                                Thursday
                            @elseif ($available->day == 'Fri')
                                Friday
                            @elseif ($available->day == 'Sat')
                                Saturday
                            @elseif ($available->day == 'Sun')
                                Sunday
                            @endif
                        </td>
                        <td>{{ Carbon\carbon::parse($available->start_time)->format('h:i A') . '-' . Carbon\carbon::parse($available->end_time)->format('h:i A') }}</td>
                        <td>{{ $available->sit_quantity }}</td>
                        <td>
                            @if ($available->status == 0)
                            <span class="badge bg-danger">Inactive</span>
                            @else
                            <span class="badge bg-success">Active</span>
                            @endif
                        </td>
                        <td>
                            @can('doctor_availability_show')
                            <a href="{{route('availability.show',$available->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('doctor_availability_update')
                            <a href="{{route('availability.edit',$available->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('doctor_availability_delete')
                            <form method="POST" action="{{route('availability.destroy',$available->id)}}">
                            @csrf
                            @method('delete')
                                <button class="btn btn-danger btn-sm warning" data-id={{$available->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
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