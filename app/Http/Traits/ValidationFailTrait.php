<?php

namespace App\Http\Traits;

use App\Constants\Enum\StatusCodeEnum;

trait ValidationFailTrait
{
    public function validationFail($validator)
    {
        if ($validator->fails()) {
            $this->setCode(StatusCodeEnum::CONFLICT);
            $this->setMessage('Validation failed');
            $this->setResult('errors', $validator->errors());
            return $this->returnResults();
        }
        return null;
    }
}
