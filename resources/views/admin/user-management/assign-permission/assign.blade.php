@extends('admin.layouts.master')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Assign Permissions</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Assign Permissions</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Assign Permissions</h4>

                <form method="POST" action="{{ route('role.permission.assign') }}">
                    @csrf
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Role Name</label>
                                <input type="text" readonly name="name" value="{{ $role->name }}" class="form-control" id="formrow-email-input">
                                @error('name')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-password-input" class="form-label">Guard Name</label>
                                <input type="text" readonly name="guard_name" value="{{ $role->guard_name }}" class="form-control" id="formrow-password-input">
                                @error('guard_name')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Permissions</label>
                        <select name="permissions[]" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose permissions...">
                            @foreach ($permissions as $key => $permission)
                                <option value="{{ $permission->id }}" {{ in_array($permission->name, $rolePermissions) ? 'selected': '' }}>{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        @error('permissions')
                            <span class="badge badge-soft-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                    </div>
                </form>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
</div>
<!-- end row -->

@endsection