<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBusinessTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_team_members', function (Blueprint $table) {
            $table->foreign(['team_member_id'], 'business_team_members_ibfk_2')->references(['id'])->on('team_members')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['business_id'], 'business_team_members_ibfk_1')->references(['id'])->on('businesses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_team_members', function (Blueprint $table) {
            $table->dropForeign('business_team_members_ibfk_2');
            $table->dropForeign('business_team_members_ibfk_1');
        });
    }
}
