<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTokensTable extends Migration {

	public function up()
	{
		Schema::create('tokens', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('tokenable_id');
			$table->string('tokenable_type');
			$table->string('token');
			$table->enum('platform', array('android', 'ios'));
		});
	}

	public function down()
	{
		Schema::drop('tokens');
	}
}