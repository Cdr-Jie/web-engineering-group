<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->string('organizer');
        $table->string('contact_person')->nullable();
        $table->string('contact_no')->nullable();
        $table->enum('type', ['Workshop', 'Seminar', 'Competition', 'Festival', 'Sport', 'Course']);
        $table->string('venue');
        $table->date('date');
        $table->time('time');
        $table->enum('mode', ['Physical', 'Online', 'Hybrid']);
        $table->date('registration_close');
        $table->integer('max_participants')->nullable();
        $table->string('fee'); // "Free" or amount in RM
        $table->text('remarks')->nullable();
        $table->json('posters'); // array of image filenames
        $table->timestamps();
        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('events');
        Schema::enableForeignKeyConstraints();
    }
};
