<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Consumidor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumidor', function (Blueprint $table) {
            $table->id();
            $table->timestamps(); // created_at and updated_at
            $table->string('nome')
            ->nullable(false);
            $table->string('email')
            ->nullable(false)
            ->unique();
            $table->string('password')
            ->nullable(false);
            $table->integer('telemovel')
            ->nullable(false)
            ->unique();
            $table->string('nif')
            ->nullable(false)
            ->unique();
            $table->string('morada');
            $table->string('api_token')
            ->unique();;
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumidor');
    }
}
