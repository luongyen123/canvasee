<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use JWTFactory;

use App\Media;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use JWTAuth;
use Response;
use Validator;
use App\Userlocation;
use App\Cities;
use  App\Countries;


class JWTAuthController extends Controller {
	public function register(Request $request) {
		$clientIP = \Request::getClientIp(true);

		$validator = Validator::make($request->all(), [
			'email' => 'required|string|email|max:255|unique:users',
			'name' => 'required',
			'password' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json($validator->errors());
		}
		$newuser = User::create([
			'name' => $request->get('name'),
			'email' => $request->get('email'),
			'password' => bcrypt($request->get('password')),
		]);

		$user = User::first();
		$token = JWTAuth::fromUser($user);

		//lay ip hien tai
		$url = 'http://api.ipstack.com/' . $clientIP . '?access_key=3982a4c2a2157583fc9e8256a4ad8f97&format=1';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$result = curl_exec($ch);
		$location = json_decode($result);

		$country_name = ($location->country_name != null ? $location->country_name : 'null');
		$zip = ($location->zip != null ? $location->zip : 'null');
		$country_code = ($location->country_code != null ? $location->country_code : 'null');
		$city = ($location->city != null ? $location->city : 'null');
		$latitude = ($location->latitude != null ? $location->latitude : 'null');
		$longitude = ($location->longitude != null ? $location->longitude : 'null');

		// save country
		$country = Countries::create([
			'name'=>$country_name,
			'code'=>$zip,
			'short_name'=>$country_code
		]);
		// save city
		$city = Cities::create([
			'country_id'=>$country->id,
			'name'=>$city
		]);
		// save user location
		$userlocation = Userlocation::create([
			'user_id'=>$newuser->id,
			'city_id'=>$city->id,
			'latitude'=>$latitude,
			'longitude'=>$longitude
		]);
		curl_close($ch);

		return Response::json(compact('token'));
	}

	public function login(Request $request) {
		$validator = Validator::make($request->all(), [
			'email' => 'required|string|email|max:255',
			'password' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json($validator->errors());
		}
		$credentials = $request->only('email', 'password');
		try {
			if (!$token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 401);
			}
		} catch (JWTException $e) {
			return response()->json(['error' => 'could_not_create_token'], 500);
		}
		return response()->json(compact('token'));
	}

	public function user(Request $request) {
		$user = User::find(Auth::user()->id);
		return response([
			'status' => 'success',
			'data' => $user,
		]);
	}

	public function logout() {
		JWTAuth::invalidate();
		return response([
			'status' => 'success',
			'msg' => 'Logged out Successfully.',
		], 200);
	}


	public function refresh() {
		return response([
			'status' => 'success',
		]);
	}
	public function upload(Request $request) {
		$dates = getdate();
		$date = $dates['mon'] . '-' . $dates['year'];

		$user = Auth::user()->name;
		$files = $request->file('uploads');
		$path = 'upload/' . $user . '/';
		$item = [];
		$tmp_item = [];

		$ids = [];
		if (!empty($files)) {
			foreach ($files as $file) {
				$name = $file->getClientOriginalName();
				$type = $file->getMimeType();
				$duoifile = explode('/', $type);
				$file->move($path . $duoifile[0] . '/' . $date, $name);

				$media = Media::create([
					'filename' => $name,
					'mimefile' => $path . $duoifile[0] . '/' . $date . '/' . $name,
				]);
				$id = $media->id;
				$tmp_item['id'] = $id;
				$tmp_item['ten'] = $name;
				$tmp_item['loai'] = $type;
				$tmp_item['duongdan'] = $path . $duoifile[0] . '/' . $date . '/' . $name;
				array_push($item, $tmp_item);
				array_push($ids, $id);

			}
			// $info = $item;
			return response([
				'status' => 'success',
				'data' => $item,
				'id_media' => $ids,
			], 200); 

		} else {
			return response([
				'status' => 'false',
			], 400);
		}
	}
	public function change_password(Request $request) {
		$user_id = Auth::user()->id;
		$password = bcrypt($request->password);
		try {
             DB::table('users')->where('id', $user_id)->update(['password' => $password]);
            $user = DB::table('users')->select('name','id','email')->where('id', $user_id)->get();
            return response::json([
                'action' =>'change_password',
                'status' => '200',
                'data'=>$user
            ], 200);
        } catch(\Exception $err){
            return Response::json([
                'status' => 500,
                'message'=>$err->getMessage()
            ]);
        }
	}

	public function getIP(Request $request)
	{
		//get ip
		$url = 'http://api.ipstack.com/' . $request->clientIP . '?access_key=3982a4c2a2157583fc9e8256a4ad8f97&format=1';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$result = curl_exec($ch);
		$location = json_decode($result);

		$country_name = ($location->country_name != null ? $location->country_name : 'null');
		$zip = ($location->zip != null ? $location->zip : 'null');

		$country_code = ($location->country_code != null ? $location->country_code : 'null');
		$city = ($location->city != null ? $location->city : 'null');
		$latitude = ($location->latitude != null ? $location->latitude : 'null');
		$longitude = ($location->longitude != null ? $location->longitude : 'null');

		// save country
		$country = Countries::create([
			'name' => $country_name,
			'code' => $zip,
			'short_name' => $country_code
		]);
		// save city
		$city = Cities::create([
			'country_id' => $country->id,
			'name' => $city
		]);
		// save user location
		$userlocation = Userlocation::create([
			'user_id' => $request->userid,
			'city_id' => $city->id,
			'latitude' => $latitude,
			'longitude' => $longitude
		]);
		return Response::json($location);
	}

}
