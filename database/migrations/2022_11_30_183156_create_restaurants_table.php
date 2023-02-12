<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('password');
			$table->string('phone');
			$table->decimal('delivery_fee', 8,2);
			$table->decimal('minimum_order', 8,2);
			$table->string('whatsapp');
			$table->string('informations');
			$table->integer('region_id')->unsigned();
			$table->string('image');
			$table->string('api_token', 60)->unique()->nullable();
			$table->string('pin_code')->nullable();
			$table->boolean('is_active')->default(1);
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}
