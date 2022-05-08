@extends('admin.layouts.master')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Prescription</li>
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
                @php
                    $day = Carbon\carbon::parse($appointment->date)->format('D');
                @endphp
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Patient Information</h4>
                                <p class="card-title-desc"></p>
                                <table class="table mb-0">
                                    <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $appointment->patient->first_name.' '.$appointment->patient->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>E-mail</th>
                                        <td>{{ $appointment->patient->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $appointment->patient->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Age</th>
                                        <td>
                                            {{ Carbon\carbon::parse($appointment->patient->dob)->diff(Carbon\carbon::now())->format('%y years') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ $appointment->patient->gender }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Appointment Information</h4>
                                <p class="card-title-desc"></p>
                                <table class="table mb-0">
                                    <tbody>
                                    <tr>
                                        <th>Doctor Name</th>
                                        <td>
                                            DR. {{ $appointment->doctor->doctordetails->first_name.' '.$appointment->doctor->doctordetails->last_name }}
                                            ({{ $appointment->doctor->designation }})
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>
                                            {{ Carbon\carbon::parse($appointment->date)->format('d-m-Y') }}
                                            <span class="badge bg-primary">{{ $day }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Token No</th>
                                        <td>{{ $appointment->token_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Expected Time</th>
                                        <td>
                                            {{ App\Models\Appointment::expectedtime($appointment->id,$appointment->doctor_id,$day) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Already Treated</th>
                                        <td>
                                            @if ($appointment->status == 'new')
                                                <span class="badge bg-danger">No</span>
                                            @elseif ($appointment->status == 'completed')
                                                <span class="badge bg-success">Yes</span>
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('appointment.update',$appointment->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Patient Physical Info</h4>
                                <p class="card-title-desc"></p>
                                <table class="table mb-0">
                                    <thead>
                                    <tr>
                                        <th>Weight</th>
                                        <th>Blood Pressure</th>
                                        <th>Pulse Rate</th>
                                        <th>Temperature</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" name="weight" value="{{ old('weight') }}" class="form-control" id="formrow-email-input">
                                            @error('weight')
                                                <span class="badge badge-soft-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" name="blood_pressure" value="{{ old('blood_pressure') }}" class="form-control" id="formrow-email-input">
                                            @error('blood_pressure')
                                                <span class="badge badge-soft-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" name="pulse" value="{{ old('pulse') }}" class="form-control" id="formrow-email-input">
                                            @error('pulse')
                                                <span class="badge badge-soft-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" name="temperature" value="{{ old('temperature') }}" class="form-control" id="formrow-email-input">
                                            @error('temperature')
                                                <span class="badge badge-soft-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Problem Description</th>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <textarea name="problem_description"class="form-control"></textarea>
                                            @error('problem_description')
                                                <span class="badge badge-soft-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Add Prescription</h4>
                                <p class="card-title-desc"></p>
                                <table class="table mb-0">
                                    <tbody>
                                    <tr>
                                        {{-- <th>Medicine Type</th> --}}
                                        <th>Medicine</th>
                                        <th>Dosage</th>
                                        <th>Days</th>
                                        <th>Time</th>
                                        <th></th>
                                    </tr>
                                    <tr id="row1">
                                        {{-- <td>
                                            <select class="form-control" name="medicine_type[]" id="medicine_type" required>
                                                <option value="">select type</option>
                                                @foreach ($medicine_types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('medicine_type')
                                                <span class="badge badge-soft-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <select class="form-control" name="medicine[]" id="medicine" required>
                                                <option value="">select medicine</option>
                                                @foreach ($medicines as $medicine)
                                                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('medicine')
                                                <span class="badge badge-soft-danger">{{ $message }}</span>
                                            @enderror
                                        </td> --}}
                                        <td>
                                            <input type="text" name="medicine[]" id="medicine" required class="form-control">
                                            @error('medicine')
                                                <span class="badge badge-soft-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <select class="form-control" name="dosage[]" id="dosage" required>
                                                <option value="0-0-0">0-0-0</option>
                                                <option value="0-0-1">0-0-1</option>
                                                <option value="0-1-0">0-1-0</option>
                                                <option value="0-1-1">0-1-1</option>
                                                <option value="1-0-0">1-0-0</option>
                                                <option value="1-0-1">1-0-1</option>
                                                <option value="1-1-0">1-1-0</option>
                                                <option value="1-1-1">1-1-1</option>
                                            </select>
                                            @error('dosage')
                                                <span class="badge badge-soft-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <select class="form-control" name="days[]" id="days" required>
                                            @for ($i=1; $i<=90; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                            </select>
                                            @error('days')
                                                <span class="badge badge-soft-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <select class="form-control" name="time[]" id="time" required>
                                                <option value="after">After Meal</option>
                                                <option value="before">Before Meal</option>
                                                </select>
                                                @error('time')
                                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                                @enderror
                                        </td>
                                        <td>
                                            <a id="add" class="btn btn-primary btn-sm float-left mr-1"><i class="fas fa-plus"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
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
    var i=1;
    $(document).ready(function(){
        //add row
        $('#add').on('click', function(){
            i++;
            $('#row1').after('<tr id="row'+i+'">' +
                /* '<td>' + 
                    '<select class="form-control" name="medicine_type[]" id="medicine_type'+i+'">' +
                    '</select>' +
                '</td>' +
                '<td>' +
                    '<select class="form-control" name="medicine[]" id="medicine'+i+'">' +
                    '</select>' +
                '</td>' + */
                '<td>' +
                    '<input type="text" name="medicine[]" id="medicine'+i+'" required class="form-control">' +
                '</td>' +
                '<td>' +
                    '<select class="form-control" name="dosage[]" id="dosage'+i+'">' +
                        '<option value="0-0-0">0-0-0</option>' +
                        '<option value="0-0-1">0-0-1</option>' +
                        '<option value="0-1-0">0-1-0</option>' +
                        '<option value="0-1-1">0-1-1</option>' +
                        '<option value="1-0-0">1-0-0</option>' +
                        '<option value="1-0-1">1-0-1</option>' +
                        '<option value="1-1-0">1-1-0</option>' +
                        '<option value="1-1-1">1-1-1</option>' +
                    '</select>' +
                '</td>' +
                '<td>' +
                    '<select class="form-control" name="days[]" id="days'+i+'">' +
                    '</select>' +
                '</td>' +
                '<td>' +
                    '<select class="form-control" name="time[]" id="time'+i+'">' +
                        '<option value="after">After Meal</option>' +
                        '<option value="before">Before Meal</option>' +
                    '</select>' +
                '</td>' +
                '<td>' +
                    '<a id="'+i+'" class="btn btn-danger btn-sm float-left mr-1 remove" value="delete"><i class="fas fa-trash"></i></a>' +
                '</td>' +
            '</tr>');
        });

        //number 1 to 90
        $('#add').on('click', function () {
            $('#days'+i+'').html('');
            for (let j=1; j<=90; j++) {
                $('#days'+i+'').append($('<option></option>').val(j).html(j))
            }
        });

        //get medicine type
        /* $('#add').on('click', function () {
            $('#medicine_type'+i+'').html('');
            $.ajax({
                url: "{{url('getmedicinetypes')}}",
                type: "GET",
                data: {
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    //console.log(result);
                    $('#medicine_type'+i+'').html('<option value="">select type</option>');
                    $.each(result, function (key, value) {
                        $('#medicine_type'+i+'').append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        }); */

        //get medicines
        /* $('#add').on('click', function () {
            $('#medicine'+i+'').html('');
            $.ajax({
                url: "{{url('getmedicines')}}",
                type: "GET",
                data: {
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    //console.log(result);
                    $('#medicine'+i+'').html('<option value="">select medicine</option>');
                    $.each(result, function (key, value) {
                        $('#medicine'+i+'').append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        }); */

        //delete row
        $(document).on('click', '.remove' , function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

    });
</script>


<script src="https://cdn.tiny.cloud/1/odznz7ajohaam8oa0hn79g5yty47asxu4lg8qb3y24i94499/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea',
        height: 200,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_css: '//www.tiny.cloud/css/codepen.min.css'
    });
</script>
@endpush