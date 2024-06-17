<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeTax;
use App\Models\SsTaxSlab;
use App\Models\TaxSlab;

class TaxSlabController extends Controller
{
    public function create(Request $request){
        $res['status']=false;
        $res['message']='Oops something went wrong';
        if($request->has('amount') && $request->has('percent') && $request->percent>0){
            $data['income_tax_id']=$request->income_tax_id;            
            $data['amount']=$request->amount;
            $data['percent']=$request->percent;
            $max_tax_rule=TaxSlab::where('income_tax_id',$request->income_tax_id)->first();
            if($max_tax_rule===null){               
                $position=1;
            }else{                
                $position=$max_tax_rule->position+1;
            }
            $data['position']=$position;
            $tax_slab=TaxSlab::create($data);
            $res['status']=true;
            $res['tax_slab']=$tax_slab;
            $res['tax_slab_id']=$tax_slab->id;
        }
        return json_encode($res);
    }
    public function updateOrder(Request $request){
        $orders=$request->order;
        foreach($orders as $key=>$order){
            $order =explode( '-', $order );
            $order_id=$order[2];
            $tax_rule=TaxSlab::find($order_id);
            $tax_rule->position= ++$key;
            $tax_rule->update();
        }
    }
    public function updateSST(Request $request, $id){
        $request->validate([
            'percent' => 'required|numeric',
            'amount' => 'required|numeric'
        ]);
        $socialSecurityTax = SsTaxSlab::find($id);
        if(!empty($socialSecurityTax)){
            $socialSecurityTaxInfo = $request->all();
            if($request->has('amount')  && $request->has('percent') && $request->percent>0 && $request->amount>0){
                $socialSecurityTaxInfo['income_tax_id'] = $request->income_tax_id;  
                $socialSecurityTaxInfo['amount']=$request->amount;
                $socialSecurityTaxInfo['percent']=$request->percent;
                $socialSecurityTaxInfo['position']=1;
                if($socialSecurityTax->update($socialSecurityTaxInfo)){
                toastr()->success('Tax Updated', 'Success !!!');
                return redirect()->route('income-tax.index');
                }
                toastr()->error('Problem in updating', 'Oops !!!');
                return redirect()->route('income-tax.index');
            }else{
                toastr()->error('Amount or Percent can not be Zero', 'Oops !!!');
                return redirect()->route('income-tax.index');
            }
        }
    }
}
