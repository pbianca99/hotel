<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
    public function AllEmployees(){

        $team = Employee::latest()->get();
        return view('backend.team.all_employees',compact('team'));

    }

    public function AddEmployee(){
        return view('backend.team.add_employee');
    }

    public function StoreTeam(Request $request){
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(550,670)->save('upload/team/'.$name_gen);
        $save_url = 'upload/team/'.$name_gen;

        Employee::insert([

            'name' => $request->name,
            'position' => $request->position,
            'email' => $request->email,
            'image' => $save_url,
            'start_date' => $request->start_date,
            'salary' => $request->salary,
            'phone' => $request->phone,
            'created_at' => Carbon::now(),
        ]);
        
        $notification = array(
            'message' => 'New Employee Profile Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.employees')->with($notification);

    }


    public function EditEmployee($id){
            $team = Employee::findOrFail($id);  
            return view('backend.team.edit_employee',compact('team')); 
    }

    public function UpdateTeam(Request $request){
        $team_id = $request->id;
        if($request->file('image')){

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550,670)->save('upload/team/'.$name_gen);
            $save_url = 'upload/team/'.$name_gen;
    
            Employee::findOrFail($team_id)->update([
    
                'name' => $request->name,
                'position' => $request->position,
                'email' => $request->email,
                'image' => $save_url,
                'start_date' => $request->start_date,
                'salary' => $request->salary,
                'phone' => $request->phone,
                'created_at' => Carbon::now(),
            ]);
            
            $notification = array(
                'message' => 'Employee Profile Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.employees')->with($notification);
            
        }else{
            Employee::findOrFail($team_id)->update([
    
                'name' => $request->name,
                'position' => $request->position,
                'email' => $request->email,
                'start_date' => $request->start_date,
                'salary' => $request->salary,
                'phone' => $request->phone,
                'created_at' => Carbon::now(),
            ]);
            
            $notification = array(
                'message' => 'Employee Profile Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.employees')->with($notification);
        }
    }


    public function DeleteEmployee($id){
        $item = Employee::findOrFail($id);
        $img = $item->image;
        unlink($img);
        Employee::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Employee Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
