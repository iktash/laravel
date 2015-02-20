<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesMessagesNumberTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries_messages_number', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('country', 2);
			
			$table->integer('currencies_id')->unsigned();
			$table->foreign('currencies_id')->references('id')->on('currencies');

			$table->integer('messages_number')->unsigned()->default(0);

			$table->unique(['country', 'currencies_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('countries_messages_number');
	}

}
