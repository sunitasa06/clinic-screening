<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_details', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->date('patient_dob');
            $table->bigInteger('patient_age');
            $table->string('mig_frequency')->comment('subject experiences migraine headaches, with response options: Monthly, Weekly, Daily');
            $table->enum('mig_frequency_daily', ['1-2', '3-4', '5+'])->nullable(true);
            $table->string('patient_cohort_type',50)->nullable(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_details');
    }
}
