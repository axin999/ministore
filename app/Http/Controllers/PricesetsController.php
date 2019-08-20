<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PricesetFormRequest;
use App\Priceset;

class PricesetsController extends Controller
{
    //
    public function showpricesets(Request $request){
        $uri = $request->path();
    	//$pricesets = Priceset::all();
    	//return view('items.index',compact('pricesets'));
        $pricesets = Priceset::where('category_id',$request->get('categoryid'))->get();
        return $pricesets;
        //return view('index',compact('pricesets'))->render();
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
        Priceset::where('priceset_id', $id)->delete();
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
