<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Delete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // これで既存の外部キーfk__team_id__members_idを削除します。
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign('fk__team_id__members_id');
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
