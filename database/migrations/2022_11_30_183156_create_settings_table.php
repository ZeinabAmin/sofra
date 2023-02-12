<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('who_are_we');
			$table->text('about_app');
			$table->integer('commission');
			$table->string('commission_text');
			$table->string('fb_link');
			$table->string('insta_link');
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}