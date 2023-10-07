<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Recreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // これで新しい外部キーを作り、その外部キーに対して削除時の挙動を明示します。
    public function up()
    {
        DB::statement(
            'ALTER TABLE members ADD CONSTRAINT 新しい外部キー名
             FOREIGN KEY (team_id) REFERENCES teams (id)
             ON DELETE CASCADE ON APDATE CASCADE'
          );
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
