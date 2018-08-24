<?php

namespace App\Http\Controllers;
use App\Category;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JD\Cloudder\Facades\Cloudder;

class ImageController extends Controller
{
    public function index()
    {
        $videos = DB::table('uploads')
                ->where('categories_id', '=', '1')
                ->where('selection', '=' ,'1')
                ->get();


        for($i = 2; $i<10; $i++) {
            $prueba[] = DB::table('uploads')
                ->where('categories_id', '=', $i)
                ->where('selection', '=', '1')
                ->where('orden', '=','1')
                ->get()->toArray();

        }

//        dd($prueba);

//        echo $images[1][0]->image_url;

//        echo $images['image_url'];
        for($i=0;$i<=7;$i++)
        {
            $images[] = $prueba[$i][0]->image_url;
        }
//        dd($images);
//        dd($categories);

        $carus = DB::table('uploads')
                ->where('categories_id', '=','10')
                ->where('selection', '=', '1')
                ->orderBy('orden','asc')
                ->get();

        $categories = Category::all();

        return view('imagenes.index', compact('videos','images', 'carus','categories'));
    }

    public function changeImg(Request $request){

        if($request->isMethod('post'))
        {
            $this->validate($request,[
                'img'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 60000',
            ]);

            $url_ant = $request->bg;
            $camb = DB::table('uploads')
                ->where('image_url', '=', $url_ant)->get();
            DB::update('update uploads set selection = 0 where id = ?',[$camb[0]->id]);
            DB::update('update uploads set orden = 0 where id = ?',[$camb[0]->id]);

            $image = $request->file('img');
            echo($image);

            $image_name = $request->file('img')
                ->getRealPath();

            Cloudder::upload($image_name, null, ["crop" => "fill", "width" => 800, "height"=> 697]);

            $image_url = Cloudder::secureShow(Cloudder::getPublicId(),["width" => 800, "height" => 697]);

            $image = new Upload();
            $image->image_name = $request->file('img')
                ->getClientOriginalName();
            $image->image_url = $image_url;
            //id
            $cat_id = $camb[0]->categories_id;
            $orden_ant = $camb[0]->orden;
//            $category = Category::where('id', '=', $cat_id)->get();
            $image->categories_id = $cat_id;
//                $category[0]->id;
            $image->selection = 1;
            $image->orden = $orden_ant;
            $image->save();
        }
    }

    public function changeVid(Request $request){

        if($request->isMethod('post'))
        {
            \Cloudinary::config(array(
                "cloud_name" => "fguzman",
                "api_key" => "819716184232435",
                "api_secret" => "6z5xZb-E55RVlne7Wswd_mkCVqg"
            ));

            $this->validate($request,[
                'video'=>'required|mimes:mp4,webm|between:1, 60000',
            ]);

            $url_ant = $request->bg;
            $camb = DB::table('uploads')
                ->where('image_url', '=', $url_ant)->get();
            DB::update('update uploads set selection = 0 where id = ?',[$camb[0]->id]);
            DB::update('update uploads set orden = 0 where id = ?',[$camb[0]->id]);
            $image = $request->file('video');
            $image_name = $request->file('video')
                ->getRealPath();
            list($width, $height) = getimagesize($image_name);
//            Cloudder::uploadVideo($image_name, null, ["resource_type"=>"video" ,"format" => "mp4"]);
//            $image_url = Cloudder::show(Cloudder::getPublicId());
            $cloud = \Cloudinary\Uploader::upload_large($image_name, array(
                "resource_type" => "video"));
            $image_url= $cloud['secure_url'];
//            dd($image_url);
//            return response()->json($image_url);
            $image = new Upload();
            $image->image_name = $request->file('video')
                ->getClientOriginalName();
            $image->image_url = $image_url;

            //id
            $cat_id = $camb[0]->categories_id;
            $orden_ant = $camb[0]->orden;
//            $category = Category::where('id', '=', $cat_id)->get();
            $image->categories_id = $cat_id;
//                $category[0]->id;
            $image->selection = 1;
            $image->orden = $orden_ant;
            $image->save();
//            return response()->json($image_url);
        }
    }

    public function changeInModal(Request $request){

        if($request->isMethod('POST')){
            $cat = $request->nom;
//
            $camb = DB::table('categories')
                ->where('title', '=', $cat)->get();
//
            $camb_id = $camb[0]->id;
//
            $images = DB::table('uploads')
                ->where('categories_id', '=', $camb_id)
                ->where('selection', '=', '1')
                ->orderBy('orden', 'asc')
                ->get();

//            comentarie por pruebas que no se te olvide -------
            $impre = array();

            foreach ($images as $indexKey=>$image)
            {
                if($indexKey == 0)
                {
                    $impre[] =  '<div id="inter" class="carousel-item active" style="height:697px">' .
                        '<img class="d-block" style="height:697px" src="' . $image->image_url . '">' .
                        '</div>';
                    echo($impre[$indexKey]);
                }
                else
                {
                    $impre[]  = '<div id="inter" class="carousel-item" style="height:697px">' .
                        '<img class="d-block" style="height:697px" src="' . $image->image_url . '">' .
                        '</div>';
                    echo($impre[$indexKey]);
                }
            }
        }
    }
    
}
