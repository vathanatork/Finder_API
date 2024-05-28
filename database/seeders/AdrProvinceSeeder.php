<?php

namespace Database\Seeders;

use App\Models\AdrProvince;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdrProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path("/data/seeders/address/adr_provinces.json");
        $getResultAdrProvinces = json_decode(file_get_contents($path), true);
        foreach ($getResultAdrProvinces as $province) {
            AdrProvince::updateOrCreate(
                [
                    'id' => $province['id'],
                    'code' => $province['code'],
                    'name_kh' => $province['name_kh'],
                    'name_en' => $province['name_en'],
                    'type' => $province['type']
                ],
                [
                    'code' => $province['code'],
                    'name_kh' => $province['name_kh'],
                    'name_en' => $province['name_en'],
                    'type' => $province['type']
                ],
            );
        }
    }
}
