<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\BookingBanner;
use App\Models\RoomType;
use App\Models\Room;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class RoomTypeController extends Controller
{
    public function RoomTypeList(){
        $allData = RoomType::orderBy('id','desc')->get();
        return view('backend.room_management.room_type.view_room_type',compact('allData'));
    }

    public function AddRoomType(){
        return view('backend.room_management.room_type.add_room_type');
    }

    public function RoomTypeStore(Request $request){

        $room_type_id = RoomType::insertGetId([
            'name' => $request->name,
            'created_at' => Carbon::now(),
        ]);

        Room::insert([
            'room_type_id' => $room_type_id,
        ]);

        $notification = array(
            'message' => 'New Room Type Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('room.type.list')->with($notification);
    }
}
