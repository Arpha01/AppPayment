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
        if(Schema::hasTable('users') && Schema::hasTable('organizations')) {
           Schema::table('users', function(Blueprint $table) {
            $table->foreignId('organization_id')->nullable()->constrained('organizations');
           });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_relations_with_organization');
    }
};
