<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'serie_number',
        'name',
        'brand',
        'model',
        'quantity',
        'article_type_id'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function suppliers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Supplier::class)
            ->withPivot('price');
    }

    public function machines(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Machine::class);
    }

    public function maintenance_sheets(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(MaintenanceSheet::class);
    }

    public function article_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ArticleType::class);
    }
    public function image(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function technical_sheet(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(TechnicalSheet::class, 'technical_sheetable');
    }
}
