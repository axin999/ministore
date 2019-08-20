<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ItemFormRequest;
use App\Item;

class ItemsController extends Controller
{

     public function __construct(){
        $this->middleware('auth');
       
    }
    function index(){
        return view('items.index');
    }
    function itemform()
    {
    	return view('items.index');
    }
    function additems(ItemFormRequest $request)
    {
    	$slug = uniqid();
		$item = new Item(array(
			'name' => $request->get('name'),
			'slug' => $slug
		));
	$item->save();
    return redirect('/')->with('status', 'Your ticket has been created! Its unique id is: '.$slug);
    }
}
