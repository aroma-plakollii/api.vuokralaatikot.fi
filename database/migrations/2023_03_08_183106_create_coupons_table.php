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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->integer('quantity');
            $table->text('code');
            $table->decimal('price', 8, 2);
            $table->string('available_at');
            $table->text('used')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('is_percentage')->default(0);
            $table->boolean('is_unlimited')->default(0);
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
        Schema::dropIfExists('coupons');
    }
};
