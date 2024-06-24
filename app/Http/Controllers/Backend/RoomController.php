<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\RoomNumber;
use App\Models\RoomType;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class RoomController extends Controller
{
    public function EditRoom($id){

        $editData = Room::find($id);
        $basic_facility = Facility::where('room_id',$id)->get();
        $multiimages = MultiImage::where('room_id',$id)->get();
        $allRoomNo = RoomNumber::where('room_id',$id)->get();
        return view('backend.room_management.rooms.edit_rooms',
        compact('editData','basic_facility','multiimages','allRoomNo'));
    }

    public function UpdateRoom(Request $request, $id){
        $room = Room::find($id);
        $room->room_type_id = $room->room_type_id;
        $room->total_adult = $request->total_adult;
        $room->total_child = $request->total_child;
        $room->room_capacity = $request->room_capacity;
        $room->price = $request->price;
        $room->size = $request->size;
        $room->view = $request->view;
        $room->bed_style = $request->bed_style;
        $room->discount = $request->discount;
        $room->short_description = $request->short_description;
        $room->description = $request->description;
        $room->status = 1;
        
        //update single image
        if($request->file('image')){
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550,850)->save('upload/room_images/'.$name_gen);
            $room['image'] = $name_gen;
        }
        
        $room->save();

        //update facilities table

        if($request->facility_name == NULL){
            $notification = array(
                'message' => 'Sorry! No basic facilities selected.',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification);
        }else{
            Facility::where('room_id',$id)->delete();
            $facilities = Count($request->facility_name);
            for($i = 0; $i < $facilities; $i++){
                $fcount = new Facility();
                $fcount->room_id = $room->id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->save();
            }
        }

        if($room->save()){
            $files = $request->multi_image;
            if(!empty($files)){
                $subimage = MultiImage::where('room_id',$id)->get()->toArray();
                MultiImage::where('room_id',$id)->delete();

            }
            if(!empty($files)){
                foreach($files as $file){
                    $imageName = date('YmdHi').$file->getClientOriginalName();
                    $file->move('upload/room_images/multi_images',$imageName);
                    $subimage['multi_image'] = $imageName;

                    $subimage = new MultiImage();
                    $subimage->room_id  = $room->id;
                    $subimage->multi_image =$imageName;
                    $subimage->save();
                }
            }
        }

            $notification = array(
                'message' => 'Room Updated Successfully!',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
    }

    public function MultiImageDelete($id){
        $deleteData = MultiImage::where('id',$id)->first();

        if($deleteData){
            $image = $deleteData->multi_image;
            $imagePath = 'upload/room_images/multi_images/'.$image;
                        //check if the file exists before unlinking
            if(file_exists($imagePath)){
                unlink($imagePath);
                echo "Image Unlinked Successfully!";
            }else{
                echo "Image does not exist!";
            }
            //delete record from database
            MultiImage::where('id',$id)->delete();
        }

        $notification = array(
            'message' => 'Image Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    public function StoreRoomNumber(Request $request,$id){
        $data = new RoomNumber();
        $data->room_id = $id;
        $data->room_type_id = $request->room_type_id;
        $data->room_no = $request->room_no;
        $data->status = $request->status;
        $data->save();

        $notification = array(
            'message' => 'Room Number Added Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function EditRoomNumber($id){
        $editRoomNo = RoomNumber::find($id);
        return view('backend.room_management.rooms.edit_room_no',compact('editRoomNo'));
    }

    public function UpdateRoomNumber(Request $request, $id){
        $data = RoomNumber::find($id);
        $data->room_no = $request->room_no;
        $data->status = $request->status;
        $data->save();

        $notification = array(
            'message' => 'Room Number Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('room.type.list')->with($notification);
    }

    public function DeleteRoomNumber($id){
        RoomNumber::find($id)->delete();
        $notification = array(
            'message' => 'Room Number Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('room.type.list')->with($notification);
    }

    public function DeleteRoom(Request $request, $id){
        $room = Room::find($id);
        if(file_exists('upload/room_images/'.$room->image) AND !empty($room->image)){
            @unlink('upload/room_images/'.$room->image);
        }
        $subimage = MultiImage::where('room_id',$room->id)->get()->toArray();
        if(!empty($subimage)){
            foreach($subimage as $value){
                if(!empty($value)){
                    @unlink('upload/room_images/multi_images/'.$value['multi_image']);
                }
            }
        }

        RoomType::where('id',$room->room_type_id)->delete();
        MultiImage::where('room_id',$room->id)->delete();
        Facility::where('room_id',$room->id)->delete();
        RoomNumber::where('room_id',$room->id)->delete();
        $room->delete();

        $notification = array(
            'message' => 'Room Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);


    }

}
