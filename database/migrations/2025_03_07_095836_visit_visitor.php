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
        Schema::create('visit_visitor', function (Blueprint $table) {
            $table->foreignId('visit_id')
                ->comment('Foreign key of visit. Mandatory.')
                ->constrained(
                    table: 'visits',
                )
                ->onDelete('restrict')
                ->onUpdate('cascade');
                
            $table->foreignId('visitor_id')
                ->comment('Foreign key of visitor. Mandatory.')
                ->constrained(
                    table: 'visitors',
                )
                ->onDelete('restrict')
                ->onUpdate('cascade');
            
            $table->timestamps();
            $table->primary(['visit_id', 'visitor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_visitor');
    }
};
