<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use App\User;
//use Intervention\Image\Facades\Image;

class UsersController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:api');
    }
	public function index(){
        //$this->authorize('isAdmin');
        if (Gate::allows('isAdmin') || Gate::allows('isUser')){
            return User::latest()->paginate(1); 
        }
		
	}

    public function profile(){
        return auth('api')->user();
    }

    public function updateProfile(UserFormRequest $request){
		$user = auth('api')->user();
        $currentPhoto = $user->photo;

/*        $this->validate($request,[
            'email'=>'required|string|email|max:191|unique:users,email,'.$user->id,
        ]);*/

        function getExtension ($mime_type){
                $extensions = array(
                    'image/jpeg' => 'jpg',
                    'text/xml' => 'xml',
                    'image/png'  => 'png',
                    'image/x-png' => 'png',
                );
                // Add as many other Mime Types / File Extensions as you like
                return $extensions[$mime_type];
                }

        if(isset($request->photo) && $request->photo != $currentPhoto){
            $data = explode( ',', $request->photo );
            $imgdata = base64_decode($data[1]);
            $fifopen = finfo_open();
            $photo_mime_type = finfo_buffer($fifopen, $imgdata, FILEINFO_MIME_TYPE);
                
            //$file_extension  = image_type_to_extension($photo_mime_type); 
            $file_extension  = getExtension($photo_mime_type);
            $save_filename = microtime() . '.' . $file_extension;
            
            \Image::make($request->photo)->save(public_path('img/profile/').$save_filename);
            $request->merge(['photo'=>$save_filename]);

            $oldPhotodel = public_path('img/profile/').$currentPhoto;

                if (file_exists($oldPhotodel)) {
                    @unlink($oldPhotodel);                
                };
        }

            /*This is exmalple if only you are updating specific colum in database
            $user->update(['photo'=> $request->photo]);*/
        if(isset($request->password) && !empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }
         $user->update($request->all());
        

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
        $this->authorize('isAdmin');

    	$user = User::findOrFail($id);
    	$user -> delete();
    	return ['message' => 'user deleted'];
    }

    public function search(){
        if($search = \Request::get('q')){
            $users = User::where(function($query) use ($search){
                    $query->where('name','LIKE',"%$search%")
                    ->orWhere('email','LIKE','%search%')
                    ->orWhere('type','LIKE','%search%');
            })->paginate(1);
        }else{
            $users = User::latest()->paginate(1); 
        }
        return $users;
    }
}
