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
        Schema::create('leads', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email');
            $table->string('cellphone')->nullable();
            $table->string('phone_ext')->nullable();
            $table->string('phone');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('password');
            $table->enum('status',['active','pending','cancelled','blocked','archived'])->default('active');        
            $table->timestamp('created');
            $table->timestamp('updated');
            $table->boolean('is_deleted',[0,1])->default(0)->comment(" 0 = not deleted and 1 = deleted");
            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
};
