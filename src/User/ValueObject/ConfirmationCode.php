<?php

namespace App\User\ValueObject;

use Webmozart\Assert\Assert;

class ConfirmationCode
{
    private int $code;

    public function __construct($code = null)
    {
        if (!is_null($code)) {
            Assert::lengthBetween($code, 4, 4, 'Код подтверждения должен состоять из 4-х чисел');
            $this->code = $code;
        } else {
            $this->code = random_int(1000, 9999);
        }
    }

    public function getCode(): int
    {
        return $this->code;
    }
}