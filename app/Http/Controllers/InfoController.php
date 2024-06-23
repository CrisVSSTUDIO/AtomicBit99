<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;

class InfoController extends Controller
{
    //
    public function store(Request $request)
    {
        ContactInfo::create($request->all());
        Toast::title('Message sent!');
        return back();
    }
}
