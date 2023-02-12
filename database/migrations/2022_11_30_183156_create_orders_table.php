<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->decimal('total', 8,2);
			$table->string('delivery_address');
			$table->decimal('delivery_price', 8,2);
			$table->decimal('total_after_delivery', 8,2);
			$table->decimal('commission', 8,2);
			$table->integer('payment_method_id')->unsigned();
			$table->enum('state', array('pending', 'accepted', 'rejected', 'deliverid', 'declined'));
			$table->string('notes');
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}