<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilterColumnToCarsTable extends Migration
{
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->string('your_filter_column')->nullable();
        });
    }

    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('your_filter_column');
        });
    }
}
