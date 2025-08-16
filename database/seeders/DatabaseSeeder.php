<?php

namespace Database\Seeders;

use App\Models\Alphabet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlphabetSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('alphabets')->truncate();
        Schema::enableForeignKeyConstraints();

        $videos = [
            'A' => 'https://example.com/videoA',
            'B' => 'https://example.com/videoB',
            'C' => 'https://example.com/videoC',
            // Tambahkan semua huruf dan URL video yang sesuai
        ];

        foreach ($videos as $letter => $videoUrl) {
            Alphabet::create([
                'letter' => $letter,
                'image_path' => 'assets/images/' . $letter . '.png',
                'video_path' => $videoUrl,
                'sound_path' => '',
            ]);
        }
    }
}
