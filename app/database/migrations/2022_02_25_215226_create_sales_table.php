<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', $precision = 8, $scale = 2)->default(0);
            $table->integer('items');
            $table->decimal('cash', $precision = 8, $scale = 2);
            $table->decimal('change', $precision = 8, $scale = 2);
            $table->enum('status', ['PAID', 'PENDING', 'CANCELED'])->default('PAID');
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('sales');
    }
};
