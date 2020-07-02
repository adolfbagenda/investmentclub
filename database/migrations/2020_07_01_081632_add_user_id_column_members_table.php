<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIDColumnMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $memberstableName='members';
    public $UserIdcolumnName='user_id';
    public function up()
    {
        Schema::table($this->memberstableName, function ($table) {
            if (!Schema::hasColumn($this->memberstableName, $this->UserIdcolumnName)) {
                $table->integer($this->UserIdcolumnName)->default(0);
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
        Schema::table($this->memberstableName, function (Blueprint $table) {
            $table->dropColumn($this->UserIdcolumnName);
        });
    }
}
