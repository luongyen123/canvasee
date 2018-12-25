<?php

namespace App\Http\Controllers;

use App\Media;
use Auth;
use File;
use Illuminate\Http\Request;

//class MediaClass extends Controller {
trait MediaClass{
	private function getdate() {
		//date now
		$dates = getdate();
		return $dates['mon'] . '-' . $dates['year'];
	}

	private function save_image($tmp_id, $small, $type, $name, $path, $file_format, $filepath, $type_img, $width, $height) {

		$source = \Tinify\fromFile($filepath);
		$resized = $source->resize(array(
			"method" => "fit",
			"width" => $width,
			"height" => $height,
		)); //fomart size
		$path1 = $path . $file_format[0] . '/' . $this->getdate() . '/';
		$resized->toFile(public_path($path1 . $type_img . '_' . $name)); //save new file

		$media = Media::create([
			'filename' => $type_img . '_' . $name,
			'mimefile' => $file_format[0],
		]); //save database
		$id = $media->id;
		$tmp_item['id'] = $id;
		$tmp_item['name'] = $type_img . '_' . $name;
		$tmp_item['type'] = $type;
		$tmp_item['path'] = $path . $file_format[0] . '/' . $this->getdate() . '/' . $type_img . '/' . $type_img . '_' . $name; // duong dan anh
		array_push($tmp_id, $id);
		array_push($small, $tmp_item);
		return $small;

	}

	private function save_video($ids, $item, $name, $file_format, $type, $path) {
		$media = Media::create([
			'filename' => $name,
			'mimefile' => $file_format[0],
		]);
		$id = $media->id;
		$tmp_item['id'] = $id;
		$tmp_item['name'] = $name;
		$tmp_item['type'] = $type;
		$tmp_item['path'] = $path . $file_format[0] . '/' . $this->getdate() . '/' . $name;
		array_push($item, $tmp_item);
		array_push($ids, $id);
		return $item;
	}
	public function upload_image(Request $request) {
		$user = Auth::user()->name;
		$files = $request->file('images');

		$path = 'upload/' . $user . '/';
		$item = [];

		$tmp = [];
		$ids = [];
		$small = [];
		$medium = [];
		$large = [];
		$err = '';
		if (!empty($files)) {
			foreach ($files as $file) {

				$name = $file->getClientOriginalName(); //get name
				$type = $file->getMimeType(); //get type
				$file_format = explode('/', $type);

				if ($file_format[0] == 'image') {
					$file->move($path . $file_format[0] . '/' . $this->getdate() . '/origin', $name);

					$filepath = public_path($path . $file_format[0] . '/' . $this->getdate() . '/origin/' . $name);
					try {
						$tmp_item = [];
						$tmp_id = [];
						\Tinify\setKey("pwGwqcG21J2K4SqX7pPjqhBWRT6n7j9w");

						//save small image
						$small = $this->save_image($tmp_id, $small, $type, $name, $path, $file_format, $filepath, 'small', 64, 96);

						//save medium image
						$medium = $this->save_image($tmp_id, $medium, $type, $name, $path, $file_format, $filepath, 'medium', 117, 176);

						//save large image
						$large = $this->save_image($tmp_id, $large, $type, $name, $path, $file_format, $filepath, 'large', 533, 800);

					} catch (\Tinify\AccountException $e) {
						// Verify your API key and account limit.
						return redirect('images/create')->with('error', $e->getMessage());
					}

					array_push($ids, $tmp_id);
					// delete image /origin
					File::delete($path . $file_format[0] . '/' . $this->getdate() . '/origin/' . $name);
				} else {
					$err = 'not a photo';
				}
			}

			$item['small'] = $small;
			$item['medium'] = $medium;
			$item['large'] = $large;

			if ($err != '') {
				if (empty($item)) {
					$data = [
						'message' => $err,
					];
				} else {
					$data = [
						'status' => 'success',
						'data' => $item,
						'message' => $err,
					];
				}
			} else {
				$data = [
					'status' => 'success',
					'data' => $item,

				];
			}
			return response($data, 200);

		} else {
			return response([
				'status' => 'false',
			], 400);
		}
		// }
	}

	public function upload_video(Request $request) {
		$user = Auth::user()->name;
		$files = $request->file('videos');
		$path = 'upload/' . $user . '/';
		$item = [];

		$tmp_item = [];
		$ids = [];
		$err = '';
		if (!empty($files)) {
			foreach ($files as $file) {

				$name = $file->getClientOriginalName();
				$type = $file->getMimeType();
				if ($type == "video/x-flv" || $type == "video/mp4" || $type == "application/x-mpegURL" || $type == "video/MP2T" || $type == "video/3gpp" || $type == "video/quicktime" || $type == "video/x-msvideo" || $type == "video/x-ms-wmv") {
					$file_format = explode('/', $type);
					$file->move($path . $file_format[0] . '/' . $this->getdate() . '/', $name);
					// save video
					$item = $this->save_video($ids, $item, $name, $file_format, $type, $path);

				} else {
					$err = 'not a video ';
//					continue;
				}

			}

			if ($err != '') {
				if (empty($item)) {
					$data = [
						'message' => $err,
                        'data'=>[]
					];
				} else {
					$data = [
						'status' => 'success',
						'data' => $item,
						'message' => $err,
					];
				}
			} else {
				$data = [
					'status' => 'success',
					'data' => $item,
				];
			}
			return response($data, 200);

		} else {
			return response([
				'status' => 'false',
                'data' =>''
			], 400);
		}
	}

	public function upload_link(Request $request) {
		$user = Auth::user()->name;
		$link = $request->link;
		$path = 'upload/' . $user . '/';
		$item = [];
		$tmp_item = [];
		if (!empty($link)) {
			$link_videos = explode(';', $link);
			foreach ($link_videos as $link_video) {
				$str_video = explode('=', $link_video);
				$str_video[1] = isset($str_video[1]) ? $str_video[1] : $link_video;
				//save database
				$media = Media::create([
					'filename' => $str_video[1],
					'mimefile' => 'text',
				]);
				//return data
				$id = $media->id;
				$tmp_item['id'] = $id;
				$tmp_item['ten'] = $str_video[1];
				$str = '<iframe src="https://www.youtube.com/embed/' . $str_video[1] . ' frameborder="0" allowfullscreen=""></iframe>';
				$tmp_item['html'] = $str;

				array_push($item, $tmp_item);
			}

			$data = [
				'status' => 'success',
				'data' => $item,
			];

			return response($data, 200);

		} else {
			return response([
				'status' => 'false',
			], 400);
		}
	}
}
