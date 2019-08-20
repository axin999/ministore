<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryFormRequest;
use App\Category;

class CategoriesController extends Controller
{
	public function index(){
		$categories = Category::all();
		return view('items.index',compact('categories'));
	}

   public function addcategories(CategoryFormRequest $request)
    {
    	$slug = uniqid();
		$category = new Category(array(
			'category_name' => $request->get('category_name'),
			'slug' => $slug
		));
	$category->save();
    return redirect('/')->with('status', 'Your ticket has been created! Its unique id is: '.$slug);
    }

    public function editCategory(CategoryFormRequest $request)
    {
    	$category = Category::find($request->get('id'));
    	$category->category_name = $request->get('category_name');
    	$category->update();
    	return response()->json(['message' => 'tangang wiws'],200);
    }
    public function destroy($id)
    {
		Category::find($id)->delete();
	}
}
