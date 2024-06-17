<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use Illuminate\Support\Str;
use DB;

class DesignationController extends Controller
{
    public function index(){
        $designations=Designation::where('is_default',false)->paginate(500);
        $designations->appends('designation_status');
        return view('designation.index')
                ->with('designations',$designations);
    }
   
    public function store(Request $request){
        $request->validate([
            'name' => 'bail|required',
            'is_active' => 'bail|required',
        ]);
        $input = $request->all();
        $input['slug']= Str::slug($request->name);
        // dd($input);
        Designation::create($input);
        toastr()->success('Designation created', 'Success!!');
        return redirect()->route('designation.index');
    }

    public function edit($id){
        $designation = Designation::where('id', $id)->first();
        return view('designation.edit', compact('designation'));
    }
    public function update($id, Request $request){
        $request->validate([
            'name' => 'bail|required',
            'is_active' => 'bail|required',
        ]);
        $designation=Designation::where('id', $id)->first();
        $designation['name'] = $request->get('name');
        $designation['slug'] = Str::slug($request->name);
        $designation['is_active'] = $request->get('is_active');
        $designation->update();
        toastr()->success('Designation updated', 'Success!!');
        return redirect()->route('designation.index');
    }
    
    public function statusChange(Request $request){
        $status = $request->get('status');
         if($status == 'yes'){
           DB::table('designations')->where('id', $request->get('id'))->update([
               'is_active' => 'no'
           ]);
           
        }else{
            DB::table('designations')->where('id', $request->get('id'))->update([
                'is_active' => 'yes'
            ]);
        }
        return 1;
    }
}
