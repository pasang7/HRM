<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveType;
class LeaveTypeController extends Controller
{
    public function index(){
        $leaves=LeaveType::all();
        return view('leave-type.index')
                ->with('leaves',$leaves);
    }
    public function create(){
        return view('leave-type.create');
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'days' => 'required|numeric|max:255'
        ]);
        $data=$request->except('_token');
        LeaveType::create($data);
        toastr()->success('Leave Type created successfully', 'Success !!!');
        return redirect()->route('leave-type.index');
    }

    public function edit($id){
        $leave_type=LeaveType::find($id);
        if($leave_type){
            return view('leave-type.edit')
                    ->with('leave_type',$leave_type);
        }else{
            return redirect()->route('leave-type.index');
        }
    }

    public function update(Request $request){
        $request->validate([
            'id'=>'required|exists:leave_types,id',
            'days'=>'required'
        ]);

        $leave_type=LeaveType::find($request->id);
        if($leave_type){
                $leave_type->name=$request->name;
                $leave_type->short_name=$request->short_name;
                $leave_type->days=$request->days;
                $leave_type->carry_forward=$request->carry_forward;
            // if($request->days!=$leave_type->days){
            // }
        }
        $leave_type->update();
        toastr()->success('Leave Type updated successfully', 'Success !!!');
        return redirect()->route('leave-type.index');

    }
}
