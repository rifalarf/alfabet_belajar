<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alphabet;
use Illuminate\Support\Facades\DB;

class AlphabetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('alphabets')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $letters = range('A', 'Z');

        foreach ($letters as $letter) {
            Alphabet::create([
                'letter' => $letter,
                'image_path' => 'assets/images/' . $letter . '.png',
                'video_path' => 'assets/videos/' . $letter . '.mp4',
                'sound_path' => '', 
            ]);
        }
    }
}
