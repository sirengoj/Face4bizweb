<?php

namespace App\Http\Controllers\Admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        ImageManager::cleanSession();
        $categories=Category::where(['position'=>0])->paginate(10);
        return view('admin-views.category.view',compact('categories'));
    }

    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $x = ImageManager::upload('category/', 'png', 'category_icon_modal');
        $category->icon = $x[0];
        $category->parent_id = 0;
        $category->position = 0;
        $category->save();
        return response()->json();
    }

    public function edit(Request $request)
    {
        $data = Category::where('id', $request->id)->first();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $x = ImageManager::update('category/', $category->icon, 'png','category_icon_modal');
        $category->icon = $x[0];
        $category->parent_id = 0;
        $category->position = 0;
        $category->save();
        return response()->json();
    }

    public function delete(Request $request)
    {
        $categories = Category::where('parent_id', $request->id)->get();
        if (!empty($categories)) {

            foreach ($categories as $category) {
                $categories1 = Category::where('parent_id', $category->id)->get();
                if (!empty($categories1)) {
                    foreach ($categories1 as $category1) {
                        Category::destroy($category1->id);
                    }
                }
                Category::destroy($category->id);
            }
        }
        Category::destroy($request->id);
        return response()->json();
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::where('position', 0)->orderBy('id', 'desc')->get();
            return response()->json($data);
        }
    }
}
