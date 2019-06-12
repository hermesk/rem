<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo PHP_EOL , 'seeding roles...';

        Role::create(
            [
                'name' => 'Admin',
                'deletable' => false,
            ]
        );
        Role::create(
            [
                'name' => 'Accountant',
                'deletable' => false,
            ]
        );
       


    }

}

