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
             $table->string('alternate_phone')->nullable();
    $table->string('whatsapp_number')->nullable();
    $table->string('email')->nullable();
    $table->string('website')->nullable();
    $table->string('contact_person_name')->nullable();
    $table->string('contact_person_role')->nullable();
    $table->string('contact_person_phone')->nullable(); 
    $table->string('contact_person_email')->nullable(); 
    $table->string('contact_person_whatsapp')->nullable();
    $table->string('logo')->nullable();
    $table->string('area')->nullable();
    $table->string('pincode')->nullable();
    $table->json('working_hours')->nullable();
    $table->year('established_year')->nullable();
    $table->json('tags')->nullable();
    $table->boolean('is_verified')->default(false);
    $table->boolean('featured')->default(false);
    
    $table->unsignedBigInteger('views')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            //
            $table->dropColumn([
                'alternate_phone',
                'whatsapp_number',
                'email',
                'website',
                'contact_person_name',
                'contact_person_role',
                'contact_person_phone',
                'contact_person_email',
                'contact_person_whatsapp',
                'logo',
                'area',
                'pincode',
                'working_hours',
                'established_year',
                'tags',
                'is_verified',
                'featured',
                'views',
            ]);
        });
    }
};
