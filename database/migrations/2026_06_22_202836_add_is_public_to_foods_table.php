<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('foods', function (Blueprint $table) {

            $table->boolean('is_public')
                ->default(false)
                ->after('image_url');

            $table->string('user_email')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('foods', function (Blueprint $table) {

            $table->dropColumn('is_public');

            $table->string('user_email')
                ->nullable(false)
                ->change();
        });
    }
};
