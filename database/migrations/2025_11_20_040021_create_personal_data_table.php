<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalDataTable extends Migration
{
    public function up()
    {
        Schema::create('personal_data', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('nationality')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->text('summary')->nullable();
            $table->json('skills')->nullable();
            $table->json('experience')->nullable();
            $table->json('education')->nullable();
            $table->string('photo')->nullable(); // store filename / path relative to storage/app/public
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_data');
    }
}
