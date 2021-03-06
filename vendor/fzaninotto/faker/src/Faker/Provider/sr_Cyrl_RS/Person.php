'Sierra Leone', 'Singapore', 'Slovakien', 'Slovenien', 'Somalia', 'Spanien', 'Sri Lanka', 'Storbritannien', 'Sudan', 'Surinam', 'Svalbard och Jan Mayen', 'Sverige', 'Swaziland', 'Sydafrika', 'Sydgeorgien och Södra Sandwichöarna', 'Sydkorea', 'Syrien', 'São Tomé och Príncipe',
        'Tadzjikistan', 'Taiwan', 'Tanzania', 'Tchad', 'Thailand', 'Tjeckien', 'Togo', 'Tokelau', 'Tonga', 'Trinidad och Tobago', 'Tunisien', 'Turkiet', 'Turkmenistan', 'Turks- och Caicosöarna', 'Tuvalu', 'Tyskland',
        'USA', 'USA:s yttre öar', 'Uganda', 'Ukraina', 'Ungern', 'Uruguay', 'Uzbekistan',
        'Vanuatu', 'Vatikanstaten', 'Venezuela', 'Vietnam', 'Vitryssland', 'Västsahara', 'Wallis- och Futunaöarna',
        'Zambia', 'Zimbabwe',
        'Åland',
        'Österrike', 'Östtimor'
    );

    /**
     * @var array Swedish street name formats
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
     * @var array Swedish street address formats
     */
    protected static $streetAddressFormats = array(
        '{{streetName}} {{buildingNumber}}'
    );

    /**
     * @var array Swedish address formats
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

namespace Faker\Provider\sv_SE;

class Company extends \Faker\Provider\Company
{
    protected static $formats = array(
        '{{lastName}} {{companySuffix}}',
        '{{lastName}} {{companySuffix}}',
        '{{lastName}} {{companySuffix}}',
        '{{firstName}} {{lastName}} {{companySuffix}}',
        '{{lastName}} & {{lastName}} {{companySuffix}}',
        '{{lastName}} & {{lastName}}',
        '{{lastName}} och {{lastName}}',
        '{{lastName}} och {{lastName}} {{companySuffix}}'
    );

    protected static $companySuffix = array('AB', 'HB');
    
    protected static $jobTitles = array('Automationsingenjör', 'Bagare', 'Digital Designer', 'Ekonom', 'Ekonomichef', 'Elektronikingenjör', 'Försäljare', 'Försäljningschef', 'Innovationsdirektör', 'Investeringsdirektör', 'Journalist', 'Kock', 'Kulturstrateg', 'Läkare', 'Lokförare', 'Mäklare', 'Programmerare', 'Projektledare', 'Sjuksköterska', 'Utvecklare', 'UX Designer', 'Webbutvecklare');
    
    public function jobTitle()
    {
        return static::randomElement(static::$jobTitles);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

namespace Faker\Provider\sv_SE;

use Faker\Calculator\Luhn;

class Person extends \Faker\Provider\Person
{
    protected static $formats = array(
        '{{firstName}} {{lastName}}',
        '{{firstName}} {{lastName}}',
        '{{firstName}} {{lastName}}',
        '{{firstName}} {{lastName}}',
        '{{firstName}} {{lastName}}',
        '{{firstName}} {{firstName}} {{lastName}}',
        '{{firstName}} {{firstName}} {{lastName}}',
        '{{firstName}} {{firstName}} {{lastName}}',
        '{{firstName}} {{lastName}} {{lastName}}',
        '{{firstName}} {{lastName}}-{{lastName}}',
        '{{firstName}} {{firstName}} {{lastName}}-{{lastName}}',
    );

    /**
     * @var array Swedish female first names
     * @link http://spraakbanken.gu.se/statistik/lbfnamnalf.phtml
     */
    protected static $firstNameFemale = array(

        'Ada', 'Adela', 'Adele', 'Adéle', 'Adelia', 'Adina', 'Adolfina', 'Agda', 'Agnes', 'Agneta', 'Aina', 'Aino', 'Albertina', 'Alexandra', 'Alfhild', 'Alfrida', 'Alice', 'Alida', 'Ally', 'Alma', 'Alva', 'Amalia', 'Amanda', 'Andrea', 'Anette', 'Angela', 'Anita', 'Anja', 'Ann', 'Anna', 'Anna-Carin', 'Anna-Greta', 'Anna-Karin', 'Anna-Lena', 'Anna-Lisa', 'Anna-Maria', 'Anna-Stina', 'Anne', 'Anneli', 'Annelie', 'Annette', 'Anne-Charlotte', 'Anne-Marie', 'Anni', 'Annica', 'Annie', 'Annika', 'Annikki', 'Anny', 'Ann-Britt', 'Ann-Charlott', 'Ann-Charlotte', 'Ann-Christin', 'Ann-Christine', 'Ann-Katrin', 'Ann-Kristin', 'Ann-Louise', 'Ann-Margret', 'Ann-Mari', 'Ann-Marie', 'Ann-Sofi', 'Ann-Sofie', 'Antonia', 'Arvida', 'Asta', 'Astrid', 'Augusta', 'Aurora', 'Axelia', 'Axelina',
        'Barbro', 'Beata', 'Beatrice', 'Beda', 'Berit', 'Bernhardina', 'Berta', 'Betty', 'Birgit', 'Birgitta', 'Blenda', 'Bodil', 'Boel', 'Borghild', 'Brita', 'Britt', 'Britta', 'Britt-Inger', 'Britt-Louise', 'Britt-Mari', 'Britt-Marie',
        'Camilla', 'Carin', 'Carina', 'Carita', 'Carola', 'Carolina', 'Caroline', 'Catarina', 'Catharina', 'Cathrine', 'Catrin', 'Cecilia', 'Charlott', 'Charlotta', 'Charlotte', 'Christel', 'Christin', 'Christina', 'Christine', 'Clara', 'Clary', 'Constance', 'Cristina',
        'Daga', 'Dagmar', 'Dagny', 'Daisy', 'Davida', 'Desideria', 'Desirée', 'Diana', 'Disa', 'Dora', 'Doris', 'Dorotea',
        'Ebba', 'Edit', 'Edith', 'Edla', 'Eira', 'Eivor', 'Ejvor', 'Elaine', 'Eleonor', 'Eleonora', 'Elfrida', 'Elida', 'Elin', 'Elina', 'Elinor', 'Elisabet', 'Elisabeth', 'Elise', 'Ella', 'Ellen', 'Ellinor', 'Elly', 'Elma', 'Elna', 'Elsa', 'Else', 'Else-Marie', 'Elsi', 'Elsie', 'Elsy', 'Elvi', 'Elvira', 'Elvy', 'Emelia', 'Emerentia', 'Emilia', 'Emma', 'Emmy', 'Erika', 'Erna', 'Ester', 'Estrid', 'Ethel', 'Eufemia', 'Eugenia', 'Eva', 'Eva-Britt', 'Eva-Lena', 'Eva-Lotta', 'Eva-Marie', 'Evelina', 'Evelyn', 'Evy', 'Ewa',
        'Fanny', 'Florence', 'Fredrika', 'Frida', 'Frideborg',
        'Gabriella', 'Gerd', 'Gerda', 'Gertie', 'Gertrud', 'Gisela', 'Greta', 'Gudrun', 'Gull', 'Gullan', 'Gullbritt', 'Gulli', 'Gullvi', 'Gully', 'Gull-Britt', 'Gun', 'Gunborg', 'Gunbritt', 'Gunda', 'Gunhild', 'Gunilla', 'Gunn', 'Gunnel', 'Gunni', 'Gunvor', 'Gun-Britt', 'Gurli', 'Gustava', 'Gärd', 'Görel', 'Göta',
        'Hanna', 'Harriet', 'Hedvig', 'Helen', 'Helén', 'Helena', 'Helene', 'Heléne', 'Helfrid', 'Helga', 'Helmi', 'Helny', 'Henny', 'Henrietta', 'Henriette', 'Herta', 'Hilda', 'Hildegard', 'Hildur', 'Hillevi', 'Hilma', 'Hjördis', 'Hulda',
        'Ida', 'Ines', 'Inez', 'Inga', 'Ingalill', 'Inga-Britt', 'Inga-Lena', 'Inga-Lill', 'Inga-Lisa', 'Inga-Maj', 'Ingbritt', 'Ingeborg', 'Ingegerd', 'Ingegärd', 'Ingela', 'Inger', 'Ingrid', 'Ingvor', 'Ing-Britt', 'Ing-Mari', 'Ing-Marie', 'Iréne', 'Irene', 'Iris', 'Irma', 'Isabella',
        'Jane', 'Janet', 'Jeanette', 'Jenny', 'Jessica', 'Johanna', 'Josefina', 'Judit', 'Judith', 'Julia', 'Juliana', 'Justina',
        'Kaarina', 'Kajsa', 'Karin', 'Karina', 'Karla', 'Karola', 'Karolina', 'Katarina', 'Katharina', 'Katrin', 'Katrina', 'Kersti', 'Kerstin', 'Klara', 'Konstantia', 'Kornelia', 'Kristin', 'Kristina', 'Kristine',
        'Laila', 'Laura', 'Leila', 'Lena', 'Leontina', 'Liisa', 'Lilian', 'Lill', 'Lillemor', 'Lillian', 'Lilly', 'Linda', 'Linnéa', 'Linnea', 'Lisa', 'Lisbet', 'Lisbeth', 'Liselott', 'Liselotte', 'Lise-Lott', 'Lise-Lotte', 'Lizzie', 'Lola', 'Louise', 'Lovisa', 'Lucia', 'Lydia',
        'Madeleine', 'Madelene', 'Magda', 'Magdalena', 'Magnhild', 'Maj', 'Maja', 'Majbritt', 'Majken', 'Majlis', 'Majvor', 'Maj-Britt', 'Maj-Lis', 'Malin', 'Malvina', 'Margaret', 'Margareta', 'Margareth', 'Margaretha', 'Margit', 'Margita', 'Margot', 'Margret', 'Margreta', 'Mari', 'Maria', 'Mariana', 'Mariann', 'Marianne', 'Marie', 'Mariette', 'Marie-Louise', 'Marika', 'Marina', 'Marion', 'Marit', 'Marita', 'Mari-Ann', 'Marja', 'Marjatta', 'Marlene', 'Marta', 'Martha', 'Martina', 'Mary', 'Mathilda', 'Matilda', 'Maud', 'May', 'Mia', 'Mildred', 'Mimmi', 'Mirjam', 'Mona', 'Monica', 'Monika', 'Märit', 'Märta', 'Märtha',
        'Naemi', 'Naima', 'Nancy', 'Nanna', 'Nanny', 'Natalia', 'Nelly', 'Nina', 'Nora',
        'Olga', 'Olivia', 'Ottilia',
        'Paula', 'Paulina', 'Pauline', 'Pernilla', 'Petra', 'Petronella', 'Pia',
        'Ragna', 'Ragnhild', 'Rakel', 'Rebecka', 'Regina', 'Renée', 'Rigmor', 'Rita', 'Rosa', 'Rose', 'Rose-Marie', 'Rosita', 'Ros-Mari', 'Ros-Marie', 'Runa', 'Rut', 'Ruth',
        'Sabina', 'Saga', 'Sally', 'Sara', 'Selma', 'Serafia', 'Sibylla', 'Sigbritt', 'Signe', 'Signhild', 'Sigrid', 'Siri', 'Siv', 'Sofi', 'Sofia', 'Sofie', 'Solbritt', 'Solveig', 'Solvig', 'Sonja', 'Stina', 'Susann', 'Susanna', 'Susanne', 'Suzanne', 'Svea', 'Sylvia', 'Synnöve', 'Syster',
        'Tea', 'Tekla', 'Terese', 'Teresia', 'Therése', 'Therese', 'Theresia', 'Thyra', 'Tina', 'Tora', 'Torborg', 'Tove', 'Tyra',
        'Ulla', 'Ulla-Britt', 'Ulla-Britta', 'Ulrica', 'Ulrika', 'Ursula',
        'Valborg', 'Vanja', 'Vega', 'Vendela', 'Vendla', 'Vera', 'Veronica', 'Veronika', 'Victoria', 'Viktoria', 'Vilhelmina', 'Vilma', 'Viola', 'Virginia', 'Vivan', 'Viveca', 'Viveka', 'Vivi', 'Vivian', 'Viviann', 'Vivianne', 'Vivi-Ann', 'Vivi-Anne',
        'Wilhelmina',
        'Ylva', 'Yvonne',
        'Åsa', 'Åse'
    );

    /**
     * @var array Swedish male first names
     * @link http://spraakbanken.gu.se/statistik/lbfnamnalf.phtml
     */
    protected static $firstNameMale = array(
        'Abraham', 'Adam', 'Adolf', 'Adrian', 'Agaton', 'Agne', 'Albert', 'Albin', 'Aldor', 'Alex', 'Alexander', 'Alexis', 'Alexius', 'Alf', 'Alfons', 'Alfred', 'Algot', 'Allan', 'Alrik', 'Alvar', 'Alve', 'Amandus', 'Anders', 'André', 'Andreas', 'Anselm', 'Anshelm', 'Antero', 'Anton', 'Antonius', 'Arne', 'Arnold', 'Aron', 'Arthur', 'Artur', 'Arvid', 'Assar', 'Astor', 'August', 'Augustin', 'Axel',
        'Bengt', 'Bengt-Göran', 'Bengt-Olof', 'Bengt-Åke', 'Benny', 'Berndt', 'Berne', 'Bernhard', 'Bernt', 'Bert', 'Berth', 'Berthold', 'Bertil', 'Bill', 'Billy', 'Birger', 'Bjarne', 'Björn', 'Bo', 'Boris', 'Bror', 'Bruno', 'Brynolf', 'Börje',
        'Carl', 'Carl-Axel', 'Carl-Erik', 'Carl-Gustaf', 'Carl-Gustav', 'Carl-Johan', 'Charles', 'Christer', 'Christian', 'Claes', 'Claes-Göran', 'Clarence', 'Clas', 'Conny', 'Crister', 'Curt',
        'Dag', 'Dan', 'Daniel', 'David', 'Dennis', 'Dick', 'Donald', 'Douglas',
        'Ebbe', 'Eddie', 'Eddy', 'Edgar', 'Edmund', 'Edvard', 'Edvin', 'Efraim', 'Egon', 'Eilert', 'Einar', 'Eje', 'Ejnar', 'Elias', 'Elis', 'Ellert', 'Elmer', 'Elof', 'Elon', 'Elov', 'Elving', 'Elvir', 'Emanuel', 'Emil', 'Enar', 'Engelbert', 'Engelbrekt', 'Enok', 'Erhard', 'Eric', 'Erik', 'Erland', 'Erling', 'Ernfrid', 'Ernst', 'Esbjörn', 'Eskil', 'Eugén', 'Eugen', 'Evald', 'Eve', 'Evert',
        'Fabian', 'Felix', 'Ferdinand', 'Filip', 'Fingal', 'Finn', 'Folke', 'Frank', 'Frans', 'Franz', 'Fred', 'Fredrik', 'Fridolf', 'Friedrich', 'Fritiof', 'Fritjof', 'Frits', 'Fritz',
        'Gabriel', 'Georg', 'George', 'Gerhard', 'Gert', 'Gideon', 'Gilbert', 'Gillis', 'Glenn', 'Gottfrid', 'Gotthard', 'Greger', 'Gudmund', 'Gunder', 'Gunnar', 'Gustaf', 'Gustav', 'Göran', 'Görgen', 'Gösta', 'Göte',
        'Hadar', 'Halvar', 'Halvard', 'Hans', 'Hans-Erik', 'Hans-Olof', 'Hans-Åke', 'Harald', 'Hardy', 'Harry', 'Hartvig', 'Hasse', 'Heinrich', 'Heinz', 'Helge', 'Helmer', 'Henning', 'Henric', 'Henrik', 'Henry', 'Herbert', 'Heribert', 'Herman', 'Hilbert', 'Hilding', 'Hilmer', 'Hjalmar', 'Holger', 'Holmfrid', 'Hubert', 'Hugo', 'Håkan',
        'Inge', 'Ingemar', 'Ingmar', 'Ingvald', 'Ingvar', 'Isak', 'Isidor', 'Ivan', 'Ivar',
        'Jack', 'Jacob', 'Jakob', 'James', 'Jan', 'Janne', 'Jan-Eric', 'Jan-Erik', 'Jan-Olof', 'Jan-Olov', 'Jan-Ove', 'Jan-Åke', 'Jarl', 'Jean', 'Jens', 'Jerker', 'Jerry', 'Jesper', 'Jim', 'Jimmy', 'Joachim', 'Joacim', 'Joakim', 'Joel', 'Johan', 'Johannes', 'John', 'Johnny', 'Johny', 'Jon', 'Jonas', 'Jonny', 'Josef', 'Juhani', 'Julius', 'Justus', 'Jöns', 'Jörgen',
        'Kai', 'Kaj', 'Kalevi', 'Karl', 'Karl-Axel', 'Karl-Erik', 'Karl-Gunnar', 'Karl-Gustaf', 'Karl-Gustav', 'Karl-Johan', 'Kennert', 'Kennet', 'Kenneth', 'Kenny', 'Kent', 'Kenth', 'Kjell', 'Kjell-Åke', 'Klas', 'Knut', 'Konrad', 'Konstantin', 'Krister', 'Kristian', 'Kristoffer', 'Kurt', 'Kåre',
        'Lage', 'Lambert', 'Lars', 'Lars-Eric', 'Lars-Erik', 'Lars-Gunnar', 'Lars-Göran', 'Lars-Olof', 'Lars-Olov', 'Lars-Ove', 'Lars-Åke', 'Laurentius', 'Leander', 'Leif', 'Lennart', 'Leo', 'Leon', 'Leonard', 'Leopold', 'Levi', 'Levin', 'Linné', 'Linus', 'Lorentz', 'Louis', 'Ludvig',
        'Magni', 'Magnus', 'Malkolm', 'Malte', 'Manfred', 'Manne', 'Marcus', 'Markus', 'Martin', 'Mathias', 'Mats', 'Matti', 'Mattias', 'Matts', 'Maurits', 'Mauritz', 'Max', 'Melker', 'Micael', 'Michael', 'Mickael', 'Mikael', 'Morgan', 'Måns', 'Mårten',
        'Napoleon', 'Natanael', 'Nicklas', 'Niclas', 'Niklas', 'Nikolaus', 'Nils', 'Nils-Erik', 'Nore',
        'Odd', 'Ola', 'Olaus', 'Olav', 'Olavi', 'Ole', 'Oliver', 'Olle', 'Olof', 'Olov', 'Orvar', 'Oscar', 'Oskar', 'Ossian', 'Osvald', 'Otto', 'Ove', 'Owe',
        'Patric', 'Patrick', 'Patrik', 'Paul', 'Peder', 'Per', 'Percy', 'Per-Anders', 'Per-Arne', 'Per-Erik', 'Per-Ola', 'Per-Olof', 'Per-Olov', 'Per-Åke', 'Peter', 'Petrus', 'Petter', 'Pierre', 'Pontus', 'Pär',
        'Ragnar', 'Ragnvald', 'Ralf', 'Ralph', 'Raymond', 'Reidar', 'Reine', 'Reinhold', 'Reino', 'Richard', 'Rickard', 'Rikard', 'Robert', 'Roger', 'Roine', 'Roland', 'Rolf', 'Ronald', 'Ronnie', 'Ronny', 'Roy', 'Ruben', 'Rudolf', 'Runar', 'Rune', 'Runo', 'Rutger',
        'Salomon', 'Sam', 'Samuel', 'Sanfrid', 'Sebastian', 'Set', 'Seth', 'Seved', 'Severin', 'Sigfrid', 'Sigmund', 'Signar', 'Sigurd', 'Sigvard', 'Simon', 'Sivert', 'Sixten', 'Sonny', 'Staffan', 'Stanley', 'Stefan', 'Stellan', 'Sten', 'Stephan', 'Steve', 'Stig', 'Sture', 'Sune', 'Svante', 'Sven', 'Sven-Erik', 'Sven-Olof', 'Sven-Olov', 'Sven-Åke', 'Sverker', 'Sölve', 'Sören',
        'Tage', 'Ted', 'Teodor', 'Theodor', 'Thomas', 'Thor', 'Thorbjörn', 'Thord', 'Thore', 'Thorsten', 'Thorvald', 'Thure', 'Tobias', 'Toivo', 'Tom', 'Tomas', 'Tommy', 'Tonny', 'Tony', 'Tor', 'Torbjörn', 'Tord', 'Tore', 'Torgny', 'Torkel', 'Torsten', 'Torvald', 'Tryggve', 'Ture', 'Tyko',
        'Ulf', 'Ulrik', 'Uno', 'Urban',
        'Valdemar', 'Valentin', 'Valfrid', 'Vallentin', 'Valter', 'Veine', 'Verner', 'Victor', 'Vidar', 'Viggo', 'Viking', 'Viktor', 'Vilgot', 'Vilhelm', 'Villiam', 'Villy', 'Vincent', 'Vitalis',
        'Waldemar', 'Walter', 'Werner', 'Wilhelm', 'William', 'Willy',
        'Yngve',
        'Åke',
        'Örjan', 'Östen'
    );

    /**
     * @var array Swedish common last names
     * @link http://www.scb.se/sv_/Hitta-statistik/Statistik-efter-amne/Befolkning/Amnesovergripande-statistik/Namnstatistik/30898/2012A01x/Samtliga-folkbokforda--Efternamn-topplistor/Efternamn-topp-100/
     */
    protected static $lastName = array(

        'Abrahamsson', 'Andersson', 'Andreasson', 'Arvidsson', 'Axelsson',
        'Bengtsson', 'Berg', 'Berggren', 'Berglund', 'Bergman', 'Bergqvist', 'Bergström', 'Björk', 'Björklund', 'Blom', 'Blomqvist',
        'Claesson',
        'Dahlberg', 'Danielsson',
        'Engström', 'Ek', 'Eklund', 'Ekström', 'Eliasson', 'Eriksson',
        'Falk', 'Forsberg', 'Fransson', 'Fredriksson',
        'Gunnarsson', 'Gustafsson',
        'Hansen', 'Hansson', 'Hedlund', 'Hellström', 'Henriksson', 'Hermansson', 'Holm', 'Holmberg', 'Holmgren', 'Holmqvist', 'Håkansson',
        'Isaksson', 'Ivarsson',
        'Jakobsson', 'Jansson', 'Johansson', 'Jonasson', 'Jonsson', 'Jönsson',
        'Karlsson',
        'Larsson', 'Lind', 'Lindberg', 'Lindgren', 'Lindholm', 'Lindqvist', 'Lindström', 'Lund', 'Lundberg', 'Lundgren', 'Lundin', 'Lundqvist', 'Lundström', 'Löfgren',
        'Magnusson', 'Martinsson', 'Mattsson', 'Månsson', 'Mårtensson',
        'Nilsson', 'Norberg', 'Nordin', 'Nordström', 'Nyberg', 'Nyström',
        'Olofsson', 'Olsson',
        'Persson', 'Pettersson', 'Pålsson',
        'Samuelsson', 'Sandberg', 'Sandström', 'Sjöberg', 'Sjögren', 'Ström', 'Strömberg', 'Sundberg', 'Sundqvist', 'Sundström', 'Svensson', 'Söderberg',
        'Viklund',
        'Wallin', 'Wikström',
        'Åberg', 'Åkesson', 'Åström',
        'Öberg'
    );

    /**
     * National Personal Identity number (personnummer)
     * @link http://en.wikipedia.org/wiki/Personal_identity_number_(Sweden)
     * @param \DateTime $birthdate
     * @param string $gender Person::GENDER_MALE || Person::GENDER_FEMALE
     * @return string on format XXXXXX-XXXX
     */
    public function personalIdentityNumber(\DateTime $birthdate = null, $gender = null)
    {
        if (!$birthdate) {
            $birthdate = \Faker\Provider\DateTime::dateTimeThisCentury();
        }
        $datePart = $birthdate->format('ymd');

        if ($gender && $gender == static::GENDER_MALE) {
            $randomDigits = (string)static::numerify('##') . static::randomElement(array(1,3,5,7,9));
        } elseif ($gender && $gender == static::GENDER_FEMALE) {
            $randomDigits = (string)static::numerify('##') . static::randomElement(array(0,2,4,6,8));
        } else {
            $randomDigits = (string)static::numerify('###');
        }


        $checksum = Luhn::computeCheckDigit($datePart . $randomDigits);

        return $datePart . '-' . $randomDigits . $checksum;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

namespace Faker\Provider\sv_SE;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    /**
     * @var array Swedish phone number formats
     */
    protected static $formats = array(
        '08-### ### ##',
        '0%#-### ## ##',
        '0%########',
        '+46 (0)%## ### ###',
        '+46(0)%########',
        '+46 %## ### ###',
        '+46%########',

        '08-### ## ##',
        '0%#-## ## ##',
        '0%##-### ##',
        '0%#######',
        '+46 (0)8 ### ## ##',
        '+46 (0)%# ## ## ##',
        '+46 (0)%## ### ##',
        '+46 (0)%#######',
        '+46(0)%#######',
        '+46%#######',

        '08-## ## ##',
        '0%#-### ###',
        '0%#######',
        '+46 (0)%######',
        '+46(0)%######',
        '+46%######',
    );
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Faker\Provider\th_TH;

class Address extends \Faker\Provider\Address
{
    protected static $cityPrefix = array(
        'เมือง', 'หมู่บ้าน', 'ท่า',
    );

    protected static $citySuffix = array(
        'เหนือ', 'ใต้', 'บุรี',
    );

    protected static $buildingNumber = array(
        '#####', '####', '###', '##', '##/###',
    );

    protected static $streetPrefix = array(
        'ซอย', 'ถนน', 'สะพาน', 'วงเวียน', 'แยก',
    );

    protected static $postcode = array('#####');

    /**
     * @var array Thai province names
     * @link https://th.wikipedia.org/wiki/%E0%B8%88%E0%B8%B1%E0%B8%87%E0%B8%AB%E0%B8%A7%E0%B8%B1%E0%B8%94%E0%B9%83%E0%B8%99%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B9%80%E0%B8%97%E0%B8%A8%E0%B9%84%E0%B8%97%E0%B8%A2
     */
    protected static $province = array(
        'กระบี่', 'กรุงเทพมหานคร', 'กาญจนบุรี', 'กาฬสินธุ์', 'กำแพงเพชร', 'ขอนแก่น',
        'จันทบุรี', 'ฉะเชิงเทรา', 'ชลบุรี', 'ชัยนาท', 'ชัยภูมิ', 'ชุมพร',
        'ตรัง', 'ตราด', 'ตาก', 'นครนายก', 'นครปฐม', 'นครพนม', 'นครราชสีมา',
        'นครศรีธรรมราช', 'นครสวรรค์', 'นนทบุรี', 'นราธิวาส', 'น่าน',
        'บึงกาฬ', 'บุรีรัมย์', 'ปทุมธานี', 'ประจวบคีรีขันธ์', 'ปราจีนบุรี', 'ปัตตานี',
        'พระนครศรีอยุธยา', 'พะเยา', 'พังงา', 'พัทลุง', 'พิจิตร', 'พิษณุโลก', 'ภูเก็ต',
        'มหาสารคาม', 'มุกดาหาร', 'ยะลา', 'ยโสธร', 'ระนอง', 'ระยอง', 'ราชบุรี', 'ร้อยเอ็ด',
        'ลพบุรี', 'ลำปาง', 'ลำพูน', 'ศรีสะเกษ', 'สกลนคร', 'สงขลา', 'สตูล', 'สมุทรปราการ', 'สมุทรสงคราม',
        'สมุทรสาคร', 'สระบุรี', 'สระแก้ว', 'สิงห์บุรี', 'สุพรรณบุรี', 'สุราษฎร์ธานี', 'สุรินทร์', 'สุโขทัย',
        'หนองคาย', 'หนองบัวลำภู', 'อำนาจเจริญ', 'อุดรธานี', 'อุตรดิตถ์', 'อุทัยธานี', 'อุบลราชธานี', 'อ่างทอง',
        'เชียงราย', 'เชียงใหม่', 'เพชรบุรี', 'เพชรบูรณ์', 'เลย', 'แพร่', 'แม่ฮ่องสอน',
    );

    /**
     * @var array Country names in Thai
     * @link https://th.wikipedia.org/wiki/%E0%B8%A3%E0%B8%B2%E0%B8%A2%E0%B8%8A%E0%B8%B7%E0%B9%88%E0%B8%AD%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B9%80%E0%B8%97%E0%B8%A8_%E0%B8%94%E0%B8%B4%E0%B8%99%E0%B9%81%E0%B8%94%E0%B8%99_%E0%B9%81%E0%B8%A5%E0%B8%B0%E0%B9%80%E0%B8%A1%E0%B8%B7%E0%B8%AD%E0%B8%87%E0%B8%AB%E0%B8%A5%E0%B8%A7%E0%B8%87
     */
    protected static $country = array(
        'กรีซ', 'กัมพูชา', 'กัวเตมาลา', 'กาตาร์', 'คอซอวอ', 'คาซัคสถาน', 'คิริบาส', 'คิวบา', 'คีร์กีซสถาน', 'คูเวต',
        'จอร์เจีย', 'จอร์แดน', 'จาเมกา', 'จีน','ชิลี', 'ซานมารีโน', 'ซามัว', 'ซาอุดีอาระเบีย', 'ซีเรีย', 'ซูรินาม',
        'ญี่ปุ่น', 'ดอมินีกา', 'ตรินิแดดและโตเบโก', 'ตองกา', 'ติมอร์-เลสเต', 'ตุรกี', 'ตูวาลู', 'ทาจิกิสถาน',
        'นครรัฐวาติกัน', 'นอร์เวย์', 'นาอูรู', 'นิการากัว', 'นิวซีแลนด์', 'บราซิล', 'บรูไนดารุสซาลาม', 'บอสเนียและเฮอร์เซโกวีนา',
        'บังกลาเทศ', 'บัลแกเรีย', 'บาร์เบโดส', 'บาห์เรน', 'บาฮามาส', 'ปากีสถาน', 'ปานามา', 'ปาปัวนิวกินี', 'ปารากวัย', 'ปาเลา',
        'ฝรั่งเศส', 'พม่า', 'ฟิจิ', 'ฟินแลนด์', 'ฟิลิปปินส์', 'ภูฏาน', 'มองโกเลีย', 'มอนเตเนโกร', 'มอลตา','มอลโดวา', 'มัลดีฟส์', 'มาเลเซีย',
        'ยูเครน', 'รัสเซีย', 'ลักเซมเบิร์ก', 'ลัตเวีย', 'ลาว', 'ลิกเตนสไตน์','ลิทัวเนีย', 'ศรีลังกา',
        'สวิตเซอร์แลนด์', 'สวีเดน', 'สหรัฐอาหรับเอมิเรตส์', 'สหรัฐอเมริกา', 'สหราชอาณาจักร', 'สาธารณรัฐมาซิโดเนีย', 'สาธารณรัฐเช็ก', 'สาธารณรัฐโดมินิกัน',
        'สิงคโปร์', 'สเปน', 'สโลวาเกีย', 'สโลวีเนีย', 'หมู่เกาะมาร์แชลล์', 'หมู่เกาะโซโลมอน',
        'ออสเตรีย', 'ออสเตรเลีย', 'อันดอร์รา', 'อัฟกานิสถาน', 'อาร์มีเนีย', 'อาร์เจนตินา', 'อาเซอร์ไบจาน',
        'อิตาลี', 'อินเดีย', 'อินโดนีเซีย', 'อิรัก', 'อิสราเอล', 'อิหร่าน', 'อุซเบกิสถาน', 'อุรุกวัย', 'ฮอนดูรัส', 'ฮังการี',
        'เกรเนดา', 'เกาหลีเหนือ', 'เกาหลีใต้', 'เซนต์คิตส์และเนวิส', 'เซนต์ลูเซีย', 'เซนต์วินเซนต์และเกรนาดีนส์', 'เซอร์เบีย',
        'เดนมาร์ก', 'เติร์กเมนิสถาน', 'เนปาล', 'เนเธอร์แลนด์', 'เบลารุส', 'เบลีซ', 'เบลเยียม', 'เปรู', 'เม็กซิโก',
        'เยอรมนี', 'เยเมน', 'เลบานอน', 'เวียดนาม', 'เวเนซุเอลา', 'เอกวาดอร์', 'เอลซัลวาดอร์', 'เอสโตเนีย', 'เฮติ',  'แคนาดา',
        'แอนติกาและบาร์บูดา', 'แอลเบเนีย', 'โครเอเชีย', 'โคลอมเบีย', 'โบลิเวีย', 'โปรตุเกส', 'โปแลนด์', 'โมนาโก', 'โรมาเนีย',
        'โอมาน', 'ไซปรัส', 'ไทย', 'ไมโครนีเซีย', 'ไอซ์แลนด์', 'ไอร์แลนด์',
    );

    protected static $cityFormats = array(
        '{{cityPrefix}} {{firstName}}{{citySuffix}}',
        '{{cityPrefix}} {{firstName}}',
        '{{firstName}}{{citySuffix}}',
        '{{lastName}}{{citySuffix}}',
    );

    protected static $streetNameFormats = array(
        '{{firstName}} {{streetSuffix}}',
        '{{lastName}} {{streetSuffix}}'
    );

    protected static $streetAddressFormats = array(
        '{{buildingNumber}} {{streetName}}',
    );
    
    protected static $addressFormats = array(
        "{{streetAddress}}\n{{city}}, {{postcode}}",
    );

    /**
     * @example 'เมือง'
     */
    public static function cityPrefix()
    {
        return static::randomElement(static::$cityPrefix);
    }

    /**
     * @example 'กรุงเทพมหานคร'
     */
    public static function province()
    {
        return static::randomElement(static::$province);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

namespace Faker\Provider\th_TH;

class Color extends \Faker\Provider\Color
{
    protected static $safeColorNames = array(
        'ขาว','ชมพู','ดำ','น้ำตาล','น้ำเงิน','ฟ้า','ม่วง','ส้ม','เขียว','เขียวอ่อน','เหลือง','แดง'
    );

    protected static $allColorNames = array(
         'กากี','ขาว','คราม','ชมพู','ดำ','ทอง','นาค','น้ำตาล',
         'น้ำเงิน','ฟ้า','ม่วง','ส้ม','เขียว','เขียวอ่อน',
         'เงิน','เทา','เหลือง','เหลืองอ่อน','แดง','่ขี้ม้า'
    );
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

namespace Faker\Provider\th_TH;

class Company extends \Faker\Provider\Company
{
    protected static $slogans = array(
        array(
            'เชื่อมต่อ', 'สรรสร้าง', 'เชื่อมโยง', 'ส่งเสริม', 'เปลี่ยน', 'ประสาน', 'พัฒนา',
        ),
        array(
            'ตลาด', 'อุตสาหกรรม', 'โครงสร้าง', 'เทคโนโลยี', 'เนื้อหา', 'สถาปัตยกรรม', 'ระบบ', 'ความคิด', 'ผู้ใช้', 'เครือข่าย', 'ประสบการณ์',
        ),
        array(
            'ที่แข็งแกร่ง', 'ที่มีคุณค่า', 'ที่สร้างสรรค์', '24 ชั่วโมง', 'อย่างสากล', 'สู่ผู้บริโภค', 'ที่น่าดึงดูด', 'อย่างมีประสิทธิภาพ', 'อย่างไร้รอยต่อ', 'อย่างไร้ที่ติ', 'ที่ปรับตัวได้', 'คุณภาพสากล', 'พร้อมใช้งาน', 'ที่มีความหมาย', 'ที่โปร่งใส', 'เพื่อการเปลี่ยนแปลง', 'สมัยใหม่', 'รูปแบบใหม่',
        ),
    );

    /**
     * @example 'เชื่อมต่อตลาดที่แข็งแกร่ง'
     */
    public function slogan()
    {
        $result = array();

        foreach (static::$slogans as &$slogan) {
            $result[] = static::randomElement($slogan);
        }

        return implode($result);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Faker\Provider\th_TH;

class Payment extends \Faker\Provider\Payment
{
    /**
     * @var array Thai bank names
     * @link https://th.wikipedia.org/wiki/%E0%B8%A3%E0%B8%B2%E0%B8%A2%E0%B8%8A%E0%B8%B7%E0%B9%88%E0%B8%AD%E0%B8%98%E0%B8%99%E0%B8%B2%E0%B8%84%E0%B8%B2%E0%B8%A3%E0%B9%83%E0%B8%99%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B9%80%E0%B8%97%E0%B8%A8%E0%B9%84%E0%B8%97%E0%B8%A2
     */
    protected static $banks = array(
        'ธนาคารแห่งประเทศไทย',
        'ธนาคารกรุงเทพ',
        'ธนาคารกรุงศรีอยุธยา',
        'ธนาคารกสิกรไทย',
        'ธนาคารเกียรตินาคิน',
        'ธนาคารซีไอเอ็มบีไทย',
        'ธนาคารทหารไทย',
        'ธนาคารทิสโก้',
        'ธนาคารไทยพาณิชย์',
        'ธนาคารไทยเครดิตเพื่อรายย่อย',
        'ธนาคารธนชาต',
        'ธนาคารยูโอบี',
        'ธนาคารแลนด์ แอนด์ เฮาส์',
        'ธนาคารสแตนดาร์ดชาร์เตอร์ด (ไทย)',
        'ธนาคารกรุงไทย',
        'ธนาคารพัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย',
        'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร',
        'ธนาคารเพื่อการส่งออกและนำเข้าแห่งประเทศไทย',
        'ธนาคารออมสิน',
        'ธนาคารอาคารสงเคราะห์',
        'ธนาคารอิสลามแห่งประเทศไทย',
        'ธนาคารไอซีบีซี (ไทย)',
    );

    /**
     * @example 'ธนาคารกสิกรไทย'
     */
    public static function bank()
    {
        return static::randomElement(static::$banks);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

namespace Faker\Provider\th_TH;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    /**
     * @var array Thai phone number formats
     * @link http://www4.sit.kmutt.ac.th/content/%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B9%80%E0%B8%82%E0%B8%B5%E0%B8%A2%E0%B8%99%E0%B8%AB%E0%B8%A1%E0%B8%B2%E0%B8%A2%E0%B9%80%E0%B8%A5%E0%B8%82%E0%B9%82%E0%B8%97%E0%B8%A3%E0%B8%A8%E0%B8%B1%E0%B8%9E%E0%B8%97%E0%B9%8C%E0%B9%83%E0%B8%AB%E0%B9%89%E0%B8%96%E0%B8%B9%E0%B8%81%E0%B8%95%E0%B9%89%E0%B8%AD%E0%B8%87
     */
    protected static $formats = array(
        '0 #### ####',
        '+66 #### ####',
        '0########',
    );

    /**
     * @var array Thai mobile phone number formats
     */
    protected static $mobileFormats = array(
      '08# ### ####',
      '08 #### ####',
      '09# ### ####',
      '09 #### ####',
      '06# ### ####',
      '06 #### ####',
    );

    /**
     * Returns a Thai mobile phone number
     * @return string
     */
    public static function mobileNumber()
    {
        return static::numerify(static::randomElement(static::$mobileFormats));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

namespace Faker\Provider\tr_TR;

class Address extends \Faker\Provider\Address
{
    protected static $buildingNumber = array('###', '##', '#');

    protected static $streetSuffix = array(
        'Sokak', 'Caddesi', 'Kavşağı', 'Durağı', 'İş Hanı', 'Mevkii'
    );

    protected static $postcode = array('#####');

    /**
    * @var array Cities of Turkey, for future updates please use @link https://tr.wikipedia.org/wiki/T%C3%BCrkiye'nin_illeri
    */
    protected static $cityNames = array(
        'Adana','Adıyaman','Afyonkarahisar','Ağrı','Aksaray','Amasya','Ankara','Antalya','Ardahan','Artvin','Aydın',
        'Balıkesir','Bartın','Batman','Bayburt','Bilecik','Bingöl','Bitlis','Bolu','Burdur','Bursa',
        'Çanakkale','Çankırı','Çorum',
        'Denizli','Diyarbakır','Düzce',
        'Edirne','Elazığ','Erzincan','Erzurum','Eskişehir',
        'Gaziantep','Giresun','Gümüşhane',
        'Hakkari','Hatay',
        'Iğdır','Isparta','İstanbul','İzmir',
        'Kahramanmaraş','Karabük','Karaman','Kars','Kastamonu','Kayseri','Kilis',
        'Kırıkkale','Kırklareli','Kırşehir','Kocaeli','Konya','Kütahya',
        'Malatya','Manisa','Mardin','Mersin','Muğla','Muş',
        'Nevşehir','Niğde',
        'Ordu','Osmaniye',
        'Rize',
        'Sakarya','Samsun','Şanlıurfa','Siirt','Sinop','Şırnak','Sivas',
        'Tekirdağ','Tokat','Trabzon','Tunceli',
        'Uşak',
        'Van',
        'Yalova','Yozgat',
        'Zonguldak'
    );

    /**
    * @var array Countries in Turkish
    * @link https://tr.wikipedia.org/wiki/%C3%9Clkeler_listesi
    */
    protected static $country = array(
        'Almanya','Amerika Birleşik Devletleri','Arjantin','Arnavutluk','Avustralya','Avusturya','Azerbaycan',
        'Bahreyn','Belçika','Beyaz Rusya','Birleşik Arap Emirlikleri','Bosna-hersek','Brezilya','Bulgaristan',
        'Çek Cumhuriyeti','Cezayir','Çin Halk Cumhuriyeti',
        'Danimarka','Dominik Cumhuriyeti',
        'Endonezya','Ermenistan','Estonya',
        'Fas','Filipinler','Filistin','Finlandiya','Fransa',
        'Güney Afrika Cumhuriyeti','Güney Kore','Gürcistan',
        'Hindistan','Hırvatistan','Hollanda',
        'İngiltere','Irak','İran','İrlanda','İskoçya','İspanya','İsrail','İsveç','İsviçre','İtalya',
        'Jamaika','Japonya',
        'Kamboçya','Kanada','Karadağ','Kazakistan','Kıbrıs','Kırgızistan','Kosta Rika','Küba','Kuzey Kore',
        'Letonya','Libya','Litvanya','Lübnan','Lüksemburg',
        'Macaristan','Makedonya','Maldivler','Malta','Maurıtıus','Mısır',
        'Nepal',
        'Özbekistan',
        'Pakistan','Polonya','Portekiz','Romanya',
        'Rusya',
        'Sırbistan','Slovakya','Slovenya',
        'Sri Lanka','Sudan','Suriye','Suudi Arabistan',
        'Tacikistan','Tayland','Tayvan','Tunus','Türkiye',
        'Ukrayna','Umman','Ürdün',
        'Venezuela','Vietnam',
        'Yemen','Yeni Zelanda','Yeşil Burun','Yunanistan',
        'Zambiya','Zimbabve'
    );

    protected static $cityFormats = array(
        '{{cityName}}',
    );

    protected static $streetNameFormats = array(
        '{{lastName}} {{streetSuffix}}',
        '{{firstName}} {{streetSuffix}}',
        '{{firstName}} {{streetSuffix}}'
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
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

namespace Faker\Provider\tr_TR;

class Color extends \Faker\Provider\Color
{
    /**
     * @link http://tr.wikipedia.org/wiki/Renkler_listesi
     */
    protected static $safeColorNames = array(
        'siyah', 'kırmızı', 'sarı', 'mavi', 'turuncu',
        'yeşil', 'mor', 'gümüş', 'gri', 'pembe',
    );

    protected static $allColorNames = array(
        'Alev kırmızısı', 'Alice mavisi', 'Alizarin', 'Altunî', 'Ametist', 'Armut',
        'Akuamarin', 'Asker yeşili', 'Bakır', 'Barut', 'Bataklık yeşili',
        'Bebek mavisi', 'Bej', 'Beyaz', 'Bondi mavisi', 'Bordo',
        'Bronz', 'Buğday', 'Burgonya', 'Camgöbeği', 'Çam yeşili', 'Çay yeşili',
        'Çelik mavisi', 'Çikolata', 'Çivit', 'Deniz mavisi', 'Deniz yeşili',
        'Devedikeni', 'Eğrelti yeşili', 'Elektrik mavisi', 'Elektrik çivit', 'Elektrik lime', 'Elektrik mor',
        'Falu kırmızısı', 'Fildişi', 'Fransız gül', 'Galibarda', 'Gece mavisi', 'Gök mavisi',
        'Gri', 'Gri-kuşkonmaz', 'Gül', 'Gümüşi', 'Haki', 'Hardal',
        'Havuç', 'Horozibiği', 'İlkbahar yeşili', 'İslam yeşili', 'Kabak', 'Kahverengi',
        'Kahverengimsi gri', 'Kamuflâj yeşili', 'Karanfil pembesi', 'Karanfil', 'Kardinal',
        'Karolina mavisi', 'Kayısı', 'Kehribar', 'Kestane',
        'Keten', 'Kırmızı', 'Kırmızımsı kahverengi', 'Kırmızı-menekşe', 'Kiraz kırmızısı',
        'Kobalt', 'Kobalt mavisi', 'Koyu galibarda', 'Koyu haki', 'Koyu kahverengi',
        'Koyu kestane', 'Koyu kırmızı', 'Koyu kızıl kahverengi', 'Koyu leylak', 'Koyu magenta',
        'Koyu mandalina', 'Koyu mavi', 'Koyu menekşe', 'Koyu mercan',
        'Koyu mor', 'Koyu pastel yeşil', 'Koyu pembe', 'Koyu şeftali', 'Koyu turkuaz',
        'Koyu toz mavi', 'Koyu turkuaz', 'Koyu yeşil', 'Kösele', 'Krem',
        'Kum kahverengisi', 'Kuşkonmaz', 'Lacivert', 'Lacivert',
        'Lavanta', 'Lavanta mavisi', 'Lavender pembesi', 'Lavender greisi',
        'Lavender magenta', 'Lavanta pembesi', 'Lavanta mor', 'Lavanta gül', 'Limoni', 'Açık Limon',
        'Leylak', 'Lime', 'Mandalina', 'Malakit', 'Mavi',
        'Menekşe', 'Menekşe-patlıcan', 'Mısır', 'Mor', 'Morsalkım',
        'Nane yeşili', 'Nar', 'Navajo beyazı', 'Okul otobüsü sarısı', 'Parlak mor',
        'Pas', 'Pastel pembe', 'Pastel yeşili', 'Patlıcan', 'Pembe',
        'Pembe-turuncu', 'Peygamber çiçeği', 'Prusya mavisi', 'Safran', 'Safir',
        'Sarımsı kahverengi', 'Sarımsı pembe', 'Sarı', 'Sarı',
        'Siyahımsı koyu kahverengi', 'Soluk sarı', 'Şeftali', 'Şeftali-turuncu', 'Şeftali-sarı',
        'Tarçın', 'Teal', 'Toz mavi', 'Turkuaz',
        'Turuncumsu sarı', 'Turuncu', 'Turuncumsu sarı', 'Yeşil', 'Yeşil-sarı', 'Yonca yeşili',
        'Yosun yeşili', 'Zeytuni', 'Zümrüt yeşili', 'Yanık turuncu', 'Yanık Toprak',
        'Kardinal', 'Şarap', 'Celadon', 'Berrak mavi',
        'Gök mavisi', 'Gül', 'Mercan', 'Mercan Kırmızısı', 'Kıpkırmızı', 'Hile mavisi',
        'Altınımsı', 'Soytarı', 'Siğil otu', 'Holivod kırmızısı', 'Sıcak Magenta',
        'Sıcak pembe', 'Uluslararası Klein mavisi', 'Enternasyonal turuncu', 'Yeşim', 'Orta şarap',
        'Orta Mor', 'Dağ pembesi', 'Aşı boyası', 'Eski altın', 'Eski iplik', 'Eski Lavanta',
        'Eski gül', 'Zeytin Kahverengisi', 'Donuk turuncu', 'Papaya',
        'Periwinkle', 'Pers mavisi', 'Pers yeşili', 'Persian lacivert', 'Pers pembesi',
        'Persian kırmızısı', 'Pers gülü', 'Ham toprak', 'Kızıl yumurta mavisi',
        'Kraliyet mavisi', 'Kırmızı şarap', 'Kırmızı', 'Deniz kabuğu', 'Ayrık sarı',
        'Vurgun pembe', 'Salamura grisi', 'Tenné (Tawny)', 'Küçük kara', 'Lacivert', 'Viridian',
        'Zinnwaldite',
    );
}
                                                                                                                                                                                                                                                                                                         <?php

namespace Faker\Provider\tr_TR;

class Company extends \Faker\Provider\Company
{
    protected static $formats = array(
        '{{lastName}} {{companySuffix}}',
        '{{lastName}}oğlu {{companySuffix}}',
        '{{lastName}} {{lastName}} {{companySuffix}}',
        '{{lastName}} {{companyField}} {{companySuffix}}',
        '{{lastName}} {{companyField}} {{companySuffix}}',
        '{{lastName}} {{companyField}} {{companySuffix}}',
        '{{lastName}} {{lastName}} {{companyField}} {{companySuffix}}',
    );

    protected static $companySuffix = array('A.Ş.', 'Ltd. Şti.');

    protected static $companyField = array(
        'Akaryakıt', 'Beyaz Eşya', 'Bilgi İşlem', 'Bilgisayar', 'Bilişim Hizmetleri',
        'Biracılık ve Malt Sanayii', 'Cam Sanayii', 'Çimento', 'Demir ve Çelik',
        'Dış Ticaret', 'Eczacılık', 'Elektrik İletim', 'Elektrik Üretim', 'Elektronik',
        'Emlak', 'Enerji', 'Giyim', 'Gıda', 'Holding', 'Isıtma ve Soğutma Sistemleri',
        'İletişim Hizmetleri', 'İnşaat ve Sanayi', 'İthalat ve İhracat', 'Kimya',
        'Kurumsal Hizmetler', 'Lojistik', 'Madencilik', 'Makina', 'Mağazalar', 'Nakliyat',
        'Otomotiv', 'Pazarlama', 'Perakende Ticaret', 'Petrol', 'Petrolcülük', 'Sanayi',
        'Sağlık Hizmetleri', 'Servis ve Ticaret', 'Süt Ürünleri', 'Tarım Sanayi',
        'Tavukçuluk', 'Tekstil', 'Telekomunikasyon', 'Tersane ve Ulaşım Sanayi',
        'Ticaret', 'Ticaret ve Sanayi', 'Ticaret ve Taahhüt', 'Turizm', 'Yatırım'
    );

    /**
    * @link https://tr.wikipedia.org/wiki/Meslekler_listesi
    * @note Randomly took 300 from this list
    */
    protected static $jobTitleFormat = array(
        'Acil tıp teknisyeni', 'Agronomist', 'Aile hekimi', 'Aktar', 'Aktör', 'Aktüer',
        'Akustikçi', 'Albay', 'Ambarcı', 'Ambulans şoförü', 'Amiral', 'Analist',
        'Antika satıcısı', 'Araba tamircisi', 'Arabacı', 'Araştırmacı', 'Armatör', 'Artist',
        'Asker', 'Astrofizikçi', 'Astrolog', 'Astronom', 'Astronot', 'Atlet', 'Avukat',
        'Ayakkabı boyacısı', 'Ayakkabı tamircisi', 'Ayakçı', 'Ağ yöneticisi', 'Aşçıbaşı',
        'Bacacı', 'Badanacı', 'Baharatçı', 'Bahçe bitkileri uzmanı', 'Bakkal', 'Bakteriyolog',
        'Balon pilotu', 'Bankacı', 'Banker', 'Barmeyd', 'Başdümenci', 'Başpiskopos',
        'Başçavuş', 'Bebek Bakıcısı', 'Belediye başkanı', 'Belediye meclisi üyesi', 'Besteci',
        'Biletçi', 'Bilgi İşlemci', 'Bilgisayar mühendisi', 'Binicilik', 'Biyografi yazarı',
        'Bobinajcı', 'Borsacı', 'Boyacı', 'Bulaşıkçı', 'Börekç', 'Çamaşırcı', 'Çantacı',
        'Çevik Kuvvet', 'Çevirmen', 'Çevre Mühendisi', 'Çevrebilimci', 'Çeyizci',
        'Çiftlik işletici', 'Çiftçi', 'Çinici', 'Çoban', 'Çırak', 'Dadı', 'Daktilograf',
        'Dalgıç', 'Dansöz', 'Dedektif', 'Derici', 'Değirmen işçisi', 'Değirmenci', 'Dilci',
        'Diplomat', 'Doktor', 'Dokumacı', 'Dondurmacı', 'Doğramacı', 'Dövizci', 'Döşemeci',
        'Elektrik mühendisi', 'Elektronik mühendisi', 'Elektronik ve Haberleşme mühendisi',
        'Embriyolog', 'Emniyet amiri', 'Emniyet genel müdürü', 'Ergonomist', 'Eskici', 'Fahişe',
        'Fizikçi', 'Fizyoterapist', 'Fotoğrafçı', 'Fıçıcı', 'Galerici', 'Garson',
        'Gazete dağıtıcısı', 'Gazete satıcısı', 'Gazeteci', 'Gelir uzman yardımcısı', 'General',
        'Genetik mühendisi', 'Gezici vaiz', 'Gondolcu', 'Guru', 'Gökbilimci', 'Gözlükçü',
        'Güfteci', 'Gümrük uzmanı', 'Haham', 'Hakem', 'Halkbilimci', 'Hamal', 'Hamurkâr',
        'Hareket memuru', 'Hava trafikçisi', 'Havacı', 'Hayvan terbiyecisi', 'Hesap uzmanı',
        'Heykeltıraş', 'Hokkabaz', 'Irgat', 'İcra memuru', 'İllüzyonist', 'İmam',
        'İnsan kaynakları uzmanı', 'İplikçi', 'İthalatçı', 'İş ve uğraşı terapisti', 'İşaretçi',
        'Jimnastikçi', 'Jokey', 'Kabin görevlisi', 'Kabuk soyucusu', 'Kadın berberi', 'Kahveci',
        'Kalaycı', 'Kaplamacı', 'Kapı satıcısı', 'Kardinal', 'Kardiyolog', 'Karikatürist',
        'Kat görevlisi', 'Kaymakam', 'Kayıkçı', 'Kazıcı', 'Klarnetçi', 'Konserveci',
        'Konveyör operatörü', 'Koramiral', 'Korgeneral', 'Kozmolog', 'Kuaför', 'Kumaşçı', 'Kumcu',
        'Kuruyemişçi', 'Kurye', 'Kuyumcu', 'Kâğıtçı', 'Köpek eğiticisi', 'Köşe yazarı', 'Kürkçü',
        'Kırtasiyeci', 'Laborant', 'Laboratuar işçisi', 'Lahmacuncu', 'Lehimci', 'Levazımcı',
        'Lobici', 'Lokantacı', 'Lokman', 'Lostracı', 'Madenci', 'Makastar', 'Makine mühendisi',
        'Makine zabiti', 'Makyajcı', 'Mali hizmetler uzmanı', 'Manastır baş rahibesi',
        'Manifaturacı', 'Manikürcü', 'Masör', 'Matematikçi', 'Memur', 'Mermerci',
        'Meteoroloji uzmanı', 'Misyoner', 'Model', 'Modelci', 'Modelist', 'Montajcı', 'Montör',
        'Muallim', 'Muhafız', 'Mumyalayıcı', 'Müzik yönetmeni', 'Müşavir', 'Nalbant', 'Nalbur',
        'Oduncu', 'Orgcu', 'Ornitolog', 'Oto elektrikçisi', 'Oto lastik tamircisi', 'Oyuncakçı',
        'Oyuncu', 'Ön muhasebe yardımcı elemanı', 'Ön muhasebeci', 'Öğretim elemanı',
        'Öğretim görevlisi', 'Öğretim üyesi', 'Papaz', 'Paramedik', 'Pastörizör', 'Pencereci',
        'Perukçu', 'Peyzaj teknikeri', 'Peçeteci', 'Pideci', 'Pilot', 'Piyanist', 'Politikacı',
        'Pompacı', 'Psikolog', 'Radyolog', 'Radyoloji teknisyeni/teknikeri', 'Rejisör',
        'Reklamcı', 'Rektör', 'Rot balansçı', 'Saat tamircisi', 'Sanat yönetmeni', 'Saraç',
        'Saz şairi', 'Sekreter', 'Ses teknisyeni', 'Sicil memuru', 'Sihirbaz', 'Sistem mühendisi',
        'Sosyal hizmet uzmanı', 'Sosyolog', 'Soğuk demirci', 'Stenograf', 'Stilist', 'Striptizci',
        'Sucu', 'Sunucu', 'Susuz araç yıkama', 'Sünnetçi', 'Sürveyan', 'Şapel papazı',
        'Şarkı sözü yazarı', 'Şehir Plancısı', 'Şekerci', 'Şimşirci', 'Şoför', 'Tahsildar',
        'Tarihçi', 'Tasarımcı', 'Taşlayıcı', 'Taşçı', 'Tekniker', 'Teknisyen', 'Teknoloji uzmani',
        'Televizyon tamircisi', 'Terapist', 'Tesisatçı', 'Teşrifatçı', 'Tornacı', 'Tuğgeneral',
        'Ulaşım sorumlusu', 'Ustabaşı', 'Uydu antenci', 'Üst Düzey Yönetici', 'Ütücü',
        'Uzay bilimcisi', 'Vali', 'Veri hazırlama ve kontrol işletmeni', 'Veteriner hekim',
        'Veteriner sağlık teknikeri', 'Veznedar', 'Vinç operatörü', 'Vitrinci', 'Yarbay',
        'Yardımcı pilot', 'Yargıç', 'Yazar', 'Yazı işleri müdürü', 'Yazılım mühendisi',
        'Yer gösterici', 'Yol bekçisi', 'Yorgancı', 'Yoğurtçu', 'Yıkıcı', 'Zabıta', 'Zoolog'
    );

    /**
     * Returns a random company field.
     *
     * @return string
     */
    public static function companyField()
    {
        return static::randomElement(static::$companyField);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

namespace Faker\Provider\tr_TR;

class DateTime extends \Faker\Provider\DateTime
{
    public static function amPm($max = 'now')
    {
        return static::dateTime($max)->format('a') === 'am' ? 'öö' : 'ös';
    }

    public static function dayOfWeek($max = 'now')
    {
        $map = array(
            'Sunday' => 'Pazar',
            'Monday' => 'Pazartesi',
            'Tuesday' => 'Salı',
            'Wednesday' => 'Çarşamba',
            'Thursday' => 'Perşembe',
            'Friday' => 'Cuma',
            'Saturday' => 'Cumartesi',
        );
        $week = static::dateTime($max)->format('l');
        return isset($map[$week]) ? $map[$week] : $week;
    }

    public static function monthName($max = 'now')
    {
        $map = array(
            'January' => 'Ocak',
            'February' => 'Şubat',
            'March' => 'Mart',
            'April' => 'Nisan',
            'May' => 'Mayıs',
            'June' => 'Haziran',
            'July' => 'Temmuz',
            'August' => 'Ağustos',
            'September' => 'Eylül',
            'October' => 'Ekim',
            'November' => 'Kasım',
            'December' => 'Aralık',
        );
        $month = static::dateTime($max)->format('F');
        return isset($map[$month]) ? $map[$month] : $month;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

namespace Faker\Provider\tr_TR;

use Faker\Calculator\TCNo;

class Person extends \Faker\Provider\Person
{
    /**
     * @var array Turkish person name formats.
     */
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

    /**
     * @link http://www.guzelisimler.com/en_cok_aranan_erkek_isimleri.php
     *
     * @var array Turkish first names.
     */
    protected static $firstNameMale = array(
        'Ahmet', 'Ali', 'Alp', 'Armağan', 'Atakan', 'Aşkın', 'Baran', 'Bartu', 'Berk', 'Berkay', 'Berke', 'Bora', 'Burak', 'Canberk',
        'Cem', 'Cihan', 'Deniz', 'Efe', 'Ege', 'Ege', 'Emir', 'Emirhan', 'Emre', 'Ferid', 'Göktürk', 'Görkem', 'Güney',
        'Kağan', 'Kerem', 'Koray', 'Kutay', 'Mert', 'Onur', 'Ogün', 'Polat', 'Rüzgar', 'Sarp', 'Serhan', 'Toprak', 'Tuna',
        'Türker', 'Utku', 'Yağız', 'Yiğit', 'Çınar', 'Derin', 'Meriç', 'Barlas', 'Dağhan', 'Doruk', 'Çağan'
    );

    /**
     * @link http://www.guzelisimler.com/en_cok_aranan_kiz_isimleri.php
     *
     * @var array Turkish first names.
     */
    protected static $firstNameFemale = array(
        'Ada', 'Esma', 'Emel', 'Ebru', 'Şahnur', 'Ümran', 'Sinem', 'İrem', 'Rüya', 'Ece', 'Burcu'
    );

    /**
     * @link http://tr.wikipedia.org/wiki/Kategori:T%C3%BCrk%C3%A7e_soyadlar%C4%B1
     *
     * @var array Turkish last names.
     */
    protected static $lastName = array(
        'Abacı', 'Abadan', '