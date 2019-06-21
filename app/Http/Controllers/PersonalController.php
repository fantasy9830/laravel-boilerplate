<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use App\Services\PersonalService;

class PersonalController extends Controller
{
    protected $service;

    public function __construct(PersonalService $service)
    {
        $this->service = $service;
    }

    public function getProfile()
    {
        $userId = Auth::id();

        $data = $this->service->getProfile($userId);

        return response()->json($data);
    }
}
