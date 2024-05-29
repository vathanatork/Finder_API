<?php

namespace Database\Seeders;

use App\Models\AdrDistrict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdrDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path("/data/seeders/address/adr_districts.json");
        $getResultAdrDistricts = json_decode(file_get_contents($path), true);
        foreach ($getResultAdrDistricts as $district) {
            AdrDistrict::updateOrCreate(
                [
                    'id' => $district['id'],
                    'code' => $district['code'],
                    'name_kh' => $district['name_kh'],
                    'name_en' => $district['name_en'],
                    'type' => $district['type'],
                    'adr_province_id' => $district['province_id']
                ],
                [
                    'id' => $district['id'],
                    'code' => $district['code'],
                    'name_kh' => $district['name_kh'],
                    'name_en' => $district['name_en'],
                    'type' => $district['type'],
                    'adr_province_id' => $district['province_id']
                ],
            );
        }
    }
}
