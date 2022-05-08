@extends('admin.layouts.master')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">General Settings</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">General Settings</li>
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
                <h4 class="card-title mb-4">General Settings</h4>

                <form method="POST" action="{{ route('settings.save') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ @$setting->id }}">
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Site Name</label>
                                <input type="text" name="name" value="{{ @$setting->name }}" class="form-control" id="formrow-email-input">
                                @error('name')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Logo Image</label>
                                <input type="file" name="logo" value="{{ old('logo') }}" class="form-control" id="formrow-password-input">
                                @error('logo')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <a class="image-popup-no-margins" href="{{ asset('storage/setting/'.@$setting->logo) }}">
                                    <img class="img-fluid" alt="" src="{{ asset('storage/setting/'.@$setting->logo) }}" width="75">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Fav Icon Image</label>
                                <input type="file" name="fav_icon" value="{{ old('fav_icon') }}" class="form-control" id="formrow-password-input">
                                @error('fav_icon')
                                    <span class="badge badge-soft-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <a class="image-popup-no-margins" href="{{ asset('storage/setting/'.@$setting->fav_icon) }}">
                                    <img class="img-fluid" alt="" src="{{ asset('storage/setting/'.@$setting->fav_icon) }}" width="75">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Copyright Text</label>
                                <textarea name="copyright"class="form-control">{!! @$setting->copyright !!}</textarea>
                                @error('copyright')
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