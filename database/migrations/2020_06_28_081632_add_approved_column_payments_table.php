<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedColumnPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public $paymentstableName='payments', $approvedcolumnName='approved';
    public function up()
    {
        Schema::table($this->paymentstableName, function (Blueprint $table) {
            if (!Schema::hasColumn($this->paymentstableName, $this->approvedcolumnName)) {
                $table->integer($this->approvedcolumnName)->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->paymentstableName, function (Blueprint $table) {
            $table->dropColumn($this->approvedcolumnName);
        });
    }
}
