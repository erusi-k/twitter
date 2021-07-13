<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserName extends Model
{
        protected $guarded =array('id');
        public static $rules =array(
            'user' =>'required',
            'email'=>'required'
        );

}
