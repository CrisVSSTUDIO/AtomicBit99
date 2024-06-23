<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\Splade\Facades\Toast;

class SettingsController extends Controller
{
    //
    public function index()
    {
        return view('settings.index');
    }
    public function setAssetPrediction(Request $request)
    {
        if ($request->use_prediction == 1) {
            DB::table('assets')->where('user_id', Auth::id())->update(['use_prediction' => 1]);
        } else {
            DB::table('assets')->where('user_id', Auth::id())->update(['use_prediction' => 0]);
        }
        // Return accuracy and predictions
        Toast::title('Setting saved!')->autoDismiss(8);
        return back();
    }
}
