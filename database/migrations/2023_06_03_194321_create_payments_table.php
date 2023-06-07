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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('surname');
            $table->string('email');
            $table->text('address');
            $table->string('postal_code');
            $table->string('city');
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->string('status')->nullable();
            $table->string('provider');
            $table->timestamp('expired_at')->nullable();
            $table->string('gateway_transaction_id')->nullable();
            $table->string('gateway_url')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
