<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	public function up()
	{
		Schema::create('payments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->decimal('paid', 8,2);
			$table->datetime('payment_date');
			$table->integer('restaurant_id')->unsigned();
			$table->string('notes');
		});
	}

	public function down()
	{
		Schema::drop('payments');
	}
}