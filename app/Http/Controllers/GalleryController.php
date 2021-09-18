<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $all_pictures = Gallery::where('product_id',$id)->get();
        foreach ($all_pictures as $key =>$picture) {
            $picture->setAttribute('selected',0);
        }
        $product = Product::where('product_id',$id)->first();
        $user = Auth::user();
        return view('gallery.gallery')->with([
            'pictures'=>$all_pictures,
            'product'=>$product,
            'user'=>$user
        ]);
    }
    public function showGallery($id){
        $highlight_image = Gallery::where('gallery_id',$id)->first();
        $images = Gallery::where('product_id',$highlight_image->product_id)->get();
        $index = 0;
        foreach ($images as $key => $image) {
            if ($image->picture == $highlight_image->picture) {
                $index = $key;
            }
        }
        return view('gallery.showGallery')->with([
            'highlight_image'=>$highlight_image,
            'images'=>$images,
            'index'=>$index,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //
        $product = Product::where('product_id',$id)->first();
        $user = Auth::user();
        if($request->hasFile('image')){
            $images = $request->file('image');
            foreach ($images as $key => $image) {
                $base_path = public_path('img/images/products');
                if(!File::isDirectory($base_path)){
                    File::makeDirectory($base_path, 0777, true, true);
                }
                $time = Carbon::now()->format('dmyhms');
                $file_name = 'P'.$product->product_id.'U'.$user->user_id.$time.$key.'.png';
                $img = Image::make($images[$key]->getRealPath());
                $gallery = Gallery::create([
                    'product_id'=>$product->product_id,
                    'picture'=> $file_name,
                ]);
                $img->save('img/images/products/'.$file_name, 80);
            }
        }
        return redirect()->route('gallery.index',$id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $images = $request->get('images');
        if ($images == null) {
            return back()->with([
                'error' => 'Choose a picture to be deleted!',
            ]);
        }
        foreach ($images as $image) {
            $imageToBeDeleted = Gallery::find($image);
            $check_image = Gallery::where('product_id', $id)->get();
            $check_image_count = $check_image->count();
            if($check_image_count == 1){
                return back()->with([
                    'error'=>'This is the only picture of this product. Each product must have at least one.'
                ]);
            }
            if($check_image_count == sizeOf($images)){
                return back()->with([
                    'error'=>'Cannot delete all pictures of a product!'
                ]);
            }
            $imageToBeDeleted->delete();
            File::delete('img/images/products/' . $imageToBeDeleted->picture);
        }
        return redirect()->route('gallery.index',$id);
    }
}
