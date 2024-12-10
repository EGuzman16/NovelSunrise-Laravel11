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
        Schema::create('novels_have_tags', function (Blueprint $table) {

            $table->foreignId('novel_fk')->constrained(table: 'novels', column: 'novel_id'); 

            $table->unsignedSmallInteger('tag_fk');
            $table->foreign('tag_fk')->references('tag_id')->on('tags');

            $table->primary(['novel_fk', 'tag_fk']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novels_have_tags');
    }
};
