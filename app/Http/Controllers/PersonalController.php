<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;

class PersonalController extends Controller
{
    public function getProfile()
    {
        $data = Auth::user();

        return response()->json($data);
    }
}
