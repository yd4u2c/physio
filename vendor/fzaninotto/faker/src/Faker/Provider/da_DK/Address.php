uernsey', 'Guinea', 'Guinea-Bissau', 'Guyana',
        'Haiti', 'Heard- und McDonald-Inseln', 'Honduras',
        'Indien', 'Indonesien', 'Irak', 'Iran', 'Irland', 'Island', 'Isle of Man', 'Israel', 'Italien',
        'Jamaika', 'Japan', 'Jemen', 'Jersey', 'Jordanien',
        'Kaimaninseln', 'Kambodscha', 'Kamerun', 'Kanada', 'Kap Verde', 'Kasachstan', 'Katar', 'Kenia', 'Kirgisistan', 'Kiribati', 'Kokosinseln', 'Kolumbien', 'Komoren', 'Kongo', 'Kroatien', 'Kuba', 'Kuwait',
        'Laos', 'Lesotho', 'Lettland', 'Libanon', 'Liberia', 'Libyen', 'Liechtenstein', 'Litauen', 'Luxemburg',
        'Madagaskar', 'Malawi', 'Malaysia', 'Malediven', 'Mali', 'Malta', 'Marokko', 'Marshallinseln', 'Martinique', 'Mauretanien', 'Mauritius', 'Mayotte', 'Mazedonien', 'Mexiko', 'Mikronesien', 'Monaco', 'Mongolei', 'Montenegro', 'Montserrat', 'Mosambik', 'Myanmar',
        'Namibia', 'Nauru', 'Nepal', 'Neukaledonien', 'Neuseeland', 'Nicaragua', 'Niederlande', 'Niederländische Antillen', 'Niger', 'Nigeria', 'Niue', 'Norfolkinsel', 'Norwegen', 'Nördliche Marianen',
        'Oman', 'Osttimor', 'Österreich',
        'Pakistan', 'Palau', 'Palästinensische Gebiete', 'Panama', 'Papua-Neuguinea', 'Paraguay', 'Peru', 'Philippinen', 'Pitcairn', 'Polen', 'Portugal', 'Puerto Rico',
        'Republik Korea', 'Republik Moldau', 'Ruanda', 'Rumänien', 'Russische Föderation', 'Réunion',
        'Salomonen', 'Sambia', 'Samoa', 'San Marino', 'Saudi-Arabien', 'Schweden', 'Schweiz', 'Senegal', 'Serbien', 'Serbien und Montenegro', 'Seychellen', 'Sierra Leone', 'Simbabwe', 'Singapur', 'Slowakei', 'Slowenien', 'Somalia', 'Sonderverwaltungszone Hongkong', 'Sonderverwaltungszone Macao', 'Spanien', 'Sri Lanka', 'St. Barthélemy', 'St. Helena', 'St. Kitts und Nevis', 'St. Lucia', 'St. Martin', 'St. Pierre und Miquelon', 'St. Vincent und die Grenadinen', 'Sudan', 'Suriname', 'Svalbard und Jan Mayen', 'Swasiland', 'Syrien', 'São Tomé und Príncipe', 'Südafrika', 'Südgeorgien und die Südlichen Sandwichinseln',
        'Tadschikistan', 'Taiwan', 'Tansania', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad und Tobago', 'Tschad', 'Tschechische Republik', 'Tunesien', 'Turkmenistan', 'Turks- und Caicosinseln', 'Tuvalu', 'Türkei',
        'Uganda', 'Ukraine', 'Unbekannte oder ungültige Region', 'Ungarn', 'Uruguay', 'Usbekistan',
        'Vanuatu', 'Vatikanstadt', 'Venezuela', 'Vereinigte Arabische Emirate', 'Vereinigte Staaten', 'Vereinigtes Königreich', 'Vietnam',
        'Wallis und Futuna', 'Weihnachtsinsel', 'Westsahara',
        'Zentralafrikanische Republik', 'Zypern',
    );

    protected static $cityFormats = array(
        '{{cityName}}',
    );

    protected static $streetNameFormats = array(
        '{{lastName}}{{streetSuffixShort}}',
        '{{firstName}}-{{lastName}}-{{streetSuffixLong}}'
    );

    protected static $streetAddressFormats = array(
        '{{streetName}} {{buildingNumber}}',
    );
    protected static $addressFormats = array(
        "{{streetAddress}}\n{{postcode}} {{city}}",
    );

    public function cityName()
    {
        return static::randomElement(static::$cityNames);
    }

    public function streetSuffixShort()
    {
        return static::randomElement(static::$streetSuffixShort);
    }

    public function streetSuffixLong()
    {
        return static::randomElement(static::$streetSuffixLong);
    }

    /**
     * @example 'Berlin'
     */
    public static function state()
    {
        return static::randomElement(static::$state);
    }

    public static function buildingNumber()
    {
        return static::regexify(self::numerify(static::randomElement(static::$buildingNumber)));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

namespace Faker\Provider\de_DE;

class Payment extends \Faker\Provider\Payment
{
    /**
     * International Bank Account Number (IBAN)
     * @link http://en.wikipedia.org/wiki/International_Bank_Account_Number
     * @param  string  $prefix      for generating bank account number of a specific bank
     * @param  string  $countryCode ISO 3166-1 alpha-2 country code
     * @param  integer $length      total length without country code and 2 check digits
     * @return string
     */
    public static function bankAccountNumber($prefix = '', $countryCode = 'DE', $length = null)
    {
        return static::iban($countryCode, $prefix, $length);
    }

    /**
     * Sources:
     * The 19 largest German banks by total assets
     * @see https://de.wikipedia.org/wiki/Liste_der_größten_Banken_in_Deutschland
     * The 20 largest co-operative banks by branch count
     * @see https://de.wikipedia.org/wiki/Liste_der_Genossenschaftsbanken_in_Deutschland
     * The 20 largest public savings banks by branch count
     * @see https://de.wikipedia.org/wiki/Liste_der_Sparkassen_in_Deutschland
     */
    protected static $banks = array(
        'Bank 1 Saar', 'Bayerische Landesbank', 'BBBank', 'Berliner Sparkasse', 'Berliner Volksbank', 'Braunschweigische Landessparkasse',
        'Commerzbank',
        'DekaBank Deutsche Girozentrale', 'Deutsche Apotheker- und Ärztebank', 'Deutsche Bank', 'Deutsche Kreditbank', 'Deutsche Pfandbriefbank', 'Dortmunder Volksbank', 'DZ Bank',
        'Erzgebirgssparkasse',
        'Frankfurter Sparkasse', 'Frankfurter Volksbank',
        'Hamburger Sparkasse', 'Hannoversche Volksbank', 'HSGV', 'HSH Nordbank',
        'ING-DiBa',
        'KfW', 'Kreissparkasse Esslingen-Nürtingen', 'Kreissparkasse Heilbronn', 'Kreissparkasse Köln', 'Kreissparkasse Ludwigsburg', 'Kreissparkasse München Starnberg Ebersberg',
        'L-Bank', 'Landesbank Baden-Württemberg', 'Landesbank Hessen-Thüringen', 'Landessparkasse zu Oldenburg', 'Landwirtschaftliche Rentenbank',
        'Mittelbrandenburgische Sparkasse in Potsdam',
        'Nassauische Sparkasse', 'Norddeutsche Landesbank', 'NRW.Bank',
        'Ostsächsische Sparkasse Dresden',
        'Postbank',
        'Sparkasse Hannover', 'Sparkasse KölnBonn', 'Sparkasse Mainfranken Würzburg', 'Sparkasse Nürnberg', 'Sparkasse Pforzheim Calw', 'Stadtsparkasse München',
        'Unicredit Bank',
        'Vereinigte Volksbank', 'Volksbank, Hildesheim-Lehrte-Pattensen', 'Volksbank Alzey-Worms', 'Volksbank Braunschweig Wolfsburg', 'Volksbank Darmstadt - Südhessen', 'Volksbank Hohenlohe', 'Volksbank Kraichgau Wiesloch-Sinsheim', 'Volksbank Lüneburger Heide', 'Volksbank Mittelhessen', 'Volksbank Paderborn-Höxter-Detmold', 'Volksbank Raiffeisenbank Rosenheim-Chiemsee', 'Volksbank Stuttgart', 'VR Bank Main-Kinzig-Büdingen',
        'WGZ Bank',
    );

    /**
     * @example 'Volksbank Stuttgart'
     */
    public static function bank()
    {
        return static::randomElement(static::$banks);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

namespace Faker\Provider\de_DE;

class Person extends \Faker\Provider\Person
{
    protected static $maleNameFormats = array(
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}-{{lastName}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}} {{suffix}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}} {{suffix}}',
    );

    protected static $femaleNameFormats = array(
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}-{{lastName}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}} {{suffix}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}} {{suffix}}',
    );

    /**
         * Top 500 Names from a phone directory (6. January 2005)
         * {@link} From http://de.wiktionary.org/wiki/Verzeichnis:Deutsch/Liste_der_h%C3%A4ufigsten_m%C3%A4nnlichen_Vornamen_Deutschlands
         **/
    protected static $firstNameMale = array(
        'Achim', 'Adalbert', 'Adam', 'Adolf', 'Adrian', 'Ahmed', 'Ahmet', 'Albert', 'Albin', 'Albrecht', 'Alex', 'Alexander', 'Alfons', 'Alfred', 'Ali', 'Alois', 'Aloys', 'Alwin', 'Anatoli', 'Andre', 'Andreas', 'Andree', 'Andrej', 'Andrzej', 'André', 'Andy', 'Angelo', 'Ansgar', 'Anton', 'Antonio', 'Antonius', 'Armin', 'Arnd', 'Arndt', 'Arne', 'Arno', 'Arnold', 'Arnulf', 'Arthur', 'Artur', 'August', 'Axel',
        'Bastian', 'Benedikt', 'Benjamin', 'Benno', 'Bernard', 'Bernd', 'Berndt', 'Bernhard', 'Bert', 'Berthold', 'Bertram', 'Björn', 'Bodo', 'Bogdan', 'Boris', 'Bruno', 'Burghard', 'Burkhard',
        'Carl', 'Carlo', 'Carlos', 'Carsten', 'Christian', 'Christof', 'Christoph', 'Christopher', 'Christos', 'Claudio', 'Claus', 'Claus-Dieter', 'Claus-Peter', 'Clemens', 'Cornelius',
        'Daniel', 'Danny', 'Darius', 'David', 'Denis', 'Dennis', 'Detlef', 'Detlev', 'Dierk', 'Dieter', 'Diethard', 'Diethelm', 'Dietmar', 'Dietrich', 'Dimitri', 'Dimitrios', 'Dirk', 'Domenico', 'Dominik',
        'Eberhard', 'Eckard', 'Eckart', 'Eckehard', 'Eckhard', 'Eckhardt', 'Edgar', 'Edmund', 'Eduard', 'Edward', 'Edwin', 'Egbert', 'Egon', 'Ehrenfried', 'Ekkehard', 'Elmar', 'Emanuel', 'Emil', 'Engelbert', 'Enno', 'Enrico', 'Erhard', 'Eric', 'Erich', 'Erik', 'Ernst', 'Ernst-August', 'Erwin', 'Eugen', 'Ewald',
        'Fabian', 'Falk', 'Falko', 'Felix', 'Ferdinand', 'Florian', 'Francesco', 'Franco', 'Frank', 'Franz', 'Franz Josef', 'Franz-Josef', 'Fred', 'Fredi', 'Fridolin', 'Friedbert', 'Friedemann', 'Frieder', 'Friedhelm', 'Friedrich', 'Friedrich-Wilhelm', 'Fritz',
        'Gabriel', 'Gebhard', 'Georg', 'Georgios', 'Gerald', 'Gerd', 'Gerhard', 'Gernot', 'Gero', 'Gerold', 'Gert', 'Gilbert', 'Giovanni', 'Gisbert', 'Giuseppe', 'Gottfried', 'Gotthard', 'Gottlieb', 'Gregor', 'Guenter', 'Guido', 'Guiseppe', 'Gunnar', 'Gunter', 'Gunther', 'Gustav', 'Götz', 'Günter', 'Günther',
        'Hagen', 'Halil', 'Hannes', 'Hanni', 'Hanno', 'Hanns', 'Hans', 'Hans Dieter', 'Hans Georg', 'Hans Jürgen', 'Hans Peter', 'Hans-Christian', 'Hans-Dieter', 'Hans-Georg', 'Hans-Gerd', 'Hans-Günter', 'Hans-Günther', 'Hans-Heinrich', 'Hans-Hermann', 'Hans-J.', 'Hans-Joachim', 'Hans-Jochen', 'Hans-Josef', 'Hans-Jörg', 'Hans-Jürgen', 'Hans-Martin', 'Hans-Otto', 'Hans-Peter', 'Hans-Ulrich', 'Hans-Walter', 'Hans-Werner', 'Hans-Wilhelm', 'Hansjörg', 'Hanspeter', 'Harald', 'Hardy', 'Harri', 'Harro', 'Harry', 'Hartmut', 'Hartwig', 'Hasan', 'Heiko', 'Heiner', 'Heino', 'Heinrich', 'Heinz', 'Heinz-Dieter', 'Heinz-Georg', 'Heinz-Günter', 'Heinz-Joachim', 'Heinz-Josef', 'Heinz-Jürgen', 'Heinz-Peter', 'Heinz-Werner', 'Helfried', 'Helge', 'Hellmut', 'Hellmuth', 'Helmar', 'Helmut', 'Helmuth', 'Hendrik', 'Henning', 'Henrik', 'Henry', 'Henryk', 'Herbert', 'Heribert', 'Hermann', 'Hermann-Josef', 'Herwig', 'Hilmar', 'Hinrich', 'Holger', 'Horst', 'Horst-Dieter', 'Hubert', 'Hubertus', 'Hugo', 'Hüseyin',
        'Ibrahim', 'Ignaz', 'Igor', 'Ingo', 'Ingolf', 'Ismail', 'Ivan', 'Ivo',
        'Jakob', 'Jan', 'Janusz', 'Jens', 'Jens-Uwe', 'Joachim', 'Jochen', 'Johann', 'Johannes', 'John', 'Jonas', 'Jonas', 'Jose', 'Josef', 'Joseph', 'Josip', 'Jost', 'Juergen', 'Julian', 'Julius', 'Juri', 'Jörg', 'Jörn', 'Jürgen',
        'Kai-Uwe', 'Karl', 'Karl Heinz', 'Karl-Ernst', 'Karl-Friedrich', 'Karl-Heinrich', 'Karl-Heinz', 'Karl-Josef', 'Karl-Ludwig', 'Karl-Otto', 'Karl-Wilhelm', 'Karlheinz', 'Karsten', 'Kaspar', 'Kevin', 'Klaus', 'Klaus Dieter', 'Klaus Peter', 'Klaus-Dieter', 'Klaus-Jürgen', 'Klaus-Peter', 'Klemens', 'Knut', 'Konrad', 'Konstantin', 'Konstantinos', 'Kuno', 'Kurt',
        'Lars', 'Leo', 'Leonhard', 'Leonid', 'Leopold', 'Lorenz', 'Lothar', 'Ludger', 'Ludwig', 'Luigi', 'Lukas', 'Lutz',
        'Magnus', 'Maik', 'Malte', 'Manfred', 'Manuel', 'Marc', 'Marcel', 'Marco', 'Marcus', 'Marek', 'Marian', 'Mario', 'Marius', 'Mark', 'Marko', 'Markus', 'Martin', 'Mathias', 'Matthias', 'Max', 'Maximilian', 'Mehmet', 'Meinhard', 'Meinolf', 'Metin', 'Michael', 'Michel', 'Mike', 'Milan', 'Mirco', 'Mirko', 'Miroslav', 'Miroslaw', 'Mohamed', 'Moritz', 'Murat', 'Mustafa',
        'Nico', 'Nicolas', 'Niels', 'Nikola', 'Nikolai', 'Nikolaj', 'Nikolaos', 'Nikolaus', 'Nils', 'Norbert', 'Norman',
        'Olaf', 'Oliver', 'Ortwin', 'Oskar', 'Osman', 'Oswald', 'Otmar', 'Ottmar', 'Otto',
        'Pascal', 'Patrick', 'Paul', 'Peer', 'Peter', 'Philip', 'Philipp', 'Pierre', 'Pietro', 'Piotr',
        'Rafael', 'Raimund', 'Rainer', 'Ralf', 'Ralph', 'Ramazan', 'Raphael', 'Reimund', 'Reiner', 'Reinhard', 'Reinhardt', 'Reinhold', 'Rene', 'René', 'Richard', 'Rico', 'Robert', 'Roberto', 'Robin', 'Roger', 'Roland', 'Rolf', 'Rolf-Dieter', 'Roman', 'Ronald', 'Ronny', 'Rudi', 'Rudolf', 'Rupert', 'Rüdiger',
        'Salvatore', 'Samuel', 'Sandro', 'Sebastian', 'Sergej', 'Siegbert', 'Siegfried', 'Siegmar', 'Siegmund', 'Sigmund', 'Sigurd', 'Silvio', 'Simon', 'Stanislaw', 'Stefan', 'Steffen', 'Stephan', 'Steven', 'Sven', 'Swen', 'Sönke', 'Sören',
        'Theo', 'Theodor', 'Thilo', 'Thomas', 'Thorsten', 'Till', 'Tilo', 'Tim', 'Timo', 'Tino', 'Tobias', 'Tom', 'Toni', 'Torben', 'Torsten',
        'Udo', 'Ulf', 'Uli', 'Ullrich', 'Ulrich', 'Uwe',
        'Valentin', 'Veit', 'Victor', 'Viktor', 'Vincenzo', 'Vinzenz', 'Vitali', 'Vladimir', 'Volker', 'Volkmar',
        'Waldemar', 'Walter', 'Walther', 'Wenzel', 'Werner', 'Wieland', 'Wilfried', 'Wilhelm', 'Willi', 'William', 'Willibald', 'Willy', 'Winfried', 'Wladimir', 'Wolf', 'Wolf-Dieter', 'Wolfgang', 'Wolfram', 'Wulf',
        'Xaver',
        'Yusuf',
    );

    // From http://de.wiktionary.org/wiki/Verzeichnis:Deutsch/Liste_der_h%C3%A4ufigsten_weiblichen_Vornamen_Deutschlands
    protected static $firstNameFemale = array(
        'Adele', 'Adelheid', 'Agathe', 'Agnes', 'Alexandra', 'Alice', 'Alma', 'Almut', 'Aloisia', 'Alwine', 'Amalie', 'Ana', 'Anastasia', 'Andrea', 'Anett', 'Anette', 'Angela', 'Angelika', 'Anika', 'Anita', 'Anja', 'Anke', 'Anna', 'Anna-Maria', 'Anne', 'Annegret', 'Annelie', 'Annelies', 'Anneliese', 'Annelore', 'Annemarie', 'Annerose', 'Annett', 'Annette', 'Anni', 'Annika', 'Anny', 'Antje', 'Antonia', 'Antonie', 'Ariane', 'Astrid', 'Auguste', 'Ayse',
        'Babette', 'Barbara', 'Beate', 'Beatrice', 'Beatrix', 'Bernadette', 'Berta', 'Bettina', 'Betty', 'Bianca', 'Bianka', 'Birgit', 'Birgitt', 'Birgitta', 'Birte', 'Brigitta', 'Brigitte', 'Britta', 'Brunhild', 'Brunhilde', 'Bärbel',
        'Carina', 'Carla', 'Carmen', 'Carola', 'Carolin', 'Caroline', 'Cathrin', 'Catrin', 'Centa', 'Charlotte', 'Christa', 'Christel', 'Christiane', 'Christin', 'Christina', 'Christine', 'Christl', 'Cindy', 'Claudia', 'Conny', 'Constanze', 'Cordula', 'Corina', 'Corinna', 'Cornelia', 'Cäcilia', 'Cäcilie',
        'Dagmar', 'Dana', 'Daniela', 'Danuta', 'Denise', 'Diana', 'Dietlinde', 'Dora', 'Doreen', 'Doris', 'Dorit', 'Dorothea', 'Dorothee', 'Du