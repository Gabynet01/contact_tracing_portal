<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class BookingList extends Model
{
    protected $table = "booking_list";

    protected $guarded = ['id'];

    protected $appends = ['saved_at', 'appointment_date', 'upsa_user', 'result_status', 'result_date', 'result_confirmed_user'];

    public function getSavedAtAttribute()
    {
        if ($this->visited_date == null) {
            return "NOT-AVAILABLE";
        } else {
            return Carbon::parse($this->visited_date)->toDayDateTimeString();
        }
    }

    public function getAppointmentDateAttribute()
    {
        return Carbon::parse($this->booked_date)->toDayDateTimeString();
    }

    public function getResultStatusAttribute()
    {
        if ($this->test_result_status == null) {
            return "NOT-AVAILABLE";
        } else {
            return $this->test_result_status;
        }
    }

    public function getResultConfirmedUserAttribute()
    {
        if ($this->result_confirmed_by == null) {
            return "NOT-AVAILABLE";
        } else {
            return $this->result_confirmed_by;
        }
    }

    public function getResultDateAttribute()
    {
        if ($this->test_result_date == null) {
            return "NOT-AVAILABLE";
        } else {
            return Carbon::parse($this->test_result_date)->toDayDateTimeString();
        }
    }

    public function getUpsaUserAttribute()
    {
        $data = MobileAppUsers::where("id", $this->upsa_id)->first();
        return $data->upsa_id;
    }
}
