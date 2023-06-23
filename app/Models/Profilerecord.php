<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profilerecord extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');
    // protected $table = 'profilerecords'; 

    public static $rules = array(
        'profile_id' => 'required',
        'edited_at' => 'required',
    );
    
}
