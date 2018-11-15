<?php

use App\Employee;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'first_name' => 'Sambada',
                'last_name' => 'Budiarga',
                'country_id' => 1,
                'age'   => 28
            ],
            [
                'first_name' => 'Kimberly L.',
                'last_name' => 'Leung',
                'country_id' => 2,
                'age'   => 24
            ],
            [
                'first_name' => 'Elizabeth K.',
                'last_name' => 'Portillo',
                'country_id' => 2,
                'age'   => 24
            ],
            [
                'first_name' => 'Ben',
                'last_name' => 'McCombie',
                'country_id' => 3,
                'age'   => 34
            ],
            [
                'first_name' => 'Eva',
                'last_name' => 'Cummins',
                'country_id' => 3,
                'age'   => 22
            ],
            [
                'first_name' => 'Lucas',
                'last_name' => 'Hall',
                'country_id' => 3,
                'age'   => 27
            ],
            [
                'first_name' => 'Takuji',
                'last_name' => 'Ooishi',
                'country_id' => 4,
                'age'   => 26
            ],
            [
                'first_name' => 'Mayuko',
                'last_name' => 'Kitano',
                'country_id' => 4,
                'age'   => 30
            ],
            [
                'first_name' => 'Aysenur',
                'last_name' => 'Brans',
                'country_id' => 6,
                'age'   => 21
            ],
            [
                'first_name' => 'Jaidy',
                'last_name' => 'Brok',
                'country_id' => 6,
                'age'   => 38
            ],
            [
                'first_name' => 'Kader',
                'last_name' => 'Groben',
                'country_id' => 6,
                'age'   => 25
            ],
            [
                'first_name' => 'Hedwig',
                'last_name' => 'Akyuz',
                'country_id' => 6,
                'age'   => 27
            ],
            [
                'first_name' => 'Anouck',
                'last_name' => 'Klopstra',
                'country_id' => 6,
                'age'   => 32
            ],
            [
                'first_name' => 'My',
                'last_name' => 'Kalter',
                'country_id' => 6,
                'age'   => 22
            ],
        ];

        foreach ($data as $d) {
            Employee::updateOrCreate(
                [
                    'first_name' => $d["first_name"],
                    'last_name' => $d["last_name"]
                ],
                $d
            );
        }
    }
}
