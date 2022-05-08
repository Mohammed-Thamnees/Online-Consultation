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
                    <li class="breadcrumb-item active">Ticket Details</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
@can('ticket_show')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Ticket Details</h4>
                <p class="card-title-desc"></p>
                <table class="table mb-0">
                    <tbody>
                    <tr>
                        <th>User Name</th>
                        <td>{{ $complaint->user->first_name.' '.$complaint->user->last_name }}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $complaint->title }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{!! $complaint->description !!}</td>
                    </tr>
                    <tr>
                        <th>Attached File</th>
                        <td>
                            @if ($complaint->attach == NULL)
                            <span class="badge bg-danger">No Attached File</span>
                            @else
                            <form method="POST" action="{{ route('attach.download',$complaint->id) }}" enctype="multipart/form-data">
                                @csrf
                                <button type="submit" class="btn bg-success">
                                    Download
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @if ($complaint->reply_attach != NULL)
                    <tr>
                        <th>Reply Attached File</th>
                        <td>
                            <form method="POST" action="{{ route('reply_attach.download',$complaint->id) }}" enctype="multipart/form-data">
                                @csrf
                                <button class="btn bg-success">
                                    Download
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($complaint->status == 0)
                            <span class="badge bg-danger">Not Replied</span>
                            @else
                            <span class="badge bg-success">Replied</span>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endcan

@can('ticket_reply')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Reply Ticket</h4>

                <form method="POST" action="{{ route('complaint.reply',$complaint->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row"> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">Reply</label>
                                    <textarea name="reply"class="form-control">{!! @$complaint->reply !!}</textarea>
                                    @error('reply')
                                        <span class="badge badge-soft-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Attach File</label>
                                <input type="file" name="reply_attach" value="{{ old('reply_attach') }}" class="form-control" id="formrow-password-input">
                                @error('reply_attach')
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
@endcan

@endsection

@push('style')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('script')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

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
