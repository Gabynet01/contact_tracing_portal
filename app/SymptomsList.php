<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SymptomsList extends Model
{
    protected $table = "symptoms_list";

    protected $guarded = ['id'];

    protected $appends = ['saved_at'];

    public function getSavedAtAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }
}