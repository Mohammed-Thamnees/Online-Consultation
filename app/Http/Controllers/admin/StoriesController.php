<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:story_list');
        $this->middleware('permission:story_create', ['only' => ['create','store']]);
        $this->middleware('permission:story_update', ['only' => ['edit','update']]);
        $this->middleware('permission:story_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->roles[0]['name'] == 'admin') {
            $stories = Story::get();
        }
        else {
            $stories = Story::where('user_id',Auth::user()->id)->get();
        }
        return view('admin.stories.index', compact('stories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.stories.create');
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
            'name' => 'required|string',
            'image' => 'required',
            'status' => 'required',
        ]);

        $story = new Story();
        $story->user_id = Auth::user()->id;
        $story->name = $request->name;
        $story->link = $request->link;

        $image = $request->file('image');
        $imagename = time() . '.' . $request->file('image')->getClientOriginalName();
        $image->storeAs('public/story', $imagename);
        $story->image = $imagename;

        $story->status = $request->status;
        $status = $story->save();

        if ($status) {
            Toastr::success('Story added','Success');
            return redirect()->route('story.index');
        }
        else {
            Toastr::error('Story failed to add','Failed');
            return redirect()->route('story.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $story = Story::findOrFail($id);
        return view('admin.stories.edit', compact('story'));
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
            'name' => 'required|string',
            'status' => 'required',
        ]);

        $story = Story::findOrFail($id);
        $story->name = $request->name;
        $story->link = $request->link;

        if ($request->file('image')) {
            Storage::delete('public/story/'.$story->image);
            $image = $request->file('image');
            $imagename = time() . '.' . $request->file('image')->getClientOriginalName();
            $image->storeAs('public/story', $imagename);
            $story->image = $imagename;
        }

        $story->status = $request->status;
        $status = $story->save();

        if ($status) {
            Toastr::success('Story updated','Success');
            return redirect()->route('story.index');
        }
        else {
            Toastr::error('Story failed to update','Failed');
            return redirect()->route('story.index');
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
        $story = Story::findOrFail($id);
        Storage::delete('public/story/'.$story->image);
        $status = $story->delete();

        if ($status) {
            Toastr::success('Story deleted','Success');
            return redirect()->route('story.index');
        }
        else {
            Toastr::error('Story failed to delete','Failed');
            return redirect()->route('story.index');
        }
    }
}
