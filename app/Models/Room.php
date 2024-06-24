<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $guarded =[];
    
    public function type(){
        return $this->belongsTo(RoomType::class, 'room_type_id', 'id');
    }

    public function room_numbers(){
        return $this->hasMany(RoomNumber::class, 'room_id')->where('status','Disponibila');
    }
}