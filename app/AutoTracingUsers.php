<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AutoTracingUsers extends Model
{
    protected $table = "auto_contact_tracing_users_list";

    protected $guarded = ['id'];

    protected $appends = ['saved_at', 'upsa_user'];

    public function getSavedAtAttribute()
    {
        return Carbon::parse($this->traced_date)->toDayDateTimeString();
    }

    public function getUpsaUserAttribute()
    {
        $data = MobileAppUsers::where("id", $this->upsa_id)->first();
        return $data->upsa_id;
    }
}
