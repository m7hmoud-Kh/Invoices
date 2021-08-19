<?php

namespace Database\Seeders;

use App\Models\product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class productsDB extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 30; $i++) {
            product::create([
                'name' => Str::random(8),
                'section_id' => rand(1,11),
                'description' => Str::random(50),
                'created_by' => 'mahmoud khairy',
            ]);
        }
    }
}
