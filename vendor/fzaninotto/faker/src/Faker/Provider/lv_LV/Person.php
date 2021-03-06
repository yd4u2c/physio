eturn a Malay female first name
     * 
     * @example 'Adibah'
     * 
     * @return string
     */
    public static function firstNameFemaleMalay()
    {
        return static::randomElement(static::$firstNameFemaleMalay);
    }

    /**
     * Return a Malay last name
     * 
     * @example 'Abdullah'
     * 
     * @return string
     */
    public function lastNameMalay()
    {
        return static::randomElement(static::$lastNameMalay);
    }

    /**
     * Return a Malay male 'Muhammad' name
     * 
     * @example 'Muhammad'
     * 
     * @return string
     */
    public static function muhammadName()
    {
        return static::randomElement(static::$muhammadName);
    }

    /**
     * Return a Malay female 'Nur' name
     * 
     * @example 'Nur'
     * 
     * @return string
     */
    public static function nurName()
    {
        return static::randomElement(static::$nurName);
    }

    /**
     * Return a Malay male 'Haji' title
     * 
     * @example 'Haji'
     * 
     * @return string
     */
    public static function haji()
    {
        return static::randomElement(static::$haji);
    }

    /**
     * Return a Malay female 'Hajjah' title
     * 
     * @example 'Hajjah'
     * 
     * @return string
     */
    public static function hajjah()
    {
        return static::randomElement(static::$hajjah);
    }

    /**
     * Return a Malay title
     * 
     * @example 'Syed'
     * 
     * @return string
     */
    public static function titleMaleMalay()
    {
        return static::randomElement(static::$titleMaleMalay);
    }

    /**
     * Return a Chinese last name
     * 
     * @example 'Lim'
     * 
     * @return string
     */
    public static function lastNameChinese()
    {
        return static::randomElement(static::$lastNameChinese);
    }

    /**
     * Return a Chinese male first name
     * 
     * @example 'Goh Tong'
     * 
     * @return string
     */
    public static function firstNameMaleChinese()
    {
        return static::randomElement(static::$firstNameChinese) . ' ' . static::randomElement(static::$firstNameMaleChinese);
    }

    /**
     * Return a Chinese female first name
     * 
     * @example 'Mew Choo'
     * 
     * @return string
     */
    public static function firstNameFemaleChinese()
    {
        return static::randomElement(static::$firstNameChinese) . ' ' . static::randomElement(static::$firstNameFemaleChinese);
    }

    /**
     * Return a Christian male name
     * 
     * @example 'Aaron'
     * 
     * @return string
     */
    public static function firstNameMaleChristian()
    {
        return static::randomElement(static::$firstNameMaleChristian);
    }

    /**
     * Return a Christian female name
     * 
     * @example 'Alice'
     * 
     * @return string
     */
    public static function firstNameFemaleChristian()
    {
        return static::randomElement(static::$firstNameFemaleChristian);
    }

    /**
     * Return an Indian initial
     * 
     * @example 'S. '
     * 
     * @return string
     */
    public static function initialIndian()
    {
        return static::randomElement(static::$initialIndian);
    }

    /**
     * Return an Indian male first name
     * 
     * @example 'Arumugam'
     * 
     * @return string
     */
    public static function firstNameMaleIndian()
    {
        return static::randomElement(static::$firstNameMaleIndian);
    }

    /**
     * Return an Indian female first name
     * 
     * @example 'Ambiga'
     * 
     * @return string
     */
    public static function firstNameFemaleIndian()
    {
        return static::randomElement(static::$firstNameFemaleIndian);
    }

    /**
     * Return an Indian last name
     * 
     * @example 'Subramaniam'
     * 
     * @return string
     */
    public static function lastNameIndian()
    {
        return static::randomElement(static::$lastNameIndian);
    }

    /**
     * Return a random last name
     * 
     * @example 'Lee'
     * 
     * @return string
     */
    public function lastName()
    {
        $formats = array(
            '{{lastNameMalay}}',
            '{{lastNameChinese}}',
            '{{lastNameIndian}}',
        );

        return $this->generator->parse(static::randomElement($formats));
    }

    /**
     * Return a Malaysian I.C. No.
     * 
     * @example '890123-45-6789'
     * 
     * @link https://en.wikipedia.org/wiki/Malaysian_identity_card#Structure_of_the_National_Registration_Identity_Card_Number_(NRIC)
     * 
     * @param string|null      $gender 'male', 'female' or null for any
     * @param bool|string|null $hyphen true, false, or any separator characters
     * 
     * @return string
     */
    public static function myKadNumber($gender = null, $hyphen = false)
    {
        // year of birth
        $yy = mt_rand(0, 99);

        // month of birth
        $mm = DateTime::month();

        // day of birth
        $dd = DateTime::dayOfMonth();

        // place of birth (1-59 except 17-20)
        while (in_array(($pb = mt_rand(1, 59)), array(17, 18, 19, 20))) {
        };

        // random number
        $nnn = mt_rand(0, 999);

        // gender digit. Odd = MALE, Even = FEMALE
        $g = mt_rand(0, 9);
        //Credit: https://gist.github.com/mauris/3629548
        if ($gender === static::GENDER_MALE) {
            $g = $g | 1;
        } elseif ($gender === static::GENDER_FEMALE) {
            $g = $g & ~1;
        }

        // formatting with hyphen
        if ($hyphen === true) {
            $hyphen = "-";
        } else if ($hyphen === false) {
            $hyphen = "";
        }

        return sprintf("%02d%02d%02d%s%02d%s%03d%01d", $yy, $mm, $dd, $hyphen, $pb, $hyphen, $nnn, $g);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

namespace Faker\Provider\ms_MY;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    protected static $formats = array(
        '{{mobileNumber}}',
        '{{fixedLineNumber}}',
        '{{voipNumber}}'
    );

    protected static $plusSymbol = array(
        '+'
    );

    protected static $countryCodePrefix = array(
        '6'
    );

    /**
     * @link https://en.wikipedia.org/wiki/Telephone_numbers_in_Malaysia#Mobile_phone_codes_and_IP_telephony
     */
    protected static $zeroOneOnePrefix = array('10','11','12','13','14','15','16','17','18','19','20','22','23','32');
    protected static $zeroOneFourPrefix = array('2','3','4','5','6','7','8','9');
    protected static $zeroOneFivePrefix = array('1','2','3','4','5','6','9');

    /**
     * @link https://en.wikipedia.org/wiki/Telephone_numbers_in_Malaysia#Mobile_phone_codes_and_IP_telephony
     */
    protected static $mobileNumberFormatsWithFormatting = array(
        '010-### ####',
        '011-{{zeroOneOnePrefix}}## ####',
        '012-### ####',
        '013-### ####',
        '014-{{zeroOneFourPrefix}}## ####',
        '016-### ####',
        '017-### ####',
        '018-### ####',
        '019-### ####',
    );

    protected static $mobileNumberFormats = array(
        '010#######',
        '011{{zeroOneOnePrefix}}######',
        '012#######',
        '013#######',
        '014{{zeroOneFourPrefix}}######',
        '016#######',
        '017#######',
        '018#######',
        '019#######',
    );

    /**
     * @link https://en.wikipedia.org/wiki/Telephone_numbers_in_Malaysia#Geographic_area_codes
     */
    protected static $fixedLineNumberFormatsWithFormatting = array(
        '03-#### ####',
        '04-### ####',
        '05-### ####',
        '06-### ####',
        '07-### ####',
        '08#-## ####',
        '09-### ####',
    );

    protected static $fixedLineNumberFormats = array(
        '03########',
        '04#######',
        '05#######',
        '06#######',
        '07#######',
        '08#######',
        '09#######',
    );

    /**
     * @link https://en.wikipedia.org/wiki/Telephone_numbers_in_Malaysia#Mobile_phone_codes_and_IP_telephony
     */
    protected static $voipNumberWithFormatting = array(
        '015-{{zeroOneFivePrefix}}## ####'
    );

    protected static $voipNumber = array(
        '015{{zeroOneFivePrefix}}######'
    );

    /**
     * Return a Malaysian Mobile Phone Number.
     * 
     * @example '+6012-345-6789'
     * 
     * @param bool $countryCodePrefix true, false
     * @param bool $formatting true, false
     * 
     * @return string
     */
    public function mobileNumber($countryCodePrefix = true, $formatting = true)
    {
        if ($formatting) {
            $format = static::randomElement(static::$mobileNumberFormatsWithFormatting);
        } else {
            $format = static::randomElement(static::$mobileNumberFormats);
        }

        if ($countryCodePrefix) {
            return static::countryCodePrefix($formatting) . static::numerify($this->generator->parse($format));
        } else {
            return static::numerify($this->generator->parse($format));
        }
    }

    /**
     * Return prefix digits for 011 numbers
     * 
     * @example '10'
     * 
     * @return string
     */
    public static function zeroOneOnePrefix()
    {
        return static::numerify(static::randomElement(static::$zeroOneOnePrefix));
    }

    /**
     * Return prefix digits for 014 numbers
     * 
     * @example '2'
     * 
     * @return string
     */
    public static function zeroOneFourPrefix()
    {
        return static::numerify(static::randomElement(static::$zeroOneFourPrefix));
    }

    /**
     * Return prefix digits for 015 numbers
     * 
     * @example '1'
     * 
     * @return string
     */
    public static function zeroOneFivePrefix()
    {
        return static::numerify(static::randomElement(static::$zeroOneFivePrefix));
    }

    /**
     * Return a Malaysian Fixed Line Phone Number.
     * 
     * @example '+603-4567-8912'
     * 
     * @param bool $countryCodePrefix true, false
     * @param bool $formatting true, false
     * 
     * @return string
     */
    public function fixedLineNumber($countryCodePrefix = true, $formatting = true)
    {
        if ($formatting) {
            $format = static::randomElement(static::$fixedLineNumberFormatsWithFormatting);
        } else {
            $format = static::randomElement(static::$fixedLineNumberFormats);
        }

        if ($countryCodePrefix) {
            return static::countryCodePrefix($formatting) . static::numerify($this->generator->parse($format));
        } else {
            return static::numerify($this->generator->parse($format));
        }
    }

    /**
     * Return a Malaysian VoIP Phone Number.
     * 
     * @example '+6015-678-9234'
     * 
     * @param bool $countryCodePrefix true, false
     * @param bool $formatting true, false
     * 
     * @return string
     */
    public function voipNumber($countryCodePrefix = true, $formatting = true)
    {
        if ($formatting) {
            $format = static::randomElement(static::$voipNumberWithFormatting);
        } else {
            $format = static::randomElement(static::$voipNumber);
        }

        if ($countryCodePrefix) {
            return static::countryCodePrefix($formatting) . static::numerify($this->generator->parse($format));
        } else {
            return static::numerify($this->generator->parse($format));
        }
    }

    /**
     * Return a Malaysian Country Code Prefix.
     * 
     * @example '+6'
     * 
     * @param bool $formatting true, false
     * 
     * @return string
     */
    public static function countryCodePrefix($formatting = true)
    {
        if ($formatting) {
            return static::randomElement(static::$plusSymbol) . static::randomElement(static::$countryCodePrefix);
        } else {
            return static::randomElement(static::$countryCodePrefix);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Faker\Provider\nb_NO;

class Address extends \Faker\Provider\Address
{
    protected static $buildingNumber = array('%###', '%##', '%#', '%#?', '%', '%?');

    protected static $streetPrefix = array(
        "Øvre", "Nedre", "Søndre", "Gamle", "Østre", "Vestre"
    );

    protected static $streetSuffix = array(
        "alléen", "bakken", "berget", "bråten", "eggen", "engen", "ekra", "faret", "flata", "gata", "gjerdet", "grenda",
        "gropa", "hagen", "haugen", "havna", "holtet", "høgda", "jordet", "kollen", "kroken", "lia", "lunden", "lyngen",
        "løkka", "marka", "moen", "myra", "plassen", "ringen", "roa", "røa", "skogen", "skrenten", "spranget", "stien",
        "stranda", "stubben", "stykket", "svingen", "tjernet", "toppen", "tunet", "vollen", "vika", "åsen"
    );

    protected static $streetSuffixWord = array(
        "sgate", "svei", "s Gate", "s Vei", "gata", "veien"
    );

    protected static $postcode = array("####", "####", "####", "0###");

    /**
    * @var array Norwegian city names
    * @link https://no.wikipedia.org/wiki/Liste_over_norske_byer
    */
    protected static $cityNames = array(
        "Alta", "Arendal", "Askim", "Bergen", "Bodø", "Brekstad", "Brevik", "Brumunddal", "Bryne", "Brønnøysund",
        "Drammen", "Drøbak", "Egersund", "Elverum", "Fagernes", "Farsund", "Fauske", "Finnsnes", "Flekkefjord", "Florø",
        "Fosnavåg", "Fredrikstad", "Førde", "Gjøvik", "Grimstad", "Halden", "Hamar", "Hammerfest", "Harstad",
        "Haugesund", "Hokksund", "Holmestrand", "Honningsvåg", "Horten", "Hønefoss", "Jessheim", "Jørpeland",
        "Kirkenes", "Kolvereid", "Kongsberg", "Kongsvinger", "Kopervik", "Kragerø", "Kristiansand", "Kristiansund",
        "Langesund", "Larvik", "Leknes", "Levanger", "Lillehammer", "Lillesand", "Lillestrøm", "Lyngdal", "Mandal",
        "Mo i Rana",  "Moelv", "Molde", "Mosjøen", "Moss", "Mysen", "Måløy", "Namsos", "Narvik", "Notodden", "Odda",
        "Orkanger", "Oslo", "Otta", "Porsgrunn", "Risør", "Rjukan", "Røros", "Sandefjord", "Sandnes", "Sandnessjøen",
        "Sandvika", "Sarpsborg", "Sauda", "Ski", "Skien", "Skudeneshavn", "Sortland", "Stathelle", "Stavanger",
        "Stavern", "Steinkjer", "Stjørdalshalsen", "Stokmarknes", "Stord", "Svelvik", "Svolvær", "Tromsø", "Trondheim",
        "Tvedestrand", "Tønsberg", "Ulsteinvik", "Vadsø", "Vardø", "Verdalsøra", "Vinstra", "Åkrehamn", "Ålesund",
        "Åndalsnes", "Åsgårdstrand"
    );

    protected static $cityFormats = array(
        '{{cityName}}'
    );

    /**
    * @var array Norwegian municipality names
    * @link https://no.wikipedia.org/wiki/Norges_kommuner
    */
    protected static $kommuneNames = array(
        "Halden", "Moss", "Sarpsborg", "Fredrikstad", "Hvaler", "Aremark", "Marker", "Rømskog", "Trøgstad", "Spydeberg",
        "Askim", "Eidsberg", "Skiptvet", "Rakkestad", "Råde", "Rygge", "Våler", "Hobøl", "Vestby", "Ski", "Ås", "Frogn",
        "Nesodden", "Oppegård", "Bærum", "Asker", "Aurskog-Høland", "Sørum", "Fet", "Rælingen", "Enebakk", "Lørenskog",
        "Skedsmo", "Nittedal", "Gjerdrum", "Ullensaker", "Nes", "Eidsvoll", "Nannestad", "Hurdal", "Oslo",
        "Kongsvinger", "Hamar", "Ringsaker", "Løten", "Stange", "Nord-Odal", "Sør-Odal", "Eidskog", "Grue", "Åsnes",
        "Våler", "Elverum", "Trysil", "Åmot", "Stor-Elvdal", "Rendalen", "Engerdal", "Tolga", "Tynset", "Alvdal",
        "Folldal", "Os", "Lillehammer", "Gjøvik", "Dovre", "Lesja", "Skjåk", "Lom", "Vågå", "Nord-Fron", "Sel",
        "Sør-Fron", "Ringebu", "Øyer", "Gausdal", "Østre Toten", "Vestre Toten", "Jevnaker", "Lunner", "Gran",
        "Søndre Land", "Nordre Land", "Sør-Aurdal", "Etnedal", "Nord-Aurdal", "Vestre Slidre", "Øystre Slidre", "Vang",
        "Drammen", "Kongsberg", "Ringerike", "Hole", "Flå", "Nes", "Gol", "Hemsedal", "Ål", "Hol", "Sigdal",
        "Krødsherad", "Modum", "Øvre Eiker", "Nedre Eiker", "Lier", "Røyken", "Hurum", "Flesberg", "Rollag",
        "Nore og Uvdal", "Horten", "Holmestrand", "Tønsberg", "Sandefjord", "Larvik", "Svelvik", "Sande", "Hof", "Re",
        "Andebu", "Stokke", "Nøtterøy", "Tjøme", "Lardal", "Porsgrunn", "Skien", "Notodden", "Siljan", "Bamble",
        "Kragerø", "Drangedal", "Nome", "Bø", "Sauherad", "Tinn", "Hjartdal", "Seljord", "Kviteseid", "Nissedal",
        "Fyresdal", "Tokke", "Vinje", "Risør", "Grimstad", "Arendal", "Gjerstad", "Vegårshei", "Tvedestrand", "Froland",
        "Lillesand", "Birkenes", "Åmli", "Iveland", "Evje og Hornnes", "Bygland", "Valle", "Bykle", "Kristiansand",
        "Mandal", "Farsund", "Flekkefjord", "Vennesla", "Songdalen", "Søgne", "Marnardal", "Åseral", "Audnedal",
        "Lindesnes", "Lyngdal", "Hægebostad", "Kvinesdal", "Sirdal", "Eigersund", "Sandnes", "Stavanger", "Haugesund",
        "Sokndal", "Lund", "Bjerkreim", "Hå", "Klepp", "Time", "Gjesdal", "Sola", "Randaberg", "Forsand", "Strand",
        "Hjelmeland", "Suldal", "Sauda", "Finnøy", "Rennesøy", "Kvitsøy", "Bokn", "Tysvær", "Karmøy", "Utsira",
        "Vindafjord", "Bergen", "Etne", "Sveio", "Bømlo", "Stord", "Fitjar", "Tysnes", "Kvinnherad", "Jondal", "Odda",
        "Ullensvang", "Eidfjord", "Ulvik", "Granvin", "Voss", "Kvam", "Fusa", "Samnanger", "Os", "Austevoll", "Sund",
        "Fjell", "Askøy", "Vaksdal", "Modalen", "Osterøy", "Meland", "Øygarden", "Radøy", "Lindås", "Austrheim",
        "Fedje", "Masfjorden", "Flora", "Gulen", "Solund", "Hyllestad", "Høyanger", "Vik", "Balestrand", "Leikanger",
        "Sogndal", "Aurland", "Lærdal", "Årdal", "Luster", "Askvoll", "Fjaler", "Gaular", "Jølster", "Førde",
        "Naustdal", "Bremanger", "Vågsøy", "Selje", "Eid", "Hornindal", "Gloppen", "Stryn", "Molde", "Ålesund",
        "Kristiansund", "Vanylven", "Sande", "Herøy", "Ulstein", "Hareid", "Volda", "Ørsta", "Ørskog", "Norddal",
        "Stranda", "Stordal", "Sykkylven", "Skodje", "Sula", "Giske", "Haram", "Vestnes", "Rauma", "Nesset", "Midsund",
        "Sandøy", "Aukra", "Fræna", "Eide", "Averøy", "Gjemnes", "Tingvoll", "Sunndal", "Surnadal", "Rindal", "Halsa",
        "Smøla", "Aure", "Trondheim", "Hemne", "Snillfjord", "Hitra", "Frøya", "Ørland", "Agdenes", "Rissa", "Bjugn",
        "Åfjord", "Roan", "Osen", "Oppdal", "Rennebu", "Meldal", "Orkdal", "Røros", "Holtålen", "Midtre Gauldal",
        "Melhus", "Skaun", "Klæbu", "Malvik", "Selbu", "Tydal", "Steinkjer", "Namsos", "Meråker", "Stjørdal", "Frosta",
        "Leksvik", "Levanger", "Verdal", "Verran", "Namdalseid", "Inderøy", "Snåsa", "Lierne", "Røyrvik", "Namsskogan",
        "Grong", "Høylandet", "Overhalla", "Fosnes", "Flatanger", "Vikna", "Nærøy", "Leka", "Bodø", "Narvik", "Bindal",
        "Sømna", "Brønnøy", "Vega", "Vevelstad", "Herøy", "Alstahaug", "Leirfjord", "Vefsn", "Grane", "Hattfjelldal",
        "Dønna", "Nesna", "Hemnes", "Rana", "Lurøy", "Træna", "Rødøy", "Meløy", "Gildeskål", "Beiarn", "Saltdal",
        "Fauske", "Sørfold", "Steigen", "Hamarøy", "Tysfjord", "Lødingen", "Tjeldsund", "Evenes", "Ballangen", "Røst",
        "Værøy", "Flakstad", "Vestvågøy", "Vågan", "Hadsel", "Bø", "Øksnes", "Sortland", "Andøy", "Moskenes",
        "Harstad[10]", "Tromsø", "Kvæfjord", "Skånland", "Ibestad", "Gratangen", "Lavangen", "Bardu", "Salangen",
        "Målselv", "Sørreisa", "Dyrøy", "Tranøy", "Torsken", "Berg", "Lenvik", "Balsfjord", "Karlsøy", "Lyngen",
        "Storfjord", "Kåfjord", "Skjervøy", "Nordreisa", "Kvænangen", "Vardø", "Vadsø", "Hammerfest", "Kautokeino",
        "Alta", "Loppa", "Hasvik", "Kvalsund", "Måsøy", "Nordkapp", "Porsanger", "Karasjok", "Lebesby", "Gamvik",
        "Berlevåg", "Tana", "Nesseby", "Båtsfjord", "Sør-Varanger"
    );


    /**
    * @var array Norwegian county names
    * @link https://no.wikipedia.org/wiki/Norges_fylker
    */
    protected static $countyNames = array(
        "Østfold", "Akershus", "Oslo", "Hedmark", "Oppland", "Buskerud", "Vestfold", "Telemark", "Aust-Agder",
        "Vest-Agder", "Rogaland", "Hordaland", "Sogn og Fjordane", "Møre og Romsdal", "Sør-Trøndelag", "Nord-Trøndelag",
        "Nordland", "Troms", "Finnmark", "Svalbard", "Jan Mayen", "Kontinentalsokkelen"
    );

    protected static $country = array(
        "Abkhasia", "Afghanistan", "Albania", "Algerie", "Andorra", "Angola", "Antigua og Barbuda", "Argentina",
        "Armenia", "Aserbajdsjan", "Australia", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belgia", "Belize",
        "Benin", "Bhutan", "Bolivia", "Bosnia-Hercegovina", "Botswana", "Brasil", "Brunei", "Bulgaria", "Burkina Faso",
        "Burundi", "Canada", "Chile", "Colombia", "Costa Rica", "Cuba", "Danmark", "De forente arabiske emirater",
        "Den demokratiske republikken Kongo", "Den dominikanske republikk", "Den sentralafrikanske republikk",
        "Djibouti", "Dominica", "Ecuador", "Egypt", "Ekvatorial-Guinea", "Elfenbenskysten", "El Salvador", "Eritrea",
        "Estland", "Etiopia", "Fiji", "Filippinene", "Finland", "Frankrike", "Gabon", "Gambia", "Georgia", "Ghana",
        "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Hellas", "Honduras", "Hviterussland",
        "India", "Indonesia", "Irak", "Iran", "Irland", "Island", "Israel", "Italia", "Jamaica", "Japan", "Jemen",
        "Jordan", "Kambodsja", "Kamerun", "Kapp Verde", "Kasakhstan", "Kenya", "Folkerepublikken Kina", "Kirgisistan",
        "Kiribati", "Komorene", "Republikken Kongo", "Kosovo", "Kroatia", "Kuwait", "Kypros", "Laos", "Latvia",
        "Lesotho", "Libanon", "Liberia", "Libya", "Liechtenstein", "Litauen", "Luxembourg", "Madagaskar", "Makedonia",
        "Malawi", "Malaysia", "Maldivene", "Mali", "Malta", "Marokko", "Marshalløyene", "Mauritania", "Mauritius",
        "Mexico", "Mikronesiaføderasjonen", "Moldova", "Monaco", "Mongolia", "Montenegro", "Mosambik", "Myanmar",
        "Namibia", "Nauru", "Nederland", "Nepal", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Nord-Korea",
        "Nord-Kypros", "Norge", "Oman", "Pakistan", "Palau", "Panama", "Papua Ny-Guinea", "Paraguay", "Peru", "Polen",
        "Portugal", "Qatar", "Romania", "Russland", "Rwanda", "Saint Kitts og Nevis", "Saint Lucia",
        "Saint Vincent og Grenadinene", "Salomonøyene", "Samoa", "San Marino", "São Tomé og Príncipe", "Saudi-Arabia",
        "Senegal", "Serbia", "Seychellene", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Somalia", "Spania",
        "Sri Lanka", "Storbritannia", "Sudan", "Surinam", "Sveits", "Sverige", "Swaziland", "Syria", "Sør-Afrika",
        "Sør-Korea", "Sør-Ossetia", "Sør-Sudan", "Tadsjikistan", "Taiwan", "Tanzania", "Thailand", "Togo", "Tonga",
        "Transnistria", "Trinidad og Tobago", "Tsjad", "Tsjekkia", "Tunisia", "Turkmenistan", "Tuvalu", "Tyrkia",
        "Tyskland", "Uganda", "USA", "Ukraina", "Ungarn", "Uruguay", "Usbekistan", "Vanuatu", "Vatikanstaten",
        "Venezuela", "Vietnam", "Zambia", "Zimbabwe", "Østerrike", "Øst-Timor"
    );

    /**
    * @var array Norwegian street name formats
    */
    protected static $streetNameFormats = array(
        '{{lastName}}{{streetSuffix}}',
        '{{lastName}}{{streetSuffix}}',
        '{{firstName}}{{streetSuffix}}',
        '{{firstName}}{{streetSuffix}}',
        '{{streetPrefix}}{{streetSuffix}}',
        '{{streetPrefix}}{{streetSuffix}}',
        '{{streetPrefix}}{{streetSuffix}}',
        '{{streetPrefix}}{{streetSuffix}}',
        '{{lastName}} {{streetSuffixWord}}'
    );

    /**
    * @var array Norwegian street address formats
    */
    protected static $streetAddressFormats = array(
        '{{streetName}} {{buildingNumber}}'
    );

    /**
    * @var array Norwegian address formats
    */
    protected static $addressFormats = array(
        "{{streetAddress}}\n{{postcode}} {{city}}"
    );

    /**
    * Randomly return a real city name
    *
    * @return string
    */
    public static function cityName()
    {
        return static::randomElement(static::$cityNames);
    }

    public static function streetSuffixWord()
    {
        return static::randomElement(static::$streetSuffixWord);
    }

    public static function streetPrefix()
    {
        return static::randomElement(static::$streetPrefix);
    }

    /**
    * Randomly return a building number.
    *
    * @return string
    */
    public static function buildingNumber()
    {
        return static::toUpper(static::bothify(static::randomElement(static::$buildingNumber)));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Faker\Provider\nb_NO;

class Company extends \Faker\Provider\Company
{
    protected static $formats = array(
        '{{lastName}} {{companySuffix}}',
        '{{lastName}} {{companySuffix}}',
        '{{lastName}} {{companySuffix}}',
        '{{firstName}} {{lastName}} {{companySuffix}}',
        '{{lastName}} & {{lastName}} {{companySuffix}}',
        '{{lastName}} & {{lastName}}',
        '{{lastName}} og {{lastName}}',
        '{{lastName}} og {{lastName}} {{companySuffix}}'
    );

    /**
     * Common suffixes
     * @link https://www.brreg.no/bedrift/organisasjonsformer/
     */
    protected static $companySuffix = array('ANS', 'AS', 'ASA', 'BA', 'DA', 'ENK', 'GFS', 'KTRF', 'NUF', 'PK', 'SA', 'SPA', 'STI', 'VIFE');

    /**
     * 1500 random job titles from Statistisk Sentralbyrå
     * @link http://www.ssb.no/a/yrke/yrke.csv
     */
    protected static $jobTitleFormat = array(
        'Administrasjonsdirektør', 'Administrasjonskonsulent', 'Administrasjonssekretær', 'Administrasjonssjef', 'Administrerende Overlege', 'Admiral', 'Advokatassistent', 'Aerobicinstruktør', 'Afis-Fullmektig', 'Agrotekniker', 'Ais-Fullmektig', 'Akrobat', 'Aktivitør', 'Akupunktør', 'Alarmoperatør', 'Allmenningbestyrer', 'Allmennpraktiserende Lege', 'Amanuensis', 'Ambassaderåd', 'Ambassadesekretær', 'Ambulansemedhjelper', 'Ambulansesjef', 'Ambulerende Vaktmester', 'Ammoniakkoker', 'Anestesilege', 'Animatør', 'Anleggsdykker', 'Anleggsgartnermester', 'Anleggsmaskinkjører', 'Anleggsmaskinmekaniker', 'Anleggsoperatør', 'Annenflyger', 'Annonseakkvisitør', 'Annonsebehandler', 'Annonsekonsulent', 'Annonseselger', 'Annonsesjef', 'Anretningshjelp', 'Apotekmedarbeider', 'Arbeidsmedisiner', 'Arbeidssjef', 'Arbeidsstudieingeniør', 'Arbeidsterapeut', 'Arbeidstilrettelegger', 'Arbeidstilsynskontrollør', 'Arbeidstilsynsrådgiver', 'Arkivassistent', 'Arkivmedarbeider', 'Arrestforvarer', 'Asfaltarbeider', 'Asfaltverkarbeider', 'Asfaltør', 'Assistentfotograf', 'Assisterende Administrerende Direktør', 'Assisterende Banksjef', 'Assisterende Bestyrer', 'Assisterende Borer', 'Assisterende Byfogd', 'Assisterende Fylkeshelsesjef', 'Assisterende Fylkeslege', 'Assisterende Fylkesmann', 'Assisterende Helsedirektør', 'Assisterende Kjøkkensjef', 'Assisterende Kommunegartner', 'Assisterende Sjefflygeleder', 'Assisterende Sjefspsykolog', 'Assisterende Sykepleiesjef', 'Assisterende Vaktmester', 'Astrofysiker', 'Astronom', 'Atomfysiker', 'Attache', 'Autoklavoperatør', 'Autoklavpasser', 'Automasjonsingeniør', 'Automatiker', 'Automatiseringsmontør', 'Avdelingsarkitekt', 'Avdelingsbanksjef', 'Avdelingsbetjent', 'Avdelingsdirektør', 'Avdelingsergoterapeut', 'Avdelingsingeniør', 'Avdelingsleder/fysioterapeut', 'Avdelingspsykolog', 'Avdelingssekretær', 'Avdelingssjef', 'Avdelingssjef Akvakultur Mv.', 'Avdelingssjef Restaurant', 'Avdelingssykepleier', 'Avlaster', 'Avlskonsulent', 'Avløser',
        'Babysvømmeinstruktør', 'Badeassistent', 'Badebetjent', 'Bakermester', 'Bakteriolog', 'Banearbeider', 'Bankassistent', 'Bankkonsulent', 'Banksjef', 'Barkeeper', 'Barmedarbeider', 'Barne- Og Ungdomssekretær', 'Barnehageassistent', 'Barnehjemsbestyrer', 'Barnepasser', 'Barnevernskonsulent', 'Bartender', 'Basketballtrener', 'Bedriftskonsulent', 'Bedriftspsykolog', 'Bedriftsrevisor', 'Bedriftsøkonom', 'Befrakter', 'Begravelsesbyråassistent', 'Begravelsesbyråmedarbeider', 'Begravelsesbyråsjåfør', 'Beleggskjærer', 'Bemanningskonsulent', 'Benkesnekker', 'Beregner', 'Bergmester', 'Bergverksarbeider', 'Beskjærer', 'Bestyrer Helsetjenester', 'Betjent', 'Betongindustriarbeider', 'Betongvarearbeider', 'Bibliotekleder', 'Biblioteksjef', 'Bilagskontrollør', 'Bilelektriker', 'Bilgummiarbeider', 'Bilinspektør', 'Bilklargjører', 'Billedkonsulent', 'Billedtekniker', 'Billettekspeditør', 'Billettkonsulent', 'Billettkontrollør', 'Billettselger', 'Billettør', 'Bilmegler', 'Bilmekaniker', 'Bilmottaker', 'Bilpleier', 'Bilrenser', 'Bilsakkyndig', 'Biltilsyninspektør', 'Biopat', 'Blandemaskinoperatør', 'Blander', 'Blogger', 'Blomsterdekoratør', 'Blåseinstrumentmaker', 'Bokbinder', 'Bokbinderassistent', 'Bokbussassistent', 'Bokbussfører', 'Bokhandlermedarbeider', 'Bokhandlermedhjelper', 'Bokholderassistent', 'Bokollektivmedarbeider', 'Boligleder', 'Boligsjef', 'Bomringvakt', 'Bomvakt', 'Bookingansvarlig', 'Bookingmedarbeider', 'Bookingsekretær', 'Borearbeider', 'Boredekksarbeider', 'Boreingeniør', 'Boreoperasjonsleder', 'Borer', 'Boresjef', 'Borevæskeingeniør', 'Botaniker', 'Boveileder', 'Bowlingvert', 'Branninspektør', 'Brannisolatør', 'Brannkonstabel', 'Brannmester', 'Brannvakt', 'Brannvarslerinstallatør', 'Brenner', 'Brolegger', 'Bromaler', 'Brooperatør', 'Brukskunstner', 'Brygger', 'Bryggeriformann', 'Bryggerimester', 'Brønnborer', 'Budsjåfør', 'Bukker', 'Bulldoserkjører', 'Bunadmedarbeider', 'Bunnlærstanser', 'Buntmaker', 'Business Controller', 'Bussfører', 'Butikkinnehaver', 'Butikkinspektør', 'Butikkmedarbeider', 'Butikkonsulent', 'Butikksjef', 'Butikkslakter', 'Byarkitekt', 'Bydelsdirektør', 'Byfogd', 'Byggekranfører', 'Byggesaksbehandler', 'Byggesjef', 'Byggtapetserer', 'Byggtapetsermester', 'Bygningsarbeider', 'Bygningskontrollør', 'Byplanlegger', 'Byplansjef', 'Byrettsdommer', 'Byråd', 'Byssegutt', 'Byssepike', 'Båndsager', 'Båtfører', 'Båtmekaniker', 'Bærplukker', 'Børsdirektør', 'Børsemakermester', 'Børstemaker', 'Bøter',
        'Cabin Chief', 'Cafemedarbeider', 'Campingplassmedarbeider', 'Cash Management Controller', 'Cellulosearbeider', 'Charge D\'affaires', 'Cirkustekniker', 'Cnc-Operatør', 'Coach', 'Controller', 'Croupier', 'Cruiseassistent',
        'Daglig Leder', 'Dagsenterleder', 'Damefrisør', 'Danselærer', 'Danser', 'Dataadministrator', 'Datamaskinoperatør', 'Dataservicetekniker', 'Datasjef', 'Datatekniker', 'Dekkbygger', 'Dekorkonsulent', 'Deleekspeditør', 'Delesjef', 'Departementsråd', 'Designer', 'Desksjef', 'Diakoniarbeider', 'Diettkokk', 'Direksjonssekretær', 'Dirigent', 'Discjockey', 'Distribusjonssjåfør', 'Distributør', 'Distriktsarbeidssjef', 'Distriktsbanksjef', 'Distriktsdirektør', 'Distriktsmusiker', 'Distriktsrevisor', 'Distriktstannlege', 'Divisjonsdirektør Akvakultur Mv.', 'Divisjonssjef Akavkultur Mv.', 'Dokumentarfilmfotograf', 'Dommer', 'Domorganist', 'Dp-Operatør', 'Dramalærer', 'Dramatiker', 'Driftsansvarlig Flyfrakt', 'Driftsfullmektig', 'Driftskonsulent', 'Driftskonsulent It', 'Driftskoordinator', 'Driftsplantekniker', 'Driftstekniker', 'Driftsøkonom', 'Droneoperatør', 'Drosjesjåfør', 'Dykkerleder', 'Dyrlege', 'Dørselger', 'Dørvert', 'Døvekapellan', 'Døveprest',
        'Edb-Leder', 'Ekspedent', 'Ekspedisjonssjef', 'Eksportagent', 'Eksportkonsulent', 'Eldreomsorgssjef', 'Elektriker', 'Elektrikerformann', 'Elektrisk Kabeloperasjonstekniker', 'Elektroautomasjonstekniker', 'Elektroingeniør', 'Elektromontør', 'Elkraftingeniør', 'Elverksmontør', 'Emaljebrenner', 'Emaljør', 'Energisjef', 'Engasjementssjef', 'Enhetsleder', 'Entomolog', 'Entreprenør', 'Ergoterapeut', 'Etatsjef', 'Etterforsker',
        'Fagbokforfatter', 'Faglaborant', 'Faglærer', 'Fagopplæringssjef', 'Fagsjef Skogbruk', 'Fagspesialist', 'Fagutdanningskonsulent', 'Faktureringssekretær', 'Familierådgiver', 'Fargekoker', 'Fargeriarbeider', 'Fasademontør', 'Fatter', 'Feierlærling', 'Feltarbeider', 'Feltassistent', 'Feltprest', 'Fengselsavdelingsbetjent', 'Fengselsbetjent', 'Fengselsinspektør', 'Fengselsoverbetjent', 'Fenrik', 'Ferdigstiller', 'Filetarbeider', 'Filialsjef', 'Filminspisient', 'Filmkontrollsjef', 'Filosof', 'Finansanalytiker', 'Finansråd', 'Finansrådgiver', 'Finanstilsynsdirektør', 'Fiolinbygger', 'Fiskehandler', 'Fiskeridirektør', 'Fiskerikonsulent', 'Fiskeriråd', 'Fiskeritekniker', 'Fiskerøkter', 'Fiskeskipper', 'Fiskeslakter', 'Fiskevraker', 'Fjøsmester', 'Flaskesorterer', 'Flekker', 'Flisarbeider', 'Fly-Radiotekniker', 'Flyattache', 'Flyeksportmedarbeider', 'Flyelektrotekniker', 'Flygeleder', 'Flygelederassistent', 'Flyinstruktør', 'Flymekaniker', 'Flyplassekspeditør', 'Flysystemavioniker', 'Flyteknisk Inspektør', 'Flytrafikkassistent', 'Flyvertinne', 'Fms-Operatør', 'Folklorist', 'Forbundssekretær', 'Forhandlingssjef', 'Forkynner', 'Forlagsmedarbeider', 'Formgiver', 'Formstøper', 'Formuesforvalter', 'Forsikringsassistent', 'Forsikringsrådgiver', 'Forsikringsselger', 'Forskalingsbas', 'Forsker', 'Forskjærer', 'Forskningsassistent', 'Forskningssjef', 'Forskningstekniker', 'Forstander', 'Forstkandidat', 'Forsvarsråd', 'Forsøksleder', 'Forvaltningsassistent', 'Forvaltningsingeniør', 'Forvaltningssjef', 'Fosterfar', 'Fotograf', 'Fotolaboratorieassistent', 'Fraktsjef', 'Freelancejournalist', 'Frisørlærling', 'Fritidsassistent', 'Fritidssjef', 'Frivillighetssentralleder', 'Fruktpressearbeider', 'Fruktprodusent', 'Fryseriarbeider', 'Fugearbeider', 'Fylkesagronom', 'Fylkesarkitekt', 'Fylkesbarnevernsjef', 'Fylkesbyggesjef', 'Fylkesingeniør', 'Fylkeskartsjef', 'Fylkeskontorsjef', 'Fylkeskoordinator I Fylkesarbeidskontoret', 'Fylkesmann', 'Fylkespersonalsjef', 'Fylkesstyrerepresentant', 'Fyrmester', 'Fyrtjenestermann', 'Fysiker', 'Fysiokjemiker', 'Fører', 'Førsteamanuensis', 'Førstefarmasøyt', 'Førstefotograf', 'Førstekonservator', 'Førstelagmann', 'Førstelektor', 'Førstemaskinist', 'Førstemeteorologifullmektig', 'Førstepasser', 'Førstepostbetjent', 'Førstepostfullmektig', 'Førstepreparant', 'Førsteprovisor', 'Førsterevisor', 'Førstesekretær', 'Førstestatsadvokat', 'Førstestyrmann', 'Førstetollinspektør',
        'Gallerivakt', 'Garderobebetjening', 'Garnfisker', 'Garnisonstannlege', 'Gartnerassistent', 'Gartnerformann', 'Gassverksjef', 'Gateselger', 'General', 'Generalinspektør For Heimevernet', 'Generalinspektør For Hæren', 'Geodet', 'Geolog', 'Geomatiker', 'Geotekniker', 'Gjærhusarbeider', 'Glasiolog', 'Glassarbeider', 'Glassblåser', 'Glassblåsermester', 'Glasshåndverker', 'Glasurarbeider', 'Godstrafikkleder', 'Grafikerlærling', 'Grafisk Formgiver', 'Grafisk Ingeniør', 'Grafisk Trykkermester', 'Granitthogger', 'Grensekontrollør', 'Grovsliper', 'Gruppeleder I Arbeidsmarkedsetaten', 'Gruvemåler', 'Guide', 'Gullarbeider', 'Gullsmedmester', 'Gummivarearbeider', 'Gynekolog', 'Gårdbruker', 'Gårdsarbeider', 'Gårdshjelp',
        'Hammerarbeider', 'Handelsagent', 'Handelsråd', 'Handlevognrydder', 'Hanskesyer', 'Hartskoker', 'Hattemaker', 'Havarisekretær', 'Havneassistent', 'Havnefogd', 'Havnekontrollør', 'Havnesjef', 'Havnetrafikkleder', 'Heisinstallatør', 'Heismontør', 'Heismontørlærling', 'Helse- Og Miljørådgiver', 'Helseinformatiker', 'Helseinspektør', 'Helsesøster', 'Herrefrisør', 'Hjelpekokk', 'Hjelpepleier', 'Hjelpepleiermedarbeider', 'Hjemmehjelper', 'Hjemmehjelpsleder', 'Hjemmekonsulent', 'Hjemmesykepleier', 'Hjullastersjåfør', 'Hms-Leder', 'Hoffmarskalk', 'Hollenderifører', 'Hostess', 'Hotellarbeider', 'Hotellmedarbeider', 'Hotellsjef', 'Hovedforvalter', 'Hovmester', 'Hr-Direktør', 'Hudarbeider', 'Hudterapeut', 'Hundefører', 'Husdyrkonsulent', 'Husholdsassistent', 'Husmorvikar', 'Hustrykker', 'Hvalfanger', 'Hydrograf', 'Hydrolog', 'Hylsemaker', 'Håndballtrener', 'Håndvever', 'Hørselsassistent', 'Høvelmester',
        'Idrettsinstruktør', 'Idrettsseksjonsleder', 'Idrettstrener', 'Ikt-Lærling', 'Illustratør', 'Importsjef', 'Impregnerer', 'Industribokbinder', 'Industrimontør', 'Industripsykolog', 'Industrirørlegger', 'Industrisnekker', 'Industrisyer', 'Informasjonskonsulent', 'Informasjonsleder', 'Informasjonsmedarbeider', 'Informasjonsskrankemedarbeider', 'Inkassoassistent', 'Inkassokonsulent', 'Inkassoleder', 'Inkassosjef', 'Inneselger', 'Innkjøpsansvarlig', 'Innkjøpsingeniør', 'Innkjøpskonsulent', 'Innreder', 'Innredningskonsulent', 'Innredningsmontør', 'Innsjekkingsmedarbeider', 'Innspillingsleder', 'Inspeksjonsingeniør', 'Inspisient', 'Installasjonsingeniør', 'Instituttsjef', 'Instruktør', 'Instruktørtannlege', 'Instrumentavioniker', 'Instrumentmaker', 'Instrumentrørlegger', 'Interiørarkitekt', 'Internatgruppeassistent', 'Internatgruppeleder', 'Internatleder', 'Iskremarbeider', 'It-Ansvarlig', 'It-Konsulent', 'It-Koordinator', 'It-Leder', 'It-Medarbeider', 'It-Prosjektleder', 'It-Selger/account Manager', 'It-Sjef', 'It-Systemingeniør', 'It-Teknisk Konsulent',
        'Jernbaneekspeditør', 'Jernbinderbas', 'Jordbrukssjef', 'Jordmor', 'Jordregistertekniker', 'Jordskifteassistent', 'Jordskiftedommer', 'Jordskifteingeniør', 'Jordskifteoverdommer', 'Jordskifterettsleder', 'Journalist', 'Juksafisker', 'Juridisk Rådgiver', 'Jurist', 'Juvelèr',
        'Kabelarbeider', 'Kabelbanefører', 'Kabinettsekretær', 'Kafemedarbeider', 'Kaiarbeider', 'Kaibetjent', 'Kalanderarbeider', 'Kammeroperatørleder', 'Kanselist', 'Kapitalforvalter', 'Kapsler', 'Kaptein', 'Kapteinløytnant', 'Kardiolog', 'Karosserimekaniker', 'Kartsjef', 'Kasseleder', 'Kennelleder', 'Keramiker', 'Keramisk Former', 'Kinokontrollør', 'Kinomaskinist', 'Kinosjef', 'Kirkegårdsarbeider', 'Kiropraktor', 'Kjellermester', 'Kjemikaliedykker', 'Kjemiker', 'Kjevekirurg', 'Kjeveortoped', 'Kjole- Og Draktsyermester', 'Kjøkkenbestyrer', 'Kjølemaskinist', 'Kjølemaskinkjører', 'Kjørelærer', 'Kjøreskolelærer', 'Kjøttskjærer', 'Klinikkassistent', 'Klinisk Ernærinsfysiolog', 'Klinisk Sosionom', 'Klinisk Vernepleier', 'Klokkedykker', 'Klokker', 'Klubbarbeider', 'Klubbleder', 'Klubbtillitsmann', 'Koder', 'Kokillestøper', 'Koksbrenner', 'Koldkjøkkenassistent', 'Kolonialhandler', 'Komiker', 'Kommunaldirektør', 'Kommunalsjef', 'Kommuneadvokat', 'Kommuneergoterapeut', 'Kommunekasserer', 'Kommuneplansjef', 'Kommunestyrerepresentant', 'Kommunikasjonsrådgiver', 'Kommunikasjonsrådmann', 'Kommunikatør', 'Kompressoroperatør', 'Konditor', 'Konduktør', 'Konfektmaker', 'Konferansevert', 'Konferansevertinne', 'Konkurransedirektør', 'Konserndirektør', 'Konsernregnskapssjef', 'Konservator', 'Konstruksjonstegner', 'Kontaktmann', 'Kontoraspirant', 'Kontormedarbeider', 'Kontorrengjører', 'Kontraktsleder', 'Kontrollflyger', 'Kontrolloperatør', 'Kontrollromsassistent', 'Kontrollsjef', 'Kontrollveterinær', 'Kontrollør', 'Kopperslager', 'Koranlærer', 'Koreolog', 'Korrespondent', 'Korrosjonsbehandler', 'Kostholdskonsulent', 'Kostnadsingeniør', 'Kostymeformann', 'Kraftmegler', 'Kraftverksdirektør', 'Kraftverksoperatør', 'Kredittleder', 'Kreftsykepleier', 'Krematoriebetjent', 'Kretskortmontør', 'Kringkastingssjef', 'Kulturhussjef', 'Kulturkonsulent', 'Kulturminnekonsulent', 'Kundemegler', 'Kundesuppertleder', 'Kunststopper', 'Kurator', 'Kursmedarbeider', 'Kursveileder', 'Kurvfletter', 'Kurvmaker', 'Kurvmakermester',  'Kusk', 'Kvalitetsbedømmer', 'Kvalitetsmedarbeider', 'Kvalitetssikringsassistent', 'Kvalitetssikringsinspektør', 'Kvalitetssikringskoordinator', 'Kvalitetssikringsleder', 'Kybernetiker', 'Kystdirektør',
        'Laboratorieleder', 'Laboratorierådgiver', 'Laboratorietekniker', 'Lagerformann', 'Lagerforvalter', 'Lagerfunksjonær', 'Lagerleder', 'Lagersjef', 'Lakkerer', 'Lakkoker', 'Landbruksdirektør', 'Landbruksmaskinmekaniker', 'Landbruksveileder', 'Landskapsarkitekt', 'Landssekretær', 'Landsstyremedlem', 'Ledende Aktivitør', 'Ledende Legesekretær', 'Leder', 'Leder It Brukerstøtte', 'Lege I Spesialisering', 'Legemiddelinspektør', 'Legesekretær', 'Legpredikant', 'Leigeskjærer', 'Lekotekleder', 'Lektor', 'Lensmannsbetjent', 'Lensmannsfullmektig', 'Leveransekoordinator', 'Ligningsrevisor', 'Ligningssekretær', 'Limarbeider', 'Limnolog', 'Lineegner', 'Linjeleder', 'Linjemontør', 'Litteraturagent', 'Litteraturkritiker', 'Location Scout', 'Locationassistent', 'Loddselger', 'Logistikkdirektør', 'Logistikkkoordinator', 'Logistikkleder', 'Logistikkmedarbeider', 'Logistikkonsulent', 'Logistikksjef', 'Logoped', 'Lokomotivfører', 'Lokomotivkontrollør', 'Losbåtfører', 'Losbåtsmann', 'Losinspektør', 'Lufthavnbetjent', 'Lufttrafikksjef', 'Lugarpike', 'Lydingeniør', 'Lydmester', 'Lydtekniker', 'Lysrigger', 'Lystekniker', 'Låsemontør', 'Lærervikar', 'Lærling', 'Lønningssekretær', 'Lønningssjef', 'Løypekjører', 'Løytnant',
        'Malerlærling', 'Manikyrist', 'Mannekeng', 'Marinamedarbeider', 'Mariningeniør', 'Maritim Sjef', 'Markedsassistent', 'Markedsfører', 'Markedskoordinator', 'Markedsmedarbeider', 'Markedsovervåker', 'Markedssjef', 'Marketingsekretær', 'Marketingsjef', 'Marketingsplanlegger', 'Markisemontør', 'Maskinassistent', 'Maskinfører', 'Maskiningeniør', 'Maskininnbinder', 'Maskinmekaniker', 'Maskinoffiser', 'Maskinpakker', 'Maskinpasser', 'Maskintegner', 'Maskør', 'Masseoppløser', 'Matematikkinstruktør', 'Materialadministrasjonssjef', 'Materialforvalter', 'Medhjelper', 'Medisinalråd', 'Meglerassistent', 'Meierikonsulent', 'Mekaniker', 'Mekanisk Kabeloperasjonstekniker', 'Mengeblander', 'Menger', 'Menig', 'Menighetsarbeider', 'Menighetssekretær', 'Mensendiecker', 'Merkevaresjef', 'Messepike', 'Messeplanlegger', 'Metalliserer', 'Metallpusser', 'Meteorologikonsulent', 'Mikrofilmfotograf', 'Mikseoperatør', 'Militærattache', 'Militærpsykolog', 'Miljøsaneringsarbeider', 'Miljøvernsjef', 'Miljøvernsjef På Svalbard', 'Mineralvannarbeider', 'Minerer', 'Minerydder', 'Minigraverfører', 'Misjonsprest', 'Misjonssekretær', 'Mobilkranfører', 'Modellsnekker', 'Modellør', 'Molekylærbiolog', 'Montasjeingeniør', 'Montasjesjef', 'Moseplukker', 'Motormann', 'Motormannlærling', 'Motormekaniker', 'Motorsykkelbud', 'Motorsykkelreparatør', 'Mub Ingeniør', 'Multimediedesigner', 'Museumsdirektør', 'Museumstekniker', 'Musikkinstrumentreparatør', 'Musikkpedagog', 'Musikkprodusent', 'Musikkterapeut', 'Mykolog', 'Myntarbeider', 'Møbelmontør', 'Møbelsnekker', 'Møbeltapetserer', 'Møllemester', 'Mølleoperatør', 'Møller', 'Mønsteroperatør', 'Mønstersliper',
        'Namsfullmektig', 'Natler', 'Nattportier', 'Nautisk Instrumentmaker', 'Ndt-Kontrollør', 'Neglskulptør', 'Nemndleder', 'Nestleder', 'Nettmann', 'Nettverksanalytiker', 'Nettverkstekniker', 'Notfisker', 'Nupper', 'Nyhetsredaktør', 'Nyhetsreporter', 'Nyhetssjef', 'Næringsmiddelkandidat', 'Næringsmiddelkontrollør', 'Næringsmiddelteknolog', 'Næringssjef',
        'Odontolog', 'Odontologisk Forsker', 'Offentlig Godkjent Sykepleier', 'Offisersaspirant', 'Offshore Installation Manager', 'Oldfrue', 'Oljeanalytiker', 'Oljedestillatør', 'Oljedirektør', 'Oljekontraktkjøper', 'Oljekontraktmegler', 'Oljepressearbeider', 'Oljeraffinerer', 'Oljeseparatør', 'Ombud', 'Ombudsmann For Forsvaret', 'Områdebanksjef', 'Områdesjef', 'Omsorgsarbeider', 'Onkolog', 'Onkologisykepleier', 'Operatør', 'Operatør Av Pakkemaskiner', 'Opplæringsfarmasøyt', 'Opplæringskonsulent', 'Opplæringsleder', 'Opplæringssjef', 'Oppmålingstekniker', 'Oppredningsarbeider', 'Oppsynssjef', 'Oppvekstsjef', 'Opsjonsmegler', 'Optikermedarbeider', 'Ordensvakt', 'Ordreplukker', 'Organisasjonskonsulent', 'Organisasjonsleder', 'Organisasjonssekretær', 'Orgelbygger', 'Ortoped', 'Ortopeditekniker', 'Ortopediteknisk Sjef', 'Ortoptist', 'Oseanograf', 'Ostemaker', 'Overgartner', 'Overingeniør', 'Overinspektør', 'Overjordmor', 'Overkokk', 'Overlærskjærer', 'Overpleier', 'Overpostbetjent', 'Overpostmester', 'Overradiograf', 'Oversetter', 'Overstiger', 'Oversykepleier',
        'Pantelåner', 'Pappsalarbeider', 'Paraplymaker', 'Parkettlegger', 'Parkettsliper', 'Parksjef', 'Parlamentarisk Leder', 'Partisekretær', 'Parykkmaker', 'Parykkmakermester', 'Passkontrollør', 'Pater', 'Patolog', 'Pedagog', 'Pedagogisk Psykolog', 'Pelsbereder', 'Pelsdyroppdretter', 'Pelsmaker', 'Pengeutlåner', 'Perforerer', 'Perfusjonist', 'Personal-Og Økonomidirektør', 'Personalassistent', 'Personalleder', 'Petrofysiker', 'Petroleumsarkitekt', 'Phytoterapeut', 'Pianoreparatør', 'Pianostemmer', 'Piping Ingeniør', 'Pizzabaker', 'Pizzasjåfør', 'Planlegger', 'Planleggingssjef', 'Planner', 'Plasseringsrådgiver', 'Pleiemedarbeider', 'Pleier', 'Poet', 'Polaritetsterapeut', 'Poliklinikksykepleier', 'Poliseprodusent', 'Politiadvokat', 'Politiavdelingssjef', 'Politiførstebetjent', 'Politimester', 'Politioverkonstabel', 'Politisk Sekretær', 'Popmusiker', 'Porteføljeforvalter', 'Porteføljeselger', 'Post Doc.', 'Postdoktor', 'Postfortoller', 'Postfullmektig', 'Postinspektør', 'Postmester', 'Poståpner', 'Preparantassistent', 'Preserveringstekniker', 'Pressebas', 'Pressefotograf', 'Presser', 'Privatassurandør', 'Prodekan', 'Production Supervisor', 'Produksjonsingeniør', 'Produksjonskoordinator', 'Produksjonsmedarbeider', 'Produksjonsoperatør', 'Produksjonsteknisk Leder', 'Produktsekretær', 'Produkttester', 'Produktutviklingskoordinator', 'Programleder', 'Programmerer', 'Programmeringssjef', 'Programsjef', 'Programvaretester', 'Programvareutvikler', 'Promotionkonsulent', 'Promotionmedarbeider', 'Prorektor', 'Prosjektmegler', 'Prosjektoppfølger', 'Prosjektstyringssjef', 'Prosjektøkonom', 'Protesetekniker', 'Protokollfører', 'Protokollsekretær', 'Pubvert', 'Purserassistent', 'Påkleder', 'Pølsemaker',
        'Rabbiner', 'Radarreparatør', 'Radioingeniør', 'Radioleder', 'Radiosondeleder', 'Radiotekniker', 'Radiotelefonist', 'Raffinerer', 'Rammemaker', 'Redaksjonssekretær', 'Redaktør', 'Regionsekretær', 'Regionsjef', 'Regissør', 'Registrert Legemiddelkonsulent', 'Regningsinnkrever', 'Regnskapsansvarlig', 'Rehabiliteringsterapeut', 'Reineier', 'Reklamefotograf', 'Reklamekonsulent', 'Reklamesekretær', 'Rekrutteringskonsulent', 'Rektor', 'Rekvisitamaker', 'Rekvisittleder', 'Rembursjef', 'Renholdsbetjent', 'Renholdsinspektør', 'Renholdskonsulent', 'Renholdsleder', 'Renovasjonskjører', 'Renseriarbeider', 'Renseribestyrer', 'Renserimaskinarbeider', 'Reparatør', 'Resepsjonsfullmektig', 'Resepsjonsleder', 'Reservedelsekspeditør', 'Reservedykker', 'Reservesjåfør', 'Ressurskoordinator', 'Restaurantinspektør', 'Restaureringsassistent', 'Restaureringstekniker', 'Rettsgenetiker', 'Rettsskriver', 'Revisjonsleder', 'Revisjonsrådgiver', 'Revisjonssjef', 'Revisor', 'Revisormedarbeider', 'Ridelærer', 'Rigger', 'Riksantikvar', 'Riksarkivar', 'Riksbibliotekar', 'Risiko Controller', 'Rockemusiker', 'Rockesanger', 'Rodeleder', 'Romanforfatter', 'Rosenterapeut', 'Roughneck', 'Rullestolreparatør', 'Ryddehjelp', 'Rådgivende Overlege', 'Røkter', 'Røntgenassistent', 'Røringeniør', 'Rørsveiser',
        'Sagbladstiller', 'Sagbruks- Og Høvleriarbeider', 'Sagsliper', 'Salatbarmedarbeider', 'Salgsanalytiker', 'Salgsassistent', 'Salgsingeniør', 'Salgskontrollør', 'Salgsrådgiver', 'Salgssekretær', 'Sambandsoffiser', 'Sametingspresident', 'Samfunnsgeograf', 'Saneringsarbeider',