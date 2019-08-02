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

    /**
     * @OA\Get(
     *      path="/user/profile",
     *      tags={"Personal"},
     *      summary="取得個人資料",
     *      description="利用 header 附帶的 token 來取得個人資料",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(response=200, description="取得個人資料"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function getProfile()
    {
        $userId = Auth::id();

        $data = $this->service->getProfile($userId);

        return response()->json($data);
    }
}
