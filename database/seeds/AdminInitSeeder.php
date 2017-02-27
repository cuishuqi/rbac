<?php

use Illuminate\Database\Seeder;

class AdminInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = new \App\Model\Admin\AdminUser();
        $admin->
        id = 1;
        $admin->username = 'root';
        $admin->email = 'root@admin.com';
        $admin->password = bcrypt('root');
        $admin->save();
    }
}
