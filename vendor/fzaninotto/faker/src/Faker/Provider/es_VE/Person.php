rvo', 'Setänen', 'Siekkinen', 'Sievinen', 'Sihvonen', 'Siira', 'Siltonen', 'Sikala', 'Silakka', 'Sillanpää', 'Siltala', 'Silvennoinen', 'Simo', 'Simonen', 'Sinnemäki', 'Sipilä', 'Sipola', 'Sirkesalo', 'Sirviö', 'Raiski', 'Soikkeli', 'Soini', 'Sonninen', 'Soppela', 'Sorajoki', 'Sormunen', 'Sorsa', 'Suhonen', 'Suikkala', 'Summanen', 'Suomela', 'Suominen', 'Suosalo', 'Susiluoto', 'Sutinen', 'Suuronen', 'Suutarinen', 'Suvela', 'Sydänmäki', 'Syrjä', 'Syrjälä', 'Säkkinen', 'Särkkä',
        'Taavettila', 'Taavila', 'Taavitsainen', 'Taipale', 'Takkala', 'Takkula', 'Tamminen', 'Tammisto', 'Tanskanen', 'Tapio', 'Tapola', 'Tarvainen', 'Taskinen', 'Tastula', 'Tauriainen', 'Tenkanen', 'Teppo', 'Tervo', 'Tervonen', 'Teräsniska', 'Tiainen', 'Tiilikainen', 'Timonen', 'Toijala', 'Toikkanen', 'Toivanen', 'Tokkola', 'Tolonen', 'Torkkeli', 'Tuisku', 'Tukiainen', 'Tulkki', 'Tuomela', 'Tuominen', 'Tuomisto', 'Tuppurainen', 'Turpeinen', 'Turunen', 'Tuutti', 'Tynkkynen', 'Typpö', 'Tyrninen', 'Törrö', 'Törrönen',
        'Ukkola', 'Ulvila', 'Unhola', 'Uosukainen', 'Urhonen', 'Uronen', 'Urpalainen', 'Urpilainen', 'Utriainen', 'Uusikari', 'Uusikylä', 'Uusisalmi', 'Uusitalo',
        'Vaara', 'Vahala', 'Vahanen', 'Vahvanen', 'Vainio', 'Valjakka', 'Valo', 'Valtanen', 'Vanhanen', 'Vanhoja', 'Varjus', 'Vartiainen', 'Vasala', 'Vauhkonen', 'Veijonen', 'Veini', 'Vennala', 'Vennamo', 'Vepsäläinen', 'Vesa', 'Vesuri', 'Veteläinen', 'Vierikko', 'Vihtanen', 'Viikate', 'Viinanen', 'Viinikka', 'Vilhola', 'Viljanen', 'Vilkkula', 'Vilpas', 'Virkkula', 'Virkkunen', 'Virolainen', 'Virtala', 'Voutilainen', 'Vuokko', 'Vuorenpää', 'Vuorikoski', 'Vuorinen', 'Vähälä', 'Väisälä', 'Väisänen', 'Välimaa', 'Välioja', 'Väyrynen', 'Väätänen',
        'Wettenranta', 'Wiitanen', 'Wirtanen', 'Wiskari',
        'Ylijälä', 'Yliannala', 'Ylijoki', 'Ylikangas', 'Ylioja', 'Ylitalo', 'Ylppö', 'Yläjoki', 'Yrjänen', 'Yrjänä', 'Yrjölä', 'Yrttiaho', 'Yömaa',
        'Äijälä', 'Ämmälä', 'Änäkkälä', 'Äyräs', 'Äärynen',
        'Översti', 'Öysti', 'Öörni'
    );

    protected static $titleMale = array('Hra.', 'Tri.');

    protected static $titleFemale = array('Rva.', 'Nti.', 'Tri.');
    
     /**
     * National Personal Identity Number (Henkilötunnus)
     * @link http://www.finlex.fi/fi/laki/ajantasa/2010/20100128
     * @param \DateTime $birthdate
     * @param string $gender Person::GENDER_MALE || Person::GENDER_FEMALE
     * @return string on format DDMMYYCZZZQ, where DDMMYY is the date of birth, C the century sign, ZZZ the individual number and Q the control character (checksum)
     */
    public function personalIdentityNumber(\DateTime $birthdate = null, $gender = null)
    {
        $checksumCharacters = '0123456789ABCDEFHJKLMNPRSTUVWXY';

        if (!$birthdate) {
            $birthdate = \Faker\Provider\DateTime::dateTimeThisCentury();
        }
        $datePart = $birthdate->format('dmy');

        switch ((int)($birthdate->format('Y')/100)) {
            case 18:
                $centurySign = '+';
                break;
            case 19:
                $centurySign = '-';
                break;
            case 20:
                $centurySign = 'A';
                break;
            default:
                throw new \InvalidArgumentException('Year must be between 1800 and 2099 inclusive.');
        }

        $randomDigits = self::numberBetween(0, 89);
        if ($gender && $gender == static::GENDER_MALE) {
            if ($randomDigits === 0) {
                $randomDigits .= static::randomElement(array(3,5,7,9));
            } else {
                $randomDigits .= static::randomElement(array(1,3,5,7,9));
            }
        } elseif ($gender && $gender == static::GENDER_FEMALE) {
            if ($randomDigits === 0) {
                $randomDigits .= static::randomElement(array(2,4,6,8));
            } else {
                $randomDigits .= static::randomElement(array(0,2,4,6,8));
            }
        } else {
            if ($randomDigits === 0) {
                $randomDigits .= self::numberBetween(2, 9);
            } else {
                $randomDigits .= (string)static::numerify('#');
            }
        }
        $randomDigits = str_pad($randomDigits, 3, '0', STR_PAD_LEFT);

        $checksum = $checksumCharacters[(int)($datePart . $randomDigits) % strlen($checksumCharacters)];

        return $datePart . $centurySign . $randomDigits . $checksum;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

namespace Faker\Provider\fi_FI;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    /**
     * @link https://www.viestintavirasto.fi/en/internettelephone/numberingoftelecommunicationsnetworks/localcallsandtelecommunicationsareas/mapoftelecommunicationsareas.html
     * @var array
     */
    protected static $landLineareaCodes = array(
        '02',
        '03',
        '05',
        '06',
        '08',
        '09',
        '013',
        '014',
        '015',
        '016',
        '017',
        '018',
        '019',
    );

    /**
     * @link https://www.viestintavirasto.fi/en/internettelephone/numberingoftelecommunicationsnetworks/mobilenetworks/mobilenetworkareacodes.html
     * @var array
     */
    protected static $mobileNetworkAreaCodes = array(
        '040',
        '050',
        '044',
        '045',
    );

    protected static $numberFormats = array(
        '### ####',
        '#######',
    );

    protected static $formats = array(
        '+358 ({{ e164MobileNetworkAreaCode }}) {{ numberFormat }}',
        '+358 {{ e164MobileNetworkAreaCode }} {{ numberFormat }}',
        '+358 ({{ e164landLineAreaCode }}) {{ numberFormat }}',
        '+358 {{ e164landLineAreaCode }} {{ numberFormat }}',
        '{{ mobileNetworkAreaCode }}{{ separator }}{{ numberFormat }}',
        '{{ landLineAreaCode }}{{ separator }}{{ numberFormat }}',
    );

    /**
     * @return string
     */
    public function landLineAreaCode()
    {
        return static::randomElement(static::$landLineareaCodes);
    }

    /**
     * @return string
     */
    public function e164landLineAreaCode()
    {
        return substr(static::randomElement(static::$landLineareaCodes), 1);
    }

    /**
     * @return string
     */
    public function mobileNetworkAreaCode()
    {
        return static::randomElement(static::$mobileNetworkAreaCodes);
    }

    /**
     * @return string
     */
    public function e164MobileNetworkAreaCode()
    {
        return substr(static::randomElement(static::$mobileNetworkAreaCodes), 1);
    }

    /**
     * @return string
     */
    public function numberFormat()
    {
        return static::randomElement(static::$numberFormats);
    }

    /**
     * @return string
     */
    public function separator()
    {
        return static::randomElement(array(' ', '-'));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

namespace Faker\Provider\fr_BE;

class Address extends \Faker\Provider\fr_FR\Address
{
    protected static $postcode = array('####');

    protected static $streetAddressFormats = array(
        '{{streetName}} {{buildingNumber}}'
    );

    protected static $streetNameFormats = array('{{streetSuffix}} {{lastName}}');

    protected static $cityFormats = array('{{cityName}}');

    protected static $addressFormats = array(
        "{{streetAddress}}\n {{postcode}} {{city}}",
    );

    protected static $streetSuffix = array(
        'rue', 'avenue', 'boulevard', 'chemin', 'chaussée', 'impasse', 'place'
    );

    /**
     * Source: http://fr.wikipedia.org/wiki/Ville_de_Belgique
     *
     * @var array
     */
    protected static $cityNames = array(
        'Aarschot','Alost','Andenne','Antoing','Anvers','Arlon','Ath','Audenarde','Bastogne','Beaumont','Beauraing','Beringen','Bilzen','Binche',
        'Blankenberge','Bouillon','Braine-le-Comte','Bree','Bruges','Bruxelles','Charleroi','Châtelet','Chièvres','Chimay','Chiny','Ciney','Comines-Warneton','Courtrai',
        'Couvin','Damme','Deinze','Diest','Dilsen-Stokkem','Dinant','Dixmude','Durbuy','Eeklo','Enghien','Eupen','Fleurus','Florenville','Fontaine-l\'Évêque','Fosses-la-Ville',
        'Furnes','Gand','Geel','Gembloux','Genappe','Genk','Gistel','Grammont','Hal','Halen','Ha