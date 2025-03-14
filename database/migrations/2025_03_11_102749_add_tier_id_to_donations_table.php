<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTierIdToDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            // Add the tier_id foreign key column
            $table->unsignedBigInteger('tier_id')->nullable();

            // Add foreign key constraint linking to tiers table
            $table->foreign('tier_id')->references('id')->on('tiers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            // Drop the foreign key constraint and the tier_id column
            $table->dropForeign(['tier_id']);
            $table->dropColumn('tier_id');
        });
    }
}
