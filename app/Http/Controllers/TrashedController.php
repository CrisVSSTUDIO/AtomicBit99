<?php

namespace App\Http\Controllers;

use App\Tables\Trashed;
use Illuminate\Http\Request;

class TrashedController extends Controller
{
    //
    public function index()
    {
        return view('trashed.index', [

            'trashed' => Trashed::class
        ]);
    }
}
