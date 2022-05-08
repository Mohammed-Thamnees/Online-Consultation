@extends('admin.layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Chat</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Chat</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="d-lg-flex">
    <div class="chat-leftsidebar me-lg-4">
        <div class="">
            <div class="py-4 border-bottom">
                <div class="media">
                    <div class="align-self-center me-3">
                        <img src="{{ asset('storage/user/'.Auth::user()->image) }}" class="avatar-xs rounded-circle" alt="">
                    </div>
                    <div class="media-body">
                        <h5 class="font-size-15 mt-0 mb-1">{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</h5>
                        <p class="text-muted mb-0"><i class="fas fa-circle text-success align-middle me-1"></i> Online</p>
                    </div>

                    <div>
                        <div class="dropdown chat-noti-dropdown active">
                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-bell bx-tada"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="chat.html#">Action</a>
                              <a class="dropdown-item" href="chat.html#">Another action</a>
                              <a class="dropdown-item" href="chat.html#">Something else here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="search-box chat-search-box py-4">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <i class="bx bx-search-alt search-icon"></i>
                </div>
            </div>

            <div class="chat-leftsidebar-nav">
                <ul class="nav nav-pills nav-justified">
                    <li class="nav-item">
                        <a href="chat.html#chat" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                            <i class="bx bx-chat font-size-20 d-sm-none"></i>
                            <span class="d-none d-sm-block">Chat</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chat.html#contacts" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="bx bx-book-content font-size-20 d-sm-none"></i>
                            <span class="d-none d-sm-block">Contacts</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content py-4">
                    <div class="tab-pane show active" id="chat">
                        <div>
                            <h5 class="font-size-14 mb-3">Recent</h5>
                            <ul class="list-unstyled chat-list" data-simplebar style="max-height: 410px;">
                                @foreach ($users as $user)
                                @if ($user->id != Auth::user()->id)
                                <li class="active">
                                    <a href="{{ route('chat.start',$user->id) }}">
                                        <div class="media">
                                            <div class="align-self-center me-3">
                                                <i class="fas fa-circle text-success font-size-10"></i>
                                            </div>
                                            <div class="align-self-center me-3">
                                                <img src="{{ asset('storage/user/'.$user->image) }}" class="rounded-circle avatar-xs" alt="">
                                            </div>
                                            
                                            <div class="media-body overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-1">{{ $user->first_name.' '.$user->last_name }}</h5>
                                                <p class="text-truncate mb-0">{{ $user->roles[0]['name'] }}</p>
                                            </div>
                                            <div class="font-size-11">05 min</div>
                                        </div>
                                    </a>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="tab-pane" id="contacts">
                        <h5 class="font-size-14 mb-3">Contacts</h5>

                        <div  data-simplebar style="max-height: 410px;">
                            <div>
                                <div class="avatar-xs mb-3">
                                    <span class="badge bg-primary">
                                        Admins
                                    </span>
                                </div>

                                <ul class="list-unstyled chat-list">
                                    @foreach ($users as $user)
                                    @if ($user->hasRole('admin') && $user->id != Auth::user()->id)
                                    <li>
                                        <a href="{{ route('chat.start',$user->id) }}">
                                            <h5 class="font-size-14 mb-0">{{ $user->first_name.' '.$user->last_name }}</h5>
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-4">
                                <div class="avatar-xs mb-3">
                                    <span class="badge bg-primary">
                                        Doctors
                                    </span>
                                </div>

                                <ul class="list-unstyled chat-list">
                                    @foreach ($users as $user)
                                    @if ($user->hasRole('doctor') && $user->id != Auth::user()->id)
                                    <li>
                                        <a href="{{ route('chat.start',$user->id) }}">
                                            <h5 class="font-size-14 mb-0">{{ $user->first_name.' '.$user->last_name }}</h5>
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-4">
                                <div class="avatar-xs mb-3">
                                    <span class="badge bg-primary">
                                        Patients
                                    </span>
                                </div>

                                <ul class="list-unstyled chat-list">
                                    @foreach ($users as $user)
                                    @if ($user->hasRole('patient') && $user->id != Auth::user()->id)
                                    <li>
                                        <a href="{{ route('chat.start',$user->id) }}">
                                            <h5 class="font-size-14 mb-0">{{ $user->first_name.' '.$user->last_name }}</h5>
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 user-chat">
        <div class="card">
            <div class="p-4 border-bottom ">
                <div class="row">
                    <div class="col-md-4 col-9">
                        <h5 class="font-size-15 mb-1">{{ @$to->first_name.' '.@$to->last_name }}</h5>
                        <p class="text-muted mb-0"><i class="fas fa-circle text-success align-middle me-1"></i> {{ @$to->roles[0]['name'] }}</p>
                    </div>
                </div>
            </div>

            @if (isset($msgs))
            <div>
                <div class="chat-conversation p-3">
                    <ul class="list-unstyled mb-0" data-simplebar style="max-height: 486px;">
                        <li> 
                            <div class="chat-day-title">
                                <span class="title">Today</span>
                            </div>
                        </li>

                        @foreach($msgs as $msg)
                        @if ($msg->from_id == $from->id)
                        <li class="right">
                        @elseif ($msg->to_id == $from->id)
                        <li>
                        @endif
                            <div class="conversation-list">
                                <div class="dropdown">

                                    <a class="dropdown-toggle" href="chat.html#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                      </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="chat.html#">Copy</a>
                                        <a class="dropdown-item" href="chat.html#">Save</a>
                                        <a class="dropdown-item" href="chat.html#">Forward</a>
                                        <a class="dropdown-item" href="chat.html#">Delete</a>
                                    </div>
                                </div>
                                <div class="ctext-wrap">
                                    <div class="conversation-name">{{ $msg->from->first_name.' '.$msg->from->last_name }}</div>
                                    <p>
                                        {{ $msg->msg }}
                                    </p>
                                    <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i> {{ Carbon\carbon::parse($msg->created_at)->setTimezone('Asia/Kolkata')->format('h:i A') }}</p>
                                </div>
                                
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="p-3 chat-input-section">
                    <form method="POST" action="{{ route('chat.send') }}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="position-relative">
                                    <input type="hidden" name="to_id" value="{{ $to->id ?? '' }}">
                                    <input type="text" name="msg" class="form-control chat-input" placeholder="Enter Message...">
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-rounded chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Send</span> <i class="bx bxs-send"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div>
                <div class="chat-conversation p-3">
                    <ul class="list-unstyled mb-0" data-simplebar style="max-height: 486px;">
                        <li> 
                            <div class="chat-day-title">
                                <span class="title">Today</span>
                            </div>
                        </li>

                        <li>
                            <div class="conversation-list">
                                <div class="ctext-wrap">
                                    <div class="conversation-name"></div>
                                    <p>
                                        Please select a contact for chat!!
                                    </p>
                                </div>
                                
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>

</div>

@endsection