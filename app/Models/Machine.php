<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
        'maximum_working_time_per_day',
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function articles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Article::class)->withTrashed();
    }

    public function image(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function technical_sheet(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(TechnicalSheet::class, 'technical_sheetable');
    }

    public function maintenance_sheets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MaintenanceSheet::class);
    }

    public function working_sheets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WorkingSheet::class);
    }

    private function converterHourInSeconds($hour)
    {
        return $hour * 3600;
    }

    public function getStatusAttribute(): string
    {
        $status = ["available", "operating", "not available"];

        $time_working_today = $this->getTimeWorkingToday();
        $time_working = $this->getTimeWorking();
        if (
            $time_working_today + $this->converterHourInSeconds(1) >= $this->converterHourInSeconds($this->maximum_working_time_per_day) ||
            $time_working + $this->converterHourInSeconds(6) >= $this->converterHourInSeconds($this->maximum_working_time)
        ) {
            return $status[2];
        }

        $is_working = $this->getIsWorking();
        if ($is_working) {
            return $status[1];
        }

        return $status[0];
    }

    private function getTimeWorkingToday()
    {
        $sum_working_hours_in_seconds = WorkingSheet::join(DB::raw('(SELECT working_sheet_id,
                            SUM(TIMESTAMPDIFF(SECOND, date_time_start, date_time_end)) AS total_seconds
                     from working_hours
                     GROUP BY working_sheet_id) AS wh '),
            function ($join) {
                $join->on('wh.working_sheet_id', '=', 'working_sheets.id');
            })
            ->where('machine_id', $this->id)
            ->where('date', '>=', date('Y-m-d'))
            ->sum('total_seconds');
        return $sum_working_hours_in_seconds;
    }

    private function getTimeWorking()
    {
//        $date_last_maintenance = $this->get_date_last_maintenance();
        $date_last_maintenance = $this->maintenance_sheets()->orderBy('date', 'desc')->first();
        $date_last_maintenance = $date_last_maintenance ? date('Y-m-d H:i:s', strtotime($date_last_maintenance->date)) : null;
        if ($date_last_maintenance) {
            $sum_working_hours_in_seconds = WorkingSheet::join(DB::raw('(SELECT working_sheet_id,
                            SUM(TIMESTAMPDIFF(SECOND, date_time_start, date_time_end)) AS total_seconds
                     from working_hours
                     GROUP BY working_sheet_id) AS wh '),
                function ($join) {
                    $join->on('wh.working_sheet_id', '=', 'workinog_sheets.id');
                })
                ->where('machine_id', $this->id)
                ->where('date', '>=', $date_last_maintenance)
                ->sum('total_seconds');
        } else {
            $sum_working_hours_in_seconds = WorkingSheet::join(DB::raw('(SELECT working_sheet_id,
                            SUM(TIMESTAMPDIFF(SECOND, date_time_start, date_time_end)) AS total_seconds
                     from working_hours
                     GROUP BY working_sheet_id) AS wh '),
                function ($join) {
                    $join->on('wh.working_sheet_id', '=', 'working_sheets.id');
                })
                ->where('machine_id', $this->id)
                ->sum('total_seconds');
        }
        return $sum_working_hours_in_seconds;
    }

    private function getIsWorking()
    {
        return ($this->working_sheets()->where('is_open', true)->count() > 0);
    }

    function get_date_last_maintenance()
    {
        $date_last_maintenance = $this->maintenance_sheets()->orderBy('date', 'desc')->first();
        return $date_last_maintenance ? date('Y-m-d', strtotime($date_last_maintenance->date)) : null;
    }
}
