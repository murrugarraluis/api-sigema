<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'serie_number',
        'name',
        'brand',
        'model',
        'image',
        'maximum_working_time',
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function articles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    public function image(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function maintenance_sheets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MaintenanceSheet::class);
    }

    public function working_sheets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WorkingSheet::class);
    }
}
