<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'over_name' => '山田',
                'under_name' => '太郎',
                'over_name_kana' => 'ヤマダ',
                'under_name_kana' => 'タロウ',
                'mail_address' => 'yamada@gmail.com',
                'sex' => '1',
                'birth_day' => '1998/04/19',
                'role' => '1',
                'password' => bcrypt('パスワード')
            ],
        ]);
    }
}
