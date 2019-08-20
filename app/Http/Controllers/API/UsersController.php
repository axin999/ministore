<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersController extends Controller
{
	public function index(){
		return User::latest()->paginate(10);
	}
    public function store(UserFormRequest $request){

/*    	$this->validate($request,[
    		'name'=>'required|string|max:191',
    		'email'=>'required|string|email|max:191|unique:users',
    		'password'=>'required|string|min:6'
    	]);*/
    	return User::create([
    		'name'=>$request['name'],
    		'email'=>$request['email'],
    		'type'=>$request['type'],
    		'bio'=>$request['bio'],
    		'photo'=>$request['photo'], 
    		'password'=>Hash::make($request['password']),
    	]);

    }
    public function update(UserFormRequest $request, $id)
    {
    	$user = User::findOrFail($id);
    	$user ->update($request->all());
    	return ['message'=>'user succesfully updated'];
    }

    public function destroy($id)
    {
    	$user = User::findOrFail($id);
    	$user -> delete();
    	return ['message' => 'user deleted'];
    }
}
