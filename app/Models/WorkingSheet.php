<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingSheet extends Model
{
    use HasFactory,Uuids;
    protected $hidden = ['created_at', 'updated_at'];

}
