<?php

namespace App\Http\Requests\Admin\v01\University;

use Illuminate\Foundation\Http\FormRequest;

    class CreateRequest extends FormRequest
    {

        private string $logo_url = '';
        private string $image_url = '';
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
         */
        public function rules(): array
        {
            return [
                'name' => 'required|string',
                'logo_image' => 'required|string',
                'image' => 'required|string',
                'description' => 'required|string',
                'university_type_id' => 'required|integer',
                'established_year' => 'integer',
                'ranking' => 'integer',
                'contact_info_id' => 'integer',
                'adr_province_id' => 'required|integer',
                'adr_district_id' => 'integer',
                'adr_commune_id' => 'integer',
                'adr_village_id' => 'integer',
                'is_active' => 'boolean'
            ];
        }

        public function getName()
        {
            return request()->name;
        }

        public function getLogoImage()
        {
            return request()->logo_image;
        }
        public function setLogoImage(string $url): void
        {
            $this->logo_url = $url;
        }

        public function getLogoImageUrl(): string
        {
            return $this->logo_url;
        }

        public function getImage()
        {
            return request()->image;
        }

        public function setImage(string $url): void
        {
            $this->image_url = $url;
        }

        public function getImageUrl(): string
        {
            return $this->image_url;
        }

        public function getDescription()
        {
            return request()->description;
        }

        public function getUniversityTypeId()
        {
            return request()->university_type_id;
        }

        public function getEstablishedYear()
        {
            return request()->established_year;
        }

        public function getRanking()
        {
            return request()->ranking ?? null;
        }

        public function getContactInfoId()
        {
            return request()->contact_info_id ?? null;
        }

        public function getGraduationRate()
        {
            return request()->graduation_rate ?? null;
        }

        public function getAverageTuition()
        {
            return request()->average_tuition ?? null;
        }

        public function getAverageStudyYear()
        {
            return request()->average_study_year ?? null;
        }

        public function getAddress()
        {
            return request()->address ?? null;
        }

        public function getProvinceId()
        {
            return request()->adr_province_id;
        }

        public function getDistrictId()
        {
            return request()->adr_district_id ?? null;
        }

        public function getCommuneId()
        {
            return request()->adr_commune_id ?? null;
        }

        public function getVillageId()
        {
            return request()->adr_village_id ?? null;
        }

        public function getIsActive():bool
        {
            return request()->is_active ?? true;
        }

    }
