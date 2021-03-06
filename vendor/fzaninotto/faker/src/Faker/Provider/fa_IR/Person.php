<?php

namespace Faker\Provider\fr_CA;

class Address extends \Faker\Provider\fr_FR\Address
{
    protected static $cityPrefix = array('Saint-', 'Sainte-', 'St-', 'Ste-');

    /**
     * The suffixes come from this list of communities in Québec
     * http://fr.wikipedia.org/wiki/Liste_des_municipalités_locales_du_Québec
     */
    protected static $citySuffix = array(
        // Bas-Saint-Laurent
        '-des-Sables', '-sur-Mer', '-des-Neiges', '-des-Sept-Douleurs', '-du-Portage', '-du-Loup', '-des-Lacs', '-de-Lessard',
        '-de-Kamourasca', '-de-Témiscouata', '-de-Ladrière', '-de-Rimouski', '-de-Rivière-du-Loup', '-du-Lac', '-du-Ha! Ha!',
        '-du-Lac-Long', '-de-Rioux', '-du-Squatec', '-de-Métis', '-d\'Ixworth', '-de-la-Croix', '-de-Matane', '-du-Lac-Humqui',
        '-de-Mérici', '-de-la-Pocatière', '-sur-le-Lac',
        // Saguenay–Lac-Saint-Jean
        '-de-Lorette', '-du-Lac-Saint-Jean', '-de-Bourget', '-de-Falardeau', '-les-Plaines', '-de-Sales', '-de-Taillon',
        '-de-Milot', '-du-Nord',
        // Québec (Capitale-Nationale)
        '-aux-Coudres', '-des-Anges', '-de-Desmaures', '-les-Neiges', '-de-l\'Île-d\'Orléans', '-de-Valcartier',
        '-de-Portneuf', '-du-Cap-Tourmente', '-des-Carrières', '-des-Caps', '-de-Beaupré', '-de-Laval', '-de-la-Jacques-Cartier',
        '-d\'Auvergne',
        // Mauricie
        '-de-Monteauban', '-du-Mont-Carmel', '-des-Monts', '-de-Maskinongé', '-de-Caxton', '-des-Grès', '-le-Grand',
        '-de-Vincennes', '-du-Parc', '-de-Champlain', '-de-Mékinac', '-de-Prémont', '-de-la-Pérade', '-de-Batiscan',
        // Estrie (Cantons de l'est)
        '-Ouest', '-Est', '-Sud', '-Nord', '-des-Bois', '-de-Woburn', '-de-Brompton', '-de-Bolton', '-de-Windsor',
        '-de-Clifton', '-de-Paquette', '-de-la-Rochelle', '-de-Hatley', '-de-Whitton',
        // Montréal
        '-de-Bellevue',
        // Chaudière-Appalaches
        '-de-Buckland', '-des-Pins', '-du-Rosaire', '-d\'Issoudun', '-de-Jésus', '-d\'Irlande', '-de-l\'Isle-aux-Grues',
        '-de-Tilly', '-de-Lellis', '-de-Bellechasse', '-de-Lessard', '-de-L\'Islet', '-de-Lotbinière', '-de-Beauce',
        '-de-Forsyth', '-de-Panet', '-de-la-Rivière-du-Sud', '-de-Dorset', '-de-Shenley', '-de-Leeds', '-de-Wolfestown',
        '-de-Joly', '-de-Brébeuf', '-de-Coleraine', '-des-Érables', '-Bretenières', '-de-Lauzon', '-de-Standon',
        '-de-Gonzague', '-de-Beaurivage', '-de-Dorchester', '-de-Cranbourne', '-de-Broughton', '-de-la-Rivière-du-Sud',
        '-des-Aulnaies', '-les-Mines', '-de-Lotbinière', '-de-Patton', '-sur-Rivière-du-Sud', '-de-Beauregard', '-de-Watford'
    );

    /**
     * @example 'Saint-Marc-des-Carrières' or 'Sainte-Monique'
     */
    protected static $cityFormats = array(
        '{{cityPrefix}}{{firstName}}{{citySuffix}}',
        '{{cityPrefix}}{{firstName}}',
    );

    protected static $buildingNumber = array('#####', '####', '###', '##', '#');

    protected static $streetSuffix = array(
        'Autoroute', 'Avenue', 'Boulevard', 'Chemin', 'Route', 'Rue', 'Pont'
    );

    protected static $postcode = array('?#? #?#', '?#?#?#');

    /**
     * @example 'Avenue Bolduc'
     */
    protected static $streetNameFormats = array(
        '{{streetSuffix}} {{firstName}}',
        '{{streetSuffix}} {{lastName}}'
    );

    protected static $streetAddressFormats = array(
        '{{buildingNumber}} {{streetName}}',
        '{{buildingNumber}} {{streetName}} {{secondaryAddress}}',
    );

    protected static $addressFormats = array(
        "{{streetAddress}}, {{city}}, {{stateAbbr}} {{postcode}}",
    );

    protected static $secondaryAddressFormats = array('Apt. ###', 'Suite ###', 'Bureau ###');

    protected static $state = array(
        'Alberta', 'Colombie-Britannique', 'Manitoba', 'Nouveau-Brunswick', 'Terre-Neuve-et-Labrador', 'Nouvelle-Écosse', 'Ontario', 'Île-du-Prince-Édouard', 'Québec', 'Saskatchewan'
    );

    protected static $stateAbbr = array(
        'AB', 'BC', 'MB', 'NB', 'NL', 'NS', 'ON', 'PE', 'QC', 'SK'
    );

    /**
     * @example 'Saint-'
     */
    public static function cityPrefix()
    {
        return static::randomElement(static::$cityPrefix);
    }

    /**
     * @example '-des-Sables'
     */
    public static function citySuffix()
    {
        return static::randomElement(static::$citySuffix);
    }

    /**
     * @example 'Bureau 500'
     */
    public static function secondaryAddress()
    {
        return static::numerify(static::randomElement(static::$secondaryAddressFormats));
    }

    /**
     * @example 'Québec'
     */
    public static function state()
    {
        return static::randomElement(static::$state);
    }

    /**
     * @example 'QC'
     */
    public static function stateAbbr()
    {
        return static::randomElement(static::$stateAbbr);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

namespace Faker\Provider\fr_CA;

class Person extends \Faker\Provider\Person
{
    protected static $maleNameFormats = array(
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}-{{lastName}}',
        '{{firstNameMale}}-{{firstNameMale}} {{lastName}}',
    );

    protected static $femaleNameFormats = array(
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}-{{lastName}}',
        '{{firstNameFemale}}-{{firstNameFemale}} {{lastName}}',
    );

    /**
     * This list is more or less the same as in \Faker\Provider\fr_FR\Person.php
     * Some common names were added and other removed.
     */
    protected static $firstNameMale = array(
        'Adrien', 'Aimé', 'Alain', 'Albert', 'Alexandre', 'Alfred', 'Alphonse', 'Alysson', 'André', 'Anthony', 'Antoine', 'Arthur', 'Auguste',
        'Augustin', 'Augustine', 'Benjamin', 'Benoit', 'Benoît', 'Bernard', 'Bertrand', 'Charles', 'Christian', 'Christophe', 'Claude', 'Daniel',
        'David', 'Denis', 'Dominic', 'Emmanuel', 'Eugène', 'Françis', 'François', 'Frédéric', 'Gabriel', 'Georges', 'Gilbert', 'Gilles',
        'Grégory', 'Guillaume', 'Guy', 'Gérard', 'Henri', 'Hugues', 'Isaac', 'Jacques', 'Joseph', 'Jules', 'Julien', 'Jérôme',
        'Laurent', 'Louis', 'Luc', 'Lucas', 'Léon', 'Marc', 'Marcel', 'Martin', 'Mathieu', 'Matthieu', 'Maurice', 'Michel',
        'Nicolas', 'Noël', 'Olivier', 'Patrick', 'Paul', 'Philippe', 'Pierre', 'Raymond', 'René', 'Richard', 'Robert', 'Roger',
        'Roland', 'Rémy', 'Simone', 'Stéphane', 'Sébastien', 'Thierry', 'Thomas', 'Théo', 'Théophile', 'Timothée', 'Tristan', 'Victor',
        'Vincent', 'William', 'Xavier', 'Yvan', 'Yves', 'Yvon', 'Zacharie', 'Édouard', 'Émanuelle', 'Émile', 'Éric', 'Étienne', 'Honoré',
    );

    protected static $firstNameFemale = array(
        'Adrienne', 'Adèle', 'Agathe', 'Aimée', 'Alexandra', 'Alice', 'Aline', 'Amélie', 'Anaïs', 'Andrée', 'Ann', 'Anne', 'Annette',
        'Annie', 'Anouk', 'Arianne', 'Audrey', 'Aurore', 'Aurélie', 'Bernadette', 'Brigitte', 'Camille', 'Caroline', 'Catherine', 'Chantal',
        'Charlotte', 'Christiane', 'Christine', 'Claire', 'Claudine', 'Colette', 'Corrine', 'Cécile', 'Céline', 'Danielle', 'Denise', 'Dominique',
        'Eugénie', 'Eve', 'Françoise', 'Frédérique', 'Gabrielle', 'Geneviève', 'Hélène', 'Isabelle', 'Jacqueline', 'Jean', 'Jeanne', 'Jeannine',
        'Joséphine', 'Julie', 'Laurence', 'Louise', 'Luce', 'Lucie', 'Madeleine', 'Maggie', 'Manon', 'Margot', 'Marguerite', 'Marianne',
        'Marie', 'Marthe', 'Martine', 'Maryse', 'Mathilde', 'Michelle', 'Michèle', 'Monique', 'Nancy', 'Nathalie', 'Nicole', 'Noémie',
        'Odette', 'Olivia', 'Patrice', 'Patricia', 'Paule', 'Paulette', 'Pauline', 'Pénélope', 'Renée', 'Rolande', 'Sophie', 'Stéphanie',
        'Susanne', 'Suzanne', 'Sylvie', 'Thérèse', 'Valérie', 'Virginie', 'Véronique', 'Yvonne', 'Zoé', 'Édith', 'Élisabeth', 'Élise',
        'Élodie', 'Émilie', 'Érika', 'Honorée',
    );

    /**
     * These last names come from this list of most common family names in Québec (1 to 130)
     * http://fr.wikipedia.org/wiki/Liste_des_noms_de_famille_les_plus_courants_au_Québec
     */
    protected static $lastName = array(
        'Allard', 'Arsenault', 'Audet',
        'Beaudoin', 'Beaulieu', 'Bédard', 'Bélanger', 'Benoît', 'Bergeron', 'Bernard', 'Bernier', 'Bertrand', 'Bérubé',
        'Bilodeau', 'Blais', 'Blanchette', 'Boisvert', 'Boivin', 'Bolduc', 'Bouchard', 'Boucher', 'Boudreau',
        'Caron', 'Carrier', 'Champagne', 'Charbonneau', 'Cloutier', 'Côté', 'Couture', 'Cyr',
        'Demers', 'Deschênes', 'Desjardins', 'Desrosiers', 'Dion', 'Dionne', 'Drouin', 'Dubé', 'Dubois', 'Dufour', 'Dupuis',
        'Fillion', 'Fontaine', 'Fortier', 'Fortin', 'Fournier',
        'Gagné', 'Gagnon', 'Gaudreault', 'Gauthier', 'Giguère', 'Gilbert', 'Gingras', 'Girard', 'Giroux', 'Goulet',
        'Gosselin', 'Gravel', 'Grenier', 'Guay',
        'Hamel', 'Harvey', 'Hébert', 'Houle',
        'Jean', 'Jacques',
        'Labelle', 'Lachance', 'Lacroix', 'Lalonde', 'Lambert', 'Landry', 'Langlois', 'Lapierre', 'Lapointe', 'Larouche',
        'Lauzon', 'Lavoie', 'Leblanc', 'Leduc', 'Leclerc', 'Lefebvre', 'Legault', 'Lemay', 'Lemieux', 'Lepage', 'Lessard',
        'Lévesque',
        'Martel', 'Martin', 'Ménard', 'Mercier', 'Michaud', 'Moreau', 'Morin',
        'Nadeau', 'Nguyen',
        'Ouellet',
        'Paquette', 'Paradis', 'Parent', 'Pelletier', 'Perreault', 'Perron', 'Picard', 'Plante', 'Poirier', 'Poulin',
        'Proulx',
        'Raymond', 'Renaud', 'Richard', 'Rioux', 'Robert', 'Rousseau', 'Roy',
        'Savard', 'Simard', 'St-Pierre',
        'Tardif', 'Tessier', 'Thériault', 'Therrien', 'Thibault', 'Tremblay', 'Trudel', 'Turcotte',
        'Vachon', 'Vaillancourt', 'Villeneuve'
    );
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Faker\Provider\fr_CH;

class Address extends \Faker\Provider\fr_FR\Address
{
    protected static $buildingNumber = array('###', '##', '#', '#a', '#b', '#c');

    protected static $streetPrefix = array('Rue', 'Rue', 'Chemin', 'Avenue', 'Boulevard', 'Place', 'Impasse');

    protected static $postcode = array('####');

    /**
     * @link https://fr.wikipedia.org/wiki/Villes_de_Suisse
     */
    protected static $cityNames = array(
        'Aarau', 'Aarberg', 'Aarburg', 'Agno', 'Aigle VD', 'Altdorf', 'Altstätten', 'Appenzell', 'Arbon', 'Ascona', 'Aubonne', 'Avenches',
        'Baden', 'Bad Zurzach', 'Bâle', 'Bellinzone', 'Berne', 'Beromünster', 'Berthoud', 'Biasca', 'Bienne', 'Bischofszell', 'Boudry', 'Bourg-Saint-Pierre', 'Bremgarten AG', 'Brigue', 'Brugg', 'Bulle', 'Bülach',
        'Cerlier', 'Châtel-Saint-Denis',
        'Coire', 'Conthey', 'Coppet', 'Cossonay', 'Croglio', 'Cudrefin', 'Cully',
        'Delémont', 'Diessenhofen', 'Échallens', 'Eglisau', 'Elgg', 'Estavayer-le-Lac',
        'Frauenfeld', 'Fribourg',
        'Genève', 'Glaris', 'Gordola', 'Grandcour', 'Grandson', 'Greifensee', 'Grüningen', 'Gruyères',
        'Hermance', 'Huttwil',
        'Ilanz',
        'Kaiserstuhl', 'Klingnau',
        'La Chaux-de-Fonds', 'La Neuveville', 'La Sarraz', 'La Tour-de-Peilz', 'La Tour-de-Trême', 'Le Landeron', 'Les Clées', 'Lachen', 'Langenthal', 'Laufon', 'Laufenburg', 'Laupen', 'Lausanne', 'Lenzburg', 'Loèche', 'Lichtensteig', 'Liestal', 'Locarno', 'Losone', 'Lugano', 'Lutry', 'Lucerne',
        'Maienfeld', 'Martigny', 'Mellingen', 'Mendrisio', 'Monthey', 'Morat', 'Morcote', 'Morges', 'Moudon', 'Moutier', 'Münchenstein',
        'Neuchâtel', 'Neunkirch', 'Nidau', 'Nyon',
        'Olten', 'Orbe', 'Orsières',
        'Payerne', 'Porrentruy',
        'Rapperswil', 'Regensberg', 'Rheinau', 'Rheineck', 'Rheinfelden', 'Riva San Vitale', 'Rolle', 'Romainmôtier', 'Romont FR', 'Rorschach', 'Rue',
        'Saillon', 'Saint-Maurice', 'Saint-Prex', 'Saint-Ursanne', 'Sala', 'Saint-Gall', 'Sargans', 'Sarnen', 'Schaffhouse', 'Schwytz', 'Sembrancher', 'Sempach', 'Sion', 'Soleure', 'Splügen', 'Stans', 'Steckborn', 'Stein am Rhein', 'Sursee',
        'Thoune', 'Thusis',
        'Unterseen', 'Uznach',
        'Valangin', 'Vevey', 'Villeneuve', 'Viège',
        'Waldenburg', 'Walenstadt', 'Wangen an der Aare', 'Werdenberg', 'Wiedlisbach', 'Wil', 'Willisau', 'Winterthour',
        'Yverdon-les-Bains',
        'Zofingue', 'Zoug', 'Zurich'
    );

    /**
     * @link https://fr.wikipedia.org/wiki/Canton_suisse
     */
    protected static $canton = array(
        array('AG' => 'Argovie'),
        array('AI' => 'Appenzell Rhodes-Intérieures'),
        array('AR' => 'Appenzell Rhodes-Extérieures'),
        array('BE' => 'Berne'),
        array('BL' => 'Bâle-Campagne'),
        array('BS' => 'Bâle-Ville'),
        array('FR' => 'Fribourg'),
        array('GE' => 'Genève'),
        array('GL' => 'Glaris'),
        array('GR' => 'Grisons'),
        array('JU' => 'Jura'),
        array('LU' => 'Lucerne'),
        array('NE' => 'Neuchâtel'),
        array('NW' => 'Nidwald'),
        array('OW' => 'Obwald'),
        array('SG' => 'Saint-Gall'),
        array('SH' => 'Schaffhouse'),
        array('SO' => 'Soleure'),
        array('SZ' => 'Schwytz'),
        array('TG' => 'Thurgovie'),
        array('TI' => 'Tessin'),
        array('UR' => 'Uri'),
        array('VD' => 'Vaud'),
        array('VS' => 'Valais'),
        array('ZG' => 'Zoug'),
        array('ZH' => 'Zurich')
    );

    protected static $cityFormats = array(
        '{{cityName}}',
    );

    protected static $streetNameFormats = array(
        '{{streetPrefix}} {{lastName}}',
        '{{streetPrefix}} de {{cityName}}',
        '{{streetPrefix}} de {{lastName}}'
    );

    protected static $streetAddressFormats = array(
        '{{streetName}} {{buildingNumber}}',
    );
    protected static $addressFormats = array(
        "{{streetAddress}}\n{{postcode}} {{city}}",
    );

    /**
     * Returns a random street prefix
     * @example Rue
     * @return string
     */
    public static function streetPrefix()
    {
        return static::randomElement(static::$streetPrefix);
    }

    /**
     * Returns a random city name.
     * @example Luzern
     * @return string
     */
    public function cityName()
    {
        return static::randomElement(static::$cityNames);
    }

    /**
     * Returns a canton
     * @example array('BE' => 'Bern')
     * @return array
     */
    public static function canton()
    {
        return static::randomElement(static::$canton);
    }

    /**
     * Returns the abbreviation of a canton.
     * @return string
     */
    public static function cantonShort()
    {
        $canton = static::canton();
        return key($canton);
    }

    /**
     * Returns the name of canton.
     * @return string
     */
    public static function cantonName()
    {
        $canton = static::canton();
        return current($canton);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Faker\Provider\fr_CH;

class Person extends \Faker\Provider\fr_FR\Person
{
    /**
     * @link http://www.bfs.admin.ch/bfs/portal/de/index/themen/01/02/blank/dos/prenoms/02.html
     */
    protected static $firstNameMale = array(
        'Adrian', 'Adrien', 'Alain', 'Albert', 'Alberto', 'Alessandro', 'Alex', 'Alexander', 'Alexandre', 'Alexis', 'Alfred', 'Ali', 'Andrea', 'André', 'Angelo', 'Anthony', 'Antoine', 'Antonio', 'António', 'Arnaud', 'Arthur', 'Aurélien', 'Axel',
        'Baptiste', 'Bastien', 'Benjamin', 'Benoît', 'Bernard', 'Bertrand', 'Bruno', 'Bryan',
        'Carlos', 'Charles', 'Christian', 'Christophe', 'Christopher', 'Claude', 'Claudio', 'Cyril', 'Cédric',
        'Damien', 'Daniel', 'David', 'Denis', 'Didier', 'Diego', 'Diogo', 'Dominique', 'Dylan',
        'Emmanuel', 'Enzo', 'Eric', 'Etienne',
        'Fabien', 'Fabio', 'Fabrice', 'Fernando', 'Filipe', 'Florian', 'Francesco', 'Francis', 'Francisco', 'François', 'Frédéric',
        'Gabriel', 'Georges', 'Gilbert', 'Gilles', 'Giovanni', 'Giuseppe', 'Gregory', 'Grégoire', 'Grégory', 'Guillaume', 'Guy', 'Gérald', 'Gérard',
        'Hans', 'Henri', 'Hervé', 'Hugo',
        'Jacques', 'Jean', 'Jean-Claude', 'Jean-Daniel', 'Jean-François', 'Jean-Jacques', 'Jean-Louis', 'Jean-Luc', 'Jean-Marc', 'Jean-Marie', 'Jean-Michel', 'Jean-Paul', 'Jean-Pierre', 'Joao', 'Joaquim', 'John', 'Jonas', 'Jonathan', 'Jorge', 'Jose', 'Joseph', 'José', 'João', 'Joël', 'Juan', 'Julien', 'Jérémie', 'Jérémy', 'Jérôme',
        'Kevin',
        'Laurent', 'Lionel', 'Loris', 'Louis', 'Loïc', 'Luc', 'Luca', 'Lucas', 'Lucien', 'Ludovic', 'Luis', 'Léo',
        'Manuel', 'Marc', 'Marcel', 'Marco', 'Mario', 'Martin', 'Mathias', 'Mathieu', 'Matteo', 'Matthieu', 'Maurice', 'Max', 'Maxime', 'Michael', 'Michaël', 'Michel', 'Miguel', 'Mohamed',
        'Nathan', 'Nicolas', 'Noah', 'Nolan', 'Nuno',
        'Olivier',
        'Pascal', 'Patrice', 'Patrick', 'Paul', 'Paulo', 'Pedro', 'Peter', 'Philippe', 'Pierre', 'Pierre-Alain', 'Pierre-André',
        'Quentin',
        'Rafael', 'Raphaël', 'Raymond', 'René', 'Ricardo', 'Richard', 'Robert', 'Roberto', 'Robin', 'Roger', 'Roland', 'Romain', 'Rui', 'Rémy',
        'Sacha', 'Salvatore', 'Samuel', 'Serge', 'Sergio', 'Simon', 'Steve', 'Stéphane', 'Sylvain', 'Sébastien',
        'Thierry', 'Thomas', 'Théo', 'Tiago',
        'Valentin', 'Victor', 'Vincent', 'Vitor',
        'Walter', 'William', 'Willy',
        'Xavier',
        'Yann', 'Yannick', 'Yvan', 'Yves',
    );

    /**
     * @link http://www.bfs.admin.ch/bfs/portal/de/index/themen/01/02/blank/dos/prenoms/02.html
     */
    protected static $firstNameFemale = array(
        'Agnès', 'Alexandra', 'Alice', 'Alicia', 'Aline', 'Amélie', 'Ana', 'Anaïs', 'Andrea', 'Andrée', 'Angela', 'Anita', 'Anna', 'Anne', 'Anne-Marie', 'Antoinette', 'Ariane', 'Arlette', 'Audrey', 'Aurélie',
        'Barbara', 'Bernadette', 'Brigitte', 'Béatrice',
        'Camille', 'Carine', 'Carla', 'Carmen', 'Carole', 'Caroline', 'Catherine', 'Chantal', 'Charlotte', 'Chloé', 'Christelle', 'Christiane', 'Christine', 'Cindy', 'Claire', 'Clara', 'Claudia', 'Claudine', 'Colette', 'Coralie', 'Corinne', 'Cristina', 'Cécile', 'Célia', 'Céline',
        'Daniela', 'Danielle', 'Danièle', 'Delphine', 'Denise', 'Diana', 'Dominique',
        'Edith', 'Elena', 'Eliane', 'Elisa', 'Elisabeth', 'Elodie', 'Elsa', 'Emilie', 'Emma', 'Erika', 'Estelle', 'Esther', 'Eva', 'Evelyne',
        'Fabienne', 'Fanny', 'Florence', 'Francine', 'Françoise',
        'Gabrielle', 'Geneviève', 'Georgette', 'Ginette', 'Gisèle', 'Géraldine',
        'Huguette', 'Hélène',
        'Inès', 'Irène', 'Isabel', 'Isabelle',
        'Jacqueline', 'Janine', 'Jeanne', 'Jeannine', 'Jennifer', 'Jessica', 'Joana', 'Jocelyne', 'Josette', 'Josiane', 'Joëlle', 'Julia', 'Julie', 'Juliette', 'Justine',
        'Karin', 'Karine', 'Katia',
        'Laetitia', 'Lara', 'Laura', 'Laure', 'Laurence', 'Liliane', 'Lisa', 'Louise', 'Lucia', 'Lucie', 'Léa',
        'Madeleine', 'Magali', 'Manon', 'Manuela', 'Marguerite', 'Maria', 'Marianne', 'Marie', 'Marie-Thérèse', 'Marina', 'Marine', 'Marion', 'Marlyse', 'Marlène', 'Martine', 'Mathilde', 'Melissa', 'Micheline', 'Michelle', 'Michèle', 'Mireille', 'Monica', 'Monique', 'Morgane', 'Muriel', 'Myriam', 'Mélanie',
        'Nadia', 'Nadine', 'Natacha', 'Nathalie', 'Nelly', 'Nicole', 'Nina', 'Noémie',
        'Océane', 'Olga', 'Olivia',
        'Pascale', 'Patricia', 'Paula', 'Pauline', 'Pierrette',
        'Rachel', 'Raymonde', 'Renée', 'Rita', 'Rosa', 'Rose', 'Rose-Marie', 'Ruth',
        'Sabine', 'Sabrina', 'Sandra', 'Sandrine', 'Sara', 'Sarah', 'Silvia', 'Simone', 'Sofia', 'Sonia', 'Sophie', 'Stéphanie', 'Suzanne', 'Sylvia', 'Sylviane', 'Sylvie', 'Séverine',
        'Tania', 'Tatiana', 'Teresa', 'Thérèse',
        'Valentine', 'Valérie', 'Vanessa', 'Victoria', 'Virginie', 'Viviane', 'Véronique',
        'Yolande', 'Yvette', 'Yvonne',
        'Zoé',
    );

    /**
     * @link http://blog.tagesanzeiger.ch/datenblog/index.php/6859
     */
    protected static $lastName = array(
        'Aebischer', 'Aeby', 'Andrey', 'Aubert', 'Aubry',
        'Bachmann', 'Baechler', 'Baeriswyl', 'Barbey', 'Barras', 'Baumann', 'Baumgartner', 'Berger', 'Bernard', 'Berset', 'Bersier', 'Berthoud', 'Besson', 'Blanc', 'Blaser', 'Boillat', 'Bonvin', 'Bourquin', 'Bruchez', 'Brunner', 'Brügger', 'Buchs', 'Bugnon', 'Burri', 'Bühler',
        'Castella', 'Cattin', 'Chappuis', 'Chapuis', 'Chassot', 'Chatelain', 'Chevalley', 'Chollet', 'Christen', 'Clerc', 'Clément', 'Constantin', 'Crausaz',
        'Da Silva', 'Darbellay', 'Demierre', 'dos Santos', 'Droz', 'Dubois', 'Dubuis', 'Duc', 'Dévaud',
        'Egger', 'Emery',
        'Fasel', 'Favre', 'Fellay', 'Fernandes', 'Fernandez', 'Ferreira', 'Fischer', 'Fleury', 'Flückiger', 'Fournier', 'Fragnière', 'Froidevaux',
        'Gaillard', 'Garcia', 'Gasser', 'Gay', 'Geiser', 'Genoud', 'Gerber', 'Gilliéron', 'Girard', 'Girardin', 'Giroud', 'Glauser', 'Golay', 'Gonzalez', 'Graf', 'Grand', 'Grandjean', 'Gremaud', 'Grosjean', 'Gross', 'Guex', 'Guignard',
        'Hofer', 'Hofmann', 'Huber', 'Huguenin', 'Héritier',
        'Jaccard', 'Jacot', 'Jaquet', 'Jaquier', 'Jeanneret', 'Jordan', 'Jungo', 'Junod',
        'Kaufmann', 'Keller', 'Kohler', 'Kolly', 'Kunz',
        'Lachat', 'Lambert', 'Lehmann', 'Leuba', 'Leuenberger', 'Liechti', 'Lopez', 'Lüthi',
        'Maeder', 'Magnin', 'Maillard', 'Maret', 'Marti', 'Martin', 'Martinez', 'Matthey', 'Maurer', 'Mauron', 'Mayor', 'Meier', 'Meyer', 'Meylan', 'Michaud', 'Michel', 'Monnet', 'Monney', 'Monnier', 'Morand', 'Morard', 'Morel', 'Moret', 'Moser', 'Muller', 'Müller',
        'Neuhaus', 'Nguyen', 'Nicolet',
        'Oberson',
        'Pache', 'Pasche', 'Pasquier', 'Pereira', 'Perez', 'Perrenoud', 'Perret', 'Perrin', 'Perroud', 'Pfister', 'Piguet', 'Piller', 'Pilloud', 'Pittet', 'Pochon',
        'Racine', 'Rey', 'Reymond', 'Richard', 'Robert', 'Rochat', 'Rodrigues', 'Rodriguez', 'Roduit', 'Rosset', 'Rossier', 'Roth', 'Rouiller', 'Roulin', 'Roy', 'Ruffieux',
        'Savary', 'Schaller', 'Schmid', 'Schmidt', 'Schmutz', 'Schneider', 'Schwab', 'Seydoux', 'Simon', 'Stalder', 'Stauffer', 'Steiner', 'Studer', 'Suter',
        'Tissot',
        'Vaucher', 'Vonlanthen', 'Vuilleumier',
        'Waeber', 'Weber', 'Wenger', 'Widmer', 'Wyss',
        'Zbinden', 'Zimmermann',
    );
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Faker\Provider\fr_CH;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    protected static $formats = array(
        '+41 (0)## ### ## ##',
        '+41(0)#########',
        '+41 ## ### ## ##',
        '0#########',
        '0## ### ## ##',
    );

    /**
     * An array of Swiss mobile (cell) phone number formats.
     *
     * @var array
     */
    protected static $mobileFormats = array(
        // Local
        '075 ### ## ##',
        '075#######',
        '076 ### ## ##',
        '076#######',
        '077 ### ## ##',
        '077#######',
        '078 ### ## ##',
        '078#######',
        '079 ### ## ##',
        '079#######',
    );

    /**
     * Return a Swiss mobile phone number.
     *
     * @return string
     */
    public static function mobileNumber()
    {
        return static::numerify(static::randomElement(static::$mobileFormats));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   