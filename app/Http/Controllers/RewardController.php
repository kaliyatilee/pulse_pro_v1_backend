<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Reward;

class RewardController extends Controller
{
    public function store(Request $request) {

        $this->validate($request, [
            'reward_name' => ['required'],
            'pulse_points' => ['required'],
            'description' => ['required'],
            'amount' => ['required'],
            'partner_id' => ['required'],
        ]);


        $partner_id = $request->partner_id ? $request->partner_id : null;

        $reward = new Reward();

        $reward->reward_name = $request->reward_name;
        $reward->quantity = $request->amount;
        $reward->pulse_points = $request->pulse_points;
        $reward->description = $request->description;
        $reward->partner_id = $partner_id;


        if ($request->hasFile('imageurl')) {
            $path = $request->file('imageurl')->store('pulsehealth/images');
            Storage::disk()->setVisibility($path, 'public');
            $image = [
                'filename' => basename($path),
                'url' => Storage::disk('s3')->url($path)
            ];
            $reward->imageurl = $image['url'];
        }
        $reward->save();
        if($reward) {
            return redirect()->back()->withSuccessMessage("Reward Successfully Created!");
        }

        return Redirect::back()->withErrors("Failed");
    }
}
