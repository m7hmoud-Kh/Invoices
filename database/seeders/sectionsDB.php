<?php

namespace Database\Seeders;

use App\Models\section;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class sectionsDB extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 11; $i++) {
            section::create([
                'name_section' => Str::random(10),
                'description' => Str::random(10),
                'created_by' => 'mahmoud khairy',
            ]);
        }
    }
}
