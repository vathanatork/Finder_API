<?php

namespace App\Http\Resources\Mobile;

use App\Http\Resources\AdmissionResource;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MobileAdmissionResource extends AdmissionResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        unset($data['university'],$data['contact']);

        return $data + [
            'tuition' => $this->university ? $this->university->average_tuition : null,
            'contact_info' => $this->contact ? ContactResource::make($this->contact) : ContactResource::make
            ($this->university->contact)
        ];
    }

}
