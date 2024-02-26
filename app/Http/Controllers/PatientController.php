<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PatientDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{

    /** Function for patient screening form request submit */
    public function store(Request $request)
    {
        // Backend Validation check
        $validator = Validator::make($request->all(), [
            'f_name' => 'required|string|min:3|max:50',
            'dob' => 'required|date',
            'frequency' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'data' => null], 400);
        }

        $patientAge = $this->calculatePatientAge($request->dob);
        if ($patientAge < 18)
        {
            return response()->json([
                'success' => false,
                'message' => 'Participants must be over 18 years of age' ,
                'data' => null,
            ],400);
        }
        $getCohortType = $this->determineCohort($patientAge, $request->frequency);
        try {
            DB::beginTransaction();

            $patientScreeningData = new PatientDetails();
            $patientScreeningData->patient_name =$request->f_name;
            $patientScreeningData->patient_dob =$request->dob;
            $patientScreeningData->patient_age = $patientAge;
            $patientScreeningData->mig_frequency =$request->frequency;
            $patientScreeningData->mig_frequency_daily = $request->daily_freq;
            $patientScreeningData->patient_cohort_type = $getCohortType;
            $patientScreeningData->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Participant '.$request->f_name.' is assigned to '. $getCohortType,
                'data' => null,
            ],200);
        }
        catch (\Exception $e){
            DB::rollBack();
            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Patient Data not saved.' ,
                'data' => null,
            ],400);
        }
    }

    private function calculatePatientAge($dob)
    {
        // Ensure $dob is a Carbon instance
        $dob = Carbon::parse($dob);

        return $dob->diffInYears(Carbon::now());
    }

    private function determineCohort($age, $frequency)
    {
        if ($age > 18)
        {
            if ($frequency == PatientDetails::MONTHLY_FREQUENCY || $frequency == PatientDetails::WEEKLY_FREQUENCY)
            {
                return 'Cohort A';
            }
            elseif ($frequency == PatientDetails::DAILY_FREQUENCY)
            {
                return 'Cohort B';
            }
        }
        return null;
    }

    public function list()
    {
        $patientData = PatientDetails::query()->get();
        return view('patient.screening_list', compact('patientData'));
    }


}
