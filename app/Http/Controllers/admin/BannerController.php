<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:banner_list');
        $this->middleware('permission:banner_create', ['only' => ['create','store']]);
        $this->middleware('permission:banner_update', ['only' => ['edit','update']]);
        $this->middleware('permission:banner_delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::get();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create');
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

        $banner = new Banner();
        $banner->name = $request->name;
        $banner->link = $request->link;

        $image = $request->file('image');
        $imagename = time() . '.' . $request->file('image')->getClientOriginalName();
        $image->storeAs('public/banner', $imagename);
        $banner->image = $imagename;

        $banner->status = $request->status;
        $status = $banner->save();

        if ($status) {
            Toastr::success('Banner added','Success');
            return redirect()->route('banners.index');
        }
        else {
            Toastr::error('Banner failed to add','Failed');
            return redirect()->route('banners.index');
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
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
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

        $banner = Banner::findOrFail($id);
        $banner->name = $request->name;
        $banner->link = $request->link;

        if ($request->file('image')) {
            Storage::delete('public/banner/'.$banner->image);
            $image = $request->file('image');
            $imagename = time() . '.' . $request->file('image')->getClientOriginalName();
            $image->storeAs('public/banner', $imagename);
            $banner->image = $imagename;
        }

        $banner->status = $request->status;
        $status = $banner->save();

        if ($status) {
            Toastr::success('Banner updated','Success');
            return redirect()->route('banners.index');
        }
        else {
            Toastr::error('Banner failed to update','Failed');
            return redirect()->route('banners.index');
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
        $banner = Banner::findOrFail($id);
        Storage::delete('public/banner/'.$banner->image);
        $status = $banner->delete();

        if ($status) {
            Toastr::success('Banner deleted','Success');
            return redirect()->route('banners.index');
        }
        else {
            Toastr::error('Banner failed to delete','Failed');
            return redirect()->route('banners.index');
        }
    }
}
