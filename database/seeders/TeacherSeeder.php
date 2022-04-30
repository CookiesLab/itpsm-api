<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\TeacherDegree;
use App\Models\TeacherLanguage;
use App\Models\Language;

class TeacherSeeder extends Seeder
{ 

    private $languages = [
        [
            'id' => 1,
            'name' => 'Español',
        ],
        [
            'id' => 2,
            'name' => 'Inglés',
        ],
    ];

    private $degrees = [
        [
            'id' => 1,
            'degree' => 'Licenciatura en Turismo',
            'date' => '2004-02-02',
            'institution' => 'Universidad Francisco Gavidia',
        ],
        [
            'id' => 2,
            'degree' => 'Licenciatura en Comunicaciones',
            'date' => '2004-02-02',
            'institution' => 'Universidad Francisco Gavidia',
        ],
    ];

    private $levels = [
        [
            'id' => 1,
            'level' => '8',
        ],
        [
            'id' => 2,
            'level' => '10',
        ],
    ];

    protected $model = Teacher::class;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::factory(7)->create();

        foreach ($this->languages as &$language) {
            Language::create([
              'id' => $language['id'],
              'name' => $language['name'],
            ]);
          }

        foreach ($this->degrees as &$degree) {
            TeacherDegree::create([
                'id' => $degree['id'],
                'teacher_id' => Teacher::all()->random()->id,
                'degree' => $degree['degree'],
                'date' => $degree['date'],
                'institution' => $degree['institution'],
            ]);
          }

          foreach ($this->levels as &$level) {
            TeacherLanguage::create([
                'id' => $level['id'],
                'teacher_id' => Teacher::all()->random()->id,
                'language_id' => $language['id'],
                'level' => $level['level'],
            ]);
          }
    }
}

