<?php

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(public_path() . DIRECTORY_SEPARATOR . 'text.txt');

        $arr = json_decode($json, true);
        foreach ($arr as &$v) {
//            $v['question_short'] = mb_substr($v['question'], 0, 100);
            $v['question_md5'] = md5($v['question']);
        }

        Question::insert($arr);
    }
}
