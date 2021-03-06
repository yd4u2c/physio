  {
        return static::randomElement(static::$companyPrefixes);
    }

    public static function companyNameElement()
    {
        return static::randomElement(static::$companyElements);
    }

    public static function companyNameSuffix()
    {
        return static::randomElement(static::$companyNameSuffixes);
    }

    public static function inn($area_code = "")
    {
        if ($area_code === "" || intval($area_code) == 0) {
            //Simple generation code for areas in Russian without check for valid
            $area_code = static::numberBetween(1, 91);
        } else {
            $area_code = intval($area_code);
        }
        $area_code = str_pad($area_code, 2, '0', STR_PAD_LEFT);
        $inn_base =  $area_code . static::numerify('#######');
        return $inn_base . \Faker\Calculator\Inn::checksum($inn_base);
    }

    public static function kpp($inn = "")
    {
        if ($inn == "" || strlen($inn) < 4) {
            $inn = static::inn();
        }
        return substr($inn, 0, 4) . "01001";
    }
}
                                                                                  