@extends('admin.layouts.master')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Add Appointment</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Appointment</li>
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
                <h4 class="card-title mb-4">Add Appointment</h4>

                <form method="POST" action="{{ route('appointment.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Select Patient</label>
                                <select class="form-control select2" name="patient">
                                    <option value="">select patient</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->first_name. ' '.$patient->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('patient')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Select Date</label>
                                <input type="date" name="date" value="{{ old('date') }}" class="form-control" id="formrow-email-input">
                                @error('date')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Select Category</label>
                                <select class="form-control select2" name="category_id" id="category_id">
                                    <option value="">select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Select Doctor</label>
                                <select class="form-control select2" name="doctor_id" id="doctor_id">
                                    <option value="">select doctor</option>
                                </select>
                                @error('doctor_id')
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

@push('script')

<script>

    $(document).ready(function () {
        $('#category_id').on('change', function () {
            var id = this.value;
            $("#doctor_id").html('');
            $.ajax({
                url: "{{url('getdoctors')}}",
                type: "GET",
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    //console.log(result);
                    $('#doctor_id').html('<option value="">Select Doctor</option>');
                    $.each(result, function (key, value) {
                        $("#doctor_id").append('<option value="' + value
                            .id + '">' + value.first_name + ' ' + value.last_name + '</option>');
                    });
                }
            });
        });
    });

</script>

@endpush