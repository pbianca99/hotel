<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingBanner;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    public function DetailsBanner(){

        $banner  = BookingBanner::find(1);
        return view('backend.banner.booking_banner',compact('banner'));

    }

    public function UpdateBanner(Request $request){
        
        $banner_id = $request->id;

        if($request->file('banner_image')){

            $image = $request->file('banner_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1250,1000)->save('upload/banner/'.$name_gen);
            $save_url = 'upload/banner/'.$name_gen;
    
            BookingBanner::findOrFail($banner_id)->update([
    
                'short_title' => $request->short_title,
                'main_title' => $request->main_title,
                'description' => $request->description,
                'link_url' => $request->link_url,
                'banner_image' => $save_url,
            ]);
            
            $notification = array(
                'message' => 'Website Banner Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
            
        }else{
            BookingBanner::findOrFail($banner_id)->update([
    
                'short_title' => $request->short_title,
                'main_title' => $request->main_title,
                'description' => $request->description,
                'link_url' => $request->link_url,
            ]);
            
            $notification = array(
                'message' => 'Website Banner Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        }

    }

}