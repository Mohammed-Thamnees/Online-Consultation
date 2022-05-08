@extends('admin.layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Doctor Profile</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Doctors Profile</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">DR. {{ $doctor->doctordetails->first_name . ' ' . $doctor->doctordetails->last_name }}</h5>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="{{ asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="{{ asset('storage/user/'.$doctor->doctordetails->image) }}" alt="" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate">{{ $doctor->doctordetails->first_name . ' ' . $doctor->doctordetails->last_name }}</h5>
                        <p class="text-muted mb-0 text-truncate">{{ $doctor->designation }}</p>
                    </div>

                    <div class="col-sm-8">
                        <div class="pt-4">
                           
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="font-size-15">{{ @App\Models\Appointment::todayappointments($doctor->id) }}</h5>
                                    <p class="text-muted mb-0">Appointments Today</p>
                                </div>
                                <div class="col-6">
                                    <h5 class="font-size-15">$ {{ number_format(@App\Models\Appointment::todayappointments($doctor->id) * $doctor->fees,2) }}</h5>
                                    <p class="text-muted mb-0">Revenue Today</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Personal Information</h4>

                <p class="text-muted mb-4">{!! $doctor->details !!}</p>
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <tbody>
                            <tr>
                                <th scope="row">Full Name :</th>
                                <td>{{ $doctor->doctordetails->first_name . ' ' . $doctor->doctordetails->last_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Caategory :</th>
                                <td>
                                    <ul>
                                    @foreach ($doctor->doctorcategory as $cat)
                                    @php
                                        $doc_cat = DB::table('categories')->where('id',$cat->category_id)->first();
                                    @endphp
                                        <li>{{ $doc_cat->name }}</li>
                                    @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Mobile :</th>
                                <td>{{ $doctor->doctordetails->phone }}</td>
                            </tr>
                            <tr>
                                <th scope="row">E-mail :</th>
                                <td>{{ $doctor->doctordetails->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">DOB :</th>
                                <td>{{ Carbon\carbon::parse($doctor->doctordetails->dob)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Location :</th>
                                <td>{{ $doctor->doctordetails->place }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>         
    
    <div class="col-xl-8">

        <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted fw-medium mb-2">Total Appointments</p>
                                <h4 class="mb-0">{{ @App\Models\Appointment::totalappointments($doctor->id) }}</h4>
                            </div>

                            <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bx-check-circle font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted fw-medium mb-2">Todays Appointments</p>
                                <h4 class="mb-0">{{ @App\Models\Appointment::todayappointments($doctor->id) }}</h4>
                            </div>

                            <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bx-hourglass font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted fw-medium mb-2">Total Revenue</p>
                                <h4 class="mb-0">$ {{ number_format(@App\Models\Appointment::totalappointments($doctor->id) * $doctor->fees,2) }}</h4>
                            </div>

                            <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bx-package font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">My History</h4>
                <div class="table-responsive">
                    <table class="table table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Patient Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Token</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($appointments as $appointment)
                            <tr>
                                <th scope="row">{{ $loop->index +1 }}</th>
                                <td>
                                    {{ $appointment->patient->first_name.' '.$appointment->patient->last_name }}
                                </td>
                                <td>
                                    {{ Carbon\carbon::parse($appointment->date)->format('d M, Y') }}
                                    <span class="badge bg-primary">
                                        {{ Carbon\carbon::parse($appointment->date)->format('D') }}
                                    </span>
                                </td>
                                <td>{{ $appointment->token_no }}</td>
                                <td>
                                    @can('appointment_view')
                                        <a href="{{ route('appointment.show',$appointment->id) }}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection