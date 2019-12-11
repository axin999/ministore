<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PricesetFormRequest;
use App\Priceset;
use DB;

class PricesetsController extends Controller
{
    //
    public function showpricesets(Request $request){
        //$uri = $request->path();
       /* The path method returns the request's path information. So, if the incoming request is targeted at http://domain.com/foo/bar, the path method will return foo/bar:*/
       
    	//$pricesets = Priceset::all();
    	//return view('items.index',compact('pricesets'));
        $pricesets = Priceset::where('category_id',$request->categoryid)
        ->select('id AS pricesetid','category_id','priceset_type')
        ->get();
        return $pricesets;
        //return view('index',compact('pricesets'))->render();
    }

    public function priceset_price(Request $request){
        $prices = DB::table('pricesets AS ps')
        ->join('prices AS pr','pr.priceset_id','ps.id')
        ->where('ps.category_id','=',$request->categoryid)
        ->where('pr.item_id','=',$request->itemid)
        ->select('ps.id AS pricesetid','ps.category_id','ps.priceset_type','pr.id AS priceid','pr.item_id','pr.priceset_id','pr.price')
        ->get();

        return $prices;
    }

    public function addpriceset(PricesetFormRequest $request){
    	/*$slug = uniqid();
        
		$priceset_type = new Priceset(array(
			'priceset_type' => $request->get('priceset_type'),
            'category_id' => $request->get('category_id'),
			'slug' => $slug
		));
		$priceset_type->save();*/
        //return $request;

        foreach ($request->priceset_type as $key => $value) {
            $slug = uniqid();
            $priceset_type = new Priceset(array(
            'priceset_type' => $request->priceset_type[$key],
            'category_id' => $request->get('category_id'),
            'slug' => $slug
            ));
            $priceset_type->save();
        }
        
    } 
    
    public function destroy($id){
        //DB::table('Priceset')->delete($id);
        Priceset::where('id', $id)->delete();
        //Priceset::find($id)->delete();


    }    

/*    public function addpriceset(PricesetFormRequest $request){
        

        if (isset($request->validator) && $request->validator->fail()) {  
            //return response()->json($request->validator->messages(), 200);
            //return $request->failedValidation();
            return $validator->errors();
        }
        else{
            $slug = uniqid();
                 $priceset_type = new Priceset(array(
                'priceset_type' => $request->get('priceset_type'),
                'category_id' => $request->get('category_id'),
                'slug' => $slug
            ));
            $priceset_type->save();
           return response()->json(['success' => true, 'message' => 'success'], 200);
        }
         
    }*/
}
