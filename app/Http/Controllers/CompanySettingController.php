<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    protected $imageController;
    function __construct(ImageController $imageController)
    {
        $this->imageController=$imageController;
    }
    public function index()
    {
        $data['setting'] = CompanySetting::where('id', 1)->first();
        return view('setting.company_setting')->with($data);
    }

    public function update(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required',
            'min_leave_days_for_review' => 'required|numeric',
            'normal_overtime_rate' => 'numeric',
            'day_in_month' => 'required|numeric',
            'month_in_year' => 'numeric',
            'working_hour' => 'required|numeric',
        ]);
        //logo validation
        if($request->has('logo')){
            $request->validate([
                'logo' => 'mimes:jpg,jpeg,png'
            ]);
        }
        if($request->bonus_type == 'customize'){
            $request->validate([
                'customize_amount' => 'numeric'
            ]);
        }
        $settingInfo=$request->all();
        $folder_name='Setting';
        $setting=CompanySetting::where('id',$request->get('id'))->first();
        if(!empty($setting)){
            if($request->file('logo')==''){
                if($request->get('delete_logo')){
                    $this->imageController->deleteImg($folder_name,$setting->logo);
                    $settingInfo['logo'] = NULL;
                }else {
                    $settingInfo['logo'] = $setting->logo;
                }
            }
            else{
                $this->imageController->deleteImg($folder_name,$setting->logo);
                $ImgName=$this->imageController->saveOrgImg($request,$folder_name,'logo');
                $settingInfo['logo']=$ImgName;
            }
            if($request->bonus == 'no'){
                $settingInfo['bonus_type'] = 'none';
                $settingInfo['customize_amount'] = 0;

            }else{
                $settingInfo['bonus_type'] = $request->bonus_type;
            }

            $setting->update($settingInfo);

            toastr()->success('Settings updated.', 'Success !!!');
            return redirect()->route('company-setting.index');
        }

        toastr()->error('Update Failed', 'Oops !!!');
        return redirect()->route('company-setting.index');
    }
}
