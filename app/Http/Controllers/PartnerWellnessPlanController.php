<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PartnerWellnessPlan;

class PartnerWellnessPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response(json_encode(PartnerWellnessPlan::all()), 200);
    }
    /**
     * Show the form for creating a new resource. 08677123123
     * TODO ensure the target date is future
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     *  @param  \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\RedirectResponse
     **/
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_code' => 'required',
            'plan_name' => 'required',
            'partner_id' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'failed')->withInput();
        }

        $partnerWellnessPlan = new PartnerWellnessPlan;
        $partnerWellnessPlan->partner_id = $request->partner_id;
        $partnerWellnessPlan->plan_code = $request->input('plan_code');
        $partnerWellnessPlan->plan_name = $request->input('plan_name');
        $partnerWellnessPlan->description = "Needs Update";
        $partnerWellnessPlan->save();
        if(count($partnerWellnessPlan->toArray())) {
            return redirect()->back()->withSuccessMessage("Successfully Added New Plan");
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
        //return response($id);
        return response(PartnerWellnessPlan::find($id), 200);
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
            'plan_code' => 'required',
            'plan_name' => 'required',
            'partner_id' => 'required'
        ]);

        $partnerWellnessPlan = PartnerWellnessPlan::find($id);
        $partnerWellnessPlan->partner_id = $request->input('partner_id');
        $partnerWellnessPlan->plan_code = $request->input('plan_code');
        $partnerWellnessPlan->plan_name = $request->input('plan_name');
        if ($partnerWellnessPlan->save()) {
            return redirect()->route('showplans')->withSuccessMessage("Plan Successfully Updated");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $partnerWellnessPlan = PartnerWellnessPlan::find($id);
        if($partnerWellnessPlan){
            if($partnerWellnessPlan->delete()){
                return "Wellness plan deleted";
            }else{
                return "Wellness plan not deleted.";
            }
        }
    }
}
