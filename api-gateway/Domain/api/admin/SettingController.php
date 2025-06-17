<?php

namespace Domain\api\admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request, Setting $mod)
    {
        $data = $mod->select("id", "key", 'value', 'holding_values', 'input_type', 'description', 'icon')->get();
        return ApiResponse::success("Settings", $data, 200);
    }
    public function update(Request $request, Setting $mod)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required',
        ]);
        $setting = $mod->where('key', $request->input('key'))->first();
        if ($setting) {
            $setting->update($request->only('value', 'description'));
            $status = $setting;
        } else {
            $status = $mod->create($request->only('key', 'value', 'description'));
        }
        if ($status) {
            return ApiResponse::success("Setting " . ($setting ? "Updated" : "Created"), $status, 201);
        } else {
            return ApiResponse::error("Failed", 500);
        }
    }

   
}
