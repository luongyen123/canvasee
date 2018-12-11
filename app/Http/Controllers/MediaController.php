<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Auth;
use App\Media;
use File; 
use Storage;


class MediaController extends Controller
{
    private function getdate()
    {
    	$dates = getdate();
        return $dates['mon'].'-'.$dates['year'];
    }

    private function save_image($tmp_id,$small,$type,$name,$path,$duoifile,$filepath,$type_img,$width,$height)
    {
    	$source = \Tinify\fromFile($filepath);
        $resized = $source->resize(array(
            "method" => "fit",
            "width" => $width,
            "height" => $height
        ));  //fomart size
        $path1 = $path.$duoifile[0].'/'.$this->getdate().'/';
        $resized->toFile(public_path($path1.$type_img.'_'.$name)); //luu file moi

        $media = Media::create([
            'filename' => $type_img.'_'.$name,
            'mimefile' => $duoifile[0]
        ]);//luu csdl
        $id = $media->id;
        $tmp_item['id'] = $id;
        $tmp_item['ten'] = $type_img.'_'.$name;
        $tmp_item['loai'] = $type;
        $tmp_item['duongdan'] = $path.$duoifile[0].'/'.$this->getdate().'/'.$type_img.'/'.$type_img.'_'.$name;
        array_push($tmp_id,$id);
        array_push($small,$tmp_item);

        return $small;
        
    }

    private function save_video($ids,$item,$name,$duoifile,$type,$path)
    {
    	$media = Media::create([
            'filename' => $name,
            'mimefile' => $duoifile[0]
        ]);
        $id = $media->id;
        $tmp_item['id'] = $id;
        $tmp_item['ten'] = $name;
        $tmp_item['loai'] = $type;
        $tmp_item['duongdan'] = $path.$duoifile[0].'/'.$this->getdate().'/'.$name;
        array_push($item,$tmp_item);
    	array_push($ids,$id); 
    	return $item;
    }
    public function upload_image(Request $request)
    {
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
                    $file->move($path.$duoifile[0].'/'.$this->getdate().'/anhgoc', $name);
                    
                    $filepath = public_path($path.$duoifile[0].'/'.$this->getdate().'/anhgoc/'.$name);
                    try {
                        $tmp_item=[];
                        $tmp_id=[];
                        \Tinify\setKey("pwGwqcG21J2K4SqX7pPjqhBWRT6n7j9w");

                        //small image
                        $small = $this->save_image($tmp_id,$small,$type,$name,$path,$duoifile,$filepath,'small',64,96);
                        
                        //medium image
                        $medium = $this->save_image($tmp_id,$medium,$type,$name,$path,$duoifile,$filepath,'medium',117,176);

                        //large
                        $large = $this->save_image($tmp_id,$large,$type,$name,$path,$duoifile,$filepath,'large',533,800);

                    } catch(\Tinify\AccountException $e) {
                        // Verify your API key and account limit.
                        return redirect('images/create')->with('error', $e->getMessage());
                    }
                       
                    array_push($ids,$tmp_id);   
                	File::delete($path.$duoifile[0].'/'.$this->getdate().'/anhgoc/'.$name);
            	} else {
            		$err = '1 số file không phải ảnh';
            	}
            }
            
            $item['small']= $small;
            $item['medium']= $medium;
            $item['large']= $large;

            if ($err != '') {
            	if (empty($item)) {
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
	                $file->move($path.$duoifile[0].'/'.$this->getdate().'/', $name);

	                $item =$this->save_video($ids,$item,$name,$duoifile,$type,$path);
	                
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
		                'message'=>$err
	            	];
	            }
            } else {
            	$data = [
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
    }

    public function upload_link(Request $request)
    {
        $user = Auth::user()->name;
        $link = $request->link;
        $path = 'upload/'.$user.'/';
        $item=[];
        $tmp_item =[];
        if(!empty($link)) {
        	$link_videos = explode(';',$link);
        	foreach ($link_videos as $link_video) {
        		$str_video = explode('=',$link_video);
	            $media = Media::create([
	                'filename' => $str_video[1],
	                'mimefile' => 'text'
	            ]);
	            $id = $media->id;
	            $tmp_item['id'] = $id;
	            $tmp_item['ten'] = $str_video[1];
	            $str ='<iframe src="https://www.youtube.com/embed/'.$str_video[1].' frameborder="0" allowfullscreen=""></iframe>';
	            $tmp_item['html'] = $str;

	            array_push($item,$tmp_item);
        	}

        	$data = [
            	'status'=>'success',
                'data' => $item,
        	];
           
            return response($data,200);

        }
        else {
            return response([
                'status'=>'false'
            ],400);
        }
    }
}
