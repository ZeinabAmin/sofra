<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMealsTable extends Migration {

	public function up()
	{
		Schema::create('meals', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('description');
			$table->string('image');
			$table->string('processing_time');
			$table->decimal('price', 8,2);
			$table->decimal('offer_price', 8,2)->nullable();
			$table->integer('restaurant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('meals');
	}
}