<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    // INDEX
    public function index() {
      return view('guest.index');
    }

    public function coordinatesHandler(Request $request){

      $data = $request->all();
        #create or update your data here
        return response()->json(['success'=>'Ajax request submitted successfully']);

    }
}
