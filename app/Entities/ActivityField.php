<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ActivityField extends Model
{
    protected $table = 'activity_fields';
    protected $fillable = ['value_ru', 'description_ru', 'value_en', 'description_en'];
    protected $hidden = ['created_at', 'updated_at'];
}
