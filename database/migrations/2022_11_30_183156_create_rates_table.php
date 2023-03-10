<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatesTable extends Migration {

	public function up()
	{
		Schema::create('rates', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('restaurant_id')->unsigned();
			$table->string('comments');
			$table->enum('reviews', array('1', '2', '3', '4', '5'));
		});
	}

	public function down()
	{
		Schema::drop('rates');
	}
}