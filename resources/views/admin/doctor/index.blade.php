@extends('admin.layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Doctors List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Doctors List</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    @foreach ($doctors as $doctor)
    <div class="col-xl-3 col-sm-6">
        <div class="card text-center">
            <div class="card-body">
                @if ($doctor->doctordetails->image == NULL)
                <div class="avatar-sm mx-auto mb-4">
                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                        D
                    </span>
                </div>
                @else
                <div class="mb-4">
                    <a class="image-popup-no-margins" href="{{ asset('storage/user/'.$doctor->doctordetails->image) }}">
                        <img class="rounded-circle avatar-sm" alt="" src="{{ asset('storage/user/'.$doctor->doctordetails->image) }}">
                    </a>
                </div>
                @endif
                <h5 class="font-size-15 mb-1"><a href="#" class="text-dark">{{ $doctor->doctordetails->first_name . ' ' . $doctor->doctordetails->last_name }}</a></h5>
                <p class="text-muted">{{ $doctor->designation }}</p>

                <div>
                    @foreach ($doctor->doctorcategory as $category)
                    @php
                        $category_name = DB::table('categories')->where('id',$category->category_id)->first();
                    @endphp
                    <a href="#" class="badge bg-primary font-size-11 m-1">{{ $category_name->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="card-footer bg-transparent border-top">
                <div class="contact-links d-flex font-size-20">
                    @can('doctor_show')
                    <div class="flex-fill">
                        <a href="{{ route('doctor.show',$doctor->id) }}"><i class="bx bx-user-circle"></i></a>
                    </div>
                    @endcan
                    @can('doctor_update')
                    <div class="flex-fill">
                        <a href="{{ route('doctor.edit',$doctor->id) }}"><i class="bx bx-pencil"></i></a>
                    </div>
                    @endcan
                    @can('doctor_delete')
                    <div class="flex-fill">
                        <a><i class="bx bx-trash"></i></a>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection