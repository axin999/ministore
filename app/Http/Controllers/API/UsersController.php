<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
//use Intervention\Image\Facades\Image;

class UsersController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:api');
    }
	public function index(){
		return User::latest()->paginate(10);
	}

    public function profile(){
        return auth('api')->user();
    }

    public function updateProfile(Request $request){
		$user = auth('api')->user();

        function getExtension ($mime_type){
                $extensions = array('image/jpeg' => 'jpg',
                'text/xml' => 'xml'
                );
                // Add as many other Mime Types / File Extensions as you like
                return $extensions[$mime_type];
                }

        if(isset($request->photo)){
            $data = explode( ',', $request->photo );
            $imgdata = base64_decode($data[1]);
            $fifopen = finfo_open();
            $photo_mime_type = finfo_buffer($fifopen, $imgdata, FILEINFO_MIME_TYPE);
                
            //$file_extension  = image_type_to_extension($photo_mime_type); 
            $file_extension  = getExtension($photo_mime_type);
            $save_filename = microtime() . '.' . $file_extension;
            \Image::make($request->photo)->save(public_path('img/profile/').$save_filename);
        }


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
