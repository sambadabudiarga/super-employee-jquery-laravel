<?php

use App\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
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
                'code' => 'ID',
                'name'  => 'Indonesia',
            ],
            [
                'code' => 'US',
                'name'  => 'United States',
            ],
            [
                'code' => 'AU',
                'name'  => 'Australia',
            ],
            [
                'code' => 'JP',
                'name'  => 'Japan',
            ],
            [
                'code' => 'NL',
                'name'  => 'Netherland',
            ],
            [
                'code' => 'PL',
                'name'  => 'Poland',
            ],
        ];

        foreach ($data as $d) {
            Country::updateOrCreate(
                ['code' => $d["code"]],
                $d
            );
        }
    }
}
