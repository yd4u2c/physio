Name}} {{streetSuffix}}',

    );
    protected static $streetAddressFormats = array(
        '{{streetNumber}} {{streetName}}',
    );
    protected static $addressFormats = array(
        "{{streetAddress}}, {{city}} {{state}}",
    );

    public static function cityPrefix()
    {
        return static::randomElement(static::$cityPrefix);
    }

    public static function state()
    {
        return static::randomElement(static::$state);
    }

    public static function streetNumber()
    {
        return Utils::getBanglaNumber(static::numberBetween(1, 100));
    }

    public static function banglaStreetName()
    {
        return static::randomElement(static::$streetNames);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

namespace Faker\Provider\bn_BD;

class Person extends \Faker\Provider\Person
{
    protected static $maleNameFormats = array(
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}}',
    );

    protected static $femaleNameFormats = array(
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}}',
    );

    protected static $firstNameMale = array(
        'অনন্ত', 'আব্দুল্লাহ', 'আহসান',  'ইমরুল', 'করিম', 'জলিল', 'বরকত', 'মাসনুন', 'রহিম',  'রিফাত', 'হাসনাত', 'হাসান',
    );

    protected static $firstNameFemale = array(
        'জারিন', 'জেরিন', 'ফারহানা', 'ফাহমেদা', 'মাহজাবিন', 'মেহনাজ', 'রহিমা', 'লাবনী', 'সাবরিন', 'সাবরিনা', 'হাসিন', 'রহমত',
    );

    protected static $lastName = array(
        'খান', 'শেখ', 'শিকদার', 'আলী', 'তাসনীম', 'তাবাসসুম'
    );

    protected static $titleMale = array('মি.');

    protected static $titleFemale = array('মিসেস.', 'মিস.');
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

namespace Faker\Provider\cs_CZ;

class Address extends \Faker\Provider\Address
{
    protected static $streetAddressFormats = array(
        '{{streetName}}',
        '{{streetName}} {{buildingNumber}}',
        '{{streetName}} {{buildingNumber}}',
        '{{streetName}} {{buildingNumber}}',
        '{{streetName}} {{buildingNumber}}',
    );

    protected static $addressFormats = array(
        "{{streetAddress}}\n{{region}}\n{{postcode}} {{city}}",
        "{{streetAddress}}\n{{postcode}} {{city}}",
        "{{streetAddress}}\n{{postcode}} {{city}}",
        "{{streetAddress}}\n{{postcode}} {{city}}",
        "{{streetAddress}}\n{{postcode}} {{city}}",
        "{{streetAddress}}\n{{postcode}} {{city}}",
        "{{streetAddress}}\n{{postcode}} {{city}}\nČeská republika",
    );

    protected static $buildingNumber = array('%', '%%', '%/%%', '%%/%%', '%/%%%', '%%/%%%');

    protected static $postcode = array('#####', '### ##');

    /**
     * Source: https://cs.wikipedia.org/wiki/Seznam_m%C4%9Bst_v_%C4%8Cesku_podle_po%C4%8Dtu_obyvatel
     */
    protected static $city = array(
        'Brno', 'Břeclav', 'Cheb', 'Chomutov', 'Chrudim', 'Černošice', 'Česká Lípa', 'České Budějovice',
        'Český Těšín', 'Děčín', 'Frýdek-Místek', 'Havlíčkův Brod', 'Havířov', 'Hodonín', 'Hradec Králové',
        'Jablonec nad Nisou', 'Jihlava', 'Karlovy Vary', 'Karviná', 'Kladno', 'Kolín', 'Krnov', 'Kroměříž',
        'Liberec', 'Litoměřice', 'Litvínov', 'Mladá Boleslav', 'Most', 'Nový Jičín', 'Olomouc', 'Opava', 'Orlová',
        'Ostrava', 'Pardubice', 'Plzeň', 'Praha', 'Prostějov', 'Písek', 'Přerov', 'Příbram', 'Sokolov', 'Šumperk',
        'Teplice', 'Trutnov', 'Tábor', 'Třebíč', 'Třinec', 'Uherské Hradiště', 'Ústí nad Labem',
        'Valašské Meziříčí', 'Vsetín', 'Zlín', 'Znojmo',
    );

    /**
     * Source: https://cs.wikipedia.org/wiki/Seznam_st%C3%A1t%C5%AF_sv%C4%9Bta
     */
    protected static $country = array(
        'Afghánistán', 'Albánie', 'Alžírsko', 'Andorra', 'Angola', 'Antigua a Barbuda', 'Argentina',
        'Arménie', 'Austrálie', 'Ázerbájdžán', 'Bahamy', 'Bahrajn', 'Bangladéš', 'Barbados', 'Belgie',
        'Belize', 'Benin', 'Bělorusko', 'Bhútán', 'Bolívie', 'Bosna a Hercegovina', 'Botswana', 'Brazílie',
        'Brunej', 'Bulharsko', 'Burkina Faso', 'Burundi', 'Cookovy ostrovy', 'Čad', 'Černá Hora', 'Česká republika',
        'Čína', 'Dánsko', 'Demokratická republika Kongo', 'Dominika', 'Dominikánská republika', 'Džibutsko',
        'Egypt', 'Ekvádor', 'Eritrea', 'Estonsko', 'Etiopie', 'Fidži', 'Filipíny', 'Finsko', 'Francie', 'Gabon',
        'Gambie', 'Ghana', 'Grenada', 'Gruzie', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras',
        'Chile', 'Chorvatsko', 'Indie', 'Indonésie', 'Irák', 'Írán', 'Irsko', 'Island', 'Itálie', 'Izrael', 'Jamajka',
        'Japonsko', 'Jemen', 'Jihoafrická republika', 'Jižní Korea', 'Jižní Súdán', 'Jordánsko', 'Kambodža', 'Kamerun',
        'Kanada', 'Kapverdy', 'Katar', 'Kazachstán', 'Keňa', 'Kiribati', 'Kolumbie', 'Komory', 'Republika Kongo',
        'Kostarika', 'Kuba', 'Kuvajt', 'Kypr', 'Kyrgyzstán', 'Laos', 'Lesotho', 'Libanon', 'Libérie', 'Libye',
        'Lichtenštejnsko', 'Litva', 'Lotyšsko', 'Lucembursko', 'Madagaskar', 'Maďarsko', 'Makedonie', 'Malajsie',
        'Malawi', 'Maledivy', 'Mali', 'Malta', 'Maroko', 'Marshallovy ostrovy', 'Mauritánie', 'Mauricius', 'Mexiko',
        'Federativní státy Mikronésie', 'Moldavsko', 'Monako', 'Mongolsko', 'Mosambik', 'Myanmar', 'Namibie', 'Nauru',
        'Nepál', 'Německo', 'Niger', 'Nigérie', 'Nikaragua', 'Niue', 'Nizozemsko', 'Norsko', 'Nový Zéland', 'Omán',
        'Pákistán', 'Palau', 'Panama', 'Papua-Nová Guinea', 'Paraguay', 'Peru', 'Pobřeží slonoviny', 'Polsko',
        'Portugalsko', 'Rakousko', 'Rovníková Guinea', 'Rumunsko', 'Rusko', 'Rwanda', 'Řecko', 'Salvador', 'Samoa',
        'San Marino', 'Saúdská Arábie', 'Senegal', 'Severní Korea', 'Seychely', 'Sierra Leone', 'Singapur',
        'Slovensko', 'Slovinsko', 'Somálsko', 'Spojené arabské emiráty', 'Spojené království', 'Spojené státy americké',
        'Srbsko', 'Středoafrická republika', 'Surinam', 'Súdán', 'Svatá Lucie', 'Svatý Kryštof a Nevis',
        'Svatý Tomáš a Princův ostrov', 'Svatý Vincenc a Grenadiny', 'Svazijsko', 'Sýrie', 'Šalamounovy ostrovy',
        'Španělsko', 'Šrí Lanka', 'Švédsko', 'Švýcarsko', 'Tádžikistán', 'Tanzanie', 'Thajsko', 'Togo', 'Tonga',
        'Trinidad a Tobago', 'Tunisko', 'Turecko', 'Turkmenistán', 'Tuvalu', 'Uganda', 'Ukrajina', 'Uruguay',
        'Uzbekistán', 'Vanuatu', 'Vatikán', 'Venezuela', 'Vietnam', 'Východní Timor', 'Zambie', 'Zimbabwe',
    );

    /**
     * Source: https://cs.wikipedia.org/wiki/Kraje_v_%C4%8Cesku#Ekonomika
     */
    private static $regions = array(
        'Hlavní město Praha', 'Jihomoravský kraj', 'Jihočeský kraj', 'Karlovarský kraj', 'Královéhradecký kraj',
        'Liberecký kraj', 'Moravskoslezský kraj', 'Olomoucký kraj', 'Pardubický kraj', 'Plzeňský kraj',
        'Středočeský kraj', 'Vysočina', 'Zlínský kraj', 'Ústecký kraj',
    );

    /**
     * Source: http://aplikace.mvcr.cz/adresy/
     */
    protected static $street = array(
        'Alžírská', 'Angelovova', 'Antonínská', 'Arménská', 'Čelkovická', 'Červenkova', 'Československého exilu',
        'Chlumínská', 'Chládkova', 'Diskařská', 'Do Kopečka', 'Do Vozovny', 'Do Vršku', 'Doubravická', 'Doudova',
        'Drahotínská', 'Dělnická', 'Generála Šišky', 'Gončarenkova', 'Gutova', 'Havlínova', 'Havraní', 'Helmova',
        'Hečkova', 'Holubinková', 'Holínská', 'Horní Hrdlořezská', 'Horní Stromky', 'Hostivařské nám.', 'Houbařská',
        'Hořanská', 'Hrachovská', 'Hrad III. nádvoří', 'Hrdlořezská', 'Jenská', 'Jerevanská', 'Ježovická', 'K Březince',
        'K Dobré Vodě', 'K Hořavce', 'K Hrušovu', 'K Háji', 'K Návsi', 'K Padesátníku', 'K Pyramidce', 'K Samotě',
        'K Vinici', 'K Vystrkovu', 'Karlovarská', 'Karlínské nám.', 'Kaňkova', 'Ke Kyjovu', 'Ke Stadionu', 'Kejnická',
        'Klatovská', 'Kohoutových', 'Kopanská', 'Kralupská', 'Kukelská', 'Kukučínova', 'Kunešova', 'Kvestorská',
        'Křišťanova', 'Lanžhotská', 'Leštínská', 'Lindavská', 'Litevská', 'Lojovická', 'Lukešova', 'Maltézské náměstí',
        'Melodická', 'Mečíková', 'Milady Horákové', 'Mšenská', 'N. A. Někrasova', 'Na Dědince', 'Na Habrové',
        'Na Jezerce', 'Na Jílech', 'Na Petynce', 'Na Rozcestí', 'Na Sedlišti', 'Na Vrchu', 'Na Výšině', 'Na Úbočí',
        'Na Štamberku', 'Nad Hliníkem', 'Nad Hřištěm', 'Nad Klikovkou', 'Nad libeňským nádražím', 'Nad Nuslemi',
        'Nad Slávií', 'Nad Trnkovem', 'Nad Šauerovými sady', 'Netřebská', 'Nivnická', 'Nádražní', 'nám. Pod Lípou',
        'nám. Před bateriemi', 'nám. Svatopluka Čecha', 'Odlehlá', 'Okrasná', 'Omská', 'Otavova', 'Oválová',
        'Palackého nám.', 'Pavlišovská', 'Paškova', 'Petřínské sady', 'Pilovská', 'Pod Bruskou', 'Pod novou školou',
        'Pod soutratím', 'Pod Svahem', 'Pod Útesy', 'Pohledná', 'Pošepného nám.', 'Prokopových', 'Pávovské náměstí',
        'Pětipeského', 'Příbramská', 'Radbuzská', 'Radnické schody', 'Raichlova', 'Roentgenova', 'Rozkošného',
        'Rozrazilová', 'Ruzyňská', 'Římovská', 'Říční', 'Satalická', 'Schoellerova', 'Smrková', 'Souvratní', 'Sovova',
        'Sportovní', 'Stadionová', 'Statková', 'Stavební', 'Široká', 'Školní', 'Tatranská', 'Tomsova', 'Toruňská',
        'Točenská', 'Trnkovo náměstí', 'Truhlářova', 'Tvrdonická', 'Týmlova', 'U Beránky', 'U Chmelnice',
        'U Chodovského hřbitova', 'U Drážky', 'U Fořta', 'U Kamýku', 'U Klubovny', 'U Lesa', 'U Pekáren',
        'U Prašné brány', 'U Prádelny', 'U Silnice', 'U Sladovny', 'U Slovanky', 'U Soutoku', 'U Trojice', 'U Vinice',
        'U vinných sklepů', 'U Vodárny', 'U Vorlíků', 'U zeleného ptáka', 'U Čekárny', 'U Županských', 'Ukrajinská',
        'Újezdská', 'V Jámě', 'V Předním Hloubětíně', 'V Rohu', 'V Uličce', 'Valčíkova', 'Ve Lhotce', 'Ve Vrších',
        'Velenická', 'Violková', 'Vlašská', 'Voděradská', 'Vyderská', 'Vysokoškolská', 'Výpadová', 'Vřesovická',
        'Za Pekárnou', 'Zámecká',
    );

    /**
     * Randomly returns a czech city.
     *
     * @example 'Krnov'
     *
     * @return string
     */
    public function city()
    {
        return static::randomElement(static::$city);
    }

    /**
     * Randomly returns a czech region.
     *
     * @example 'Liberecký kraj'
     *
     * @return string
     */
    public static function region()
    {
        return static::randomElement(static::$regions);
    }

    /**
     * Real street names as random data can hardly be
     * generated due to inflection.
     *
     * @example 'U Vodárny'
     *
     * @return string
     */
    public function streetName()
    {
        return static::randomElement(static::$street);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

namespace Faker\Provider\cs_CZ;

class Company extends \Faker\Provider\Company
{
    /**
     * @var array Czech company name formats.
     */
    protected static $formats = array(
        '{{lastName}} {{companySuffix}}',
        '{{lastName}} {{lastName}} {{companySuffix}}',
        '{{lastName}}-{{lastName}} {{companySuffix}}',
        '{{lastName}} a {{lastName}} {{companySuffix}}',
    );

    /**
     * @var array Czech catch phrase formats.
     */
    protected static $catchPhraseFormats = array(
        '{{catchPhraseVerb}} {{catchPhraseNoun}} {{catchPhraseAttribute}}',
        '{{catchPhraseVerb}} {{catchPhraseNoun}} a {{catchPhraseNoun}} {{catchPhraseAttribute}}',
        '{{catchPhraseVerb}} {{catchPhraseNoun}} {{catchPhraseAttribute}} a {{catchPhraseAttribute}}',
        'Ne{{catchPhraseVerb}} {{catchPhraseNoun}} {{catchPhraseAttribute}}',
    );

    /**
     * @var array Czech nouns (used by the catch phrase format).
     */
    protected static $noun = array(
        'bezpečnost', 'pohodlí', 'seo', 'rychlost', 'testování', 'údržbu', 'odebírání', 'výstavbu',
        'návrh', 'prodej', 'nákup', 'zprostředkování', 'odvoz', 'přepravu', 'pronájem'
    );

    /**
     * @var array Czech verbs (used by the catch phrase format).
     */
    protected static $verb = array(
        'zajišťujeme', 'nabízíme', 'děláme', 'provozujeme', 'realizujeme', 'předstihujeme', 'mobilizujeme',
    );

    /**
     * @var array End of sentences (used by the catch phrase format).
     */
    protected static $attribute = array(
        'pro vás', 'pro vaší službu', 'a jsme jednička na trhu', 'pro lepší svět', 'zdarma', 'se zárukou',
        's inovací', 'turbíny', 'mrakodrapů', 'lampiónků a svíček', 'bourací techniky', 'nákupních košíků',
        'vašeho webu', 'pro vaše zákazníky', 'za nízkou cenu', 'jako jediní na trhu', 'webu', 'internetu',
        'vaší rodiny', 'vašich známých', 'vašich stránek', 'čehokoliv na světě', 'za hubičku'
    );

    /**
     * @var array Company suffixes.
     */
    protected static $companySuffix = array('s.r.o.', 's.r.o.', 's.r.o.', 's.r.o.', 'a.s.', 'o.p.s.', 'o.s.');

    /**
     * Returns a random catch phrase noun.
     *
     * @return string
     */
    public function catchPhraseNoun()
    {
        return static::randomElement(static::$noun);
    }

    /**
     * Returns a random catch phrase attribute.
     *
     * @return string
     */
    public function catchPhraseAttribute()
    {
        return static::randomElement(static::$attribute);
    }

    /**
     * Returns a random catch phrase verb.
     *
     * @return string
     */
    public function catchPhraseVerb()
    {
        return static::randomElement(static::$verb);
    }

    /**
     * @return string
     */
    public function catchPhrase()
    {
        $format = static::randomElement(static::$catchPhraseFormats);

        return ucfirst($this->generator->parse($format));
    }

    /**
     * Generates valid czech IČO
     *
     * @see http://phpfashion.com/jak-overit-platne-ic-a-rodne-cislo
     * @return string
     */
    public function ico()
    {
        $ico = static::numerify('#######');
        $split = str_split($ico);
        $prod = 0;
        foreach (array(8, 7, 6, 5, 4, 3, 2) as $i => $p) {
            $prod += $p * $split[$i];
        }
        $mod = $prod % 11;
        if ($mod === 0 || $mod === 10) {
            return "{$ico}1";
        } elseif ($mod === 1) {
            return "{$ico}0";
        }

        return $ico . (11 - $mod);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

namespace Faker\Provider\cs_CZ;

/**
 * Czech months and days without setting locale
 */
class DateTime extends \Faker\Provider\DateTime
{
    protected static $days = array(
        'neděle', 'pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota'
    );
    protected static $months = array(
        'leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec',
        'srpen', 'září', 'říjen', 'listopad', 'prosinec'
    );
    protected static $monthsGenitive  = array(
        'ledna', 'února', 'března', 'dubna', 'května', 'června', 'července',
        'srpna', 'září', 'října', 'listopadu', 'prosince'
    );
    protected static $formattedDateFormat = array(
        '{{dayOfMonth}}. {{monthNameGenitive}} {{year}}',
    );

    public static function monthName($max = 'now')
    {
        return static::$months[parent::month($max) - 1];
    }

    public static function monthNameGenitive($max = 'now')
    {
        return static::$monthsGenitive[parent::month($max) - 1];
    }

    public static function dayOfWeek($max = 'now')
    {
        return static::$days[static::dateTime($max)->format('w')];
    }

    /**
     * @param  \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @return string
     * @example '2'
     */
    public static function dayOfMonth($max = 'now')
    {
        return static::dateTime($max)->format('j');
    }

    /**
     * Full date with inflected month
     * @return string
     * @example '16. listopadu 2003'
     */
    public function formattedDate()
    {
        $format = static::randomElement(static::$formattedDateFormat);

        return $this->generator->parse($format);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

namespace Faker\Provider\cs_CZ;

class Person extends \Faker\Provider\Person
{
    protected static $lastNameFormat = array(
        '{{lastNameMale}}',
        '{{lastNameFemale}}',
    );

    protected static $maleNameFormats = array(
        '{{firstNameMale}} {{lastNameMale}}',
        '{{firstNameMale}} {{lastNameMale}}',
        '{{firstNameMale}} {{lastNameMale}}',
        '{{firstNameMale}} {{lastNameMale}}',
        '{{titleMale}} {{firstNameMale}} {{lastNameMale}}',
    );

    protected static $femaleNameFormats = array(
        '{{firstNameFemale}} {{lastNameFemale}}',
        '{{firstNameFemale}} {{lastNameFemale}}',
        '{{firstNameFemale}} {{lastNameFemale}}',
        '{{firstNameFemale}} {{lastNameFemale}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastNameFemale}}',
    );

    protected static $firstNameMale = array(
            'Adam', 'Aleš', 'Alois', 'Antonín', 'Bohumil', 'Bohuslav', 'Dagmar',
            'Dalibor', 'Daniel', 'David', 'Dominik', 'Dušan', 'Eduard', 'Emil',
            'Filip', 'František', 'Ilona', 'Ivan', 'Ivo', 'Jakub', 'Jan', 'Ján',
            'Jaromír', 'Jaroslav', 'Jindřich', 'Jiří', 'Josef', 'Jozef', 'Kamil',
            'Karel', 'Kryštof', 'Ladislav', 'Libor', 'Lubomír', 'Luboš', 'Luděk',
            'Ludvík', 'Lukáš', 'Marcel', 'Marek', 'Martin', 'Matěj', 'Matyáš',
            'Michael', 'Michal', 'Milan', 'Miloslav', 'Miloš', 'Miroslav',
            'Oldřich', 'Ondřej', 'Patrik', 'Pavel', 'Peter', 'Petr', 'Radek',
            'Radim', 'Radomír', 'René', 'Richard', 'Robert', 'Roman', 'Rostislav',
            'Rudolf', 'Stanislav', 'Šimon', 'Štefan', 'Štěpán', 'Tomáš',
            'Václav', 'Vasyl', 'Viktor', 'Vít', 'Vítězslav', 'Vladimír',
            'Vladislav', 'Vlastimil', 'Vojtěch', 'Zbyněk', 'Zdeněk'
    );

    protected static $firstNameFemale = array(
            'Adéla', 'Alena', 'Alžběta', 'Andrea', 'Aneta', 'Anežka', 'Anna',
            'Barbora', 'Blanka', 'Božena', 'Dana', 'Daniela', 'Denisa', 'Dominika',
            'Eliška', 'Emilie', 'Eva', 'Františka', 'Gabriela', 'Hana', 'Helena',
            'Irena', 'Iva', 'Ivana', 'Iveta', 'Jana', 'Jarmila', 'Jaroslava',
            'Jindřiška', 'Jiřina', 'Jitka', 'Kamila', 'Karolína', 'Kateřina',
            'Klára', 'Kristýna', 'Lenka', 'Libuše', 'Lucie', 'Ludmila', 'Marcela',
            'Mária', 'Marie', 'Markéta', 'Marta', 'Martina', 'Michaela', 'Milada',
            'Milena', 'Miloslava', 'Miluše', 'Miroslava', 'Monika', 'Naděžda',
            'Natálie', 'Nela', 'Nikola', 'Olga', 'Pavla', 'Pavlína', 'Petra',
            'Radka', 'Renata', 'Renáta', 'Romana', 'Růžena', 'Simona', 'Soňa',
            'Stanislava', 'Šárka', 'Štěpánka', 'Tereza', 'Vendula', 'Věra',
            'Veronika', 'Vladimíra', 'Vlasta', 'Zdenka', 'Zdeňka', 'Zdeňka',
            'Zuzana'
    );

    protected static $lastNameMale = array(
            'Adam', 'Adamec', 'Adámek', 'Albrecht', 'Ambrož', 'Anděl', 'Andrle',
            'Antoš', 'Bajer', 'Baláž', 'Balcar', 'Balog', 'Baloun', 'Barák',
            'Baran', 'Bareš', 'Bárta', 'Barták', 'Bartoň', 'Bartoš',
            'Bartošek', 'Bartůněk', 'Bašta', 'Bauer', 'Bayer', 'Bažant',
            'Bečka', 'Bečvář', 'Bednář', 'Bednařík', 'Bělohlávek',
            'Benda', 'Beneš', 'Beran', 'Beránek', 'Berger', 'Berka', 'Berky',
            'Bernard', 'Bezděk', 'Bílek', 'Bílý', 'Bína', 'Bittner',
            'Blaha', 'Bláha', 'Blažek', 'Blecha', 'Bobek', 'Boček', 'Boháč',
            'Boháček', 'Böhm', 'Borovička', 'Bouček', 'Bouda', 'Bouška',
            'Brabec', 'Brabenec', 'Brada', 'Bradáč', 'Braun', 'Brázda',
            'Brázdil', 'Brejcha', 'Brož', 'Brožek', 'Brychta', 'Březina',
            'Bříza', 'Bubeník', 'Buček', 'Buchta', 'Burda', 'Bureš', 'Burian',
            'Buriánek', 'Byrtus', 'Caha', 'Cibulka', 'Cihlář', 'Císař', 'Coufal',
            'Čada', 'Čáp', 'Čapek', 'Čech', 'Čejka', 'Čermák', 'Černík',
            'Černohorský', 'Černoch', 'Černý', 'Červeňák', 'Červenka',
            'Červený', 'Červinka', 'Čihák', 'Čížek', 'Čonka', 'Čurda',
            'Daněk', 'Daniel', 'Daniš', 'David', 'Dědek', 'Dittrich', 'Diviš',
            'Dlouhý', 'Dobeš', 'Dobiáš', 'Dobrovolný', 'Dočekal', 'Dočkal',
            'Dohnal', 'Dokoupil', 'Doleček', 'Dolejš', 'Dolejší', 'Doležal',
            'Doležel', 'Doskočil', 'Dostál', 'Doubek', 'Doubrava', 'Douša',
            'Drábek', 'Drozd', 'Dubský', 'Duda', 'Dudek', 'Dufek', 'Duchoň',
            'Dunka', 'Dušek', 'Dvorský', 'Dvořáček', 'Dvořák', 'Eliáš',
            'Erben', 'Fabián', 'Fanta', 'Farkaš', 'Fejfar', 'Fencl', 'Ferenc',
            'Fiala', 'Fiedler', 'Filip', 'Fischer', 'Fišer', 'Florián', 'Fojtík',
            'Foltýn', 'Formánek', 'Forman', 'Fořt', 'Fousek', 'Franc', 'Franěk',
            'Frank', 'Fridrich', 'Frydrych', 'Fučík', 'Fuchs', 'Fuksa', 'Gábor',
            'Gabriel', 'Gajdoš', 'Gregor', 'Gruber', 'Grundza', 'Grygar', 'Hájek',
            'Hajný', 'Hála', 'Hampl', 'Hanáček', 'Hána', 'Hanák', 'Hanousek',
            'Hanus', 'Hanuš', 'Hanzal', 'Hanzl', 'Hanzlík', 'Hartman', 'Hašek',
            'Havel', 'Havelka', 'Havlíček', 'Havlík', 'Havránek', 'Heczko',
            'Heger', 'Hejda', 'Hejduk', 'Hejl', 'Hejna', 'Hendrych', 'Herman',
            'Heřmánek', 'Heřman', 'Hladík', 'Hladký', 'Hlaváček', 'Hlaváč',
            'Hlavatý', 'Hlávka', 'Hloušek', 'Hoffmann', 'Hofman', 'Holan',
            'Holas', 'Holec', 'Holeček', 'Holík', 'Holoubek', 'Holub', 'Holý',
            'Homola', 'Homolka', 'Horáček', 'Hora', 'Horák', 'Horký', 'Horňák',
            'Horníček', 'Horník', 'Horský', 'Horváth', 'Horvát', 'Hořejší',
            'Hošek', 'Houdek', 'Houška', 'Hovorka', 'Hrabal', 'Hrabovský',
            'Hradecký', 'Hradil', 'Hrbáček', 'Hrbek', 'Hrdina', 'Hrdlička',
            'Hrdý', 'Hrnčíř', 'Hroch', 'Hromádka', 'Hron', 'Hrubeš', 'Hrubý',
            'Hruška', 'Hrůza', 'Hubáček', 'Hudec', 'Hudeček', 'Hůlka', 'Huml',
            'Husák', 'Hušek', 'Hýbl', 'Hynek', 'Chaloupka', 'Chalupa', 'Charvát',
            'Chládek', 'Chlup', 'Chmelař', 'Chmelík', 'Chovanec', 'Chromý',
            'Chudoba', 'Chvátal', 'Chvojka', 'Chytil', 'Jahoda', 'Jakeš',
            'Jakl', 'Jakoubek', 'Jakubec', 'Janáček', 'Janák', 'Janata',
            'Janča', 'Jančík', 'Janda', 'Janeček', 'Janečka', 'Janíček',
            'Janík', 'Janků', 'Janota', 'Janoušek', 'Janovský', 'Jansa',
            'Jánský', 'Jareš', 'Jaroš', 'Jašek', 'Javůrek', 'Jedlička',
            'Jech', 'Jelen', 'Jelínek', 'Jeníček', 'Jeřábek', 'Ježek', 'Jež',
            'Jílek', 'Jindra', 'Jíra', 'Jirák', 'Jiránek', 'Jirásek', 'Jirka',
            'Jirků', 'Jiroušek', 'Jirsa', 'Jiřík', 'John', 'Jonáš', 'Junek',
            'Jurčík', 'Jurečka', 'Juřica', 'Juřík', 'Kabát', 'Kačírek',
            'Kadeřábek', 'Kadlec', 'Kafka', 'Kaiser', 'Kaláb', 'Kala', 'Kalaš',
            'Kalina', 'Kalivoda', 'Kalousek', 'Kalous', 'Kameník', 'Kaňa',
            'Kaňka', 'Kantor', 'Kaplan', 'Karásek', 'Karas', 'Karban', 'Karel',
            'Karlík', 'Kasal', 'Kašík', 'Kašpárek', 'Kašpar', 'Kavka', 'Kazda',
            'Kindl', 'Klečka', 'Klein', 'Klement', 'Klíma', 'Kliment', 'Klimeš',
            'Klouček', 'Klouda', 'Knap', 'Knotek', 'Kocián', 'Kocman', 'Kocourek',
            'Kohoutek', 'Kohout', 'Koch', 'Koláček', 'Kolařík', 'Kolář',
            'Kolek', 'Kolman', 'Komárek', 'Komínek', 'Konečný', 'Koníček',
            'Kopal', 'Kopecký', 'Kopeček', 'Kopečný', 'Kopřiva', 'Korbel',
            'Kořínek', 'Kosík', 'Kosina', 'Kos', 'Kostka', 'Košťál', 'Kotas',
            'Kotek', 'Kotlár', 'Kotrba', 'Kouba', 'Koubek', 'Koudela', 'Koudelka',
            'Koukal', 'Kouřil', 'Koutný', 'Kováč', 'Kovařík', 'Kovářík',
            'Kovář', 'Kozák', 'Kozel', 'Krajíček', 'Králíček', 'Králík',
            'Král', 'Krátký', 'Kratochvíl', 'Kraus', 'Krčmář', 'Krejčík',
            'Krejčí', 'Krejčíř', 'Krištof', 'Kropáček', 'Kroupa', 'Krupa',
            'Krupička', 'Krupka', 'Křeček', 'Křenek', 'Křivánek', 'Křížek',
            'Kříž', 'Kuba', 'Kubálek', 'Kubánek', 'Kubát', 'Kubec', 'Kubelka',
            'Kubeš', 'Kubica', 'Kubíček', 'Kubík', 'Kubín', 'Kubiš', 'Kuča',
            'Kučera', 'Kudláček', 'Kudrna', 'Kuchař', 'Kuchta', 'Kukla',
            'Kulhánek', 'Kulhavý', 'Kunc', 'Kuneš', 'Kupec', 'Kupka', 'Kurka',
            'Kužel', 'Kvapil', 'Kvasnička', 'Kyncl', 'Kysela', 'Lacina', 'Lacko',
            'Lakatoš', 'Landa', 'Langer', 'Lang', 'Langr', 'Látal', 'Lavička',
            'Lebeda', 'Levý', 'Líbal', 'Linhart', 'Liška', 'Lorenc', 'Louda',
            'Ludvík', 'Lukáč', 'Lukášek', 'Lukáš', 'Lukeš', 'Macák', 'Macek',
            'Macura', 'Macháček', 'Machač', 'Macháč', 'Machala', 'Machálek',
            'Mácha', 'Mach', 'Majer', 'Maleček', 'Málek', 'Malík', 'Malina',
            'Malý', 'Maňák', 'Mareček', 'Marek', 'Mareš', 'Maršálek',
            'Maršík', 'Martinec', 'Martinek', 'Martínek', 'Mařík', 'Masopust',
            'Mašek', 'Matějíček', 'Matějka', 'Matoušek', 'Matouš', 'Matula',
            'Matuška', 'Matyáš', 'Matys', 'Maxa', 'Mayer', 'Mazánek', 'Medek',
            'Melichar', 'Mencl', 'Menšík', 'Merta', 'Mička', 'Michalec',
            'Michálek', 'Michalík', 'Michal', 'Michna', 'Mika', 'Míka', 'Mikeš',
            'Miko', 'Mikula', 'Mikulášek', 'Minařík', 'Minář', 'Mirga',
            'Mládek', 'Mlčoch', 'Mlejnek', 'Mojžíš', 'Mokrý', 'Molnár',
            'Moravec', 'Morávek', 'Motl', 'Motyčka', 'Moučka', 'Moudrý',
            'Mráček', 'Mrázek', 'Mráz', 'Mrkvička', 'Mucha', 'Müller',
            'Műller', 'Musil', 'Mužík', 'Myška', 'Nagy', 'Najman', 'Navrátil',
            'Nečas', 'Nedbal', 'Nedoma', 'Nedvěd', 'Nejedlý', 'Němec',
            'Němeček', 'Nesvadba', 'Nešpor', 'Neubauer', 'Neuman', 'Neumann',
            'Nguyen', 'Nguyen', 'Nosek', 'Nováček', 'Novák', 'Novosad', 'Novotný',
            'Nový', 'Odehnal', 'Oláh', 'Oliva', 'Ondráček', 'Ondra', 'Orság',
            'Otáhal', 'Paleček', 'Pánek', 'Papež', 'Pařízek', 'Pašek',
            'Pátek', 'Patočka', 'Paul', 'Pavelek', 'Pavelka', 'Pavel', 'Pavlas',
            'Pavlica', 'Pavlíček', 'Pavlík', 'Pavlů', 'Pazdera', 'Pecka',
            'Pecháček', 'Pecha', 'Pech', 'Pekárek', 'Pekař', 'Pelc', 'Pelikán',
            'Pernica', 'Peroutka', 'Peřina', 'Pešek', 'Peška', 'Pešta',
            'Peterka', 'Petrák', 'Petráš', 'Petr', 'Petrů', 'Petříček',
            'Petřík', 'Pham', 'Pícha', 'Pilař', 'Pilát', 'Píša', 'Pivoňka',
            'Plaček', 'Plachý', 'Plšek', 'Pluhař', 'Podzimek', 'Pohl', 'Pokorný',
            'Poláček', 'Polách', 'Polák', 'Polanský', 'Polášek', 'Polívka',
            'Popelka', 'Pospíchal', 'Pospíšil', 'Potůček', 'Pour', 'Prachař',
            'Prášek', 'Pražák', 'Prchal', 'Procházka', 'Prokeš', 'Prokop',
            'Prošek', 'Provazník', 'Průcha', 'Průša', 'Přibyl', 'Příhoda',
            'Přikryl', 'Pšenička', 'Ptáček', 'Rác', 'Rada', 'Rak', 'Rambousek',
            'Raška', 'Rataj', 'Remeš', 'Rezek', 'Richter', 'Richtr', 'Roubal',
            'Rous', 'Rozsypal', 'Rudolf', 'Růžek', 'Růžička', 'Ryba', 'Rybář',
            'Rýdl', 'Ryšavý', 'Řeháček', 'Řehák', 'Řehoř', 'Řezáč',
            'Řezníček', 'Říha', 'Sadílek', 'Samek', 'Sedláček', 'Sedlák',
            'Sedlář', 'Sehnal', 'Seidl', 'Seifert', 'Sekanina', 'Semerád',
            'Severa', 'Schejbal', 'Schmidt', 'Schneider', 'Schwarz', 'Sikora',
            'Sivák', 'Skácel', 'Skala', 'Skála', 'Skalický', 'Sklenář',
            'Skopal', 'Skořepa', 'Skřivánek', 'Slabý', 'Sládek', 'Sladký',
            'Sláma', 'Slanina', 'Slavíček', 'Slavík', 'Slezák', 'Slováček',
            'Slovák', 'Sluka', 'Smejkal', 'Smékal', 'Smetana', 'Smola', 'Smolík',
            'Smolka', 'Smrčka', 'Smrž', 'Smutný', 'Sobek', 'Sobotka', 'Sochor',
            'Sojka', 'Sokol', 'Sommer', 'Souček', 'Soukup', 'Sova', 'Spáčil',
            'Spurný', 'Srb', 'Staněk', 'Stárek', 'Starý', 'Stehlík', 'Steiner',
            'Stejskal', 'Stibor', 'Stoklasa', 'Straka', 'Stránský', 'Strejček',
            'Strnad', 'Strouhal', 'Studený', 'Studnička', 'Stuchlík',
            'Stupka', 'Suchánek', 'Suchomel', 'Suchý', 'Suk', 'Svačina',
            'Svatoň', 'Svatoš', 'Světlík', 'Sviták', 'Svoboda', 'Svozil',
            'Sýkora', 'Synek', 'Syrový', 'Šafařík', 'Šafář', 'Šafránek',
            'Šálek', 'Šanda', 'Šašek', 'Šebek', 'Šebela', 'Šebesta', 'Šeda',
            'Šedivý', 'Šenk', 'Šesták', 'Ševčík', 'Šilhavý', 'Šimáček',
            'Šimák', 'Šimánek', 'Šíma', 'Šimčík', 'Šimeček', 'Šimek',
            'Šimon', 'Šimůnek', 'Šindelář', 'Šindler', 'Šípek', 'Šíp',
            'Široký', 'Šír', 'Šiška', 'Škoda', 'Škrabal', 'Šlechta',
            'Šmejkal', 'Šmerda', 'Šmíd', 'Šnajdr', 'Šolc', 'Špaček',
            'Špička', 'Šplíchal', 'Šrámek', 'Šťastný', 'Štefan',
            'Štefek', 'Štefl', 'Štěpánek', 'Štěpán', 'Štěrba', 'Šubrt',
            'Šulc', 'Šustr', 'Šváb', 'Švanda', 'Švarc', 'Švec', 'Švehla',
            'Švejda', 'Švestka', 'Táborský', 'Tancoš', 'Teplý', 'Tesař',
            'Tichý', 'Tománek', 'Toman', 'Tomášek', 'Tomáš', 'Tomeček',
            'Tomek', 'Tomeš', 'Tóth', 'Tran', 'Trávníček', 'Trčka', 'Trnka',
            'Trojan', 'Truhlář', 'Tříska', 'Tuček', 'Tůma', 'Tureček', 'Turek',
            'Tvrdík', 'Tvrdý', 'Uher', 'Uhlíř', 'Ulrich', 'Urbanec', 'Urbánek',
            'Urban', 'Vacek', 'Václavek', 'Václavík', 'Vaculík', 'Vágner',
            'Vácha', 'Valášek', 'Vala', 'Válek', 'Valenta', 'Valeš', 'Váňa',
            'Vančura', 'Vaněček', 'Vaněk', 'Vaníček', 'Varga', 'Vašák',
            'Vašek', 'Vašíček', 'Vávra', 'Vavřík', 'Večeřa', 'Vejvoda',
            'Verner', 'Veselý', 'Veverka', 'Vícha', 'Vilímek', 'Vinš', 'Víšek',
            'Vitásek', 'Vítek', 'Vít', 'Vlach', 'Vlasák', 'Vlček', 'Vlk',
            'Vobořil', 'Vodák', 'Vodička', 'Vodrážka', 'Vojáček', 'Vojta',
            'Vojtěch', 'Vojtek', 'Vojtíšek', 'Vokoun', 'Volek', 'Volf', 'Volný',
            'Vondráček', 'Vondrák', 'Vondra', 'Voráček', 'Vorel', 'Vorlíček',
            'Voříšek', 'Votava', 'Votruba', 'Vrabec', 'Vrána', 'Vrba', 'Vrzal',
            'Vybíral', 'Vydra', 'Vymazal', 'Vyskočil', 'Vysloužil', 'Wagner',
            'Walter', 'Weber', 'Weiss', 'Winkler', 'Wolf', 'Zábranský', 'Zahrádka',
            'Zahradník', 'Zach', 'Zajíc', 'Zajíček', 'Zálešák', 'Zámečník',
            'Zapletal', 'Záruba', 'Zatloukal', 'Zavadil', 'Zavřel', 'Zbořil',
            'Zdražil', 'Zedník', 'Zelenka', 'Zelený', 'Zelinka', 'Zemánek',
            'Zeman', 'Zezula', 'Zíka', 'Zikmund', 'Zima', 'Zlámal', 'Zoubek',
            'Zouhar', 'Zvěřina', 'Žáček', 'Žák', 'Žďárský', 'Žemlička',
            'Žídek', 'Žižka', 'Žůrek'
    );

    protected static $lastNameFemale = array(
            'Adamová', 'Adamcová', 'Adámková', 'Albrechtová', 'Ambrožová',
            'Andělová', 'Andrlová', 'Antošová', 'Bajerová', 'Balážová',
            'Balcarová', 'Balogová', 'Balounová', 'Baráková', 'Baranová',
            'Barešová', 'Bártová', 'Bartáková', 'Bartoňová', 'Bartošová',
            'Bartošková', 'Bartůňková', 'Baštová', 'Bauerová', 'Bayerová',
            'Bažantová', 'Bečková', 'Bečvářová', 'Bednářová',
            'Bednaříková', 'Bělohlávková', 'Bendová', 'Benešová',
            'Beranová', 'Beránková', 'Bergerová', 'Berková', 'Berkyová',
            'Bernardová', 'Bezděková', 'Bílková', 'Bílová', 'Bínová',
            'Bittnerová', 'Blahová', 'Bláhová', 'Blažková', 'Blechová',
            'Bobková', 'Bočková', 'Boháčová', 'Boháčková', 'Böhmová',
            'Borovičková', 'Boučková', 'Boudová', 'Boušková', 'Brabcová',
            'Brabencová', 'Bradová', 'Bradáčová', 'Braunová', 'Brázdová',
            'Brázdilová', 'Brejchová', 'Brožová', 'Brožková', 'Brychtová',
            'Březinová', 'Břízová', 'Bubeníková', 'Bučková', 'Buchtová',
            'Burdová', 'Burešová', 'Burianová', 'Buriánková', 'Byrtusová',
            'Cahová', 'Cibulková', 'Cihlářová', 'Císařová', 'Coufalová',
            'Čadová', 'Čápová', 'Čapková', 'Čechová', 'Čejková',
            'Čermáková', 'Černíková', 'Černohorská', 'Černochová',
            'Černá', 'Červeňáková', 'Červenková', 'Červená', 'Červinková',
            'Čiháková', 'Čížková', 'Čonková', 'Čurdová', 'Daňková',
            'Danielová', 'Danišová', 'Davidová', 'Dědková', 'Dittrichová',
            'Divišová', 'Dlouhá', 'Dobešová', 'Dobiášová', 'Dobrovolná',
            'Dočekalová', 'Dočkalová', 'Dohnalová', 'Dokoupilová',
            'Dolečková', 'Dolejšová', 'Dolejší', 'Doležalová', 'Doleželová',
            'Doskočilová', 'Dostálová', 'Doubková', 'Doubravová', 'Doušová',
            'Drábková', 'Drozdová', 'Dubská', 'Dudová', 'Dudková', 'Dufková',
            'Duchoňová', 'Dunková', 'Dušková', 'Dvorská', 'Dvořáčková',
            'Dvořáková', 'Eliášová', 'Erbenová', 'Fabiánová', 'Fantová',
            'Farkašová', 'Fejfarová', 'Fenclová', 'Ferencová', 'Fialová',
            'Fiedlerová', 'Filipová', 'Fischerová', 'Fišerová', 'Floriánová',
            'Fojtíková', 'Foltýnová', 'Formánková', 'Formanová', 'Fořtová',
            'Fousková', 'Francová', 'Fraňková', 'Franková', 'Fridrichová',
            'Frydrychová', 'Fučíková', 'Fuchsová', 'Fuksová', 'Gáborová',
            'Gabrielová', 'Gajdošová', 'Gregorová', 'Gruberová', 'Grundzová',
            'Grygarová', 'Hájková', 'Hajná', 'Hálová', 'Hamplová',
            'Hanáčková', 'Hánová', 'Hanáková', 'Hanousková', 'Hanusová',
            'Hanušová', 'Hanzalová', 'Hanzlová', 'Hanzlíková', 'Hartmanová',
            'Hašková', 'Havelová', 'Havelková', 'Havlíčková', 'Havlíková',
            'Havránková', 'Heczková', 'Hegerová', 'Hejdová', 'Hejduková',
            'Hejlová', 'Hejnová', 'Hendrychová', 'Hermanová', 'Heřmánková',
            'Heřmanová', 'Hladíková', 'Hladká', 'Hlaváčková', 'Hlaváčová',
            'Hlavatá', 'Hlávková', 'Hloušková', 'Hoffmannová', 'Hofmanová',
            'Holanová', 'Holasová', 'Holcová', 'Holečková', 'Holíková',
            'Holoubková', 'Holubová', 'Holá', 'Homolová', 'Homolková',
            'Horáčková', 'Horová', 'Horáková', 'Horká', 'Horňáková',
            'Horníčková', 'Horníková', 'Horská', 'Horváthová', 'Horvátová',
            'Hořejšíová', 'Hošková', 'Houdková', 'Houšková', 'Hovorková',
            'Hrabalová', 'Hrabovská', 'Hradecká', 'Hradilová', 'Hrbáčková',
            'Hrbková', 'Hrdinová', 'Hrdličková', 'Hrdá', 'Hrnčířová',
            'Hrochová', 'Hromádková', 'Hronová', 'Hrubešová', 'Hrubá',
            'Hrušková', 'Hrůzová', 'Hubáčková', 'Hudcová', 'Hudečková',
            'Hůlková', 'Humlová', 'Husáková', 'Hušková', 'Hýblová',
            'Hynková', 'Chaloupková', 'Chalupová', 'Charvátová', 'Chládková',
            'Chlupová', 'Chmelařová', 'Chmelíková', 'Chovancová', 'Chromá',
            'Chudobová', 'Chvátalová', 'Chvojková', 'Chytilová', 'Jahodová',
            'Jakešová', 'Jaklová', 'Jakoubková', 'Jakubcová', 'Janáčková',
            'Janáková', 'Janatová', 'Jančová', 'Jančíková', 'Jandová',
            'Janečková', 'Janečková', 'Janíčková', 'Janíková', 'Janková',
            'Janotová', 'Janoušková', 'Janovská', 'Jansová', 'Jánská',
            'Jarešová', 'Jarošová', 'Jašková', 'Javůrková', 'Jedličková',
            'Jechová', 'Jelenová', 'Jelínková', 'Jeníčková', 'Jeřábková',
            'Ježková', 'Ježová', 'Jílková', 'Jindrová', 'Jírová',
            'Jiráková', 'Jiránková', 'Jirásková', 'Jirková', 'Jirková',
            'Jiroušková', 'Jirsová', 'Jiříková', 'Johnová', 'Jonášová',
            'Junková', 'Jurčíková', 'Jurečková', 'Juřicová', 'Juříková',
            'Kabátová', 'Kačírková', 'Kadeřábková', 'Kadlcová', 'Kafková',
            'Kaiserová', 'Kalábová', 'Kalová', 'Kalašová', 'Kalinová',
            'Kalivodová', 'Kalousková', 'Kalousová', 'Kameníková', 'Kaňová',
            'Kaňková', 'Kantorová', 'Kaplanová', 'Karásková', 'Karasová',
            'Karbanová', 'Karelová', 'Karlíková', 'Kasalová', 'Kašíková',
            'Kašpárková', 'Kašparová', 'Kavková', 'Kazdová', 'Kindlová',
            'Klečková', 'Kleinová', 'Klementová', 'Klímová', 'Klimentová',
            'Klimešová', 'Kloučková', 'Kloudová', 'Knapová', 'Knotková',
            'Kociánová', 'Kocmanová', 'Kocourková', 'Kohoutková', 'Kohoutová',
            'Kochová', 'Koláčková', 'Kolaříková', 'Kolářová', 'Kolková',
            'Kolmanová', 'Komárková', 'Komínková', 'Konečná', 'Koníčková',
            'Kopalová', 'Kopecká', 'Kopečková', 'Kopečná', 'Kopřivová',
            'Korbelová', 'Kořínková', 'Kosíková', 'Kosinová', 'Kosová',
            'Kostková', 'Košťálová', 'Kotasová', 'Kotková', 'Kotlárová',
            'Kotrbová', 'Koubová', 'Koubková', 'Koudelová', 'Koudelková',
            'Koukalová', 'Kouřilová', 'Koutná', 'Kováčová', 'Kovaříková',
            'Kováříková', 'Kovářová', 'Kozáková', 'Kozelová',
            'Krajíčková', 'Králíčková', 'Králíková', 'Králová',
            'Krátká', 'Kratochvílová', 'Krausová', 'Krčmářová',
            'Krejčíková', 'Krejčová', 'Krejčířová', 'Krištofová',
            'Kropáčková', 'Kroupová', 'Krupová', 'Krupičková', 'Krupková',
            'Křečková', 'Křenková', 'Křivánková', 'Křížková',
            'Křížová', 'Kubová', 'Kubálková', 'Kubánková', 'Kubátová',
            'Kubcová', 'Kubelková', 'Kubešová', 'Kubicová', 'Kubíčková',
            'Kubíková', 'Kubínová', 'Kubišová', 'Kučová', 'Kučerová',
            'Kudláčková', 'Kudrnová', 'Kuchařová', 'Kuchtová', 'Kuklová',
            'Kulhánková', 'Kulhavá', 'Kuncová', 'Kunešová', 'Kupcová',
            'Kupková', 'Kurková', 'Kuželová', 'Kvapilová', 'Kvasničková',
            'Kynclová', 'Kyselová', 'Lacinová', 'Lacková', 'Lakatošová',
            'Landová', 'Langerová', 'Langová', 'Langrová', 'Látalová',
            'Lavičková', 'Lebedová', 'Levá', 'Líbalová', 'Linhartová',
            'Lišková', 'Lorencová', 'Loudová', 'Ludvíková', 'Lukáčová',
            'Lukášková', 'Lukášová', 'Lukešová', 'Macáková', 'Macková',
            'Macurová', 'Macháčková', 'Machačová', 'Macháčová', 'Machalová',
            'Machálková', 'Máchová', 'Machová', 'Majerová', 'Malečková',
            'Málková', 'Malíková', 'Malinová', 'Malá', 'Maňáková',
            'Marečková', 'Marková', 'Marešová', 'Maršálková',
            'Maršíková', 'Martincová', 'Martinková', 'Martínková',
            'Maříková', 'Masopustová', 'Mašková', 'Matějíčková',
            'Matějková', 'Matoušková', 'Matoušová', 'Matulová', 'Matušková',
            'Matyášová', 'Matysová', 'Maxová', 'Mayerová', 'Mazánková',
            'Medková', 'Melicharová', 'Menclová', 'Menšíková', 'Mertová',
            'Mičková', 'Michalcová', 'Michálková', 'Michalíková',
            'Michalová', 'Michnová', 'Miková', 'Míková', 'Mikešová',
            'Miková', 'Mikulová', 'Mikulášková', 'Minaříková', 'Minářová',
            'Mirgová', 'Mládková', 'Mlčochová', 'Mlejnková', 'Mojžíšová',
            'Mokrá', 'Molnárová', 'Moravcová', 'Morávková', 'Motlová',
            'Motyčková', 'Moučková', 'Moudrá', 'Mráčková', 'Mrázková',
            'Mrázová', 'Mrkvičková', 'Muchová', 'Müllerová', 'Műllerová',
            'Musilová', 'Mužíková', 'Myšková', 'Nagyová', 'Najmanová',
            'Navrátilová', 'Nečasová', 'Nedbalová', 'Nedomová', 'Nedvědová',
            'Nejedlá', 'Němcová', 'Němečková', 'Nesvadbová', 'Nešporová',
            'Neubauerová', 'Neumanová', 'Neumannová', 'Nguyenová', 'Vanová',
            'Nosková', 'Nováčková', 'Nováková', 'Novosadová', 'Novotná',
            'Nová', 'Odehnalová', 'Oláhová', 'Olivová', 'Ondráčková',
            'Ondrová', 'Orságová', 'Otáhalová', 'Palečková', 'Pánková',
            'Papežová', 'Pařízková', 'Pašková', 'Pátková', 'Patočková',
            'Paulová', 'Pavelková', 'Pavelková', 'Pavelová', 'Pavlasová',
            'Pavlicová', 'Pavlíčková', 'Pavlíková', 'Pavlová', 'Pazderová',
            'Pecková', 'Pecháčková', 'Pechová', 'Pechová', 'Pekárková',
            'Pekařová', 'Pelcová', 'Pelikánová', 'Pernicová', 'Peroutková',
            'Peřinová', 'Pešková', 'Pešková', 'Peštová', 'Peterková',
            'Petráková', 'Petrášová', 'Petrová', 'Petrová', 'Petříčková',
            'Petříková', 'Phamová', 'Píchová', 'Pilařová', 'Pilátová',
            'Píšová', 'Pivoňková', 'Plačková', 'Plachá', 'Plšková',
            'Pluhařová', 'Podzimková', 'Pohlová', 'Pokorná', 'Poláčková',
            'Poláchová', 'Poláková', 'Polanská', 'Polášková', 'Polívková',
            'Popelková', 'Pospíchalová', 'Pospíšilová', 'Potůčková',
            'Pourová', 'Prachařová', 'Prášková', 'Pražáková',
            'Prchalová', 'Procházková', 'Prokešová', 'Prokopová',
            'Prošková', 'Provazníková', 'Průchová', 'Průšová',
            'Přibylová', 'Příhodová', 'Přikrylová', 'Pšeničková',
            'Ptáčková', 'Rácová', 'Radová', 'Raková', 'Rambousková',
            'Rašková', 'Ratajová', 'Remešová', 'Rezková', 'Richterová',
            'Richtrová', 'Roubalová', 'Rousová', 'Rozsypalová', 'Rudolfová',
            'Růžková', 'Růžičková', 'Rybová', 'Rybářová', 'Rýdlová',
            'Ryšavá', 'Řeháčková', 'Řeháková', 'Řehořová', 'Řezáčová',
            'Řezníčková', 'Říhová', 'Sadílková', 'Samková', 'Sedláčková',
            'Sedláková', 'Sedlářová', 'Sehnalová', 'Seidlová', 'Seifertová',
            'Sekaninová', 'Semerádová', 'Severová', 'Schejbalová', 'Schmidtová',
            'Schneiderová', 'Schwarzová', 'Sikorová', 'Siváková', 'Skácelová',
            'Skalová', 'Skálová', 'Skalická', 'Sklenářová', 'Skopalová',
            'Skořepová', 'Skřivánková', 'Slabá', 'Sládková', 'Sladká',
            'Slámová', 'Slaninová', 'Slavíčková', 'Slavíková', 'Slezáková',
            'Slováčková', 'Slováková', 'Sluková', 'Smejkalová', 'Smékalová',
            'Smetanová', 'Smolová', 'Smolíková', 'Smolková', 'Smrčková',
            'Smržová', 'Smutná', 'Sobková', 'Sobotková', 'Sochorová',
            'Sojková', 'Sokolová', 'Sommerová', 'Součková', 'Soukupová',
            'Sovová', 'Spáčilová', 'Spurná', 'Srbová', 'Staňková',
            'Stárková', 'Stará', 'Stehlíková', 'Steinerová', 'Stejskalová',
            'Stiborová', 'Stoklasová', 'Straková', 'Stránská', 'Strejčková',
            'Strnadová', 'Strouhalová', 'Studená', 'Studničková',
            'Stuchlíková', 'Stupková', 'Suchánková', 'Suchomelová', 'Suchá',
            'Suková', 'Svačinová', 'Svatoňová', 'Svatošová', 'Světlíková',
            'Svitáková', 'Svobodová', 'Svozilová', 'Sýkorová', 'Synková',
            'Syrová', 'Šafaříková', 'Šafářová', 'Šafránková',
            'Šálková', 'Šandová', 'Šašková', 'Šebková', 'Šebelová',
            'Šebestová', 'Šedová', 'Šedivá', 'Šenková', 'Šestáková',
            'Ševčíková', 'Šilhavá', 'Šimáčková', 'Šimáková',
            'Šimánková', 'Šímová', 'Šimčíková', 'Šimečková', 'Šimková',
            'Šimonová', 'Šimůnková', 'Šindelářová', 'Šindlerová',
            'Šípková', 'Šípová', 'Široká', 'Šírová', 'Šišková',
            'Škodová', 'Škrabalová', 'Šlechtová', 'Šmejkalová', 'Šmerdová',
            'Šmídová', 'Šnajdrová', 'Šolcová', 'Špačková', 'Špičková',
            'Šplíchalová', 'Šrámková', 'Šťastná', 'Štefanová',
            'Štefková', 'Šteflová', 'Štěpánková', 'Štěpánová',
            'Štěrbová', 'Šubrtová', 'Šulcová', 'Šustrová', 'Švábová',
            'Švandová', 'Švarcová', 'Švecová', 'Švehlová', 'Švejdová',
            'Švestková', 'Táborská', 'Tancošová', 'Teplá', 'Tesařová',
            'Tichá', 'Tománková', 'Tomanová', 'Tomášková', 'Tomášová',
            'Tomečková', 'Tomková', 'Tomešová', 'Tóthová', 'Tranová',
            'Trávníčková', 'Trčková', 'Trnková', 'Trojanová', 'Truhlářová',
            'Třísková', 'Tučková', 'Tůmová', 'Turečková', 'Turková',
            'Tvrdíková', 'Tvrdá', 'Uherová', 'Uhlířová', 'Ulrichová',
            'Urbancová', 'Urbánková', 'Urbanová', 'Vacková', 'Václavková',
            'Václavíková', 'Vaculíková', 'Vágnerová', 'Váchová',
            'Valášková', 'Valová', 'Válková', 'Valentová', 'Valešová',
            'Váňová', 'Vančurová', 'Vaněčková', 'Vaňková', 'Vaníčková',
            'Vargová', 'Vašáková', 'Vašková', 'Vašíčková', 'Vávrová',
            'Vavříková', 'Večeřová', 'Vejvodová', 'Vernerová', 'Veselá',
            'Veverková', 'Víchová', 'Vilímková', 'Vinšová', 'Víšková',
            'Vitásková', 'Vítková', 'Vítová', 'Vlachová', 'Vlasáková',
            'Vlčková', 'Vlková', 'Vobořilová', 'Vodáková', 'Vodičková',
            'Vodrážková', 'Vojáčková', 'Vojtová', 'Vojtěchová',
            'Vojtková', 'Vojtíšková', 'Vokounová', 'Volková', 'Volfová',
            'Volná', 'Vondráčková', 'Vondráková', 'Vondrová', 'Voráčková',
            'Vorlová', 'Vorlíčková', 'Voříšková', 'Votavová', 'Votrubová',
            'Vrabcová', 'Vránová', 'Vrbová', 'Vrzalová', 'Vybíralová',
            'Vydrová', 'Vymazalová', 'Vyskočilová', 'Vysloužilová',
            'Wagnerová', 'Walterová', 'Weberová', 'Weissová', 'Winklerová',
            'Wolfová', 'Zábranská', 'Zahrádková', 'Zahradníková', 'Zachová',
            'Zajícová', 'Zajíčková', 'Zálešáková', 'Zámečníková',
            'Zapletalová', 'Zárubová', 'Zatloukalová', 'Zavadilová',
            'Zavřelová', 'Zbořilová', 'Zdražilová', 'Zedníková', 'Zelenková',
            'Zelená', 'Zelinková', 'Zemánková', 'Zemanová', 'Zezulová',
            'Zíková', 'Zikmundová', 'Zimová', 'Zlámalová', 'Zoubková',
            'Zouharová', 'Zvěřinová', 'Žáčková', 'Žáková', 'Žďárská',
            'Žemličková', 'Žídková', 'Žižková', 'Žůrková'
    );

    protected static $title = array(
        'Bc.', 'Ing.', 'MUDr.', 'MVDr.', 'Mgr.', 'JUDr.', 'PhDr.', 'RNDr.', 'doc.', 'Dr.'
    );

    /**
     * @return czech birth number
     * @param string|null $gender 'male', 'female' or null for any
     * @param int $minAge minimal age of "generated person" in years
     * @param int $maxAge maximal age of "generated person" in years
     */

    public function birthNumber($gender = null, $minAge = 0, $maxAge = 100, $slashProbability = 50)
    {
        if ($gender === null) {
            $gender = $this->generator->boolean() ? static::GENDER_MALE : static::GENDER_FEMALE;
        }

        $startTimestamp = strtotime("-${maxAge} year");
        $endTimestamp = strtotime("-${minAge} year");
        $randTimestamp = static::numberBetween($startTimestamp, $endTimestamp);

        $year = intval(date('Y', $randTimestamp));
        $month = intval(date('n', $randTimestamp));
        $day = intval(date('j', $randTimestamp));
        $suffix = static::numberBetween(0, 999);

        // women has +50 to month
        if ($gender == static::GENDER_FEMALE) {
            $month += 50;
        }
        // from year 2004 everyone has +20 to month when birth numbers in one day are exhausted
        if ($year >= 2004 && $this->generator->boolean(10)) {
            $month += 20;
        }

        $birthNumber = sprintf('%02d%02d%02d%03d', $year % 100, $month, $day, $suffix);

        // from year 1954 birth number includes CRC
        if ($year >= 1954) {
            $crc = intval($birthNumber, 10) % 11;
            if ($crc == 10) {
                $crc = 0;
            }
            $birthNumber .= sprintf('%d', $crc);
        }

        // add slash
        if ($this->generator->boolean($slashProbability)) {
            $birthNumber = substr($birthNumber, 0, 6) . '/' . substr($birthNumber, 6);
        }

        return $birthNumber;
    }

    public static function birthNumberMale()
    {
        return static::birthNumber(static::GENDER_MALE);
    }

    public static function birthNumberFemale()
    {
        return static::birthNumber(static::GENDER_FEMALE);
    }

    public function title($gender = null)
    {
        return static::titleMale();
    }

    /**
     * replaced by specific unisex Czech title
     */
    public static function titleMale()
    {
        return static::randomElement(static::$title);
    }

    /**
     * replaced by specific unisex Czech title
     */
    public static function titleFemale()
    {
        return static::titleMale();
    }

    /**
     * @param string|null $gender 'male', 'female' or null for any
     * @example 'Albrecht'
     */
    public function lastName($gender = null)
    {
        if ($gender === static::GENDER_MALE) {
            return static::lastNameMale();
        } elseif ($gender === static::GENDER_FEMALE) {
            return static::lastNameFemale();
        }

        return $this->generator->parse(static::randomElement(static::$lastNameFormat));
    }

    public static function lastNameMale()
    {
        return static::randomElement(static::$lastNameMale);
    }

    public static function lastNameFemale()
    {
        return static::randomElement(static::$lastNameFemale);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        INDX( 	 b<k             (   �  �                             8     h X     7     �X��ok� Uze�h��<��X��ok� 0      F$               A d d r e s s . p h p 9     h X     7     r���ok� Uze��v��<�r���ok�                      C o m p a n y . p h p :     p Z     7     i	 �ok� Uze�X����<�i	 �ok�       �               D a t e T i m e . p h p       ;     p Z     7     �j�ok� Uze��<��<��j�ok�H      G               I n t e r n e t . p h p       <     h X    7     ��	�ok� Uze��<��<���	�ok��      �               P a y m e n t . p h p =     h V     7     ��ok� Uze�Ӟ���<���ok� �      �              
 P e r s o n . p h p   >     p `     7     A��ok� Uze�@���<�A��ok�                     P h o n e N u m b e r . p h p ?     h R     7     K�(�ok� Uze�@���<�K�(�ok� �     ��              T e x t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

namespace Faker\Provider\cs_CZ;

class Text extends \Faker\Provider\Text
{
    public function realText($maxNbChars = 200, $indexSize = 2)
    {
        $text = parent::realText($maxNbChars, $indexSize);
        $text = str_replace('„', '', $text);

        return str_replace('“', '', $text);
    }

    /**
     * License: PD old 70
     *
     * Title: Krakatit
     * Author: Karel Čapek
     * Release Date: 25. 12. 1923 – 15. 4. 1924
     * Language: Czech
     *
     * @see https://cs.wikisource.org/wiki/Krakatit
     * @var string
     *
     * Karel Čapek
     * KRAKATIT
     * Znění tohoto textu vychází z díla Krakatit tak, jak bylo vydáno v Československém spisovateli v roce 1982
     * (ČAPEK, Karel. Továrna na absolutno ; Krakatit. 12. vyd. Továrny na absolutno, 16. vyd. Krakatitu. Praha :
     * Československý spisovatel, 1982. 476 s. Spisy, sv. 3.).
     * Další díla Karla Čapka naleznete online na www stránkách Městské knihovny v Praze: www.mlp.cz/karelcapek.
     * Elektronické publikování díla Karla Čapka je společným projektem Městské knihovny v Praze,
     * Společnosti bratří Čapků, Památníku Karla Čapka a Českého národního korpusu.
     */
    protected static $baseText = <<<'EOT'
I.
S večerem zhoustla mlha sychravého dne. Je ti, jako by ses protlačoval řídkou
vlhkou hmotou, jež se za tebou neodvratně zavírá. Chtěl bys být doma. Doma, u
své lampy, v krabici čtyř stěn. Nikdy ses necítil tak opuštěn.
Prokop si razí cestu po nábřeží. Mrazí ho a čelo má zvlhlé potem slabosti;
chtěl by si sednout tady na té mokré lavičce, ale bojí se strážníků. Zdá se
mu, že se motá; ano, u Staroměstských mlýnů se mu někdo vyhnul obloukem jako
opilému. Nyní tedy vynakládá veškeru sílu, aby šel rovně. Teď, teď jde proti
němu člověk, má klobouk do očí a vyhrnutý límec. Prokop zatíná zuby, vraští
čelo, napíná všechny svaly, aby bezvadně přešel. Ale zrovna na krok před
chodcem se mu udělá v hlavě tma a celý svět se s ním pojednou zatočí; náhle
vidí zblízka, zblizoučka pár pronikavých očí, jak se do něho vpíchly, naráží
na něčí rameno, vypraví ze sebe cosi jako „promiňte“ a vzdaluje se s
křečovitou důstojností. Po několika krocích se zastaví a ohlédne; ten člověk
stojí a dívá se upřeně za ním. Prokop se sebere a odchází trochu rychleji; ale
nedá mu to, musí se znovu ohlédnout; a vida, ten člověk ještě pořád stojí a
dívá se za ním, dokonce samou pozorností vysunul z límce hlavu jako želva. „Ať
kouká,“ myslí si Prokop znepokojen, „teď už se ani neohlédnu.“ A jde, jak
nejlépe umí; náhle slyší za sebou kroky. Člověk s vyhrnutým límcem jde za ním.
Zdá se, že běží. A Prokop se v nesnesitelné hrůze dal na útěk.
Svět se s ním opět zatočil. Těžce oddychuje, jektaje zuby opřel se o strom a
zavřel oči. Bylo mu strašně špatně, bál se, že padne, že mu praskne srdce a
krev vyšplíchne ústy. Když otevřel oči, viděl těsně před sebou člověka s
vyhrnutým límcem.
„Nejste vy inženýr Prokop?“ ptal se člověk, patrně už poněkolikáté.
„Já… já tam nebyl,“ pokoušel se Prokop cosi zalhávat.
„Kde?“ ptal se muž.
„Tam,“ řekl Prokop a ukazoval hlavou kamsi k Strahovu. „Co na mně chcete?“
„Copak mne neznáš? Já jsem Tomeš. Tomeš z techniky, nevíš už?“
„Tomeš,“ opakoval Prokop, a bylo mu k smrti jedno, jaké to je jméno. „Ano,
Tomeš, to se rozumí. A co – co mi chcete?“
Muž s vyhrnutým límcem uchopil Prokopa pod paží. „Počkej, teď si sedneš,
rozumíš?“
„Ano,“ řekl Prokop a nechal se dovést k lavičce. „Já totiž… mně není dobře,
víte?“ Náhle vyprostil z kapsy ruku zavázanou jakýmsi špinavým cárem.
„Poraněn, víte? Zatracená věc.“
„A hlava tě nebolí?“ řekl člověk.
„Bolí.“
„Tak poslouchej, Prokope,“ řekl člověk. „Teď máš horečku nebo co. Musíš do
špitálu, víš? Je ti zle, to je vidět. Ale aspoň se hleď upamatovat, že se
známe. Já jsem Tomeš. Chodili jsme spolu do chemie. Člověče, rozpomeň se!“
„Já vím, Tomeš,“ ozval se Prokop chabě. „Ten holomek. Co s ním je?“
„Nic,“ řekl Tomeš. „Mluví s tebou. Musíš do postele, rozumíš? Kde bydlíš?“
„Tam,“ namáhal se mluvit Prokop a ukazoval někam hlavou. „U… u Hybšmonky.“
Náhle se pokoušel vstát. „Já tam nechci! Nechoďte tam! Tam je – tam je –“
„Co?“
„Krakatit,“ zašeptal Prokop.
„Co je to?“
„Nic. Neřeknu. Tam nikdo nesmí. Nebo – nebo –“
„Co?“
„Ffft, bum!“ udělal Prokop a hodil rukou do výše.
„Co je to?“
„Krakatoe. Kra-ka-tau. Sopka. Vul-vulkán, víte? Mně to… natrhlo palec. Já
nevím, co…“ Prokop se zarazil a pomalu dodal: „To ti je strašná věc, člověče.“
Tomeš se pozorně díval, jako by něco očekával. „Tak tedy,“ začal po chvilce,
„ty ještě pořád děláš do třaskavin?“
„Pořád.“
„S úspěchem?“
Prokop vydal ze sebe cosi na způsob smíchu. „Chtěl bys vědět, že? Holenku, to
není jen tak. Není – není jen tak,“ opakoval klátě opile hlavou. „Člověče, ono
to samo od sebe samo od sebe –“
„Co?“
„Kra-ka-tit. Krakatit. Krrrakatit. A ono to samo od sebe – Já nechal jen
prášek na stole, víš? Ostatní jsem smetl dododo-do takové piksly. Zu-zůstal
jen poprašek na stole, – a najednou –“
„– to vybuchlo.“
„Vybuchlo. Jen takový nálet, jen prášek, co jsem utrousil. Ani to vidět
nebylo. Tuhle – žárovka – kilometr dál. Ta to nebyla. A já – v lenošce, jako
kus dřeva. Víš, unaven. Příliš práce. A najednou… prásk! Já letěl na zem. Okna
to vyrazilo a – žárovka pryč. Detonace jako – jako když bouchne lydditová
patrona. Stra-strašná brizance. Já – já nejdřív myslel, že praskla ta por-
porcená – ponce – por-ce-lánová, polcelánová, porcenálová, poncelár, jak se to
honem, to bílé, víte, izolátor, jak se to jmenuje? Kře-mi-čitan hlinitý.“
„Porcelán.“
„Piksla. Já myslel, že praskla ta piksla, se vším všudy. Tak rozškrtnu sirku,
a ona tam je celá, ona je celá, ona je celá. A já – jako sloup – až mně sirka
spálila prsty. A pryč – přes pole – potmě – na Břevnov nebo do Střešovic – Aa
někde mě napadlo to slovo. Krakatoe. Krakatit. Kra-ka-tit. Nene, tak to
nenenebylo. Jak to bouchlo, letím na zem a křičím Krakatit. Krakatit. Pak jsem
na to zapomněl. Kdo je tu? Kdo – kdo jste?“
„Kolega Tomeš.“
„Tomeš, aha. Ten všivák! Přednášky si vypůjčoval. Nevrátil mně jeden sešit
chemie. Tomeš, jak se jmenoval?“
„Jiří.“
„Já už vím, Jirka. Ty jsi Jirka, já vím. Jirka Tomeš. Kde máš ten sešit?
Počkej, já ti něco řeknu. Až vyletí to ostatní, je zle. Člověče, to rozmlátí
celou Prahu. Smete. Odfoukne, ft! Až vyletí ta por-ce-lánová dóze, víš?“
„Jaká dóze?“
„Ty jsi Jirka Tomeš, já vím. Jdi do Karlína. Do Karlína nebo do Vysočan, a
dívej se, až to vyletí. Běž, běž honem!“
„Proč?“
„Já toho nadělal cent. Cent Krakatitu. Ne, asi – asi patnáct deka. Tam nahoře,
v té por-ce-lánové dózi. Člověče, až ta vyletí – Ale počkej, to není možné, to
je nesmysl,“ mumlal Prokop chytaje se za hlavu.
„Nu?“
„Proč – proč – proč to nevybuchlo také v té dózi? Když ten prášek – sám od
sebe – Počkej, na stole je zin-zinkový plech – plech – Od čeho to na stole
vybuchlo? Poč-kej, buď tiše, buď tiše,“ drtil Prokop a vrávoravě se zvedl.
„Co je ti?“
„Krakatit,“ zabručel Prokop, udělal celým tělem jakýsi otáčivý pohyb a svalil
se na zem v mrákotách.


II.

První, co si Prokop uvědomil, bylo, že se s ním všechno otřásá v drnčivém
rachotu a že ho někdo pevně drží kolem pasu. Hrozně se bál otevřít oči;
myslel, že se to na něj řítí. Ale když to neustávalo, otevřel oči a viděl před
sebou matný čtyřúhelník, kterým se sunou mlhavé světelné koule a pruhy. Neuměl
si to vysvětlit; díval se zmateně na uplývající a poskakující mátohy, trpně
odevzdán ve vše, co se s ním bude dít. Pak pochopil, že ten horlivý rachot
jsou kola vozu a venku že míjejí jenom svítilny v mlze; a unaven tolikerým
pozorováním zavřel opět oči a nechal se unášet.
„Teď si lehneš,“ řekl tiše hlas nad jeho hlavou; „spolkneš aspirin a bude ti
líp. Ráno ti přivedu doktora, ano?“
„Kdo je to,“ ptal se Prokop ospale.
„Tomeš. Lehneš si u mne, Prokope. Máš horečku. Kde tě co bolí?“
„Všude. Hlava se mi točí. Tak, víš –“
„Jen tiše lež. Uvařím ti čaj a vyspíš se. Máš to z rozčilení, víš. To je
taková nervová horečka. Do rána to přejde.“
Prokop svraštil čelo v námaze vzpomínání. „Já vím,“ řekl po chvíli
starostlivě. „Poslyš, ale někdo by měl tu pikslu hodit do vody. Aby
nevybuchla.“
„Bez starosti. Teď nemluv.“
„A… já bych snad mohl sedět. Nejsem ti těžký?“
„Ne, jen lež.“
„– – A ty máš ten můj sešit chemie,“ vzpomněl si Prokop najednou.
„Ano, dostaneš jej. Ale teď klid, slyšíš?“
„Já ti mám tak těžkou hlavu –“
Zatím drkotala drožka nahoru Ječnou ulicí. Tomeš slabounce hvízdal nějakou
melodii a díval se oknem. Prokop sípavě dýchal s tichým sténáním. Mlha smáčela
chodníky a vnikala až pod kabát svým sychravým slizem; bylo pusto a pozdě.
„Už tam budeme,“ řekl Tomeš nahlas. Drožka se čerstvěji rozhrčela na náměstí a
zahnula vpravo. „Počkej, Prokope, můžeš udělat pár kroků? Já ti pomohu.“
S námahou vlekl Tomeš svého hosta do druhého patra, Prokop si připadal jaksi
lehký a bez váhy, a nechal se skoro vynést po schodech nahoru; ale Tomeš silně
oddechoval a utíral si pot.
„Viď, jsem jako nitě,“ divil se Prokop.
„Nu ovšem,“ mručel udýchaný Tomeš odemykaje svůj byt.
Prokopovi bylo jako malému dítěti, když jej Tomeš svlékal. „Má maminka,“ začal
něco povídat, „když má maminka, to už je, to už je dávno, tatínek seděl u
stolu, a maminka mne nosila do postele, rozumíš?“
Pak už byl v posteli, přikryt po bradu, jektal zuby a díval se, jak se Tomeš
točí u kamen a rychle zatápí. Bylo mu do pláče dojetím, lítostí a slabostí, a
pořád brebentil; uklidnil se, až dostal na čelo studený obkladek. Tu se tiše
díval po pokoji; bylo tu cítit tabák a ženu.
„Ty jsi kujón, Tomši,“ ozval se vážně. „Pořád máš holky.“
Tomeš se k němu obrátil. „Nu, a co?“
„Nic. Co vlastně děláš?“
Tomeš mávl rukou. „Mizerně, kamaráde. Peníze nejsou.“
„Flámuješ.“
Tomeš jen potřásl hlavou.
„A je tě škoda, víš?“ začal Prokop starostlivě. „Ty bys mohl – Koukej, já
dělám už dvanáct let.“
„A co z toho máš?“ namítl Tomeš příkře.
„No, sem tam něco. Prodal jsem letos třaskavý dextrin.“
„Zač?“
„Za deset tisíc. Víš, nic to není, hloupost. Taková pitomá bouchačka, pro
doly. Ale kdybych chtěl –“
„Je ti už líp?“
„Krásně mi je. Já jsem ti našel metody! Člověče, jeden nitrát ceru, to ti je
vášnivá potvora; a chlor, chlor, tetrastupeň chlordusíku se zapálí světlem.
Rozsvítíš žárovku, a prásk! Ale to nic není. Koukej,“ prohlásil náhle
vystrkuje zpod pokrývky hubenou, děsně zkomolenou ruku. „Když něco vezmu do
ruky, tak… v tom cítím šumět atomy. Zrovna to mravenčí. Každá hmota mravenčí
jinak, rozumíš?“
„Ne.“
„To je síla, víš? Síla v hmotě. Hmota je strašně silná. Já… já hmatám, jak se
to v ní hemží. Drží to dohromady… s hroznou námahou. Jak to uvnitř rozvikláš,
rozpadne se, bum! Všechno je exploze. Když se rozevře květina, je to exploze.
Každá myšlenka, to je takové prasknutí v mozku. Když mně podáš ruku, cítím,
jak v tobě něco exploduje. Já mám takový hmat, člověče. A sluch. Všechno šumí,
jako šumivý prášek. To jsou samé malinkaté výbuchy. Mně ti tak hučí v hlavě…
Ratatata, jako strojní puška.“
„Tak,“ řekl Tomeš, „a teď spolkni tuhleten aspirin.“
„Ano. Třa-třaskavý aspirin. Perchlorovaný acetylsalicylazid. To nic není.
Člověče, já jsem našel exotermické třaskaviny. Každá látka je vlastně
třaskavina. Voda… voda je třaskavina. Hlína… a vzduch jsou třaskaviny. Peří,
peří v peřině je taky třaskavina. Víš, zatím to má jen teoretický význam. A já
jsem našel atomové výbuchy. Já – já – já jsem udělal alfaexploze. Roz-pad-ne
se to na plus plus částice. Žádná termochemie. De-struk-ce. Destruktivní
chemie, člověče. To ti je ohromná věc, Tomši, čistě vědecky. Já ti mám doma
tabulky… Lidi, kdybych já měl aparáty! Ale já mám jen oči… a ruce… Počkej, až
to napíšu!“
„Nechce se ti spát?“
„Chce. Jsem – dnes – unaven. A co tys pořád dělal?“
„Nu, nic. Život.“
„Život je třaskavina, víš? Prásk, člověk se narodí a rozpadne se, bum! A nám
se zdá, že to trvá bůhvíkolik let, viď? Počkej, já jsem teď něco spletl, že?“
„Docela v pořádku, Prokope. Možná že zítra udělám bum. Nebudu-li mít totiž
peníze. Ale to je jedno, starouši, jen spi.“
„Já bych ti půjčil, nechceš?“
„Nech. Na to bys nestačil. Snad ještě můj tatík –“ Tomeš mávl rukou.
„Tak vidíš, ty máš ještě tatínka,“ ozval se Prokop po chvíli s náhlou
měkkostí.
„Nu ano. Doktor v Týnici.“ Tomeš vstal a přecházel po pokoji. „Je to mizérie,
člověče, mizérie. Mám to nahnuté, nu! A nestarej se o mne. Já už – něco
udělám. Spi!“
Prokop se utišil. Polozavřenýma očima viděl, jak Tomeš sedá ke stolku a hrabe
se v nějakých papírech. Bylo mu jaksi sladko naslouchat šustění papíru a
tichému hukotu ohně v kamnech. Člověk skloněný u stolku opřel hlavu o dlaně a
snad ani nedýchal; a Prokopovi bylo, že leží doma a vidí svého staršího
bratra, svého bratra Josefa; učí se z knížek elektrotechnice a bude zítra
dělat zkoušku; a Prokop usnul horečným spánkem.


III.

Zdálo se mu, že slyší hukot jakoby nesčetných kol. „To je nějaká továrna,“
myslel si a běžel po schodech nahoru. Zničehonic se ocitl před velikými
dveřmi, kde stálo na skleněné tabulce: Plinius. Zaradoval se nesmírně a vešel
dovnitř. „Je tu pan Plinius?“ ptal se nějaké slečinky u psacího stroje. „Hned
přijde,“ řekla slečinka, a tu k němu přistoupil vysoký oholený muž v cutawayi
a s ohromnými kruhovými skly na očích. „Co si přejete?“ řekl.
Prokop se zvědavě díval do jeho neobyčejně výrazné tváře. Mělo to britskou
hubu a vypouklé rozježděné čelo, na skráni bradavici zvící šestáku a bradu
jako filmový herec. „Vy – vy – račte být – Plinius?“
„Prosím,“ řekl vysoký muž a krátkým gestem mu ukázal do své pracovny.
„Jsem velmi… je mi… ohromnou ctí,“ koktal Prokop usedaje.
„Co si přejete?“ přerušil ho vysoký muž.
„Já jsem rozbil hmotu,“ prohlásil Prokop. Plinius nic; hrál si jen s ocelovým
klíčkem a zavíral těžká víčka pod skly.
„To je totiž tak,“ začal Prokop překotně. „V-v-všecko se rozpadá, že? Hmota je
křehká. Ale já udělám, že se to rozpadne najednou, bum! Výbuch, rozumíte? Na
padrť. Na molekuly. Na atomy. Ale já jsem rozbil také atomy.“
„Škoda,“ řekl Plinius povážlivě.
„Proč – jaká škoda?“
„Škoda něco rozbít. I atomu je škoda. Nu tak dál.“
„Já… rozbiju atom. Já vím, že už Rutherford… Ale to byla jen taková páračka se
zářením, víte? To nic není. To se musí en masse. Jestli chcete, já vám
rozbourám tunu bismutu; rozštípne to ce-celý svět, ale to je jedno. Chcete?“
„Proč byste to dělal?“
„Je to… vědecky zajímavé,“ zmátl se Prokop. „Počkejte, jakpak bych vám to… To
je – to je vám ne-smír-ně zajímavé.“ Chytil se za hlavu. „Počkejte, mně
praskne hla-va; to bude – vědecky – ohromně zajímavé, že? Aha, aha,“ vyhrkl s
úlevou, „já vám to vyložím. Dynamit – dynamit trhá hmotu na kusy, na balvany,
ale benzoltrioxozonid ji roztrhá na prášek; udělá jen malou díru, ale
rrrozdrtí hmotu nana-na submikroskopickou padrť, rozumíte? To dělá detonační
rychlost. Hmota nemá čas ustoupit; nemůže se už ani roz-rozhrnout, roztrhnout,
víte? A já… jjjá jsem stupňoval detonační rychlost. Argonozonid.
Chlorargonoxozonid. Tetrargon. A pořád dál. Pak už ani vzduch nemůže ustoupit;
je stejně tuhý jako… jako ocelová deska. Roztrhá se na molekuly. A pořád dál.
A najednou vám… od jisté rychlosti… začne brizance děsně stoupat. Roste…
kvadraticky. Já koukám jako blázen. Odkud se to bere? Kde kde kde se najednou
vzala ta energie?“ naléhal Prokop zimničně. „Tak řekněte.“
„Nu, třeba v atomu,“ mínil Plinius.
„Aha,“ prohlásil Prokop vítězně a utřel si pot. „Tady je ten vtip. Jednoduše v
atomu. Ono to… vrazí atomy do sebe… a… sss… serve betaplášť… a jádro se musí
rozpadnout. To je alfaexploze. Víte, kdo jsem? Já jsem první člověk, který
překročil koeficient stlačitelnosti, pane. Já jsem našel atomové výbuchy. Já…
já jsem vyrazil z bismutu tantal. Poslyšte, víte vy, kolik je vy-výkonu v
jednom gramu rtuti? Čtyři sta dvaašedesát miliónů kilogramometrů. Hmota je
děsně silná. Hmota je regiment, který přešlapuje na místě: ráz dva, ráz dva;
ale dejte ten pravý povel, a regiment vyrazí v útok, en evant! To je výbuch,
rozumíte? Hurá!“
Prokop se zarazil vlastním křikem; v hlavě mu bušilo tak, že přestal cokoli
vnímat. „Promiňte,“ řekl, aby zamluvil rozpaky, a hledal třesoucí se rukou své
pouzdro na cigára. „Kouříte?“
„Ne.“
„Již staří Římané kouřili,“ ujišťoval Prokop a otevřel pouzdro; byly tam samé
těžké patrony. „Zapalte si,“ nutil, „to je lehoučký Nobel Extra.“ Sám ukousl
špičku tetrylové patrony a hledal sirky. „To nic není,“ začal, „ale znáte
třaskavé sklo? Škoda. Poslyšte, já vám mohu udělat výbušný papír. Napíšete
psaní, někdo to hodí do ohně a prásk! celý barák se sesype. Chcete?“
„K čemu?“ ptal se Plinius zvedaje obočí.
„Jen tak. Síla musí ven. Já vám něco povím. Kdybyste chodil po stropě, tak co
vám z toho vznikne? Já především kašlu na valenční teorie. Všecko se dá dělat.
Slyšíte, jak to venku rachotí? To slyšíte růst trávu: samé výbuchy. Každé
semínko je třaskavá kapsle, která vyletí. Puf, jako raketa. A ti hlupáci si
myslí, že není žádná tautomerie. Já jim ukážu takovou merotropii, že budou z
toho blázni. Samá laboratorní zkušenost, pane.“
Prokop cítil s hrůzou, že žvaní nesmysly; chtěl tomu uniknout a mlel tím
rychleji, pleta páté přes deváté. Plinius vážně kýval hlavou; dokonce komihal
celým tělem hlouběji a pořád hlouběji, jako by se klaněl. Prokop drmolil
zmatené formule a nemohl se zastavit, poule oči na Plinia, který se komihal s
rostoucí rychlostí jako stroj. Podlaha pod ním se začala houpat a zvedat.
„Ale tak přestaňte, člověče,“ zařval Prokop zděšen a probudil se. Místo Plinia
viděl Tomše, který neobraceje se od stolku bručel: „Nekřič, prosím tě.“
„Já nekřičím,“ řekl Prokop a zavřel oči. V hlavě mu hučelo rychlými a
bolestnými tepy.
Zdálo se mu, že letí přinejmenším rychlostí světla; nějak se mu svíralo srdce,
ale to dělá jen Fitzgerald-Lorentzovo zploštění, řekl si; musím být placatý
jako lívanec. A najednou se proti němu vyježí nesmírné skleněné hranoly; ne,
jsou to jenom nekonečné hladce vybroušené roviny, jež se protínají a
prostupují v břitkých úhlech jako krystalografické modely; a proti jedné
takové hraně je hnán úžasnou rychlostí. „Pozor,“ zařval sám na sebe, neboť v
tisícině vteřiny se musí roztříštit; ale tu již bleskově odletěl zpět a rovnou
proti hrotu obrovského jehlanu; odrazil se jako paprsek a byl vržen na
skleněně hladkou stěnu, smeká se podle ní, sviští do ostrého úhlu, kmitá
šíleně mezi jeho stěnami, je hozen pozpátku nevěda proti čemu, zas odmrštěn
dopadá bradou na ostrou hranu, ale v poslední chvíli ho to odhodí vzhůru; nyní
si roztřískne hlavu o euklidovskou rovinu nekonečna, ale již se řítí střemhlav
dolů, dolů do tmy; prudký náraz, bolestné cuknutí v celém těle, ale hned zas
se zvedl a dal se na útěk. Uhání labyrintickou chodbou a za sebou slyší dupot
pronásledovatelů; chodba se úží, svírá se, její stěny se přirážejí k sobě
děsným a neodvratným pohybem; i dělá se tenký jako šídlo, zatajuje dech a
upaluje v bláznivé hrůze, aby tudy proběhl, než ho ty stěny rozdrtí. Zavřelo
se to za ním s kamenným nárazem, zatímco sám svistí do propasti podle ledově
čišící zdi. Strašný úder, a ztrácí vědomí; když procitl, vidí, že je v černé
tmě; hmatá po slizkých kamenných stěnách a křičí o pomoc, ale z jeho úst
nevychází zvuku; taková je tu tma. Jektaje hrůzou klopýtá po dně propasti;
nahmatá postranní chodbu, i vrhá se do ní; jsou to vlastně. schody, a nahoře,
nekonečně daleko svítá malinký otvor jako v šachtě; běží tedy nahoru po
nesčíslných a strašně příkrých stupních; ale nahoře není než plošinka,
lehoučká plechová platforma drnčící a chvějící se nad závratnou hlubinou, a
dolů se šroubem točí jen nekonečné schůdky ze železných plátů. A tu již za
sebou slyšel supění pronásledovatelů. Bez sebe hrůzou se řítil a točil po
schůdkách dolů, a za ním železně řinčí a rachotí dupající zástup nepřátel. A
najednou vinuté schody se končí ostře v prázdnu. Prokop zavyl, rozpřáhl ruce a
pořád ještě víře padal do bezdna. Hlava se mu zatočila, neviděl už a neslyšel;
váznoucíma nohama běžel nevěda kam, drcen strašným a slepým puzením, že musí
kamsi dorazit, než bude pozdě. Rychleji a rychleji ubíhal nekonečným
koridorem; čas od času míjel semafor, na kterém pokaždé vyskočila vyšší
číslice: 17, 18, 19. Najednou pochopil, že běhá v kruhu a ta čísla že udávají
počet jeho oběhů. 40, 41. Popadla ho nesnesitelná hrůza, že přijde pozdě a že
se odtud nedostane; svištěl zběsilou rychlostí, takže se semafor jenom mihal
jako telegrafní tyče z rychlíku; a ještě rychleji! nyní už semafor ani
neubíhá, nýbrž stojí na jednom místě a odpočítává bleskovou rychlostí tisíce a
desettisíce oběhů, a nikde není východ z té chodby, a chodba je na pohled
rovná a lesklá jako hamburský tunel, a přece se vrací kruhem; Prokop vzlyká
děsem: to je Einsteinův vesmír, a já musím dojít, než bude pozdě! Náhle zazněl
strašný výkřik, a Prokop ustrnul: je to hlas tatínkův, někdo ho vraždí; i jal
se obíhat ještě rychleji, semafor zmizel, udělala se tma; Prokop tápal po
stěnách a nahmatal zamčené dveře, a za nimi je slyšet to zoufalé bědování a
rány pokáceného nábytku. Řva hrůzou zarývá Prokop nehty do dveří, štípe je a
rozškrabává; vytrhal je po třískách a našel za nimi staré známé schody, jež ho
denně vedly domů, když byl maličký; a nahoře dusí se tatínek, někdo ho škrtí a
smýká jím po zemi. Křiče vyletí Prokop nahoru, je doma na chodbě, vidí konve a
chlebovou skříň maminčinu a pootevřené dveře do kuchyně, a tam uvnitř chroptí
a prosí tatínek, aby ho nezabíjeli; někdo mu tluče hlavou o zem; chce mu jít
na pomoc, ale nějaká slepá, bláznivá moc ho nutí, aby tady na chodbě běhal
dokola, pořád rychleji dokolečka a chechtal se jíkavě, zatímco uvnitř skomírá
a dusí se tatínkovo sténání. A neschopen vykročit ze závratného bludného
kruhu, řítě se stále rychleji ryčel Prokop šíleným smíchem hrůzy.
Tu se probudil zalit potem a jektaje zuby. Tomeš mu stál u hlav a dával mu na
rozžhavené čelo nový chladivý obklad.
„To je dobře, to je dobře,“ mumlal Prokop, „já už nebudu spát.“ I ležel tiše a
díval se na Tomše, jak sedí u lampy. Jirka Tomeš, říkal si, a počkejme, pak
kolega Duras, a Honza Buchta, Sudík, Sudík, Sudík, a kdo ještě? Sudík, Trlica,
Trlica, Pešek, Jovanovič, Mádr, Holoubek, co nosil brejle, to je náš ročník na
chemii. Bože, a který je tamhleten? Aha, to je Vedral, ten padl v roce
šestnáct, a za ním sedí Holoubek, Pacovský, Trlica, Šeba, celý ročník. A tu
slyšel najednou: „Pan Prokop bude kolokvovat.“
Lekl se nesmírně. U katedry sedí profesor Wald a tahá se suchou ručičkou za
vousy, jako vždy. „Povězte,“ praví profesor Wald, „co víte o třaskavinách.“
„Třaskaviny třaskaviny,“ začíná Prokop nervózně, „jejich výbušnost záleží na
tom, že že že se náhle vyvine veliký objem plynu, který který se vyvine z
mnohem menšího objemu výbušné masy… Prosím, to není správné.“
„Jak to?“ táže se Wald přísně.
„Já já já jsem našel alfavýbuchy. Výbuch totiž nastane rozpadem atomu.
Částečky atomu se rozletí – rozletí –“
„Nesmysl,“ přeruší ho profesor. „Není žádných atomů.“
„Jsou jsou jsou,“ drtil Prokop. „Prosím, já já já to dokážu –“
„Překonaná teorie,“ bručí profesor. „Nejsou vůbec žádné atomy, jsou jenom
gumetály. Víte, co je to gumetál?“
Prokop se zapotil úlekem. Toho slova nikdy v životě neslyšel. Gumetál? „To
neznám,“ vydechl stísněně.
„Tak vidíte,“ řekl suše Wald. „A pak si troufáte dělat kolokvium. Co víte o
Krakatitu?“
Prokop se nesmírně zarazil. „Krakatit,“ šeptal, „to je… to je úplně nová
třaskavina, která… která dosud…“
„Čím se zanítí? Čím? Čím exploduje?“
„Hertzovými vlnami,“ vyhrkl Prokop s úlevou.
„Jak to víte?“
„Protože mně zničehonic vybuchla. Protože… protože nebyl žádný jiný impuls. A
protože –“
„Nu?“
„… její syn-syntéza… se mně povedla za-za-za… vysokofrekvenční oscilace. Není
to dosud vyvyvysvětleno; ale já myslím, že – – že to byly nějaké
elektromagnetické vlny.“
„Byly. Já to vím. Teď napište na tabuli chemicky vzorec Krakatitu.“
Prokop vzal kus křídy a načmáral na tabuli svůj vzorec.
„Přečtěte.“
Prokop odříkal vzorec nahlas. Tu vstal profesor Wald a řekl najednou jakýmsi
docela jiným hlasem: „Jak? Jak je to?“
Prokop opakoval formuli.
„Tetrargon?“ ptal se profesor rychle. „Pb kolik?“
„Dvě.“
„Jak se to dělá?“ tázal se hlas podivně blízce. „Postup! Jak se to dělá? Jak?…
Jak se dělá Krakatit?“
Prokop otevřel oči. Nad ním se skláněl Tomeš s tužkou a zápisníkem v ruce a
bez dechu se díval na jeho rty.
„Co?“ mumlal Prokop neklidně. „Co chceš? Jak… jak se to dělá?“
„Něco se ti zdálo,“ řekl Tomeš a schoval zápisník za zády. „Spi, člověče,
spi.“


IV.

Teď jsem něco vyžvanil, uvědomoval si Prokop jasnějším cípem mozku; ale jinak
mu to bylo svrchovaně lhostejno; chtělo se mu jen spát, nesmírně spát. Viděl
jakýsi turecký koberec, jehož vzor se bez konce přesunoval, prostupoval a
měnil. Nebylo to nic, a přece ho to jaksi rozčilovalo; i ve spaní zatoužil
vidět znovu Plinia. Snažil se vybavit si jeho podobu; místo toho měl před
sebou ohavnou zešklebenou tvář, jež skřípala žlutými vyžranými zuby, až se
drtily, a pak je po kouskách vyplivovala. Chtěl tomu uniknout; napadlo ho
slovo „rybář“, a hle, zjevil se mu rybář nad šedivou vodou i s rybami v
čeřenu; řekl si „lešení“, a viděl skutečné lešení do poslední skoby a vazby.
Dlouho se bavil tím, že vymýšlel slova a pozoroval obrázky jimi promítnuté;
ale pak, pak už si živou mocí nemohl na žádné slovo vzpomenout. Namáhal se
usilovně, aby našel aspoň jedno jediné slovo nebo věc, ale marně; tu ho zalila
hrůza bezmoci studeným potem. Musím postupovat metodicky, umínil si; začnu zas
od začátku, nebo jsem ztracen. Šťastně si vzpomněl na slovo „rybář“, ale
zjevil se mu hliněný prázdný galon od petroleje; bylo to děsné. Řekl si
„židle“, a ukázal se mu s podivnou podrobností dehtovaný tovární plot s
trochou smutné zaprášené trávy a rezavými obručemi. To je šílenství, řekl si s
mrazivou jasností; to je, pánové, typická pomatenost, hyperofabula ugongi
dugongi Darwin. Tu se mu tento odborný název zazdál neznámo proč ukrutně
směšný, a dal se do hlasitého, zrovna zalykavého smíchu, jímž se probudil.
Byl úplně zpocen a odkopán. Díval se horečnýma očima na Tomše, který chvatně
přecházel po pokoji a házel nějaké věci do kufříku; ale nepoznával ho.
„Poslyšte, poslyšte,“ začal, „to je k smíchu, poslyšte, tak počkejte, to
musíte, poslyšte –“ Chtěl říci jako vtip ten podivuhodný odborný název, a sám
se smál předem; ale živou mocí si nemohl vzpomenout, jak to vlastně bylo, i
rozmrzel se a umkl.
Tomeš si oblékl ulstr a narazil čepici; a když už bral kufřík, zaváhal a sedl
si na pelest k Prokopovi. „Poslyš, starouši,“ řekl starostlivě, „já teď musím
odejet. K tátovi, do Týnice. Nedá-li mně peníze, tak – se už nevrátím, víš?
Ale nic si z toho nedělej. Ráno sem přijde domovnice a přivede ti doktora,
ano?“
„Kolik je hodin?“ ptal se Prokop netečně.
„Čtyři… Čtyři a pět minut. Snad… ti tu nic neschází?“
Prokop zavřel oči, odhodlán nezajímat se už o nic na světě. Tomeš ho pečlivě
přikryl, a bylo ticho.
Náhle otevřel oči dokořán. Viděl nad sebou neznámý strop a po jeho kraji běží
neznámý ornament. Sáhl rukou po svém nočním stolku, a hmátl do prázdna.
Obrátil se polekán, a místo svého širokého laboratorního pultu vidí nějaký
cizí stolek s lampičkou. Tam, kde bývalo okno, je skříň; kde stávalo umyvadlo,
jsou jakési dveře. Zmátl se tím vším nesmírně; nedovedl pochopit, co se s ním
děje, kde se octl, a přemáhaje závrať usedl na posteli. Pomalu si uvědomil, že
není doma, ale nemohl si vzpomenout, jak se sem dostal. „Kdo je to,“ zeptal se
hlasitě nazdařbůh, stěží hýbaje jazykem. „Pít,“ ozval se po chvíli, „pít!“
Bylo trýznivé ticho. Vstal z postele a trochu vrávoravě šel hledat vodu. Na
umyvadle našel karafu a pil z ní dychtivě; a když se vracel do postele,
podlomily se mu nohy a usedl na židli, nemoha dále. Seděl snad hodně dlouho;
pak ho roztřásla zima, neboť se celý polil vodou z karafy, a přišlo mu líto
sebe sama, že je kdesi a neví sám kde, že ani do postele nedojde a že je tak
bezradně a bezmocně sám; tu propukl v dětský vzlykavý pláč.
Když se trochu vyplakal, bylo mu v hlavě jasněji. Dokonce mohl dojít až k
posteli a ulehl jektaje zuby; a sotva se zahřál, usnul mrákotným spánkem beze
snu.
Když se probudil, byla roleta vytažena do šedivého dne a v pokoji trochu
pouklizeno; nedovedl pochopit, kdo to udělal, ale jinak se pamatoval na vše,
na včerejší explozi, na Tomše i na jeho odjezd. Zato ho třeštivě bolela hlava,
bylo mu těžko na prsou a drásavě ho mučil kašel. Je to špatné, říkal si, je to
docela špatné; měl bych jít domů a lehnout si. Vstal tedy a začal se pomalu
strojit chvílemi odpočívaje. Bylo mu, jako by mu něco drtilo hrozným tlakem
prsa. Usedl pak netečný ke všemu a těžce dýchal.
Tu krátce, jemně zazněl zvonek. Vzchopil se s námahou a šel otevřít. Na prahu
v chodbě stála mladá dívka s tváří zastřenou závojem.
„Bydlí tady… pan Tomeš?“ ptala se spěšně a stísněně.
„Prosím,“ řekl Prokop a ustoupil jí z cesty; a když, trochu váhajíc, těsně
podle něho vcházela dovnitř, zavála na něj slabounká a spanilá vůně, že
rozkoší vzdychl.
Posadil ji vedle okna a usedl proti ní, drže se zpříma, jak nejlépe dovedl.
Cítil, že samým úsilím vypadá přísně a strnule, což uvádělo do nesmírných
rozpaků jeho i dívku. Hryzala si pod závojem rty a klopila oči; ach, líbezná
hladkost tváře, ach, ruce malé a hrozně rozčilené! Náhle zvedla oči, a Prokop
zatajil dech omámen úžasem; tak krásná se mu zdála.
„Pan Tomeš není doma?“ ptala se dívka.
„Tomeš odejel,“ řekl Prokop váhavě. „Dnes v noci, slečno.“
„Kam?“
„Do Týnice, k svému otci.“
„A vrátí se?“
Prokop pokrčil rameny.
Dívka sklopila hlavu a její ruce s něčím zápasily. „A řekl vám, proč – proč –“
„Řekl.“
„A myslíte, že – že to udělá?“
„Co, slečno?“
„Že se zastřelí.“
Prokop si bleskem vzpomněl, že viděl Tomše ukládat revolver do kufříku. ,Možná
že zítra udělám bum,‘ slyšel jej znovu drtit mezi zuby. Nechtěl nic říci, ale
vypadal asi velmi povážlivě.
„Ó bože, ó bože,“ vypravila ze sebe dívka, „ale to je strašné! Řekněte,
řekněte –“
„Co, slečno?“
„Kdyby – kdyby někdo mohl za ním jet! Kdyby mu někdo řekl – kdyby mu dal –
Vždyť by to nemusel udělat, chápete? Kdyby někdo za ním ještě dnes jel –“
Prokop se díval na její zoufalé ruce, jež se zatínaly a spínaly.
„Já tam tedy pojedu, slečno,“ řekl tiše. „Náhodou… mám snad v tu stranu
nějakou cestu. Kdybyste chtěla – já –“
Dívka zvedla hlavu. „Skutečně,“ vyhrkla radostně, „vy byste mohl –?“
„Já jsem jeho… starý kamarád, víte?“ vysvětloval Prokop. „Chcete-li mu něco
vzkázat… nebo poslat… já ochotně…“
„Bože, vy jste hodný,“ vydechla dívka.
Prokop se slabě začervenal. „To je maličkost, slečno,“ bránil se. „Náhodou…
mám zrovna volný čas… stejně chci někam jet, a vůbec –“ Mávl v rozpacích
rukou. „To nestojí za řeč. Udělám všecko, co chcete.“
Dívka se zarděla a honem se dívala jinam. „Ani nevím, jak bych… vám měla
děkovat,“ řekla zmateně. „Mně je tak líto, že… že vy… Ale je to tak důležité –
A pak, vy jste jeho přítel – Nemyslete si, že já sama –“ Tu se přemohla a
upřela na Prokopa čiré oči. „Já mu něco musím poslat. Od někoho jiného. Já vám
nemohu říci –“
„Není třeba,“ řekl Prokop rychle. „Já mu to dám, a je to. Já jsem tak rád, že
mohu vám… že mohu jemu… Prší snad?“ ptal se náhle dívaje se na její zrosenou
kožišinku.
„Prší.“
„To je dobře,“ mínil Prokop; myslel totiž na to, jak příjemně by chladilo,
kdyby na tu kožišinku směl položit čelo.
„Já to tu nemám,“ řekla vstávajíc. „Bude to jen malý balíček. Kdybyste mohl
počkat… Já vám to přinesu za dvě hodiny.“
Prokop se velmi strnule uklonil; bál se totiž, že ztratí rovnováhu. Ve dveřích
se obrátila a pohlédla na něj upřenýma očima. „Na shledanou.“ A byla ta tam.
Prokop usedl a zavřel oči. Krupičky deště na kožišince, hustý a orosený závoj;
zastřený hlas, vůně, neklidné ruce v těsných, maličkých rukavičkách; chladná
vůně, pohled jasný a matoucí pod sličným, pevným obočím. Ruce na klíně, měkké
řasení sukně na silných kolenou, ach, maličké ruce v těsných rukavicích! Vůně,
temný a chvějící se hlas, líčko hladké a pobledlé. Prokop zatínal zuby do
chvějících se rtů. Smutná, zmatená a statečná. Modrošedé oči, oči čisté a
světelné. Ó bože, ó bože, jak se tiskl závoj k jejím rtům!
Prokop zasténal a otevřel oči. Je to Tomšova holka, řekl si se slepým vztekem.
Věděla kudy jít, není tu poprvé. Snad tady… zrovna tady v tom pokoji – –
Prokop si v nesnesitelné trýzni vrýval nehty do dlaní. A já hlupák se nabízím,
že pojedu za ním! Já hlupák, já mu ponesu psaníčko! Co – co – co mi je vůbec
po ní?
Tu ho napadla spásná myšlenka. Uteku domů, do svého laboratorního baráku tam
nahoře. A ona, ať si sem přijde! ať si pak dělá, co chce! Ať – ať – ať si jede
za ním sama, když… když jí na tom záleží –
Rozhlédl se po pokoji; viděl zválenou postel, zastyděl se a ustlal ji, jak byl
zvyklý doma. Pak se mu nezdála dost slušně ustlaná, přestlal ji, rovnal a
hladil, a pak už rovnal všechno všudy, uklízel, pokoušel se pěkně zřasit i
záclony, načež usedl s hlavou zmotanou a hrudí drcenou bolestným tlakem a
čekal.


V.

Zdálo se mu, že jde ohromnou zelinářskou zahradou; kolem dokola nic než samé
zelné hlávky, ale nejsou to hlávky, nýbrž zešklebené a olezlé, krhavé a
blekotající, nestvůrné, vodnaté, trudovité a vyboulené hlavy lidské; vyrůstají
z hubených košťálů a lezou po nich odporné zelené housenky. A hle, přes pole k
němu běží dívka se závojem na tváři; zvedá trochu sukni a přeskakuje lidské
hlávky. Tu vyrůstají zpod každé z nich nahé, úžasně tenké a chlupaté ruce a
sahají jí po nohou a po sukních. Dívka křičí v šílené hrůze a zvedá sukni
výše, až nad silná kolena, obnažuje bílé nohy a snaží se přeskočit ty
chňapající ruce. Prokop zavírá oči; nesnese pohled na její bílé silné nohy, a
šílí úzkostí, že ji ty zelné hlávky zhanobí. Tu vrhá se na zem a uřezává
kapesním nožem první hlávku; ta zvířecky ječí a cvaká mu vyžranými zuby po
rukou. Nyní druhá, třetí hlávka; Kriste Ježíši, kdy skosí to ohromné pole, než
se dostane k dívce zápasící tam na druhé straně nekonečné zahrady? Zběsile
vyskakuje a šlape po těch příšerných hlavách, rozdupává je, kope do nich;
zaplete se nohama do jejich tenkých, přísavných pracek, padá, je uchopen,
rván, dušen, a vše mizí.
Vše mizí v závratném víření. A náhle se ozve zblízka zastřený hlas: „Nesu vám
ten balíček.“ Tu vyskočil a otevřel oči, a před ním stojí děvečka z Hybšmonky,
šilhavá a těhotná, se zmáčeným břichem, a podává mu cosi zabaleného v mokrém
hadru. To není ona, trne bolestně Prokop, a rázem vidí vytáhlou smutnou
prodavačku, která mu dřevěnými tyčinkami roztahuje rukavice. To není ona,
brání se Prokop, a vidí naduřelé dítě na křivičných nožkách, jež – jež – jež
se mu nestoudně nabízí! „Jdi pryč,“ křičí Prokop, a tu se mu zjeví pohozená
konev uprostřed záhonu povadlé a slimáky prolezlé kapusty a nemizí přes
všechno jeho úsilí.
Vtom tiše zazněl zvonek jako tiknutí ptáčka. Prokop se vrhl ke dveřím a
otevřel; na prahu stála dívka se závojem, tiskla k ňadrům balíček a
oddychovala. „To jste vy,“ řekl Prokop tiše a (neznámo proč) nesmírně dojat.
Dívka vešla, dotkla se ho ramenem; její vůně dechla na Prokopa trýznivým
opojením.
Zůstala stát uprostřed pokoje. „Prosím vás, nehněvejte se,“ mluvila tiše a
jakoby spěchajíc, „že jsem vám dala takové poslání. Vždyť ani nevíte, proč –
proč já – Kdyby vám to dělalo nějaké potíže –“
„Pojedu,“ vypravil ze sebe Prokop chraptivě.
Dívka upřela na něj zblízka své vážné, čisté oči. „Nemyslete si o mně nic
zlého. Já mám jenom strach, aby pan… aby váš přítel neudělal něco, co by
někoho… někoho jiného do smrti trápilo. Já mám k vám tolik důvěry… Vy ho
zachráníte, že?“
„Nesmírně rád,“ vydechl Prokop nějakým nesvým a rozechvěným hlasem; tak ho
opojovalo nadšení. „Slečno, já… co budete chtít…“ Odvracel oči; bál se, že
něco vybleptne, že je snad slyšet, jak mu bouchá srdce, a styděl se za svou
těžkopádnost.
I dívku zachvátil jeho zmatek; hrozně se zarděla a nevěděla kam s očima.
„Děkuju, děkuju vám,“ pokoušela se také jaksi nejistým hlasem, a silně mačkala
v rukou zapečetěný balíček. Nastalo ticho, jež působilo Prokopovi sladkou a
mučivou závrať. Cítil s mrazením, že dívka letmo zkoumá jeho tvář; a když k ní
náhle obrátil oči, viděl, že se dívá k zemi a čeká, připravena, aby snesla
jeho pohled. Prokop cítil, že by měl něco říci, aby zachránil situaci; místo
toho jen hýbal rty a chvěl se na celém těle.
Konečně pohnula dívka rukou a zašeptala: „Ten balíček –“ Tu zapomněl Prokop,
proč schovává pravou ruku za zády, a sáhl po tlusté obálce. Dívka zbledla a
couvla. „Vy jste poraněn,“ vyhrkla. „Ukažte!“ Prokop honem schovával ruku. „To
nic není,“ ujišťoval rychle, „to… to se mi jen trochu zanítila… zanítila
taková ranka, víte?“
Dívka, docela bledá, zasykla, jako by sama cítila tu bolest. „Proč nejdete k
lékaři?“ řekla prudce. „Vy nemůžete nikam jet! Já… já pošlu někoho jiného!“
„Vždyť už se to hojí,“ bránil se Prokop, jako by mu brali něco drahého.
„Jistě, to už je… skoro v pořádku, jen škrábnutí, a vůbec, to je nesmysl; proč
bych nejel? A pak, slečno, v takové věci… nemůžete poslat cizího člověka,
víte? Vždyť to už ani nebolí, hleďte,“ a zatřepal pravou rukou.
Dívka stáhla obočí přísnou soustrastí. „Vy nesmíte jet! Proč jste mi to
neřekl? Já – já – já to nedovolím! Já nechci –“
Prokop byl docela nešťasten. „Hleďte, slečno,“ spustil horlivě, „to jistě nic
není; já jsem na to zvyklý. Podívejte se, tady,“ a ukázal jí levou ruku, kde
mu scházel skoro celý malík a kloub ukazováčku naduřel uzlovitou jizvou. „To
už je takové řemeslo, víte?“ Ani nepozoroval, že dívka couvá s blednoucími rty
a dívá se na pořádný šrám jeho čela od oka k vlasům. „Udělá to prásk, a je to.
Jako voják. Zvednu se a běžím útokem dál, rozumíte? Nic se mně nemůže stát.
Nu, dejte sem!“ Vzal jí z ruky balíček, vyhodil do výše a chytil. „Žádná
starost, pane. Pojedu jako pán. Víte, já, já už jsem dávno nikde nebyl. Znáte
Ameriku?“
Dívka mlčela a hleděla na něho se zachmuřeným obočím.
„Ať si říkají, že mají nové teorie,“ drmolil Prokop horečně; „počkejte, já jim
to dokážu, až vyjdou mé výpočty. Škoda že tomu nerozumíte; já bych vám to
vyložil, vám věřím, vám věřím, ale jemu ne. Nevěřte mu,“ mluvil naléhavě,
„mějte se na pozoru. Vy jste tak krásná,“ vydechl nadšeně. „Tam nahoře já
nikdy s nikým nemluvím. Je to jen taková bouda z prken, víte? Haha, vy jste se
tak bála těch hlávek! Ale já vás nedám, o to nic; nebojte se ničeho. Já vás
nedám.“
Pohlížela na něho s očima rozšířenýma hrůzou. „Vy přece nemůžete odejet!“
Prokop zesmutněl a zmalátněl. „Ne, na to nesmíte dát, co mluvím. Povídal jsem
nesmysly, že? Já jsem jenom chtěl, abyste nemyslela na tu ruku. Abyste se
nebála. To už přešlo.“ – Přemohl své vzrušení, byl tuhý a zakaboněný samým
soustředěním. „Pojedu do Týnice a najdu Tomše. Dám mu ten balíček a řeknu, že
to posílá slečna, kterou zná. Je to tak správně?“
„Ano,“ řekla dívka váhavě, „ale vy přece nemůžete –“
Prokop se pokusil o prosebný úsměv; jeho těžká, rozjizvená tvář náhle docela
zkrásněla. „Nechte mne,“ řekl tiše, „vždyť je to – je to – pro vás.“
Dívka zamžikala očima; bylo jí skoro do pláče prudkým pohnutím. Mlčky kývla a
podávala mu ruku. Zvedl svou beztvarou levici; pohlédla na ni zvědavě a silně
ji stiskla. „Já vám tolik děkuju,“ řekla rychle, „sbohem!“
Ve dveřích se zastavila a chtěla něco říci; mačkala v ruce kliku a čekala –
„Mám mu… vyřídit… pozdrav?“ optal se Prokop s křivým úsměvem.
„Ne,“ vydechla a rychle na něj pohlédla. „Na shledanou.“
Dveře za ní zapadly. Prokop se na ně díval, bylo mu najednou na smrt těžko a
chabě, hlava se mu točila, a stálo ho nesmírné usilí, aby učinil jediný krok.


VI.

Na nádraží bylo mu čekati půldruhé hodiny. Sedl si na chodbě a chvěl se zimou.
V poraněné ruce mu pulsovala ukrutná bolest; zavíral oči, a tu se mu zdálo, že
ta bolavá ruka roste, že je veliká jako hlava, jako tykev, jako hrnec na
vyváření prádla, a že v celém jejím rozsahu palčivě cuká živé maso. Přitom mu
bylo mdlo k dávení a na čele mu ustavičně vyrážel studený pot úzkosti. Nesměl
se podívat na špinavé, poplivané, zablácené dlážky chodby, aby se mu nezvedal
žaludek. Vyhrnul si límec a polo snil, pomalu přemáhán nekonečnou
lhostejností. Zdálo se mu, že zas je vojákem a leží poraněn v širém poli; kde
– kde to pořád bojují? Tu zazněl mu do uší prudký zvon a někdo volal: „Týnice,
Duchcov, Moldava, nastupovat!“
Nyní už tedy sedí ve vagóně u okna a je mu nezřízeně veselo, jako by někoho
přelstil nebo někomu utekl; teď, holenku, už jedu do Týnice a nic mne nemůže
zadržet. Skoro se chechtal radostí, uvelebil se ve svém koutě a s náramnou
čilostí pozoroval své spolucestující. Naproti němu sedí nějaký krejčík s
tenkým krkem, hubená černá paní, pak člověk s divně bezvýraznou tváří; vedle
Prokopa strašně tlustý pán, kterému se nemůže nějak břicho vejít mezi nohy, a
snad ještě někdo, to už je jedno. Prokop se nesmí dívat z okna, protože mu to
dělá závrať. Ratata ratata ratata vybuchuje vlak, vše drnčí, bouchá, otřásá se
samou horlivostí spěchu. Krejčíkovi se klátí hlava napravo nalevo, napravo
nalevo; černá paní jaksi podivně a ztuhle hopkuje na místě, bezvýrazná tvář se
třese a kmitá jako špatný snímek ve filmu. A tlustý soused, to je kupa rosolu,
jež se houpe, otřásá, poskakuje nesmírně směšným způsobem. Týnice, Týnice,
Týnice, skanduje Prokop s údery kol; rychleji! rychleji! Vlak se ohřál samým
chvatem, je tu horko, Prokop se potí žárem; krejčík má nyní dvě hlavy na dvou
tenkých krcích, obě hlavy se třesou a narážejí na sebe, až to drnčí. Černá
paní výsměšně a urážlivě hopkuje na svém sedadle; tváří se naschvál jako
dřevěná loutka. Bezvýrazná tvář zmizela; sedí tam trup s rukama mrtvě
složenýma na klíně, ruce neživě poskakují, ale trup je bezhlavý.
Prokop sbírá všechny své síly, aby se na to pořádně podíval; štípe se do nohy,
ale nic platno, trup je dál bezhlavý a mrtvě se poddává otřesům vlaku.
Prokopovi je z toho děsně úzko; šťouchá loktem tlustého souseda, ale ten se
jen rosolovitě chvěje, a Prokopovi se zdá, že se mu to tlusté tělo bezhlase
chechtá. Nemůže se už na to dívat; obrací se k oknu, ale tam zničehonic vidí
lidskou tvář. Neví zprvu, co je na ní tak zarážejícího; pozoruje ji
vytřeštěnýma očima a poznává, že to je jiný Prokop, který na něho upírá oči s
děsivou pozorností. Co chce? zhrozil se Prokop. Proboha, nezapomněl jsem ten
balíček v Tomšově bytě? Hmatá honem po kapsách a najde obálku v náprsní kapse.
Tu se tvář v okně usmála a Prokopovi se ulevilo. Odvážil se dokonce pohlédnout
na bezhlavý trup; a vida, on si ten člověk jen přetáhl pověšený svrchník přes
hlavu a spí pod ním. Prokop by to udělal také, ale bojí se, aby mu někdo
nevytáhl z kapsy tu zapečetěnou obálku. A přece jde na něho spaní, je
nesnesitelně unaven; nikdy by si nedovedl představit, že je možno být tak
unaven. Usíná, vyrve se z toho vytřeštěně a opět usíná. Černá paní má jednu
hopkující hlavu na ramenou a druhou drží na klíně oběma rukama; a co se
krejčíka týče, sedí místo něho jen prázdné, beztělé šaty, z nichž čouhá
porcelánová palička. Prokop usíná, ale pojednou se z toho vytrhne v horlivé
jistotě, že je v Týnici; snad to někdo venku volal, neboť vlak stojí.
Vyběhl tedy ven a viděl, že už je večer; dva tři lidé vystupují na malinkém
blikajícím nádraží, za nímž je neznámá a mlhavá tma. Řekli Prokopovi, že do
Týnice musí jet poštou, je-li na ní ještě místo. Poštovní vůz, to byl jen
kozlík a za ním truhlík na zásilky; a na kozlíku už seděl pošťák a nějaký
pasažér.
„Prosím vás, vemte mne do Týnice,“ řekl Prokop.
Pošťák potřásl hlavou v nekonečném smutku. „Nejde,“ odpověděl po chvíli.
„Proč… jak to?“
„Není už místo,“ řekl pošťák zrale.
Prokopovi vstoupily do očí slzy samou lítostí. „Jak je tam daleko… pěšky?“
Pošťák účastně přemýšlel. „No, hodinu,“ řekl.
„Ale já… nemohu jít pěšky! Já musím k doktoru Tomšovi!“ protestoval Prokop
zdrcen.
Pošťák uvažoval. „Vy jste… jako… pacient?“
„Mně je zle,“ zamumlal Prokop; skutečně se chvěl slabostí a zimou.
Pošťák přemýšlel a potřásal hlavou. „Když to nejde,“ ozval se konečně.
„Já se vejdu, já… kdyby byl jen kousek místa, já…“
Na kozlíku ticho; jen pošťák se drbal ve vousech, až to chrastělo; pak neřekl
slova a slezl, dělal něco na postraňku a mlčky odešel do nádraží. Pasažér na
kozlíku se ani nepohnul.
Prokop byl tak vyčerpán, že si musel sednout na patník. Nedojdu, cítil
zoufale; zůstanu tady, až… až…
Pošťák se vracel z nádraží a nesl prázdnou bedničku. Nějak ji vpravil na
plošinu kozlíku a rozvážně ji pozoroval. „Tak si tam sedněte,“ řekl posléze.
„Kam?“ ptal se Prokop.
„No… na kozlík.“
Prokop se dostal na kozlík tak nadpřirozeně, jako by ho vynesly nebeské síly.
Pošťák zas dělal cosi na řemení, a teď sedí na bedničce s nohama visícíma dolů
a bere opratě. „Hý,“ povídá.
Kůň nic. Jenom se zachvěl.
Pošťák nasadil jakési tenké, hrdelní „rrr“. Kůň pohodil ocasem a pustil
hlasitý pšouk.
„Rrrrr.“
Pošta se rozjela. Prokop se křečovitě chytil nízkého zábradlíčka; cítil, že je
nad jeho síly udržet se na kozlíku.
„Rrrrr.“ Zdálo se, že ten vysoký hrčivý zpěv nějak galvanizuje starého koně.
Běžel kulhavě, pohazoval ocasem a při každém kroku pouštěl slyšitelné větry.
„Rrrrrrrr.“ Šlo to alejí holých stromů; byla černočerná tma, jen kmitavý
proužek světla z lucerny se smýkal po blátě. Prokop ztuhlými prsty svíral
zábradlíčko; cítil, že už vůbec nevládne svému tělu, že nesmí spadnout, že
bezmezně slábne. Nějaké osvětlené okno, alej, černá pole. „Rrrr.“ Kůň vytrvale
pšukal a klusal pleta nohama toporně a nepřirozeně, jako by byl už dávno
mrtev.
Prokop se úkosem podíval na svého spolucestujícího. Byl to děda s krkem
ovázaným šálou; pořád něco žvýkal, překusoval, žmoulal a zase vyplivoval. A tu
si Prokop vzpomněl, že tu podobu už viděl. Byla to ta ohavná tvář ze sna, jež
skřípala vyžranými zuby, až se drtily, a pak je po kouskách vyplivovala. Bylo
to divné a strašné.
„Rrrrr.“ Silnice se obrací, motá se do kopce a zase dolů. Nějaký statek, je
slyšet psa, člověk jde po silnici a povídá „dobrý večer“. Domků přibývá, jde
to do kopce. Pošta zatáčí, vysoké „rrrr“ náhle ustane a kůň se zastaví.
„Tak tady bydlí doktor Tomeš,“ povídá pošťák.
Prokop chtěl něco říci, ale nemohl; chtěl se pustit zábradlí, ale nešlo to,
protože mu prsty křečovitě ztuhly.
„No, už jsme tady,“ povídá pošťák znovu. Ponenáhlu křeče povolí a Prokop slézá
z kozlíku, chvěje se na celém těle. Jakoby popaměti otvírá vrátka a zvoní u
dveří. Uvnitř zuřivý štěkot, a mladý hlas volá: „Honzíku, ticho!“ Dveře se
otevrou, a stěží hýbaje jazykem ptá se Prokop: „Je pan doktor doma?“
Chvilku ticho; pak řekl mladý hlas: „Pojďte dál.“
Prokop stojí v teplé světnici; na stole je lampa a večeře, voní to bukovým
dřívím. Starý pán s brejličkami na čele vstává od svého talíře, jde k
Prokopovi a povídá: „Tak copak vám schází?“
Prokop se mračně upomínal, co tu vlastně chce. „Já… totiž…,“ začal, „je váš
syn doma?“
Starý pán se pozorně díval na Prokopa. „Není. Co vám je?“
„Jirka… Jiří,“ m ručel Prokop, „já jsem… jeho přítel a nesu mu… mám mu dát…“
Lovil v kapse zapečetěnou obálku. „Je to… důležitá věc a… a…“
„Jirka je v Praze,“ přerušil ho starý pán. „Člověče, sedněte si aspoň!“
Prokop se nesmírně podivil. „Vždyť říkal… říkal, že jede sem. Já mu musím
dát…“ Podlaha se pod ním zakymácela a počala se naklánět.
„Aničko, židli,“ křikl starý pán podivným hlasem.
Tu ještě zaslechl Prokop tlumený výkřik a poroučel se na zem. Zalila ho
nesmírná temnota, a pak již nebylo nic.


VII.

Nebylo nic; jen jako kdyby se časem protrhly mlhy, zjevil se vzorek malované
stěny, řezaná římsa skříně, cíp záclony či frýzek stropu; nebo se naklonila
nějaká tvář jakoby nad otvorem studně, ale nebylo vidět jejích rysů. Něco se
dělo, někdo časem svlažil horké rty nebo pozvedal bezvládné tělo, ale vše
mizelo v plynoucích útržcích snění. Byly to krajiny, kobercové vzory,
diferenciální počty, ohnivé koule, chemické formule; jen časem něco vyplulo
navrch a stalo se na okamžik jasnějším snem, aby se to vzápětí zas rozplynulo
v širokotokém bezvědomí.
Konečně přišla chvíle, kdy procitl; viděl nad sebou teplý a bezpečný strop se
štukovým frýzkem; našel očima své vlastní hubené, mrtvě bílé ruce na květované
přikrývce; za nimi objevil pelest postele, skříň a bílé dveře: vše nějak milé,
tiché a už známé. Neměl ponětí, kde je; chtěl o tom uvažovat, ale měl nemožně
slabou hlavu, vše se mu opět počalo mást, i zavřel oči a odpočíval v odevzdané
chabosti.
Dveře tichounce zavrzly. Prokop otevřel oči a posadil se na posteli, jako by
ho něco zvedlo. A ono u dveří stojí děvče, vytáhlé nějak a světlé, má
jasňoučké oči náramně udivené, ústa pootevřená překvapením a tiskne k prsoum
bílé pláténko. Nehýbe se rozpačitá, mrká dlouhými řasami a její růžový čumáček
se počíná nejistě, plaše usmívat.
Prokop se zachmuřil; usilovně hleděl něco říci, ale měl v hlavě docela
prázdno; hýbal nehlasně rty a pozoroval dívku jaksi přísnýma a vzpomínavýma
očima.
„Gúnúmai se, anassa,“ splynulo mu náhle a bezděčně se rtů, „theos ny tis é
brotos essi? Ei men tis theos essi, toi úranon euryn echúsin, Artemidi se egó
ge, Dios kúré megaloio, eidos te megethos te fyén t’anchista eďskó.“ A dále,
verš za veršem, řinulo se božské pozdravení, jímž Odysseus oslovil Nausikau.
„Proboha prosím tě, paní! Jsi božstvo či smrtelný člověk? Jestližes některá z
bohyň, co sídlí na nebi širém, s Artemidou bych já, jež velkého Dia je dcera,
krásou a vzrůstem těla i velkostí nejspíš tě srovnal. Jsi-li však některá z
lidí, co mají na zemi sídlo, třikrát blaženi jsou tvůj otec i velebná matka,
třikrát blaženi bratři, neb jistě jim nadmíru srdce pokaždé rozkoší blahou se
pro tebe rozhřívá v hrudi, kdykoli zří, jak takový květ jde do kola k tanci.“
Dívka bez hnutí, jako zkamenělá, naslouchala tomuto po. zdravu v neznámé řeči;
a na jejím hladkém čele bylo tolik zmatku, její oči tak dětsky a polekaně
mžikaly, že Prokop zdvojnásobil horlivost Odyssea na břeh vyvrženého, sám jer
nejasně chápaje smysl slov.
„Keinos ďau peri kéri makartatos,“ odříkával rychle. „Avšak nad jiné ten se
pocítí blaženým v srdci, který zvítězí dary a tebe si odvede domů, neboť dosud
nikdy jsem takého člověka nezřel ze všech mužů ni žen; já s úžasem na tebe
hledím.“
Sebas m’echei eisoroónta. Děvče se silně zardělo, jako by rozumělo pozdravu
řeckého hrdiny; neobratný a líbezný zmatek jí vázal údy, a Prokop, spínaje
ruce na pokrývce, mluvil, jako by se modlil.
„Déló dé pote,“ pokračoval spěšně, „jenom na Délu jednou, blíž oltáře jasného
Foiba, palmový mladý strůmek jsem viděl ze země růsti, – neboť i tam jsem
přišel a množství lidu šlo se mnou na cestě té, z níž trampoty zlé mi vzejíti
měly. Tam jsem právě tak stál, pln úžasu, když jsem jej viděl, dlouho, vždyť
takový kmen se nezrodil ze země dosud. Tak teď tobě se divím a žasnu a bojím
se hrozně dotknout se kolenou tvých, ač velký smutek mě tísní.“
Deidia ďainós: ano, bál se hrozně, ale i dívka se bála a tiskla k prsoum bílé
prádlo a neodvracela očí z Prokopa, jenž chvátal vypovědět svou trýzeň:
„Včera, až v dvacátý den, jsem ušel třpytnému moři, do doby té jsem vlnou byl
hnán a prudkými větry od výspy Ógygie, teď sem mě zas uvrhlo božstvo, abych tu
též snad zakusil strast, vždyť sotva se, tuším, skončí, a množství běd mi
bohové přisoudí ještě.“
Prokop těžce vzdychl a pozvedl úděsně vyhublé ruce. „Alla, anass‘, eleaire!
Avšak slituj se, paní, vždyť vytrpěv útrapy mnohé, nejdřív přišel jsem k tobě
– z těch druhých nikoho neznám lidí, co v krajině té a v městě své obydlí
mají. Do města cestu mi ukaž, dej roucho, bych tělo si zakryl, jestližes
vzala, sem jdouc, snad nějaký na prádlo obal.“
Nyní se dívčí tvář poněkud vyjasnila, vlahé rty se pootevřely; snad Nausikaá
promluví, ale Prokop chtěl jí ještě požehnati za ten obláček líbezného
soucitu, kterým růžovělo její líčko. „Soi de theoi tosa doien, hosa fresi sési
menoinás: bozi pak račte ti dát, čeho ve své mysli si žádáš, muže i dům, a
přidejtež vám i svorného ducha, vzácný to dar, – vždyť lepšího nic ni krasšího
není, než když smýšlením svorni svou domácnost společně vedou žena i muž, jak
odpůrcům v žal, tak na radost velkou všechněm příznivcům svým, a nejvíc to
pocítí sami.“ [* Překlad O. Vaňorného (1921)]
Poslední slova Prokop už skoro jen dýchal; sám stěží rozuměl tomu, co
odříkává, vytékalo to plynně a bez vůle z nějakého neznámého kouta paměti;
bylo tomu skoro dvacet let, co se jakžtakž probíral sladkou melodií šestého
zpěvu. Působilo mu až fyzickou úlevu nechávat to volně odtékat; dělalo se mu v
hlavě lehčeji a jasněji, bylo mu skoro blaženě v té plihé a libé slabosti, a
tu se mu zachvěl na rtech rozpačitý úsměv.
Dívka se usmála, pohnula sebou a řekla: „Nu tak?“ Udělala krůček blíž a dala
se do smíchu. „Co jste to povídal?“
„Já nevím,“ děl Prokop nejistě.
Tu se rozlétly nedovřené dveře a do pokoje vrazilo něco malého a chundelatého,
kviklo radostí a skočilo Prokopovi na postel.
„Honzíku,“ křikla dívka polekaně, „jdeš dolů!“ Ale psisko už olízlo Prokopovu
tvář a v náruživé radosti se zachumlávalo do přikrývek. Prokop si sáhl na
tvář, aby se otřel, a s úžasem pocítil pod rukou plnovous. „Co-copak,“ koktal
a umlkl údivem. Psisko bláznilo; kousalo s překypující něhou Prokopovy ruce,
pištělo, funělo, a tumáš! mokrou mordou se mu dostalo až na prsa.
„Honzíku,“ křičela dívka, „ty jsi blázen! Necháš pána!“ Přiběhla k posteli a
vzala psíka do náruče. „Bože, Honzíku, ty jsi hlupák!“
„Nechte ho,“ žádal Prokop.
„Vždyť máte bolavou ruku,“ namítalo děvče s velikou vážností, tisknouc k
prsoum zápasícího psa.
Prokop se podíval nechápavě na svou pravici. Od palce přes dlaň táhla se
široká jizva, pokrytá novou, tenoučkou, červenou kožkou příjemně svědící.
„Kde… kde to jsem?“ podivil se.
„U nás,“ řekla s náramnou samozřejmostí, jež Prokopa ihned uspokojila. „U
vás,“ opakoval s úlevou, ač neměl ponětí, kde to je. „A jak dlouho?“
„Dvacátý den. A pořád –,“ chtěla něco říci, ale spolkla to. „Honzík spával s
vámi,“ dodala spěšně a zarděla se neznámo proč, chovajíc psa jako malé dítě.
„Víte o tom?“
„Nevím,“ vzpomínal Prokop. „Copak jsem spal?“
„Pořád,“ vyhrkla. „Už jste se mohl vyspat.“ Tu postavila psa na zem a
přiblížila se k posteli. „Je vám líp?… Chtěl byste něco?“
Prokop zakroutil hlavou; nevěděl o ničem, co by chtěl. „Kolik je hodin?“ ptal
se nejistě.
„Deset. Já nevím, co smíte jíst; až přijde tati… Tati bude tak rád… Chtěl
byste něco?“
„Zrcadlo,“ řekl Prokop váhavě.
Dívka se zasmála a vyběhla. Prokopovi hučelo v hlavě; pořád se hleděl
rozpomenout a pořád mu vše unikalo. A už je tu děvče, něco povídá a podává mu
zrcátko. Prokop chce zvednout ruku, ale bůhsámví proč to nejde; děvče mu
vkládá držadlo mezi prsty, ale zrcátko padá na pokrývku. Tu zbledlo děvče,
nějak se znepokojilo a samo mu nastavilo zrcadlo k očím. Prokop se dívá, vidí
docela zarostlé tváře a obličej skoro neznámý; hledí a nemůže pochopit, a tu
se mu roztřásly rty.
„Lehněte si, hned si zas lehněte,“ káže mu drobounký hlásek skoro plačící, a
rychlé ruce mu nastavují podušku. Prokop se sváží naznak a zavírá oči; jen
chvilinku si zdřímnu, myslí si, a udělalo se libé, hluboké ticho.


VIII.

Někdo ho zatahal za rukáv. „Nu, nu,“ povídá ten někdo, „už bychom nemuseli
spát, co?“ Prokop otevřel oči a viděl starého pána, má růžovou pleš a bílou
bradu, zlaté brejličky na čele a náramně čilý koukej. „Už nespěte, velectěný,“
povídá, „už toho je dost; nebo se probudíte na onom světě.“
Prokop si chmurně prohlížel starého pána; chtělo se mu totiž dřímat. „Co
chcete?“ ozval se vzdorovitě. „A… s kým mám tu čest?“
Starý pán se dal do smíchu. „Prosím, doktor Tomeš. Vy jste mne neráčil dosud
vzít na vědomí, co? Ale nic si z toho nedělejte. Tak co, jak se máme?“
„Prokop,“ ozval se nemocný nevlídně.
„Tak, tak,“ povídal doktor spokojeně. „A já jsem si myslel, že jste Šípková
Růženka. A teď, pane inženýre,“ řekl čile, „se na vás musíme podívat. No,
neškareďte se.“ Vyeskamotoval mu z podpaží teploměr a libě zachrochtal.
„Třicet pět osm. Človíčku, vy jste jako moucha. Musíme vás nakrmit, co?
Nehýbejte se.“
Prokop cítil na prsou hladkou pleš a studené ucho, jak mu jezdí od ramene k
rameni, od břicha k hrdlu za povzbuzujícího broukání.
„No, sláva,“ řekl konečně doktor a nasadil si brejle na oči. „Napravo vám to
drobátko rachotí, a srdce – no, to se urovná, že?“ Naklonil se k Prokopovi,
drbal ho prsty ve vlasech a přitom mu palcem zvedal a zase zatlačoval oční
víčka. „Nespat už, víme?“ mluvil a přitom mu něco zkoumal na zorničkách.
„Dostaneme knížky a budeme číst. Sníme něco, vypijeme skleničku vína a –
nehýbejte se! Já vás neukousnu.“
„Co mně je?“ ptal se Prokop nesměle.
Doktor se vztyčil. „No, nic už. Poslechněte, kde jste se tady vzal?“
„Kde tady?“
„Tady, v Týnici. Sebrali jsme vás na podlaze a… Odkud jste, člověče, přišel?“
„Já nevím. Z Prahy, ne?“ vzpomínal Prokop.
Doktor potřásl hlavou. „Vlakem z Prahy! Se zápalem mozkových blan! Měl jste
rozum? Víte, co to vůbec je?“
„Co?“
„Meningitis. Spací forma. A k tomu zápal plic. Čtyřicet celých, he? Kamaráde,
s něčím takovým se nejezdí na výlety. A víte, že – nu, ukažte honem pravou
ruku!“
„To… to bylo jen škrábnutí,“ hájil se Prokop.
„Pěkné škrábnutí. Otrava krve, rozumíte? Až budete zdráv, řeknu vám, že jste
byl… že jste byl osel. Odpusťte,“ řekl s důstojným rozhořčením, „málem bych
byl řekl něco horšího. Vzdělaný člověk, a neví, že toho má v sobě na trojí
exitus! Jak jste se vůbec mohl držet na nohou?“
„Já nevím,“ šeptal Prokop zahanbeně.
Doktor chtěl hubovat dál, ale zavrčel jen a mávl rukou. „A jak se cítíte?“
začal přísně. „Trochu pitomý, ne? Žádná paměť, co? A tady, tady nějak,“ ťukal
si na čelo, „nějaký slabý, že?“
Prokop mlčel.
„Tak tedy, pane inženýre,“ spustil doktor. „Z toho si nic nedělat. Nějaký
čásek to potrvá, co? Rozumíte mi? Nesmíte si namáhat hlavu. Nemyslet. To se
vrátí… po kouskách. Jen přechodná porucha, slabá amence, rozumíte mi? To
přejde samo od sebe, co? Rozumíte mi?“
Doktor křičel, potil se a rozčiloval se, jako by se hádal s hluchoněmým.
Prokop se na něj pozorně díval, a ozval se klidně: „Já tedy zůstanu
slabomyslný?“
„Ale ne, ne,“ rozčiloval se doktor. „Naprosto vyloučeno. Ale prostě… po
nějakou dobu… porucha paměti, roztržitost, únava a takové ty příznaky,
rozumíte mi? Poruchy v koordinaci, chápete? Odpočívat. Klid. Nic nedělat.
Velectěný, děkujte pánubohu, že jste to vůbec přečkal.“
„Přečkal,“ ozval se po chvíli a radostně zatroubil do kapesníku. „Poslechněte,
takový případ jsem ještě neměl. Vy jste sem přišel pěkně v deliriu, praštil
jste sebou na zem, a finis, poroučím se vám. Co jsem měl s vámi dělat? Do
nemocnice je daleko, a holka nad vámi tento, brečela… a vůbec, přišel jste
jako host k… Jirkovi, k synovi, no ne? Tak jsme si vás tu nechali, rozumíte
mi? Nu, nám to nevadí. Ale takového zábavného hosta jsem ještě neviděl. Dvacet
dní prospat, pěkně děkuju! Když vám kolega primář řezal ruku, ani jste se
neráčil probudit, co? Tichý pacient, namouduši. No, to už je jedno. Jen když
jste z toho venku, člověče.“ Doktor se plácl hlučně do stehna. „U čerta,
nespěte už! Pane, hej, pane, mohl byste usnout nadobro, slyšíte? U všech
všudy, hleďte se trochu přemáhat! Nechte toho, slyšíte?“
Prokop chabě kývl; cítil, že se nějaké závoje přetahují mezi ním a
skutečností, že se vše obestírá, kalí a tichne.
„Andulo,“ slyšel zdáli rozčilený hlas, „víno! dones víno!“ Nějaké rychlé
kroky, hovor jakoby pod vodou, a chladivá chuť vína mu stékala do hrdla.
Otevřel oči a viděl nad sebou skloněné děvče. „Nesmíte spát,“ povídá děvče
rozechvěně, a její předlouhé řasy mžikají, jako když srdce tluče.
„Já už nebudu,“ omlouvá se Prokop pokorně.
„To bych si vyprosil, velectěný,“ lomozil doktor u pelestě. „Přijede sem z
města primář extra na konzultaci; ať vidí, že my felčaři venku taky něco
umíme, no ne? Musíte se pěkně držet.“ S neobyčejnou obratností zvedl Prokopa a
shrnul mu za záda polštáře. „Tak, teď bude pán sedět; a spaní si nechá až po
obědě, že? Já musím do ordinace. A ty, Ando, si tady sedni a něco žvaň; jindy
ti huba jede jako trakař, co? A kdyby chtěl spát, zavolej mne; já už si to s
ním vyřídím.“ Ve dveřích se obrátil a zavrčel: „Ale… mám radost, rozumíte? Co?
Tak pozor!“
Prokopovy oči se svezly na dívku. Seděla opodál, ruce v klíně, a při bohu
nevěděla, o čem mluvit. Tak, teď zvedla hlavu a pootevřela ústa; slyšme, co z
ní vyletí; ale zatím se jenom zastyděla, spolkla to a sklopila hlavu ještě
níž; je vidět jen dlouhé řasy, jak se chvějí nad líčkem.
„Tati je tak prudký,“ ozvala se konečně. „On je tak zvyklý křičet… vadit se… s
pacienty…“ Látka jí bohužel došla; zato – jako na zavolanou – ocitla se jí v
prstech zástěra a nechala se dlouho a všelijak zajímavě skládat, za pozorného
mžikání ohnutých řas.
„Co to řinčí?“ optal se Prokop po delší době.
Obrátila hlavu k oknu; má pěkné světlé vlasy, jež jí ozařují čelo, a šťavnaté
světélko na vlhké puse. „To jsou krávy,“ povídá s úlevou. „Tam je panský dvůr,
víte? Tenhle dům taky patří k panství. Tati má koně a kočárek… Jmenuje se
Fricek.“
„Kdo?“
„Ten kůň. Vy jste nebyl nikdy v Týnici, že? Tady nic není. Jen aleje a pole…
Dokud byla živa maminka, tak tu bylo veseleji; to sem jezdil náš Jirka… Už tu
nebyl přes rok; pohádal se s tatim a… ani nepíše. Ani se o něm u nás nesmí
mluvit – Vídáte ho často?“
Prokop rozhodně zavrtěl hlavou.
Děvče vzdychlo a zamyslilo se. „On je… já nevím. Takový divný. Jen tu chodil s
rukama v kapsách a zíval… Já vím, že tu nic není; ale přec… Tati je taky rád,
že jste zůstal u nás,“ zakončila rychle a trochu nesouvisle.
Někde venku se chraptivě a směšně rozkřikl mladý kohoutek. Najednou se tam
dole strhlo jakési slepičí rozčilení, bylo slyšet divoké „ko-ko-ko-“ a vítězně
kvikající štěkot psiska. Děvče vyskočilo. „Honzík honí slepice!“ Ale hned si
zase sedla, odhodlána ponechat slípky jejich osudu. Bylo příjemné a jasné
ticho.
„Já nevím, o čem povídat,“ řekla po chvíli s nejkrásnější prostotou. „Já vám
přečtu noviny, chcete?“
Prokop se usmál. A už tu byla s novinami a pustila se odvážně do úvodníku.
Finanční rovnováha, státní rozpočet, nekrytý úvěr… Líbezný a nejistý hlásek
odříkával klidně ty nesmírně vážné věci, a Prokopovi, jenž naprosto
neposlouchal, bylo lépe, než kdyby hluboce spal.


IX.

Nyní už smí Prokop na nějakou hodinku denně vylézt z postele; dosud táhne nohy
všelijak a bohužel není s ním mnoho řeči; říkejte si mu co chcete, většinou
odpoví nějak skoupě a přitom se omlouvá plachým úsměvem.
Dejme tomu v poledne – je teprve začátek dubna – sedává v zahrádce na lavičce;
vedle něho ježatý teriér Honzík se směje na celé kolo pod svými mokrými
fořtovskými vousy, neboť je zřejmě pyšný na svou funkci společníka, a samou
radostí se oblízne a mhouří oči, když ho zjizvená Prokopova levička pohladí po
teplé huňaté hlavě. V tu hodinu obyčejně doktor vyběhne z ordinace, čepička mu
sem tam jezdí po hladké pleši, sedne na bobek a sází zeleninu; tlustými
krátkými prsty rozmílá hrudky prsti a pozorně vystýlá lůžko mladých klíčků. Co
chvíli se začne rozčilovat a bručí; zapíchl někde do záhonku svou lulku a
nemůže ji najít. Tu se Prokop zvedne a s divinací detektiva (neboť čte v
posteli detektivky) zamíří rovnou k ztracené faječce. Čehož Honzík užije k
tomu, aby se hlučně otřepal.
V tu hodinu chodívá Anči (neboť tak a nikoliv Andula si přeje být jmenována)
zalévat tatínkovy záhony. V pravé ruce nese konev, levá plave ve vzduchu;
stříbrná prška šumí do mladé hlíny, a naskytne-li se nablízku Honzík, dostane
ji na zadek nebo na pitomou veselou hlavu; tu zoufale kvikne a hledá ochranu u
Prokopa.
Celé ráno se trousí do ordinace pacienti. Chrchlají v čekárně a mlčí, každý
mysle jen na své utrpení. Někdy se ozve z ordinace strašný křik, když doktor
tahá zub nějakému kloučeti. Tu se zase Anči v panice zachrání k Prokopovi,
bledá a zrovna bez sebe, úzkostně mžiká krásnými řasami a čeká, až strašná
událost přejde. Konečně kluk ubíhá ven s táhlým vytím, a Anči nějak nešikovně
zamlouvá svou útlocitnou zbabělost.
Ovšem něco jiného je, když před doktorovým domem zastaví vůz vystlaný slámou a
dva strejci opatrně vynášejí po schodech těžce raněného člověka. Má rozdrcenou
ruku nebo zlomenou nohu nebo hlavu roztříštěnou kopytem; studený pot se mu
řine po hrozně bledém čele, a tiše, s hrdinným sebepřemáháním sténá. Na celý
dům lehne tragické ticho; v ordinaci se bez hluku odehrává něco těžkého,
tlustá veselá služka chodí po špičkách, Anči má oči plné slz a prsty se jí
třesou. Doktor vrazí do kuchyně, s křikem žádá rum, víno nebo vodu, a
dvojnásobnou hrubostí zakrývá mučivý soucit. A ještě celý den potom nemluví a
vzteká se a bouchá dveřmi.
Ale je také veliký svátek, slavný výroční trh venkovské doktořiny: očkování
dětí. Sta maminek houpá své bečící, řvoucí, spící uzlíčky, je toho plná
ordinace, chodba, kuchyně i zahrádka; Anči je jako blázen, chtěla by chovat,
houpat a převíjet všechny ty bezzubé, uřvané, ochmýřené děti v nadšeném
záchvatu kybelického mateřství. I starému doktorovi se nějak okázaleji svítí
pleš, od rána chodí bez brejlí, aby nepolekal ty haranty, a oči mu plavou
únavou a radostí.
Jindy uprostřed noci rozčileně zařinčí zvonek. Pak bručí ve dveřích nějaké
hlasy, doktor hubuje a kočí Jozef musí zapřahat. Někde ve vsi za svítícím
okénkem přichází na svět nový člověk. Až ráno se doktor vrací, unavený, ale
spokojený, a na deset kroků smrdí karbolem; ale takhle ho má Anči nejraději.
Pak jsou tu ještě jiné osobnosti: tlustá řehtavá Nanda v kuchyni, která po
celý den zpívá a řinčí a ohýbá se smíchem. Dále vážný kočí Jozef s visutými
kníry, historik; čte pořád dějepisné knížky a rád vykládá dejme tomu o
husitských válkách nebo o historických tajemnostech kraje. Dále panský
zahradník, náramný holkář, který denně zaskočí do doktorovy zahrady, očkuje mu
růže, stříhá keře a uvádí Nandu do nebezpečných záchvatů smíchu. Dále zmíněný
chlupatý a rozjařený Honzík, jenž provází Prokopa, honí blechy a slepice a
zmíry rád jezdí na kozlíku doktorova kočárku. Fric, to je starý rap trochu
šedivějící, přítel králíků, rozšafný a dobrosrdečný kůň; pohladit jeho teplé a
citlivé nozdry, to je prostě vrchol příjemnosti. Dále brunátný adjunkt ze
dvora, zamilovaný do Anči, která si z něho ve spojení s Nandou ukrutně střílí.
Ředitel ze dvora, starý lišák a zloděj, jenž chodí s doktorem hrát v šachy;
doktor se rozčiluje, zuří a prohrává. A jiné místní osobnosti, mezi nimiž
neobyčejně nudný a politicky interesovaný civilní geometr otravuje Prokopa
právem kolegiality.
Prokop mnoho čte nebo se tváří, jako by četl. Jeho zjizvená, těžká tvář mnoho
nepovídá, zejména ne o zoufalém a tajném zápasu s porouchanou pamětí. Zvláště
poslední pracovní léta mnoho utrpěla; nejjednodušší vzorce a procesy jsou ty
tam, a na okraji knížek si píše Prokop kusé formule, které se mu vynořují v
hlavě, když na ně nejméně myslí. Pak se sebere a jde hrát s Anči kulečník;
neboť je to hra, při které se mnoho nemluví. I na Anči padá jeho kožená a
neproniknutelná vážnost; hraje soustředěně, míří s přísně staženým obočím, ale
když koule zamíří naschvál jinam, otevře údivem ústa a mokrým jazejčkem jí
ukazuje správnou cestu.
Večery u lampy. Nejvíc toho napovídá doktor, nadšený přírodovědec bez
jakýchkoliv znalostí. Zejména jej okouzlují poslední záhady světa:
radioaktivita, nekonečnost prostoru, elektřina, relativita, původ hmoty a
stáří lidstva. Je zapřisáhlý materialista, a právě proto cítí tajemnou a
sladkou hrůzu neřešitelných věcí. Někdy se Prokop nezdrží a opravuje
büchnerovskou naivitu jeho názorů. Tu starý pán naslouchá přímo pobožně a
počíná si Prokopa nesmírně vážit, zejména tam, kde mu přestává rozumět,
řekněme takhle o rezonančním potenciálu nebo teorii kvant. Anči, ta prostě
sedí opírajíc se bradou o stůl; je sice na tuto pozici už trochu veliká, ale
patrně od maminčiny smrti zapomněla dospívat. Ani nemrká a dívá se velkýma
očima z táty na Prokopa a vice versa.
A noci, noci jsou pokojné a širé jako všude venku. Chvílemi zařinčí z kravína
řetězy, chvílemi se blízko nebo daleko rozštěkají psi; po nebi se mihne
padající hvězda, jarní déšť zašumí v zahradě nebo stříbrným zvukem odkapává
osamělá studna. Čirý, hlubinný chlad vane otevřeným oknem, a člověk usíná
požehnaným spánkem bez vidin.


X.

Nuže, bylo lépe; den za dnem se Prokopovi vracel život drobnými krůčky. Cítil
jen malátnost hlavy, bylo mu stále trochu jako ve snách. Nezbývalo než
poděkovat doktorovi a jeti po svém. Chtěl to ohlásit jednou po večeři, ale
zrovna všichni mlčeli jako zařezaní. A pak vzal starý doktor Prokopa pod paží
a dovedl si ho do ordinace; po nějakém okolkování vyhrkl s rozpačitou
hrubostí, že jako Prokop nemusí odjíždět, ať raději odpočívá, že nemá ještě
vyhráno, a vůbec ať si tu zůstane a dost. Prokop se matně bránil; faktum ovšem
bylo, že se ještě necítil v sedle a že se poněkud rozmazlil. Zkrátka o odjezdu
nebylo zatím řeči.
Vždy odpoledne se doktor zavíral v ordinaci. „Přijďte si někdy ke mně sednout,
co?“ řekl Prokopovi mimochodem. Tak tedy ho Prokop zastihl u všelijakých
lahviček a kelímků a prášků. „Víte, tady v místě není hapatyka,“ vysvětloval
doktor, „já musím sám dělat léky.“ A třesoucími se tlustými prsty dozoval
nějaký prášek na ručních vážkách. Měl nejistou ruku, váhy se mu houpaly a
točily; starý pán se rozčiloval, funěl a potil se na nose drobnými krůpějkami.
„Když na to pořádně nevidím,“ zamlouval stáří svých prstů. Prokop se chvíli
díval, pak neřekl nic a vzal mu vážky z ruky. Klep, klep, a prášek byl na
miligram odvážen. A druhý, třetí prášek. Citlivé vážky jen tančily v
Prokopových prstech. „Ale koukejme, koukejme,“ divil se doktor a s úžasem
sledoval Prokopovy ruce, rozbité, uzlovité, s netvornými klouby, ulámanými
nehty a krátkými pahýly místo několika prstů. „Človíčku, vy máte šikovnost v
těch rukou!“ Za chvíli už Prokop roztíral nějakou masť, odměřoval kapky a
nahříval zkumavky. Doktor zářil a nalepoval viněty. Za půl hodiny byl hotov s
celou lékárnou, a ještě tu byla hromada prášků do zásoby. A po několika dnech
Prokop už zběžně četl doktorovy recepty a bez řečí mu dělal magistra. Bon.
Kdysi kvečeru se dloubal doktor na zahradě v kyprém záhonku. Najednou strašná
rána v domě, a hned nato se s řinkotem sypalo sklo. Doktor se vrhl do domu a
na chodbě se srazil s uděšenou Anči. „Co se stalo?“ volal. „Já nevím,“
vypravilo ze sebe děvče. „To v ordinaci…“ Doktor běžel do ordinace a viděl
Prokopa, jak na všech čtyřech sbírá na podlaze střepy a papíry.
„Co jste tu dělal?“ rozkřikl se doktor.
„Nic,“ řekl Prokop a provinile vstával. „Praskla mně zkumavka.“
„Ale co u všech všudy,“ hromoval doktor a zarazil se: z Prokopovy levice
čurkem stékala krev. „Copak vám to utrhlo prst?“
„Jen škrábnutí,“ protestoval Prokop a schovával levičku za zády.
„Ukažte,“ křikl starý doktor a táhl Prokopa k oknu. Půl prstu viselo jen na
kůži. Doktor se hnal ke skříni pro nůžky, a v otevřených dveřích zahlédl Anči
na smrt bledou. „Co tu chceš?“ spustil. „Marš odtud!“ Anči se nehnula; tiskla
ruce k prsoum a vypadala co nejslibněji na omdlení.
Doktor se vrátil k Prokopovi; nejdřív dělal něco s vatičkou a pak cvakly
nůžky. „Světlo,“ křikl na Anči. Anči se vrhla k vypínači a rozsvítila. „A
nestůj tady,“ hřmotil starý pán a koupal jehlu v benzínu. „Co tu máš co dělat?
Podej sem nitě!“ Anči skočila ke skříni a podala mu ampulku s nitěmi. „A teď
jdi!“
Anči se podívala na Prokopova záda a udělala něco jiného; přistoupila blíž,
chopila oběma dlaněma tu poraněnou ruku a podržela ji. Doktor si zrovna myl
ruce; obrátil se k Anči a chtěl vybuchnout; místo toho zabručel: „Tak, teď drž
pevně! A víc u světla!“
Anči zamhouřila oči a držela. Když nebylo slyšet nic než doktorovo supění,
odvážila se zvednout oči. Dole, kde pracoval otec, to bylo krvavé a ošklivé.
Pohlédla honem na Prokopa; měl odvrácenou tvář, a jeho víčkem cukala bolest.
Anči trnula a polykala slzy a dělalo se jí nanic.
Zatím Prokopova ruka narůstala: spousta vaty, Billrothův batist a snad
kilometr fáče pořád navíjeného; konečně z toho bylo něco ohromného bílého.
Anči držela, kolena se jí třásla, zdálo se jí, že ta strašná operace nikdy
nebude u konce. Najednou se jí zatočila hlava, a pak slyšela, jak otec povídá:
„Na, vypij to honem!“ Otevřela oči a shledala, že sedí v ordinační sesli, že
tati jí podává skleničku s něčím, za ním že stojí Prokop, usmívá se a chová na
prsou zavázanou ruku vypadající jako obrovské poupě. „Tak to vypij,“ naléhal
doktor a jen cenil zuby. Spolkla to tedy a rozkuckala se; byl to vražedný
koňak.
„A teď vy,“ řekl doktor a podal skleničku Prokopovi. Prokop byl trochu bledý a
statečně čekal, že dostane vynadáno. Nakonec se napil doktor, odchrchlal a
spustil: „Tak co jste tu vlastně prováděl?“
„Pokus,“ řekl Prokop s křivým úsměvem provinilce.
„Co? Jaký pokus? S čím pokus?“
„Jen tak. Jen – jen – jde-li něco udělat z chloridu draselnatého.“
„Co udělat?“
„Třaskavina,“ šeptal Prokop v pokoře hříšníka.
Doktor se svezl očima na jeho ofáčovanou ruku. „A to se vám vyplatilo,
člověče! Ruku vám to mohlo utrhnout, co? Bolí? Ale dobře na vás, patří vám
to,“ prohlašoval krvelačně.
„Ale tati,“ ozvala se Anči, „nech ho teď!“
„A co ty tu máš co dělat,“ zavrčel doktor a pohladil ji rukou páchnoucí
karbolem a jodoformem.
Nyní doktor nosil klíč od ordinace v kapse. Prokop si objednal balík učených
svazků, chodil s rukou na pásku a studoval po celé dny. Už kvetou třešně,
lepkavé mladé listí se třpytí ve slunci, zlaté lilie rozvírají těžká poupata.
Po zahrádce chodí Anči s obtloustlou kamarádkou, obě se drží kolem pasu a
smějí se; teď sestrčily k sobě růžové čumáčky, něco si šeptají, zrudnou ve
smíchu a začnou se líbat.
Po létech zase cítí Prokop tělesné blaho. Živočišně se oddává slunci a mhouří
oči, aby naslouchal šumění svého těla. Vzdychne a sedá k práci; ale chce se mu
běhat, toulá se daleko po kraji a věnuje se náruživé radosti dýchat. Někdy
potká Anči v domě či v zahradě a pokouší se něco povídat; Anči se na něj dívá
po očku a neví co mluvit; ale ani Prokop to neví, a proto upadá do bručivého
tónu. Zkrátka je mu lépe nebo se aspoň cítí jistější, je-li sám.
Při studiu pozoroval, že mnoho zanedbal; věda byla už v mnohém dále a jinde,
leckdy se musel nově orientovat; a hlavně se bál vzpomínat na svou vlastní
práci, neboť tam, to cítil, se mu nejvíc potrhala souvislost. Pracoval jako
mezek nebo snil; snil o nových laboratorních metodách, ale zároveň ho lákal
jemný a odvážný kalkul teoretika; a vztekal se sám na sebe, když jeho hrubý
mozek nebyl s to rozštípnout teninký vlas problému. Byl si vědom, že jeho
laboratorní „destruktivní chemie“ otvírá nejpodivnější průhledy do teorie
hmoty; narážel na nečekané souvislosti, ale hned zas je rozšlapal svým příliš
těžkým uvažováním. Rozmrzen praštil vším, aby se ponořil do nějakého hloupého
románu; ale i tam ho pronásledovala laboratorní posedlost: místo slov četl
samé chemické symboly; byly to bláznivé vzorce plné prvků dosud neznámých, jež
ho znepokojovaly i ve snách.


XI.

Té noci se mu zdálo, že studuje veleučený článek v The Chemist. Zarazil se u
vzorce AnCi a nevěděl si s ním rady; hloubal, kousal se do kloubů a najednou
pochopil, že to znamená Anči. A vida, ona je vlastně tady a posmívá se mu s
pažema založenýma za hlavou; přistoupil k ní, chytil ji oběma rukama a začal
ji líbat a kousat do úst. Anči se divoce brání koleny a lokty; drží ji
brutálně a jednou rukou z ní trhá šaty v dlouhých pásech. Už cítí dlaněmi její
mladé maso; Anči sebou zběsile zmítá, vlasy padly jí přes tvář, teď, teď náhle
ochabuje a klesá; Prokop se vrhá k ní, ale nalézá pod rukama jen samé dlouhé
hadříky a fáče; trhá je, rve je, chce se z nich vyprostit, a probouzí se.
Hanbil se nesmírně za svůj sen; i ustrojil se potichu, sedl u okna a čekal na
svítání. Není hranice mezi nocí a dnem; jen nebe maličko pobledne, a vzduchem
proletí signál, jenž není ani světlo ani zvuk, ale poroučí přírodě: vzbuď se!
Tu tedy nastalo ráno ještě prostřed noci. Rozkřičeli se kohouti, zvířata v
stájích se pohnula. Nebe bledne do perleťova, rozzařuje se a lehce růžoví;
první červený pruh vyskočil na východě, „štilip štilip játiti piju piju já,“
štěkají a křičí ptáci, a první člověk jde volným krokem za svým povoláním.
Také učený člověk sedl k dílu. Dlouho kousal násadku, než se odhodlal napsat
první slova; neboť toto bude veliká věc, úhrn experimentování a přemýšlení
dvanácti let, práce opravdu vykoupená krví. Ovšem, to zde bude jen náčrt, či
spíš jistá fyzikální filozofie nebo báseň nebo vyznání víry. Bude to obraz
světa sklenutý z čísel a rovnic; avšak tyto cifry astronomického řádu měří
něco jiného než vznešenost oblohy: kalkulují vratkost a destrukci hmoty. Vše,
co jest, je tupá a vyčkávající třaskavina; ale jakékoliv budiž číslo její
netečnosti, je jenom mizivým zlomkem její brizance. Vše, co se děje, oběhy
hvězd a telurická práce, veškerá entropie, sám pilný a nenasytný život, to vše
jen na povrchu, nepatrně a neměřitelně ohlodává a váže tuto výbušnou sílu, jež
se jmenuje hmota. Vězte tedy, že pouto, jež ji váže, je jenom pavučina na
údech spícího titána; dejte mi sílu, aby jej pobodl, i setřese kůru země a
vrhne Jupitera na Saturna. A ty, lidstvo, jsi jenom vlaštovka, která si pracně
ulepila hnízdo pod krovem kosmické prachárny; cvrlikáš za slunce východu,
zatímco v sudech pod tebou mlčky duní strašlivý potenciál výbuchu…
Ty věci Prokop ovšem nepsal; byly mu jenom ztajenou melodií, jež okřídlovala
těžkopádné věty odborného výkladu. Pro něho bylo více fantazie v holém vzorci
a víc oslnivé krásy v číselném výrazu. A tak psal svou báseň ve značkách,
číslicích a děsné hantýrce učených slov.
K snídani nepřišel. Přišla tedy Anči a nesla mu mlíčko. Děkoval a přitom si
vzpomněl na svůj sen, a jaksi to nesvedl podívat se na ni. Koukal tvrdošíjně
do kouta; bůhví jak je to možno, že přesto viděl každý zlatý vlásek na jejích
holých pažích; nikdy si toho tak nevšiml.
Anči stála blizoučko. „Budete psát?“ ptala se neurčitě.
„Budu,“ bručel a myslel, co by tomu řekla, kdyby jí zničehonic položil hlavu
na prsa.
„Po celý den?“
„Po celý den.“ Asi by ucouvla náramně dotčena; ale má pevná, malá a široká
ňadra, o kterých snad ani neví. Ostatně, co s tím!
„Chtěl byste něco?“
„Ne, nic.“ Je to hloupé; chtěl by ji hryzat do paží či co; ženská nikdy neví,
jak člověka vyrušuje.
Anči pokrčila rameny trochu uraženě. „Taky dobře.“ A byla pryč.
Vstal a přecházel po pokoji; zlobil se na sebe i na ni, a hlavně se mu už
nechtělo psát. Sbíral myšlenky, ale naprosto se mu to nedařilo. Rozmrzel se a
otráven chodil od stěny ke stěně s pravidelností kyvadla. Hodinu, dvě hodiny.
Dole řinčí talíře, prostírá se k obědu. Sedl znovu k svým papírům a položil
hlavu do dlaní. Za chvíli tu byla služka a přinesla mu oběd.
Vrátil jídlo skoro netknuté a vrhl se rozmrzen na postel. Je zřejmo, že už ho
mají dost, že i on má toho všeho až po krk a že je načase odejet. Ano, hned
zítra. Dělal si nějaké plány pro příští práci, bylo mu neznámo proč stydno a
trapno a konečně z toho všeho usnul jako zabitý. Probudil se pozdě odpoledne s
duší zbahnělou a tělem zamořeným shnilou leností. Coural po pokoji, zíval a
bezmyšlenkovitě se mrzel. Setmělo se, a ani nerozsvítil.
Služka mu přinesla večeři. Nechal ji vystydnout a poslouchal, co se děje dole.
Vidličky cinkaly, doktor bručel a náramně brzo po večeři práskl dveřmi u svého
pokoje. Bylo ticho.
Jist, že už nikoho nepotká, sebral se Prokop a šel do zahrady. Byla vlažná a
jasná noc. Už kvetou šeříky a pustoryl, Bootes široce rozpíná na nebi svou
hvězdnou náruč, je ticho prohloubené dalekým psím štěkáním. O kamennou zídku v
zahradě se opírá něco světlého. Je to ovšem Anči.
„Je krásně, že?“ dostal ze sebe, aby vůbec něco řekl, a opřel se o zídku vedle
ní. Anči nic, jenom odvrací tvář a její ramena sebou nezvykle a neklidně
trhají.
„To je Bootes,“ bručel Prokop sdílně. „A nad ním… je Drak, a Cepheus, a tamto
je Kassiopeja, ty čtyři hvězdičky pohromadě. Ale to se musíte dívat výš.“
Anči se odvrací a něco roztírá kolem očí. „Tamta jasná,“ povídá Prokop váhavě,
„je Pollux, beta Geminorum. Nesmíte se na mne zlobit. Snad jsem se vám zdál
hrubý, že? Já jsem… něco mne trápilo, víte? Nesmíte na to dát.“
Anči zhluboka vzdychla. „A která je… tamta?“ ozvala se tichým, kolísavým
hláskem. „Ta nejjasnější dole.“
„To je Sírius, ve Velkém psu. Taky Alhabor mu říkají. A tamhle docela vlevo
Arcturus a Spica. Teď padala hvězda. Viděla jste?“
„Viděla. Proč jste se ráno na mne tak zlobil?“
„Nezlobil. Jsem snad… někdy… trochu hranatý; ale já jsem byl tvrdě živ, víte,
příliš tvrdě; pořád sám a… jako první hlídka. Nedovedu ani pořádně mluvit.
Chtěl jsem dnes… dnes napsat něco krásného… takovou vědeckou modlitbu, aby
tomu každý rozuměl; myslil jsem, že… že vám to přečtu; a vidíte, všechno ve
mně vyschlo, člověk už se stydí… rozehřát se, jako by to byla slabost. Nebo
vůbec něco říci ze sebe. Takový okoralý, víte? Už hodně šedivím.“
„Vždyť vám to sluší,“ vydechla Anči.
Prokopa překvapila tato stránka věci. „Nu víte,“ řekl zmateně, „příjemné to
není. Už by byl čas… už by byl čas svážet svou úrodu domů. Co by jiný udělal z
toho, co já vím! A já nemám nic, nic, nic z toho všeho. Jsem jenom… ,berühmt‘
a ,célčbre‘ a ,highly esteemed‘; ani o tom… u nás… nikdo neví. Já myslím,
víte, že mé teorie jsou dost špatné; já nemám hlavu na teoretika. Ale co jsem
našel, není bez ceny. Mé exotermické třaskaviny… diagramy… a exploze atomů… to
má nějakou cenu. A publikoval jsem sotva desetinu toho, co vím. Co by z toho
jiný udělal! Já už… ani nerozumím jejich teoriím; jsou tak subtilní, tak
duchaplné… a mne to jen mate. Jsem kuchyňský duch. Dejte mně k nosu nějakou
látku, a já zrovna čichám, co se s ní dá dělat. Ale pochopit, co z toho plyne…
teoreticky a filozoficky…, to neumím. Já znám… jen fakta; já je dělám; jsou to
má fakta, rozumíte? A přece… já… já za nimi cítím nějakou pravdu; ohromnou
obecnou pravdu… která všechno převrátí… až vybuchne. Ale ta velká pravda… je
za fakty a ne za slovy. A proto, proto musíš za fakty! až ti to třeba obě ruce
utrhne…“
Anči, opřena o zídku, sotva dýchala. Nikdy dosud se ten zamračený patron tolik
nerozmluvil – a hlavně nikdy nemluvil o sobě. Zápasil těžce se slovem; zmítala
jím ohromná pýcha, ale také plachost a zmučenost; a kdyby mluvil třeba v
integrálách, chápala Anči, že se před ní děje něco naprosto niterného a lidsky
zjitřeného.
„Ale to nejhorší, to nejhorší,“ bručel Prokop. „Někdy… a tady zvlášť… i to, i
to se mně zdá hloupé… a k ničemu. I ta konečná pravda… vůbec všecko. Nikdy
dřív mně to tak nepřišlo. Nač, a k čemu… Snad je rozumnější poddat se… prostě
poddat se tomu, tomu všemu – (Nyní ukázal rukou cosi kolem dokola.) Prostě
životu. Člověk nemá být šťastný; to ho změkčuje, víte? Pak se mu zdá všechno
ostatní zbytečné, malé… a nesmyslné. Nejvíc… nejvíc udělá člověk ze
zoufalství. Ze stesku, ze samoty, z ohlušování. Protože mu nic nestačí. Já
jsem pracoval jako blázen. Ale tady, tady jsem začal být šťastný. Tady jsem
poznal, že je snad… něco lepšího než myslet. Tady člověk jenom žije… a vidí,
že je to něco ohromného… jenom žít. Jako váš Honzík, jako kočka, jako slepice.
Každé zvíře to umí… a mně to připadá tak ohromné, jako bych dosud nežil. A
tak… tak jsem podruhé ztratil dvanáct let.“
Jeho potlučená, bůhvíkolikrát sešívaná pravice se chvěla na zídce. Anči mlčí,
i potmě je vidět její dlouhé řasy; opírá se lokty a hrudí o zděný plot a mžiká
k hvězdičkám. Tu zašelestilo něco v křoví, a Anči se zděsila; až ji to mocí
vrhlo k Prokopovu rameni. „Co je to?“
„Nic, nejspíš kuna; jde asi do dvora, na kuřata.“
Anči znehybněla. Její mladé prsy se nyní pružně, plně opírají o Prokopovu
pravici, – snad, jistě o tom sama neví, ale Prokop to ví víc než cokoliv na
světě; bojí se hrozně pohnout rukou, neboť, předně, by si Anči myslela, že ji
tam položil schválně, a za druhé by vůbec změnila polohu. Zvláštní však je, že
tato okolnost vylučuje, aby dále mluvil o sobě a o ztraceném životě. „Nikdy,“
koktá zmateně, „nikdy jsem nebyl tak rád… tak šťasten jako tady. Váš tatík je
nejlepší člověk na světě, a vy… vy jste tak mladá…“
„Já jsem myslela, že se vám zdám… příliš hloupá,“ povídá Anči tiše a šťastně.
„Nikdy jste se mnou takhle nemluvil.“
„Pravda, nikdy dosud,“ zabručel Prokop. Oba se odmlčeli. Cítil na ruce lehké
oddechování jejích ňader; mrazilo ho a tajil dech, i ona, zdá se, tají dech v
tichém trnutí, ani nemrká a široce hledí nikam. Oh, pohladit a stisknout! Oh,
závrati, prvý dotyku, lichotko bezděčná a horoucí! Zda tě kdy potkalo
dobrodružství opojnější než tato nevědomá a oddaná důvěrnost? Skloněné poupě,
tělo bázlivé a jemné! kdybys tušilo mučivou něhu té tvrdé chlapské ruky, jež
tě bez hnutí hladí a svírá! Kdybys – kdyby – kdybych teď učinil… a stiskl…
Anči se vztyčila nejpřirozenějším pohybem. Ach, děvče, tys tedy opravdu o
ničem nevědělo! „Dobrou noc!“ povídá Anči tiše, a její tvář je bledá a
nejasná. „Dobrou noc,“ praví trochu sevřeně a podává mu ruku; podává ji levě a
chabě, je jako polámaná a dívá se široce nějak jinam. Není-liž pak to, jako by
chtěla ještě prodlít? Ne, jde už, váhá; ne, stojí a trhá na kousíčky nějaký
lístek. Co ještě říci? Dobrou noc, Anči, a spěte lépe než já.
Neboť zajisté nelze teď jít spat. Prokop se vrhá na lavičku a položí hlavu do
dlaní. Nic, nic se neudálo… tak dalece; bylo by hanebné hnedle myslet na
bůhvíco. Anči je čistá a nevědomá jako telátko, a teď už dost o tom; nejsem
přece chlapec. Tu se rozsvítilo v prvním patře okno. Je to Ančina ložnice.
Prokopovi bouchá srdce. Ví, že je to hanebnost, tajně se tam dívat; jistě, to
by jako host dělat neměl. Pokouší se dokonce zakašlat (aby ho slyšela), ale
jaksi to selhalo; i sedí jako socha a nemůže odvrátit očí od zlatého okna.
Anči tam přechází, shýbá se, něco dlouze a široce robí; aha, rozestýlá si
postýlku. Teď stojí u okna, dívá se do tmy a zakládá ruce za hlavou: zrovna
tak ji viděl ve snu. Teď, teď by bylo radno se ozvat; proč to neudělal? Už je
na to pozdě; Anči se odvrací, přechází, je ta tam; ba ne, to sedí zády k oknu
a zřejmě se zouvá hrozně pomalu a zamyšleně; nikdy se nesní líp než se
střevícem v ruce. Aspoň teď by bylo načase zmizet; ale místo toho vylezl na
lavičku, aby líp viděl. Anči se vrací, už nemá na sobě živůtek; zvedá nahé
paže a vyndává si z účesu vlásničky. Nyní hodila hlavou, a celá hříva se jí
rozlévá po ramenou; děvče jí potřese, hurtem si přehodí celou tu úrodu vlasů
přes čelo a teď ji zpracovává kartáčem a hřebenem, až má hlavu jako cibulku;
je to patrně velmi směšné, neboť Prokop, hanebník, přímo září.
Anči, panenka bílá, stojí se skloněnou hlavou a splétá si vlasy ve dva copy;
má víčka sklopena a něco si šeptá, zasměje se, zastydí se, až jí to ramena
zvedá; pásek košile, pozor, sklouzne. Anči hluboce přemýšlí a hladí si bílé
ramínko v nějakém rozkošnictví, zachvěje se chladem, pásek se smeká už
povážlivě, a světlo zhaslo.
Nikdy jsem neviděl nic bělejšího, nic pěknějšího a bělejšího než toto
osvětlené okno.


XII.

Hned ráno ji zastihl, jak drhne mydlinkami Honzíka v neckách; psisko zoufale
vytřepávalo vodu, ale Anči se nedala, držela ho za čupřiny a náruživě mydlila,
postříkaná, zmáčená na břiše a usmátá. „Pozor,“ křičela z dálky, „postříká
vás!“ Vypadala jako mladá nadšená maminka; oj bože, jak je vše prosté a jasné
na tomto slunném světě!
Ani Prokop nevydržel zahálet. Vzpomněl si, že nefunguje zvonek, a jal se
spravovat baterii. Zrovna oškrabával zinek, když se k němu tiše blížila ona;
měla rukávy po loket vyhrnuté a mokré ruce, neboť se pere. „Nevybuchne to?“
ptá se starostlivě. Prokop se musel usmát; i ona se zasmála a stříkla po něm
mydlinkami; ale hned mu šla s vážnou tváří utřít loktem bublinku mýdla na
vlasech. Hle, včera by se toho nebyla odvážila.
K polednímu vleče s Nandou koš prádla na zahradu; bude se bílit. Prokop s
povděkem sklapl knihu; nenechá ji přece tahat se s těžkou kropicí konví.
Zmocnil se konve a kropí prádlo; hustá prška přeradostně a horlivě bubnuje na
řásné ubrusy a na bělostné rozložité povlaky a do široce rozevřených náručí
mužských košil, šumí, crčí a slévá se ve fjordy a jezírka. Prokop se žene
zkropit i bílé zvonky sukének a jiné zajímavé věci, ale Anči mu vyrve konev a
zalévá sama. Zatím si Prokop sedl do trávy, dýchá s rozkoší vůni vlhkosti a
pozoruje Ančiny činné a krásné ruce. Soi de theoi tosa doien, vzpomněl si
zbožně. Sebas m’echei eisoroónta. Já s úžasem na tebe hledím.
Anči usedá k němu do trávy. „Nač jste to myslel?“ Mhouří oči oslněním a
radostí, zardělá a kdovíproč tak šťastná. Rve plnou hrstí svěží trávu a chtěla
by mu ji z bujnosti hodit do vlasů; ale bůhví, i teď ji tísní jakýsi uctivý
ostych před tím ochočeným hrdinou. „Měl jste někdy někoho rád?“ ptá se
zčistajasna a honem se dívá jinam.
Prokop se směje. „Měl. Vždyť i vy jste už měla někoho ráda.“
„To jsem byla ještě hloupá,“ vyhrkne Anči a proti své vůli se červená.
„Študent?“
Anči jen kývne a kouše nějakou travinu. „To nic nebylo,“ povídá pak rychle. „A
vy?“
„Jednou jsem potkal děvče, které mělo takové řasy jako vy. Možná že vám byla
podobná. Prodávala rukavice či co.“
„A co dál?“
„Nic dál. Když jsem tam šel podruhé koupit rukavice, už tam nebyla.“
„A… líbila se vám?“
„Líbila.“
„A… nikdy jste ji…“
„Nikdy. Teď mně dělá rukavice… bandažista.“
Anči soustřeďuje svou pozornost na zem. „Proč… vždycky přede mnou schováváte
ruce?“
„Protože… protože je mám tak rozbité,“ děl Prokop a chudák se začervenal.
„To je zrovna tak krásné,“ šeptá Anči s očima sklopenýma.
„K obědúúú, k obědúúú,“ vyvolává Nanda před domem. „Bože, už,“ vzdychne Anči a
velmi nerada se zvedá.
Po obědě se starý doktor jen tak trochu položil, jen docela málo. „Víte,“
omlouval se, „já jsem se ráno nadřel jako pes.“ A hned začal pravidelně a
pilně chrupat. Zasmáli se na sebe očima a po špičkách vyšli; a i v zahradě
mluvili potichu, jako by ctili jeho sytý spánek.
Prokop musel povídat o svém životě. Kde se narodil a kde rostl, že byl až v
Americe, co bídy poznal, co kdy dělal. Dělalo mu dobře zopakovat si celý ten
život; neboť, kupodivu, byl klikatější a divnější, než by sám myslel; a ještě
o mnohém pomlčel, zejména, nu, zejména o jistých citových záležitostech, neboť
předně to nemá takový význam, a za druhé, jak známo, každý mužský má o čem
mlčet. Anči byla tichá jako pěna; připadalo jí jaksi směšné a zvláštní, že
Prokop byl také dítětem a chlapcem a vůbec něčím jiným než bručivým a divným
člověkem, vedle něhož se cítí taková nesvá a maličká. Nyní by se už nebála na
něho i sáhnout, zavázat mu kravatu, pročísnout vlasy nebo vůbec. A poprvé
viděla teď jeho tlustý nos, jeho drsná ústa a přísné, mračné, krvavě protkané
oči; připadalo jí to vše nesmírně divné.
A nyní byla řada na ní, aby povídala o svém životě. Už otevřela ústa a
nabírala dechu, ale dala se do smíchu. Uznejte, co se může říci o tak
nepopsaném životě, a dokonce někomu, kdo už jednou byl dvanáct hodin zasypán,
kdo byl ve válce, v Americe a kdovíkde ještě? „Já nic nevím,“ řekla upřímně.
Nuže, řekněte, není takové „nic stejně cenné jako mužovy zkušenosti?
Je pozdě odpoledne, když spolu putují vyhřátou polní stezkou. Prokop mlčí a
Anči poslouchá. Anči hladí rukou ostnaté vrcholky klasů. Anči se ho dotýká
ramenem, zpomaluje krok, vázne; pak zase zrychlí chůzi, jde dva kroky před ním
a rve klasy v jakési potřebě ničit. Tato slunečná samota je posléze tíží a
znervózňuje; neměli jsme sem jít, myslí si oba potají, a v tísnivém rozladění
soukají ze sebe plytký, potrhaný hovor. Konečně tady je cíl, kaplička mezi
dvěma starými lípami; je pozdní hodina, kdy pasáci začínají zpívat. Tu je
sedátko poutníků; usedli a jaksi ještě víc potichli. Nějaká žena klečela u
kapličky a modlila se, jistěže za svou rodinu. Sotva odešla, zvedla se Anči a
klekla na její místo. Bylo v tom něco nekonečně a samozřejmě ženského; Prokop
se cítil chlapcem vedle zralé prostoty tohoto pravěkého a posvátného gesta.
Anči konečně vstala, zvážnělá jaksi a vyspělá, o čemsi rozhodnutá, s čímsi
smířená; jako by něco poznala, jako by něco v sobě nesla, přetížená,
zamyšlená, bůhvíčím tak změněná; jen slabikami odpovídala sladkým a potemnělým
hlasem, když se loudali domů cestičkou soumraku.
Nemluvila při večeři a nemluvil ani Prokop; mysleli asi na to, kdy starý pán
si půjde přečíst noviny. Starý pán bručel a zkoumal je přes brejličky;
holenku, něco se mu tady netento, nezdálo jaksi v pořádku. Už se to trapně
táhlo, když se ozval zvonek a člověk odněkud ze Sedmidolí nebo ze Lhoty prosil
doktora k porodu. Starý doktor byl pramálo potěšen, zapomněl dokonce hubovat.
Ještě s porodním tlumokem zaváhal ve dveřích a kázal suše: „Jdi spat, Anči.“
Beze slova se zvedla a sklízela se stolu. Byla dlouho, velmi dlouho někde v
kuchyni. Prokop nervózně kouřil a už chtěl odejít. Tu se vrátila, bledá, jako
by ji mrazilo, a řekla s hrdinným přemáháním: „Nechcete si zahrát biliár?“ To
znamenalo: se zahradou dnes nic nebude.
Nu, byla to prašpatná partie; zejména Anči byla zrovna toporná, šťouchala
naslepo, zapomínala hrát a stěží odpovídala. A když jednou zahodila
nejvyloženějšího sedáka, ukazoval jí Prokop, jak to měla sehrát: pravá faleš,
vzít trochu dole, a je to; při tom – jen aby jí vedl ruku – položil svou ruku
na její. Tu Anči prudce, temně mu vzhlédla do tváře, hodila tágo na zem a
utekla.
Nuže, co dělat? Prokop pobíhal po salóně, kouřil a mrzel se. Eh, divné děvče;
ale proč to tak mate mne sama? Její hloupá pusa, jasné blizoučké oči, líčko
hladké a horoucí, nu, člověk není konečně ze dřeva. Což by bylo takovým
hříchem pohladit líčko, políbit, pohladit, ach, růžové líce, a požehnat vlasy,
vlasy, přejemné vlásky nad mladou šíjí (člověk není ze dřeva); políbit,
pohladit, vzít do rukou, pocelovat zbožně a opatrně? Hlouposti, mrzel se
Prokop; jsem starý osel; což bych se nestyděl – takové dítě, které na to ani
nemyslí, ani nemyslí – Dobrá; toto pokušení vyřídil Prokop sám se sebou, ale
tak rychle to nešlo; mohli byste jej vidět, jak stojí před zrcadlem se rty do
krve rozkousanými a mračně, hořce vyzývá a měří svá léta.
Jdi spat, starý mládenče, jdi; právě sis ušetřil ostudu, až by se ti mladá,
hloupá holčička vysmála; i tenhle výsledek stojí za to. Jakžtakž odhodlán
stoupal Prokop nahoru do své ložnice; jen ho tížilo, že musí tadyhle projít
podle Ančina pokojíčku. Šel po špičkách: snad už spí, dítě. A najednou stanul
se srdcem splašeně tlukoucím. Ty dveře… Ančiny… nejsou dovřeny. Nejsou vůbec
zavřeny a za nimi tma. Co je to? A tu slyšel uvnitř cosi jako zakvílení.
Něco ho chtělo vrhnout tam, do těch dveří; ale něco silnějšího jej tryskem
srazilo se schodů dolů a ven do zahrady. Stál v temném houští a tiskl ruku k
srdci, jež bouchalo jako na poplach. Kristepane, že jsem k ní nešel! Anči
jistě. klečí – polosvlečena – a pláče do peřinky, proč? to nevím; ale kdybych
byl vešel – nuže, co by se stalo? Nic; klekl bych vedle ní a prosil, aby
neplakala; pohladil, pohladil bych lehké vlasy, vlásky už rozpuštěné – Ó bože,
proč nechala otevřeno?
Ejhle, světlý stín vyklouzl z domu a míří do zahrady. Je to Anči, není
svlečena ani nemá vlasy rozpušt�