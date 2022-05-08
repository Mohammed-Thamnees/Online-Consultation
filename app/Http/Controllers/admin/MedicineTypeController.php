<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\MedicineType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class MedicineTypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:medicine_type_list');
        $this->middleware('permission:medicine_type_create', ['only' => ['create','store']]);
        $this->middleware('permission:medicine_type_update', ['only' => ['edit','update']]);
        $this->middleware('permission:medicine_type_delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicine_types = MedicineType::get();
        return view('admin.medicine_type.index', compact('medicine_types'));
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

        $type = new MedicineType();
        $type->name = $request->name;
        $status = $type->save();

        if ($status) {
            Toastr::success('Medicine type added', 'Success');
            return redirect()->route('medicinetype.index');
        }
        else {
            Toastr::error('Medicine type failed to add', 'Failed');
            return redirect()->route('medicinetype.index');
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

        $type = MedicineType::findOrfail($id);
        $type->name = $request->name;
        $status = $type->save();

        if ($status) {
            Toastr::success('Medicine type updated', 'Success');
            return redirect()->route('medicinetype.index');
        }
        else {
            Toastr::error('Medicine type failed to update', 'Failed');
            return redirect()->route('medicinetype.index');
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
        $type = MedicineType::findOrFail($id);
        $medicine = Medicine::where('medicine_type_id',$id)->first();
        if ($medicine) {
            Toastr::error('Medicine exist in this type', 'Failed');
            return redirect()->route('medicinetype.index');
        }
        else {
            $status = $type->delete();

            if ($status) {
                Toastr::success('Medicine type deleted', 'Success');
                return redirect()->route('medicinetype.index');
            }
            else {
                Toastr::error('Medicine type failed to delete', 'Failed');
                return redirect()->route('medicinetype.index');
            }
        }
    }
}
