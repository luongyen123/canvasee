<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Media;
use File; 
use Storage;
class MediaController extends Controller
{
    public function upload_image(Request $request)
    {
        $dates = getdate();
        $date =$dates['mon'].'-'.$dates['year'];
        
        $user=Auth::user()->name;

            $files = $request->file('uploads');

            $path = 'upload/'.$user.'/';
            $item=[];
            $tmp =[];
            $ids=[];
            $small =[];
            $medium =[];
            $large=[];
            $err ='';
            if(!empty($files)) {
                foreach($files as $file) {
                    
                    $name = $file->getClientOriginalName(); //ten file
                    $type = $file->getMimeType();   //loại
                    $duoifile = explode('/',$type); 

                    if ($duoifile[0] == 'image') {
	                    $file->move($path.$duoifile[0].'/'.$date.'/anhgoc', $name);
	                    
	                    $filepath = public_path($path.$duoifile[0].'/'.$date.'/anhgoc/'.$name);
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
	                        array_push($small,$tmp_item);
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
	                        array_push($medium,$tmp_item);
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
	                        array_push($large,$tmp_item);

	                    } catch(\Tinify\AccountException $e) {
	                        // Verify your API key and account limit.
	                        return redirect('images/create')->with('error', $e->getMessage());
	                    }
	                       
	                    array_push($ids,$tmp_id);   
	                	File::delete($path.$duoifile[0].'/'.$date.'/anhgoc/'.$name);
                	}
                	else {
                		$err = '1 số file không phải ảnh';
                	}
                }
                $item['small']= $small;
                $item['medium']= $medium;
                $item['large']= $large;

                if ($err != '') {
                	if (isset($item)) {
                		$data=[
                			'message'=>$err
                		];
                	} else {
	                	$data =[
		                	'status'=>'success',
		                    'data' => $item,
		                    'message'=>$err
		                ];
		            }
                } else {
	                $data =[
	                	'status'=>'success',
	                    'data' => $item,
	                    
	                ];
	            }
                return response($data,200);

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
        
        $user = Auth::user()->name;
        $files = $request->file('uploads');
        $path = 'upload/'.$user.'/';
        $item=[];
        $tmp_item =[];
        $ids=[];
        $err='';
        if(!empty($files)) {
            foreach($files as $file) {
                
                $name = $file->getClientOriginalName();
                $type = $file->getMimeType();
                if ($type == "video/x-flv" || $type == "video/mp4" || $type == "application/x-mpegURL" || $type == "video/MP2T" || $type == "video/3gpp" || $type == "video/quicktime" || $type == "video/x-msvideo" || $type == "video/x-ms-wmv") {
                	$duoifile = explode('/',$type);
	                $file->move($path.$duoifile[0].'/'.$date.'/', $name);

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
                }else {
                	$err ='1 số file không phải video';
                	continue;
	            }
	               
            }

            if($err != ''){
            	if (empty($item)) {
	            	$data = [
	            		'message'=>'file không phải video'
	            	];
	            } else {
	            	$data = [
		            	'status'=>'success',
		                'data' => $item,
		                'id_media'=>$ids,
		                'message'=>$err
	            	];
	            }
            } else {
            	$data = [
	            	'status'=>'success',
	                'data' => $item,
	                'id_media'=>$ids,
            	];
            }
            return response($data,200);

        }
        else {
            return response([
                'status'=>'false'
            ],400);
        }
    }
}
