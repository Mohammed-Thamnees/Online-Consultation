<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ticket_list');
        $this->middleware('permission:ticket_create', ['only' => ['create','store']]);
        $this->middleware('permission:ticket_update', ['only' => ['edit','update']]);
        $this->middleware('permission:ticket_delete', ['only' => ['destroy']]);
        $this->middleware('permission:ticket_show', ['only' => ['show']]);
        $this->middleware('permission:ticket_reply', ['only' => ['reply']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complaints = Complaint::get();
        return view('admin.complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.complaints.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required'
        ]);

        $complaint = new Complaint();
        $complaint->user_id = Auth::user()->id;
        $complaint->title = $request->title;
        $complaint->description = $request->description;

        if ($request->file('attach')) {
            $image = $request->file('attach');
            $filename = time() . '.' . $request->file('attach')->getClientOriginalName();
            $image->storeAs('public/complaint', $filename);
            $complaint->attach = $filename;
        }

        $complaint->status = 0;
        $status = $complaint->save();

        if ($status) {
            Toastr::success('Ticket rised', 'Success');
            return redirect()->route('complaint.index');
        }
        else {
            Toastr::error('Ticket failed to rise', 'Failed');
            return redirect()->route('complaint.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('admin.complaints.edit', compact('complaint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required'
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->title = $request->title;
        $complaint->description = $request->description;

        if ($request->file('attach')) {
            Storage::delete('public/complaint/'.$complaint->attach);
            $image = $request->file('attach');
            $filename = time() . '.' . $request->file('attach')->getClientOriginalName();
            $image->storeAs('public/complaint', $filename);
            $complaint->attach = $filename;
        }

        $status = $complaint->save();

        if ($status) {
            Toastr::success('Ticket edited', 'Success');
            return redirect()->route('complaint.index');
        }
        else {
            Toastr::error('Ticket failed to edit', 'Failed');
            return redirect()->route('complaint.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        if ($complaint->attach != NULL) {
            Storage::delete('public/complaint/'.$complaint->attach);
        }
        if ($complaint->reply_attach != NULL) {
            Storage::delete('public/complaint/'.$complaint->reply_attach);
        }

        $status = $complaint->delete();

        if ($status) {
            Toastr::success('Ticket deleted', 'Success');
            return redirect()->route('complaint.index');
        }
        else {
            Toastr::error('Ticket failed to delete', 'Failed');
            return redirect()->route('complaint.index');
        }
    }

    public function attachdownload(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $random = rand(0,100);
        return Storage::download('public/complaint/'.$complaint->attach, 'attachfile'.$random);
    }

    public function replyattachdownload(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $random = rand(0,100);
        return Storage::download('public/complaint/'.$complaint->reply_attach, 'replyattachfile'.$random);
    }

    public function reply(Request $request, $id)
    {
        $this->validate($request, [
            'reply' => 'required|string',
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->reply = $request->reply;
        $complaint->status = 1;

        if ($request->file('reply_attach')) {
            if ($complaint->reply_attach != NULL) {
                Storage::delete('public/complaint/'.$complaint->reply_attach);
            }
            $image = $request->file('reply_attach');
            $filename = time() . '.' . $request->file('reply_attach')->getClientOriginalName();
            $image->storeAs('public/complaint', $filename);
            $complaint->reply_attach = $filename;
        }

        $status = $complaint->save();

        if ($status) {
            Toastr::success('Ticket replied', 'Success');
            return redirect()->route('complaint.index');
        }
        else {
            Toastr::error('Ticket failed to reply', 'Failed');
            return redirect()->route('complaint.index');
        }
    }

}
