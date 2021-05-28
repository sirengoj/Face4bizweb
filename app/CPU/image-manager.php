<?php

namespace App\CPU;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageManager
{
    public static function upload(String $dir, String $format, $storage = null, $image = null, $height = null, $width = null)
    {
        if ($image == null) {
            $i = session($storage);
        } else {
            $i[0]['image'] = $image;
        }

        $image_names = [];

        if (isset($i[0])) {
            foreach ($i as $x) {
                $image = $x;
                if ($height == null || $width == null) {
                    $data = getimagesize($image['image']);
                } else {
                    $data[0] = $width;
                    $data[1] = $height;
                }
                $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                $note_img = Image::make($image['image'])->fit($data[0], $data[1])->stream();
                Storage::disk('public')->put($dir . $imageName, $note_img);
                array_push($image_names, $imageName);
            }
        } else {
            $image_names[0] = 'def.png';
        }

        session()->forget($storage);
        return $image_names;
    }

    public static function update(String $dir, $old_image, String $format, $storage = null, $image = null, $height = null, $width = null)
    {
        if ($image == null) {
            $i = session($storage);
        } else {
            $i[0]['image'] = $image;
        }

        if (isset($i[0])) {
            if (Storage::disk('public')->exists($dir . $old_image)) {
                Storage::disk('public')->delete($dir . $old_image);
            }
            $imageName = ImageManager::upload($dir, $format, $storage, $image, $height, $width);
        } else {
            $imageName[0] = $old_image;
        }

        return $imageName;
    }

    public static function keepInSession($image, $remove_route = null, $folder = null, $session_destroy = true)
    {
        if ($session_destroy == true) {
            session()->forget($folder);
        }

        $modal_id = str_replace('_', '-', $folder);

        if ($image != null) {
            session()->push($folder, ['image' => $image, 'remove_route' => $remove_route]);
            session()->push('image_folders', $folder);
            return [
                'success' => 1,
                'images' => view('shared-partials.image-process._show-images', compact('folder', 'modal_id'))->render(),
                'count' => count(session($folder))
            ];
        }

        return [
            'success' => 0,
        ];
    }

    public static function removeFromSession($id, $folder)
    {
        $ar = session($folder);
        unset($ar[$id]);
        session()->put($folder, $ar);
        $modal_id = str_replace('_', '-', $folder);
        return [
            'success' => 1,
            'images' => view('shared-partials.image-process._show-images', compact('folder', 'modal_id'))->render(),
            'count' => count(session($folder))
        ];
    }

    public static function delete($full_path)
    {
        if (Storage::disk('public')->exists($full_path)) {
            Storage::disk('public')->delete($full_path);
        }

        return [
            'success' => 1,
            'message' => 'Removed successfully !'
        ];

    }

    public static function cleanSession()
    {
        $ar = session('image_folders');
        if ($ar != null) {
            foreach ($ar as $a) {
                session()->forget($a);
            }
        }
    }
}
