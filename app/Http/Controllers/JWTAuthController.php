<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Media;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Auth;
use Storage;

class JWTAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);
        $user = User::first();
        $token = JWTAuth::fromUser($user);
        
        return Response::json(compact('token'));
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function user(Request $request){
        $user=User::find(Auth::user()->id);
        return response([
            'status'=>'success',
            'data'=>$user
        ]);
    }

    public function logout() {
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function refresh() {
        return response([
            'status' => 'success'
        ]);
    }
    public function upload_image(Request $request)
    {
        $dates = getdate();
        $date =$dates['mon'].'-'.$dates['year'];
        
        $user=Auth::user()->name;

        // $a = $this->validate($request, [
        //     'uploads' => 'image|required|mimes:jpeg,png,jpg,gif,svg'
        // ]);
        // return response()->json(['error'=>$a]);
        // if ($validator->fails()) {
           
        //     return response()->json([$validator->errors(),'status'=>400]);
        // }
        // else {
            $files = $request->file('uploads');

            $path = 'upload/'.$user.'/';
            $item=[];
            $tmp =[];
            $ids=[];
            if(!empty($files)) {
                foreach($files as $file) {
                    
                    $name = $file->getClientOriginalName(); //ten file
                    $type = $file->getMimeType();   //loại
                    $duoifile = explode('/',$type); 


                    $file->move($path.$duoifile[0].'/'.$date, $name);
                    
                    $filepath = public_path($path.$duoifile[0].'/'.$date.'/'.$name);
                    try {
                        $tmp_item=[];
                        $tmp_id=[];
                        \Tinify\setKey("pwGwqcG21J2K4SqX7pPjqhBWRT6n7j9w");
                        //small
                        $source = \Tinify\fromFile($filepath);
                        $resized = $source->resize(array(
                            "method" => "fit",
                            "width" => 64,
                            "height" => 96
                        ));  //fomart size
                        $path1 = $path.$duoifile[0].'/'.$date.'/';
                        $resized->toFile(public_path($path1.'small_'.$name)); //luu file moi
                        $media = Media::create([
                            'filename' => 'small_'.$name,
                            'mimefile' => $path1.'small_'.$name
                        ]);//luu csdl
                        $id = $media->id;
                        $tmp_item['id'] = $id;
                        $tmp_item['ten'] = 'small_'.$name;
                        $tmp_item['loai'] = $type;
                        $tmp_item['duongdan'] = $path.$duoifile[0].'/'.$date.'/small/'.'small_'.$name;
                        array_push($tmp,$tmp_item);
                        array_push($tmp_id,$id);
                        //medium
                        $source2 = \Tinify\fromFile($filepath);
                        $resized2 = $source2->resize(array(
                            "method" => "fit",
                            "width" => 117,
                            "height" => 176
                        ));
                        $path2 =$path.$duoifile[0].'/'.$date.'/';
                        $resized2->toFile(public_path($path2.'medium_'.$name));
                        $media = Media::create([
                            'filename' => 'medium_'.$name,
                            'mimefile' => $path2.'medium_'.$name
                        ]);
                        $id = $media->id;
                        $tmp_item['id'] = $id;
                        $tmp_item['ten'] = 'medium_'.$name;
                        $tmp_item['loai'] = $type;
                        $tmp_item['duongdan'] = $path.$duoifile[0].'/'.$date.'/medium/'.'medium_'.$name;
                        array_push($tmp,$tmp_item);
                        array_push($tmp_id,$id);
                        //large
                        $source3 = \Tinify\fromFile($filepath);
                        $resized3 = $source3->resize(array(
                            "method" => "fit",
                            "width" => 533,
                            "height" => 800
                        ));
                        $path3 = $path.$duoifile[0].'/'.$date.'/';
                        $resized3->toFile(public_path($path3.'large_'.$name));
                        $media = Media::create([
                            'filename' => 'large_'.$name,
                            'mimefile' => $path3.'large_'.$name
                        ]);
                        $id = $media->id;
                        $tmp_item['id'] = $id;
                        $tmp_item['ten'] = 'large_'.$name;
                        $tmp_item['loai'] = $type;
                        $tmp_item['duongdan'] = $path.$duoifile[0].'/'.$date.'/large/'.'large_'.$name;
                        array_push($tmp,$tmp_item);
                        array_push($tmp_id,$id);

                    } catch(\Tinify\AccountException $e) {
                        // Verify your API key and account limit.
                        return redirect('images/create')->with('error', $e->getMessage());
                    }
                    array_push($item,$tmp);   
                    array_push($ids,$tmp_id);   
                        
                }
                return response([
                    'status'=>'success',
                    'data' => $item,
                    'id_image'=>$ids
                ],200);

            }
            else {
                return response([
                    'status'=>'false'
                ],400);
            }
        // }
    }

    public function upload_video(Request $request)
    {
        $dates = getdate();
        $date =$dates['mon'].'-'.$dates['year'];
        
        $user=Auth::user()->name;
        $files = $request->file('uploads');
        $path = 'upload/'.$user.'/';
        $item=[];
        $tmp_item =[];
        $ids=[];
        if(!empty($files)) {
            foreach($files as $file) {
                
                $name = $file->getClientOriginalName();
                $type = $file->getMimeType();
                $duoifile = explode('/',$type);
                $file->move($path.$duoifile[0].'/'.$date, $name);

                $media = Media::create([
                    'filename' => $name,
                    'mimefile' => $path.$duoifile[0].'/'.$date.'/'.$name
                ]);
                $id = $media->id;
                $tmp_item['id'] = $id;
                $tmp_item['ten'] = $name;
                $tmp_item['loai'] = $type;
                $tmp_item['duongdan'] = $path.$duoifile[0].'/'.$date.'/'.$name;
                array_push($item,$tmp_item);
                array_push($ids,$id);

            }
            // $info = $item;
            return response([
                'status'=>'success',
                'data' => $item,
                'id_media'=>$ids
            ],200);

        }
        else {
            return response([
                'status'=>'false'
            ],400);
        }
    }
}
