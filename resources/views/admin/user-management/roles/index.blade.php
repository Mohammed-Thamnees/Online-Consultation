@extends('admin.layouts.master')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">User Roles</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">User Roles</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<div class="card-header py-3">
    @can('role_create')
    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Add User Role"><i class="fas fa-plus"></i> Add Role</a>
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
                        <th>Name</th>
                        <th>Guard Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>

                    @foreach ($roles as $role)
                    <tr>
                        <td>{{ $loop->index +1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->guard_name }}</td>
                        <td>
                            @if ($role->id != 1 && $role->id != 2 && $role->id != 3)
                                @can('role_update')
                                <a href="{{route('roles.edit',$role->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                @endcan
                                @can('role_delete')
                                <form method="POST" action="{{route('roles.destroy',$role->id)}}">
                                @csrf
                                @method('delete')
                                    <button class="btn btn-danger btn-sm warning" data-id={{$role->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                </form>
                                @endcan
                            @else
                            <span class="badge rounded-pill bg-success">System Role</span>
                            @endif
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