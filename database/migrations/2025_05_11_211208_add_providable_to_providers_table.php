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
        Schema::table('providers', function (Blueprint $table) {
            //
             $table->unsignedBigInteger('providable_id')->nullable()->after('id');
             $table->string('providable_type')->nullable()->after('providable_id');
             $table->index(['providable_id', 'providable_type'], 'providers_providable_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            //
             $table->dropIndex('providers_providable_index'); // Using the name of the index

            // Drop the columns
            $table->dropColumn(['providable_id', 'providable_type']);
        });
    }
};
