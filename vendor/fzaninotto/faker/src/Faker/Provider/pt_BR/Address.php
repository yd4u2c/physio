> '31', 'SB' => '32', 'SV' => '33',
        'TR' => '34', 'TM' => '35', 'TL' => '36', 'VS' => '37', 'VL' => '38', 'VN' => '39',

        'B1' => '41', 'B2' => '42', 'B3' => '43', 'B4' => '44', 'B5' => '45', 'B6' => '46'
    );

    /**
     * Personal Numerical Code (CNP)
     *
     * @link http://ro.wikipedia.org/wiki/Cod_numeric_personal
     * @example 1111111111118
     *
     * @param null|string $gender Person::GENDER_MALE or Person::GENDER_FEMALE
     * @param null|string $dateOfBirth (1800-2099) 'Y-m-d', 'Y-m', 'Y'  I.E. '1981-06-16', '2085-03', '1900'
     * @param null|string $county county code where the CNP was issued
     * @param null|bool $isResident flag if the person resides in Romania
     * @return string 13 digits CNP code
     */
    public function cnp($gender = null, $dateOfBirth = null, $county = null, $isResident = true)
    {
        $genders = array(Person::GENDER_MALE, Person::GENDER_FEMALE);
        if (empty($gender)) {
            $gender = static::randomElement($genders);
        } elseif (!in_array($gender, $genders)) {
            throw new \InvalidArgumentException("Gender must be '{Person::GENDER_MALE}' or '{Person::GENDER_FEMALE}'");
        }

        $date = $this->getDateOfBirth($dateOfBirth);

        if (is_null($county)) {
            $countyCode = static::randomElement(array_values(static::$cnpCountyCodes));
        } elseif (!array_key_exists($county, static::$cnpCountyCodes)) {
            throw new \InvalidArgumentException("Invalid county code '{$county}' received");
        } else {
            $countyCode = static::$cnpCountyCodes[$county];
        }

        $cnp = (string)$this->getGenderDigit($date, $gender, $isResident)
            . $date->format('ymd')
            . $countyCode
            . static::numerify('##%')
        ;

        $checksum = $this->getChecksumDigit($cnp);

        return $cnp.$checksum;
    }

    /**
     * @param $dateOfBirth
     * @return \DateTime
     */
    protected function getDateOfBirth($dateOfBirth)
    {
        if (empty($dateOfBirth)) {
            $dateOfBirthParts = array(static::numberBetween(1800, 2099));
        } else {
            $dateOfBirthParts = explode('-', $dateOfBirth);
        }
        $baseDate = \Faker\Provider\DateTime::dateTimeBetween("first day of {$dateOfBirthParts[0]}", "last day of {$dateOfBirthParts[0]}");

        switch (count($dateOfBirthParts)) {
            case 1:
                $dateOfBirthParts[] = $baseDate->format('m');
            //don't break, we need the day also
            case 2:
                $dateOfBirthParts[] = $baseDate->format('d');
            //don't break, next line will
            case 3:
                break;
            default:
                throw new \InvalidArgumentException("Invalid date of birth - must be null or in the 'Y-m-d', 'Y-m', 'Y' format");
        }

        if ($dateOfBirthParts[0] < 1800 || $dateOfBirthParts[0] > 2099) {
            throw new \InvalidArgumentException("Invalid date of birth - year must be between 1900 and 2099, '{$dateOfBirthParts[0]}' received");
        }

        $dateOfBirthFinal = implode('-', $dateOfBirthParts);
        $date = \DateTime::createFromFormat('Y-m-d', $dateOfBirthFinal);
        //a full (invalid) date might have been supplied, check if it converts
        if ($date->format('Y-m-d') !== $dateOfBirthFinal) {
            throw new \InvalidArgumentException("Invalid date of birth - '{$date->format('Y-m-d')}' generated based on '{$dateOfBirth}' received");
        }

        return $date;
    }

    /**
     *
     * https://ro.wikipedia.org/wiki/Cod_numeric_personal#S
     *
     * @param \DateTime $dateOfBirth
     * @param bool $isResident
     * @param string $gender
     * @return int
     */
    protected static function getGenderDigit(\DateTime $dateOfBirth, $gender, $isResident)
    {
        if (!$isResident) {
            return 9;
        }

        if ($dateOfBirth->format('Y') < 1900) {
            if ($gender == Person::GENDER_MALE) {
                return 3;
            }
            return 4;
        }

        if ($dateOfBirth->format('Y') < 2000) {
            if ($gender == Person::GENDER_MALE) {
                return 1;
            }
            return 2;
        }

        if ($gender == Person::GENDER_MALE) {
            return 5;
        }
        return 6;
    }

    /**
     * Calculates a checksum for the Personal Numerical Code (CNP).
     *
     * @param string $value 12 digit CNP
     * @return int checksum digit
     */
    protected function getChecksumDigit($value)
    {
        $checkNumber = 279146358279;

        $checksum = 0;
        foreach (range(0, 11) as $digit) {
            $checksum += (int)substr($value, $digit, 1) * (int)substr($checkNumber, $digit, 1);
        }
        $checksum = $checksum % 11;

        return $checksum == 10 ? 1 : $checksum;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         