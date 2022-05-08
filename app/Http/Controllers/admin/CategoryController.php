<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\DoctorCategory;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Brian2694\Toastr\Facades\Toastr;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:category_list');
        $this->middleware('permission:category_create', ['only' => ['create','store']]);
        $this->middleware('permission:category_update', ['only' => ['edit','update']]);
        $this->middleware('permission:category_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $status = $category->save();

        if ($status) {
            Toastr::success('Category added','Success');
            return redirect()->route('category.index');
        }
        else {
            Toastr::error('Category failed to add','Failed');
            return redirect()->route('category.index');
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
        //
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
            'name' => 'required'
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $status = $category->save();

        if ($status) {
            Toastr::success('Category updated','Success');
            return redirect()->route('category.index');
        }
        else {
            Toastr::error('Category failed to update','Failed');
            return redirect()->route('category.index');
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
        $category = Category::findOrFail($id);
        $doctors = DoctorCategory::where('category_id',$id)->first();

        if ($doctors) {
            Toastr::error('Doctors exist in this category.','Failed');
            return redirect()->route('category.index');
        }
        else {
            $status = $category->delete();
        }

        if ($status) {
            Toastr::success('Category deleted','Success');
            return redirect()->route('category.index');
        }
        else {
            Toastr::error('Category failed to delete','Failed');
            return redirect()->route('category.index');
        }
    }
}
