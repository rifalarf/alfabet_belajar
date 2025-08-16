<?php
namespace Database\Seeders;

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

        $videos = [
            'A' => 'https://www.youtube.com/shorts/2OcC9i1InLU',
            'B' => 'https://www.youtube.com/shorts/YvFxrZ0fztQ',
            'C' => 'https://www.youtube.com/shorts/LOacf34VxTU',
            'D' => 'https://www.youtube.com/shorts/ZKADa6gapbA',
            'E' => 'https://www.youtube.com/shorts/2BDsDoFPN8g',
            'F' => 'https://www.youtube.com/shorts/RvuWR7_BWtw',
            'G' => 'https://www.youtube.com/shorts/WDts7U1tv-w',
            'H' => 'https://www.youtube.com/shorts/aB42HiuAovA',
            'I' => 'https://www.youtube.com/shorts/B2k4b09ft6M',
            'J' => 'https://www.youtube.com/shorts/i1rK-dt06Rc',
            'K' => 'https://www.youtube.com/shorts/40ArLDrA-P4',
            'L' => 'https://www.youtube.com/shorts/gaFK-TaguMQ',
            'M' => 'https://www.youtube.com/shorts/czr_IBMxCQo',
            'N' => 'https://www.youtube.com/shorts/aUW6PqTXUXw',
            'O' => 'https://www.youtube.com/shorts/MtQr7njFDw8',
            'P' => 'https://www.youtube.com/shorts/1KnRr16FPS4',
            'Q' => 'https://www.youtube.com/shorts/cB834Hwh6RE',
            'R' => 'https://www.youtube.com/shorts/zRFLyEzUFl8',
            'S' => 'https://www.youtube.com/shorts/Z7xN1EVOrP8',
            'T' => 'https://www.youtube.com/shorts/-mgz8x_sVSA',
            'U' => 'https://www.youtube.com/shorts/2BDsDoFPN8g',
            'V' => 'https://www.youtube.com/shorts/Bokfph5clc8',
            'W' => 'https://www.youtube.com/shorts/4rMBTVhLZto',
            'X' => 'https://www.youtube.com/shorts/gsgfc3cK5Kc',
            'Y' => 'https://www.youtube.com/shorts/1y-1GOBRHsw',
            'Z' => 'https://www.youtube.com/shorts/wibmUY8DAW4',
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
