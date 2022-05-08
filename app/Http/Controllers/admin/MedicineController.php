<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\MedicineType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class MedicineController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:medicine_list');
        $this->middleware('permission:medicine_create', ['only' => ['create','store']]);
        $this->middleware('permission:medicine_update', ['only' => ['edit','update']]);
        $this->middleware('permission:medicine_delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicines = Medicine::get();
        return view('admin.medicine.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = MedicineType::get();
        return view('admin.medicine.create', compact('types'));
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
            'medicine_type_id' => 'required|integer',
            'status' => 'required'
        ]);

        $medicine = new Medicine();
        $medicine->medicine_type_id = $request->medicine_type_id;
        $medicine->name = $request->name;
        $medicine->status = $request->status;
        $status = $medicine->save();

        if ($status) {
            Toastr::success('Medicine added', 'Success');
            return redirect()->route('medicine.index');
        }
        else {
            Toastr::error('Medicine failed to add', 'Failed');
            return redirect()->route('medicine.index');
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
        $medicine = Medicine::findOrFail($id);
        $types = MedicineType::get();
        return view('admin.medicine.edit', compact('medicine','types'));
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
            'medicine_type_id' => 'required|integer',
            'status' => 'required'
        ]);

        $medicine = Medicine::findOrFail($id);
        $medicine->medicine_type_id = $request->medicine_type_id;
        $medicine->name = $request->name;
        $medicine->status = $request->status;
        $status = $medicine->save();

        if ($status) {
            Toastr::success('Medicine updated', 'Success');
            return redirect()->route('medicine.index');
        }
        else {
            Toastr::error('Medicine failed to update', 'Failed');
            return redirect()->route('medicine.index');
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
        $medicine = Medicine::findOrFail($id);
        $status = $medicine->delete();

        if ($status) {
            Toastr::success('Medicine deleted', 'Success');
            return redirect()->route('medicine.index');
        }
        else {
            Toastr::error('Medicine failed to delete', 'Failed');
            return redirect()->route('medicine.index');
        }
    }
}
