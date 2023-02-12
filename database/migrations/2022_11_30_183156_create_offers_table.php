<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('description');
			$table->integer('restaurant_id')->unsigned();
			$table->string('image');
			$table->string('discount_percentage');
			$table->datetime('time_from');
			$table->datetime('time_to');
		}); 
	}

	public function down()
	{
		Schema::drop('offers');
	}
}
