<?php

use App\Author;
use App\Editorial;
use App\Stand;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        factory(Editorial::class,20)->create();
        factory(Author::class,20)->create();
        factory(Stand::class,20)->create();

    }
}
