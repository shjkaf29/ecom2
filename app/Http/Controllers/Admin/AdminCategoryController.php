<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function addCategory() {
        return view('admin.addcategory');
    }

    public function postAddCategory(Request $request) {
        $category = new Category();
        $category->category = $request->category;
        $category->save();

        return redirect()->back()->with('category_message', 'Category Added Successfully!');
    }

    public function viewCategory() {
        $categories = Category::all();
        return view('admin.viewcategory', compact('categories'));
    }

    public function deleteCategory($id) {
        Category::findOrFail($id)->delete();
        return redirect()->back()->with('deletecategory_message', 'Category deleted successfully!');
    }

    public function updateCategory($id) {
        $category = Category::findOrFail($id);
        return view('admin.updatecategory', compact('category'));
    }

    public function postUpdateCategory(Request $request, $id) {
        $category = Category::findOrFail($id);
        $category->category = $request->category;
        $category->save();

        return redirect()->back()->with('update_message', 'Category updated successfully!');
    }
}
