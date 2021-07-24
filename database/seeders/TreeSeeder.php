<?php

namespace Database\Seeders;

use App\Models\Tree;

use Illuminate\Database\Seeder;

class TreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 500;

        while ($count--)
        {
            Tree::factory()->create();
        }
    }
}
