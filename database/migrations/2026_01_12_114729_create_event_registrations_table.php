<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('event_registrations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('event_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('email');
        $table->decimal('payment', 8, 2);
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('event_registrations');
        Schema::enableForeignKeyConstraints();
    }

};
