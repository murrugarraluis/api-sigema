<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkingSheet extends Model
{
    use HasFactory,Uuids,SoftDeletes;
    protected $hidden = ['created_at', 'updated_at'];
    public function machine(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }
}
