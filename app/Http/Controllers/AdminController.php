<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class AdminController extends Controller
{
    function addCategory(){
        return view('admin.addcategory');
    }

    function postAddCategory(Request $request){

        $category = new Category();

        $category->category = $request->category;

        $category->save();

        return redirect()->back()->with('category_message', 'Category Added Successfully!!!');
    }

    public function viewCategory(){
        $categories = Category::all();
        return view('admin.viewcategory', compact('categories'));
    }

    public function deleteCategory($id){

        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->back()->with("deletecategory_message","Category deleted Successfully");

    }

    public function updateCategory($id){
        $category = Category::findOrFail($id);

        return view("admin.updatecategory", compact('category'));
    }

    public function postUpdateCategory(Request $request, $id){

        $category = Category::findOrFail($id);

        $category->category = $request->category;

        $category->save();

        return redirect()->back()->with("update_message","Category updated successfully");
    }

    public function addProduct(){
       $categories = Category::all(); 
       return view('admin.addproduct', compact('categories'));
    }

    public function postAddProduct(Request $request){
        $product = new Product;
        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_prices = $request->product_prices;
        $product->product_quantity = $request->product_quantity;
        $product->product_category = $request->product_category;

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('product_images'), $imageName);
            $product->product_image = $imageName; 
        }

        $product->save();

        return redirect()->back()->with('product_message', 'Product added successfully!');

        }

        public function viewProduct(){
            $products = Product::all();
            return view("admin.viewproduct",compact('products'));
        }

        public function deleteProduct($id){
            $products = Product::findOrFail($id);
            $products->delete();
            return redirect()->back()->with("delete_message", "Product Deleted Successfully");
        }

        public function updateProduct($id) {
            $product = Product::findOrFail($id);
            $categories = Category::all();
            return view('admin.updateproduct', compact('product', 'categories'));
        }

        public function postUpdateProduct(Request $request, $id) {
            $product = Product::findOrFail($id);

            $product->product_title = $request->product_title;
            $product->product_description = $request->product_description;
            $product->product_prices = $request->product_prices;
            $product->product_quantity = $request->product_quantity;
            $product->product_category = $request->product_category;

            if ($request->hasFile('product_image')) {
                $image = $request->file('product_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('product_images'), $imageName);
                $product->product_image = $imageName;
            }

            $product->save();

            return redirect()->back()->with('product_message', 'Product updated successfully!');
        }


}
