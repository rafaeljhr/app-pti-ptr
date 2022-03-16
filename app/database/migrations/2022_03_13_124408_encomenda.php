<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Encomenda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encomenda', function (Blueprint $table) {
            $table->id();
            $table->timestamps(); // created_at and updated_at
            $table->decimal('preco', 10, 2)
            ->nullable(false);
            $table->string('morada_de_entrega')
            ->nullable(false);
            $table->integer('quantidade')
            ->nullable(false);
            $table->date('data_realizada')
            ->nullable(false);
            $table->date('data_finalizada');
            $table->string('api_token', 80)
            ->unique()
            ->nullable()
            ->default(null);

            // foreign keys
            $table->integer('id_consumidor');
            $table->foreign('id_consumidor')->references('id')->on('consumidor');

            $table->integer('id_produto');
            $table->foreign('id_produto')->references('id')->on('produto');

            $table->integer('id_transportadora');
            $table->foreign('id_transportadora')->references('id')->on('transportadora');
            
            
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encomenda');
    }
}
