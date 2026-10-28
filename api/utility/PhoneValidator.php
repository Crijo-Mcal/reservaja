<?php

namespace public\api\utility;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;

class PhoneValidator
{
    public static function isValid(string $phone, string $country = 'PT'): bool
    {
        try {
            $phoneUtil = PhoneNumberUtil::getInstance();

            $number = $phoneUtil->parse(
                $phone,
                $country
            );

            return $phoneUtil->isValidNumber($number);
        } catch (NumberParseException) {
            return false;
        }
    }
}