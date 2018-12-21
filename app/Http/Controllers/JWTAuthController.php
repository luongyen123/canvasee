<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use JWTFactory;

use App\Media;
use App\User;
use Auth;
use Illuminate\Http\Request;
use DB;

use JWTAuth;
use Response;
use Validator;

class JWTAuthController extends Controller {
	public function register(Request $request) {
		$validator = Validator::make($request->all(), [
			'email' => 'required|string|email|max:255|unique:users',
			'name' => 'required',
			'password' => 'required',
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
		DB::table('users')->where('id', $user_id)->update(['password' => $password]);
		return response::json([
			'status' => 'success',
		], 200);
	}
	public function refresh() {
		return response([
			'status' => 'success'
		]);
	}
}
