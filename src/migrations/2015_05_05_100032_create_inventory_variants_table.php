<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryVariantsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('inventories', function (Blueprint $table) {
            $table->integer('parent_id')->unsigned()->nullable()->after('id');

            $table->foreign('parent_id')->references('id')->on('inventories')
                ->onUpdate('restrict')
                ->onDelete('cascade');
        });
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('inventories', function(Blueprint $table) {
            $table->dropColumn('parent_id');
        });
	}
}