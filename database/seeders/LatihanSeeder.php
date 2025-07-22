<?php

namespace Database\Seeders;

use App\Models\Alphabet;
use App\Models\Level;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LatihanSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Level::truncate();
        Question::truncate();
        Option::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $alphabets = Alphabet::all();

        $levels = [
            'A' => Level::create(['name' => 'Level A', 'description' => 'Latihan untuk huruf A - E']),
            'B' => Level::create(['name' => 'Level B', 'description' => 'Latihan untuk huruf F- J']),
            'C' => Level::create(['name' => 'Level C', 'description' => 'Latihan untuk huruf K - O']),
            'D' => Level::create(['name' => 'Level D', 'description' => 'Latihan untuk huruf P - T']),
            'E' => Level::create(['name' => 'Level E', 'description' => 'Latihan untuk huruf U - Z']),
        ];

        $letterGroups = [
            'A' => ['A', 'B', 'C', 'D', 'E',],
            'B' => ['F', 'G', 'H', 'I', 'J',],
            'C' => ['K', 'L', 'M', 'N', 'O',],
            'D' => ['P', 'Q', 'R', 'S', 'T',],
            'E' => ['U', 'V', 'W', 'X', 'Y', 'Z'],
        ];

        foreach ($letterGroups as $levelKey => $letters) {
            $currentLevel = $levels[$levelKey];
            $hurufLevel = $alphabets->whereIn('letter', $letters);

            $numberOfQuestions = ($levelKey === 'E') ? 6 : 5;

            $soalSamples = $hurufLevel->count() >= $numberOfQuestions
                ? $hurufLevel->random($numberOfQuestions)
                : $hurufLevel;

            $i = 0;
            foreach ($soalSamples as $jawabanBenar) {
                $type = ($i % 2 == 0) ? 'video_to_image' : 'image_to_video';

                $question = Question::create([
                    'level_id' => $currentLevel->id,
                    'alphabet_id' => $jawabanBenar->id,
                    'type' => $type,
                ]);

                $this->createOptions($question, $jawabanBenar, $alphabets);
                $i++;
            }
        }
    }



    private function createOptions(Question $question, Alphabet $jawabanBenar, $alphabets)
    {
        if ($alphabets->count() > 3) {
            $pengecoh = $alphabets->where('id', '!=', $jawabanBenar->id)->random(3);
            $pilihanJawaban = $pengecoh->push($jawabanBenar)->shuffle();

            foreach ($pilihanJawaban as $pilihan) {
                Option::create([
                    'question_id' => $question->id,
                    'alphabet_id' => $pilihan->id,
                ]);
            }
        }
    }
}
