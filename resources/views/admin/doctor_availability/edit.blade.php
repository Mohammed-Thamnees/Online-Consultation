@extends('admin.layouts.master')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Edit Doctor Availability</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Edit Doctor Availability</li>
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
                <h4 class="card-title mb-4">Edit Doctor Availability</h4>

                <form method="POST" action="{{ route('availability.update',$available->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Select Doctor</label>
                                <select name="doctor_id" class="form-control select2" id="formrow-email-input">
                                    <option value="{{ $available->doctor_id }}">{{ $available->doctor->doctordetails->first_name. ' '.  $available->doctor->doctordetails->last_name}}</option>
                                </select>
                                @error('doctor_id')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Select Day</label>
                                <select name="day" class="form-control select2" id="formrow-email-input">
                                    <option value="{{ $available->day }}">
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
                                    </option>
                                </select>
                                @error('day')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Start Time</label>
                                <input type="time" name="start_time" value="{{ $available->start_time }}" class="form-control" id="formrow-email-input">
                                @error('start_time')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">End Time</label>
                                <input type="time" name="end_time" value="{{ $available->end_time }}" class="form-control" id="formrow-email-input">
                                @error('end_time')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Sit Quantity</label>
                                <input type="text" name="sit_quantity" value="{{ $available->sit_quantity }}" class="form-control" id="formrow-email-input">
                                @error('sit_quantity')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control select2" name="status">
                                    <option value="">Select</option>
                                    <option value="1" {{ old('status',$available->status==1 ? 'selected' : '') }}>Active</option>
                                    <option value="0" {{ old('status',$available->status==0 ? 'selected' : '') }}>Inactive</option>
                                </select>
                                @error('status')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-md">Update</button>
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