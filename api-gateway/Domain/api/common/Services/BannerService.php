<?php
namespace Domain\api\common\Services;


use App\Models\Banner;
use App\Traits\FileUpload;
use Intervention\Image\Facades\Image;

class BannerService
{

    use FileUpload;
    function getAll()
    {
        return Banner::orderBy("sort")->get();
    }

    function getById($id)
    {
        return Banner::find($id);
    }

    function store($request)
    {
        $input = $request->only('title', 'desc', 'link', 'sort', 'for');
        $uploadPath = public_path('uploads/banners');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        $file_name = uniqid() . '.webp';
        $file_path = $uploadPath . '/' . $file_name;
        $file_url = '/uploads/banners/' . $file_name;
        Image::make($request->file('image'))
            ->encode('webp', 50)
            ->save($file_path);
        $input['image'] = $file_url;
        return Banner::create($input);
    }

    function deleteById($id)
    {
        return Banner::destroy($id);
    }

    function changeStatus($id)
    {

    }

    function update($id, $request)
    {
        $input = $request->only('title', 'desc', 'link', 'sort');
        if ($request->hasFile('image')) {
            $uploadPath = public_path('uploads/banners');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file_name = uniqid() . '.webp';
            $file_path = $uploadPath . '/' . $file_name;
            $file_url = '/uploads/banners/' . $file_name;

            Image::make($request->file('image'))
                ->encode('webp', 50)
                ->save($file_path);

            $input['image'] = $file_url;
        }
        return Banner::findOrFail($id)->update($input);
    }
}