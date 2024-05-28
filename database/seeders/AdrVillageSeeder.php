<?php

namespace Database\Seeders;

use App\Models\AdrVillage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdrVillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path("/data/seeders/address/adr_villages.json");
        $getResultAdrDistricts = json_decode(file_get_contents($path), true);
        foreach ($getResultAdrDistricts as $district) {
            AdrVillage::updateOrCreate(
                [
                    'id' => $district['id'],
                    'code' => $district['code'],
                    'name_kh' => $district['name_kh'],
                    'name_en' => $district['name_en'],
                    'adr_province_id' => $district['province_id'],
                    'adr_district_id' => $district['district_id'],
                    'adr_commune_id' => $district['commune_id']
                ],
                [
                    'id' => $district['id'],
                    'code' => $district['code'],
                    'name_kh' => $district['name_kh'],
                    'name_en' => $district['name_en'],
                    'adr_province_id' => $district['province_id'],
                    'adr_district_id' => $district['district_id'],
                    'adr_commune_id' => $district['commune_id']
                ],
            );
        }
    }
}
