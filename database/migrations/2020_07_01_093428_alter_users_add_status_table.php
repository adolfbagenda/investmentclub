<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersAddStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $usertableName='users';
    public $StatuscolumnName='status';
    public function up()
    {
        Schema::table($this->usertableName, function ($table) {
            if (!Schema::hasColumn($this->usertableName, $this->StatuscolumnName)) {
                $table->tinyInteger($this->StatuscolumnName)->default(0);
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
        Schema::table($this->usertableName, function (Blueprint $table) {
            $table->dropColumn($this->StatuscolumnName);
        });
    }
}
