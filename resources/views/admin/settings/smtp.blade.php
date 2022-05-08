@extends('admin.layouts.master')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Mail Settings</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Mail Settings</li>
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
                <h4 class="card-title mb-4">Mail Settings</h4>

                <form method="POST" action="{{ route('mail.save') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ @$mail->id }}">
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Driver</label>
                                <input type="text" name="driver" value="{{ @$mail->driver }}" class="form-control" id="formrow-email-input">
                                @error('driver')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Host</label>
                                <input type="text" name="host" value="{{ @$mail->host }}" class="form-control" id="formrow-password-input">
                                @error('host')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Port</label>
                                <input type="text" name="port" value="{{ @$mail->port }}" class="form-control" id="formrow-password-input">
                                @error('port')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">From</label>
                                <input type="text" name="from" value="{{ @$mail->from }}" class="form-control" id="formrow-password-input">
                                @error('from')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Name</label>
                                <input type="text" name="name" value="{{ @$mail->name }}" class="form-control" id="formrow-password-input">
                                @error('name')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Encryption</label>
                                <input type="text" name="encryption" value="{{ @$mail->encryption }}" class="form-control" id="formrow-password-input">
                                @error('encryption')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">User Name</label>
                                <input type="text" name="username" value="{{ @$mail->username }}" class="form-control" id="formrow-password-input">
                                @error('username')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Password</label>
                                <input type="text" name="password" value="{{ @$mail->password }}" class="form-control" id="formrow-password-input">
                                @error('password')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
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
