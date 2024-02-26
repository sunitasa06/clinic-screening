<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientDetails extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'patient_details';

    const MONTHLY_FREQUENCY = 'Monthly';
    const WEEKLY_FREQUENCY = 'Weekly';
    const DAILY_FREQUENCY = 'Daily';
}
