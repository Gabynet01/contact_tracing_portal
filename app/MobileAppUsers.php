<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MobileAppUsers extends Model
{
    protected $table = "app_users_list";

    protected $guarded = ['id'];

    protected $appends = ['saved_at'];

    public function getSavedAtAttribute()
    {
        return Carbon::parse($this->registered_date)->toDayDateTimeString();
    }
}
