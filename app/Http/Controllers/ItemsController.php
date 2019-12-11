<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ItemFormRequest;
use App\Item;
use App\Price;
use DB;

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
    function additems(Request $request)
    {
        
    	$slug = uniqid();
		$item = new Item(array(
            'category_id' => 1,
			'name' => $request->itemname,
            'description' => $request->description,
            'quantity' => $request->quantity,
			'slug' => $slug,
		));
    $item->save();
    foreach ($request->prices as $pricekey => $pricedata) {
        if($pricedata[1] != null){
            $price = new Price(array(
                    'priceset_id' => $pricedata[0],
                    'price' => $pricedata[1],
                ));

            $item->prices()->save($price);
        }
    }
            
        return $request->prices;

    //return $request;
     
    //return redirect('/')->with('status', 'Your ticket has been created! Its unique id is: '.$slug);
    }
    function showitem(Request $request){
        $pricelist = DB::table('items AS i')
        ->join('categories AS c','c.id','i.category_id')
        ->join('pricesets AS ps','ps.category_id','c.id')
        ->leftJoin('prices AS pr', function($join){
            $join->on('pr.priceset_id', '=', 'ps.id')
                 ->on('pr.item_id', '=', 'i.id');
                 })
        ->where('i.id', '=', $request->itemid)
        ->where('c.id','=',  $request->categoryid)
        ->select('i.id','i.name','i.description','ps.priceset_type','pr.price','ps.category_id','pr.priceset_id','c.category_name','pr.id AS priceid', 'priceset_type')

        ->get()
        ->toJSON()
        ;

        return $pricelist;
    }

    function showitemlist(){
        $pricelist = DB::table('items AS i')
        ->join('categories AS c','c.id','i.category_id')
        ->join('pricesets AS ps','ps.category_id','c.id')
        ->leftJoin('prices AS pr', function($join){
            $join->on('pr.priceset_id', '=', 'ps.id')
                 ->on('pr.item_id', '=', 'i.id');
                 })
        ->select('i.id','i.name','i.description','ps.priceset_type','pr.price','ps.category_id','pr.priceset_id','c.category_name','pr.id AS priceid')
        ->get()
        ->toJSON()
        ;

        

        //$pricelist = Item::all();
       /* $pricelist = Item::get();
        $pricelist->prices;*/

        return $pricelist;
    }

    function updateitemlist(Request $request, $id){

      $item =  DB::table('items AS i')
        ->join('categories AS c','c.id','i.category_id')
        ->join('pricesets AS ps','ps.category_id','c.id')
        ->where('i.id','=', $id)
        ->update(array( 
            'i.name' => $request->name,
            'i.description' => $request->description,
            'i.category_id' => $request->categoryid,

        ));

        foreach ($request->pricestoedit as $pricestoeditkey => $pricestoeditvalue) {
            if(!isset($pricestoeditvalue['price'])){
                $setprice = array('price' => 0);
                $pricestoeditvalue = array_merge($pricestoeditvalue,$setprice);
            };
            if(!isset($pricestoeditvalue['priceid']) || $pricestoeditvalue['priceid'] == null){
                    $price = new Price(array(
                        'item_id' => $request->id,
                        'priceset_id' => $pricestoeditvalue['pricesetid'],
                        'price' => $pricestoeditvalue['price']
                    ));
                    $price->save();
            }
            elseif(isset($pricestoeditvalue['priceid']) || $pricestoeditvalue['priceid'] != null){
                    $price = Price::where('id',$pricestoeditvalue['priceid'])
                    ->update(['price' => $pricestoeditvalue['price']]);                    
            }
        };
        /*->updateOrInsert(array(
            'pr.id' => 1000,
            'pr.item_id' => 1,
            'pr.priceset_id' => 7,
            'pr.price' => 13,

        ));*/
 
       /* return $request->pricestoedit;*/
    }
}
