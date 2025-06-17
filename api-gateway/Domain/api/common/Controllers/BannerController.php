<?php

namespace Domain\api\common\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Helpers\ApiResponse;
use App\Traits\FileUpload;
use Domain\api\common\Resources\BannerRes;
use Domain\api\common\Services\BannerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    use FileUpload;

    public function getAll(BannerService $bannerService)
    {
        return ApiResponse::success("Banners", BannerRes::collection($bannerService->getAll()), 200);
    }

    public function store(Request $request, BannerService $bannerService)
    {
        $request->validate(["image" => "required"]);
        $status = $bannerService->store($request);
        return ApiResponse::success("Created", new BannerRes($status), 200);
    }

    function destory($id, BannerService $bannerService)
    {
        return $bannerService->deleteById($id) ?
            ApiResponse::success("Deleted !", ["Target  id" => $id], 201) :
            ApiResponse::error("Deleted !", 500);
    }

    public function update(Request $request, $id, BannerService $bannerService)
    {
        return $bannerService->update($id, $request) ?
            ApiResponse::success("Update !", ["Target  id" => $id], 200) :
            ApiResponse::error("Delete Err !", 500);

    }

    function changeStatus($id, BannerService $bannerService)
    {
        return $bannerService->changeStatus($id);
    }
    private function validateRequest($req)
    {
        return Validator::make($req->all(), [
            "image" => "required",
        ]);
    }
}