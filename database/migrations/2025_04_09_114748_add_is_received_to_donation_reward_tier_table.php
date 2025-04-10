<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsReceivedToDonationRewardTierTable extends Migration
{
    public function up()
    {
        Schema::table('donation_reward_tier', function (Blueprint $table) {
            $table->boolean('is_received')->default(false)->after('reward_tier_id');
        });
    }

    public function down()
    {
        Schema::table('donation_reward_tier', function (Blueprint $table) {
            $table->dropColumn('is_received');
        });
    }
}