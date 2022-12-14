<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class IsolatedPersons extends Model
{
    protected $table = "isolated_persons_list";

    protected $guarded = ['id'];

    protected $appends = ['saved_at', 'upsa_user', 'symptoms_checked', 'contacts_affected', 'contacts_number_affected'];

    public function getSavedAtAttribute()
    {
        return Carbon::parse($this->reported_date)->toDayDateTimeString();
    }

    public function getUpsaUserAttribute()
    {
        $data = MobileAppUsers::where("id", $this->upsa_id)->first();
        return $data->upsa_id;
    }

    public function getSymptomsCheckedAttribute()
    {
        $string_version = "";

        if (!empty(explode(',', $this->symptoms_list_checked))) {

            if (count(explode(',', $this->symptoms_list_checked)) > 1) {

                $selectedData = explode(',', $this->symptoms_list_checked);
                $allData = array();

                foreach ($selectedData as $itemselect) {
                    $data = SymptomsList::where("id", $itemselect)->first();
                    array_push($allData, $data->label);
                }

                // lets convert the array to string 
                $string_version = implode(',', $allData);

                // lets add a space after the comma
                $string_version = preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $string_version);
            } else {
                $data = SymptomsList::where("id", $this->symptoms_list_checked)->first();
                return $data->label;
            }
        }

        return $string_version;
    }

    public function getContactsNumberAffectedAttribute()
    {
        $string_version = "";

        if (!empty(explode(',', $this->last_contact_users_id))) {

            if (count(explode(',', $this->last_contact_users_id)) > 1) {

                $selectedData = explode(',', $this->last_contact_users_id);
                $allData = array();

                foreach ($selectedData as $itemselect) {
                    $data = MobileAppUsers::where("id", $itemselect)->first();
                    array_push($allData, $data->phone_number);
                }

                // lets convert the array to string 
                $string_version = implode(',', $allData);

                // lets add a space after the comma
                $string_version = preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $string_version);
            } else {
                $data = MobileAppUsers::where("id", $this->last_contact_users_id)->first();
                return $data->phone_number;
            }
        }

        return $string_version;
    }

    public function getContactsAffectedAttribute()
    {
        $string_version = "";

        if (!empty(explode(',', $this->last_contact_users_id))) {

            if (count(explode(',', $this->last_contact_users_id)) > 1) {

                $selectedData = explode(',', $this->last_contact_users_id);
                $allData = array();

                foreach ($selectedData as $itemselect) {
                    $data = MobileAppUsers::where("id", $itemselect)->first();
                    array_push($allData, $data->upsa_id);
                }

                // lets convert the array to string 
                $string_version = implode(',', $allData);

                // lets add a space after the comma
                $string_version = preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $string_version);
            } else {
                $data = MobileAppUsers::where("id", $this->last_contact_users_id)->first();
                return $data->upsa_id;
            }
        }

        return $string_version;
    }
}
