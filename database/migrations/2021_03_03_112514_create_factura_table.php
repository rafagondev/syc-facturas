<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura', function (Blueprint $table) {
            $table->id('id_factura');
            $table->foreignId('nume_doc')->constrained('clientes','nume_doc');
            $table->foreignId('codi_estado')->constrained('estados_factura', 'codi_estado');
            $table->bigInteger('valor_fact');
            $table->date('fecha_fact');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factura');
    }
}
