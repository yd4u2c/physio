s', 'Noël', 'Parmentier', 'Pauwels', 'Peeters',
        'Petit', 'Pierre', 'Pieters', 'Piette', 'Piron', 'Pirotte', 'Poncelet',
        'Raes', 'Remy', 'Renard', 'Robert', 'Roels', 'Roland', 'Rousseau', 'Sahin',
        'Saidi', 'Schmitz', 'Segers', 'Servais', 'Simon', 'Simons', 'Smet', 'Smets',
        'Somers', 'Stevens', 'Thijs', 'Thiry', 'Thomas', 'Thys', 'Timmermans',
        'Toussaint', 'Tran', 'Urbain', 'Van Acker', 'Van Damme', 'Van de Velde',
        'Van den Bossche', 'Van den Broeck', 'Van Dyck', 'Van Hecke', 'Van Hoof',
        'Vandamme', 'Vandenberghe', 'Verbeeck', 'Verbeke', 'Verbruggen', 'Vercammen',
        'Verhaegen', 'Verhaeghe', 'Verhelst', 'Verheyen', 'Verhoeven', 'Verlinden',
        'Vermeersch', 'Vermeiren', 'Vermeulen', 'Verschueren', 'Verstraete', 'Verstraeten',
        'Vervoort', 'Wauters', 'Willems', 'Wouters', 'Wuyts', 'Yildirim', 'Yilmaz'
    );

    /**
     *  Belgian Rijksregister numbers are used to identify each citizen,
     *  it consists of three parts, the person's day of birth, in the
     *  format 'ymd', followed by a number between 1 and 997, odd for
     *  males, even for females. The last part is used to check if it's
     *  a valid number.
     *
     *  @link https://nl.wikipedia.org/wiki/Rijksregisternummer
     *
     *  @param string|null $gender 'male', 'female' or null for any
     *  @return string
     */
    public static function rrn($gender = null)
    {
        $middle = self::numberBetween(1, 997);
        if ($gender === static::GENDER_MALE) {
            $middle = $middle %2 === 1 ? $middle : $middle+1;
        } elseif ($gender === static::GENDER_FEMALE) {
            $middle = $middle %2 === 0 ? $middle : $middle+1;
        }
        $middle = sprintf('%03d', $middle);
        
        $date = DateTime::dateTimeThisCentury();
        $dob = sprintf('%06d', $date->format('ymd'));
        $help = $date->format('Y') >= 2000 ? 2 : null;

        $check = intval($help.$dob.$middle);
        $rest = sprintf('%02d', 97 - ($check % 97));
        
        return $dob.$middle.$rest;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

namespace Faker\Provider\nl_BE;

class Text extends \Faker\Provider\Text
{
    /**
     * The Project Gutenberg EBook of De legende en de heldhaftige, vroolijke en
     * roemrijke daden van Uilenspiegel en Lamme Goedzak in Vlaanderenland en elders, by Charles de Coster
     *
     * This eBook is for the use of anyone anywhere at no cost and with
     * almost no restrictions whatsoever.  You may copy it, give it away or
     * re-use it under the terms of the Project Gutenberg License included
     * with this eBook or online at www.gutenberg.org/license
     *
     *
     * Title: De legende en de heldhaftige, vroolijke en roemrijke daden
     * van Uilenspiegel en Lamme Goedzak in Vlaanderenland en elders
     *
     * Author: Charles de Coster
     *
     * Release Date: July 3, 2005 [EBook #11208]
     * [Last updated: March 14, 2015]
     *
     * Language: Dutch
     *
     * @see http://www.gutenberg.org/cache/epub/11208/pg11208.txt
     * @var string
     */
    protected static $baseText = <<<'EOT'
  De legende en de heldhaftige,
                    vroolijke en roemrijke daden van
                     Uilenspiegel en Lamme Goedzak
                      in Vlaanderenland en elders


                                  door

                           Charles de Coster



                     in het Vlaamsch vertaald door

                 Richard Delbecq   en   René de Clercq
                 (voor het proza)     (voor de liederen)

                               Derde druk
                     met 22 platen van Jules Gondry
                                  1919







KORTE LEVENSBESCHRIJVING VAN CHARLES DE COSTER

Bewerkt naar Ch. Potvin, Francis Nautet enz.


Charles-Theodore-Henri De Coster werd geboren te München, den 20n
Augustus 1827. Zijn vader was intendant van graaf Charles Mercy
d'Argenteau, aartsbisschop van Tyrus, die peter des kunstenaars was en
hem de markiezin Henriette de la Tour Dupin, vrouw van den Franschen
gezant te Turijn, tot meter gaf.

De kleine De Coster, een engeltje van een knaap, sleet dus zijne
eerste levensjaren in het paleis van den aartsbisschop, midden in
weelde, in bloemen, geliefkoosd door zijne ouders en zijnen peter. Zijn
eerste opvoeding was dus zeer aristocratisch en die indrukken blijven
gewoonlijk onuitwischbaar.

Doch weinig tijds nadien verandert dit alles. Zijne ouders verlaten
München en gaan naar Brussel, waar hun tweede kind ter wereld komt;
dan sterft zijn vader te Ieperen, bij zijn broeder, die daar geneesheer
was. Zijn moeder keert terug naar Brussel bij hare zuster en hare
kinderen.

Charles was reeds in eene kostschool te Etterbeek, waar "ik mij zal
moeten schikken naar den wil van een ander", zegt hij, "na zoolang
mijn zin te hebben gedaan". Als hij uit de kostschool komt, is het
om in het "Collège Saint-Michel" te treden, waar men een oogenblik
hoopte dat het kind, dat reeds de droomerijen boven de droge studiën
verkoos, zich aan het priesterschap zou wijden.

Eerst dacht hij in de balie te treden, doch een vriend deed hem
opmerken dat de rechten en de kunst moeilijk samengaan, en De Coster,
geholpen door machtige beschermers, aanvaardde eene bediening in de
"Société Générale".

In 't lot gevallen, stelde zijne moeder eenen plaatsvervanger, die
wegliep; na eenige dagen in het regiment, bij zijn kolonel, vertoefd
te hebben, "om den plaatsvervanger te vervangen", maakte de jonge
bediende op zijne beurt van de gelegenheid gebruik om zijne plaats
te ontloopen. "Het ambtenaarsleven bevalt mij in het geheel niet",
zegde hij. In de Bank voelde hij zich als een vreemdeling te midden
van de bureaucraten. Hij stikte in die atmosfeer en "overigens wilde
hij voor zich zelven werken". De letterkundige roeping verkreeg de
bovenhand en hij trad in 1850 in de Hoogeschool van Brussel, waar
hij het diploma van candidaat in de letteren behaalde.

Maar De Coster gaf aan de Hoogeschool noch zijn hart, noch zijnen
geest, noch zijne pen. Toen hij ze verliet, was hij noch doctor,
noch professor, noch dagbladschrijver, noch tooneeldichter. Maar hij
was kunstenaar, meer dan ooit.

Vervolgens wilde hij in de redactie van een dagblad treden, maar hij
aanbad het schoone boven alles en weigerde "een werktuig te maken
van zijne pen".

Dan begint een jammerlijk leven van voortdurenden tegenspoed en
onbegrepen arbeid. In 1856 weigert hij eene plaats bij een makelaar
in wijnen,--alles wat men hem aanbood.

Om het even, de jonge kunstenaar heeft wilskracht en, door al zijn
kommer heen, maakt hij eervol naam in de Fransche letterkunde. Buiten
en behalve menigvuldige gewaardeerde bijdragen in dagbladen en
tijdschriften, levert hij, in 1856, les Frères de la bonne trogne
(Brabantsche legende); in 1857, de Légendes flamandes et wallones,
die een ongemeenen bijval ontmoeten en door de Fransche pers vleiend
beoordeeld worden; in 1861, de Contes brabançons.

Zijn peter, de aartsbisschop, had hem sedert lang zijne bescherming
onttrokken, die hem zeker ware bijgebleven, hadde De Coster zijne
studiën in de Hoogeschool van Leuven willen doen. Hij had Brussel
verkozen, waar hij vrienden vond. Dat was eene keuze doen voor de
algeheele vrijheid des geestes. In 1863 wordt het petekind van den
aartsbisschop van Tyrus lid van de Vrije Gedachte van Brussel. Hij was
toen in den vollen bloei van zijn eersten bijval en gansch vervoerd
door zijne liefde voor het schoone.

Zijne liefde voor het volk, voor het wakkere Vlaamsche volk, stuwt
hem voorwaarts en houdt zijn machtig genie bezig. De schilder Dillens
zijn vriend, bezat in zijn werkhuis een verzameling oude Vlaamsche
boeken. De Coster en Dillens doen verscheidene reizen door Zeeland
en Vlaanderen: de "Legende van Uilenspiegel" was van dan af geboren
in De Coster's brein.

De Legende van Uilenspiegel en Lamme Goedzak, in de letterwereld
met ongeduld verwacht, verscheen in 1867 in een prachtige uitgave,
opgeluisterd met twee en dertig etsen van negentien talentvolle
kunstenaars.

Ziehier wat onder meer drie Fransche bladen zeiden van dat gewrocht:

La Liberté van 18 December 1868: "'t Is een heldendicht in proza,
waarin het bloed zoo rijkelijk vloeit als het bier. Men zou zeggen
een kermis rondom eenen brandstapel".

Le Constitutionnel, 9 December 1868, wijdde drie groote kolommen
aan Uilenspiegel, waarin de recensent het boek met Goethe's Faust
vergelijkt.

Le Corsaire: "'t Is een heldendicht in proza, 't is de verheerlijking
van den Vlaamschen geest".

Heel de Fransche pers deelde dit gevoelen en drukte hare bewondering
in de vleiendste artikelen uit.

Onze Busken Huët getuigde: "Hollanders noch Vlamingen bezitten een
werk over de XVIe eeuw in Vlaanderen, dat met het meesterwerk van De
Coster kan vergeleken worden".

Na Uilenspiegel verscheen nog: Voyage de noce (1872) en le Mariage
de Toulet (1879).

Edoch De Coster, die in het volle succes van de Légendes flamandes
zijne vriendin verloren had, zag zich op 29 Juli 1869, wanneer
Uilenspiegel zoo gunstig onthaald werd, nu nog zijne moeder ontrukken.

Die ramp schokte hem diep in zijn reeds droevig bestaan, want De Coster
leefde veelal in armoede, niettegenstaande zijn talent en de gunst
waarmede zijne werken ontvangen werden. Schrale schrijversrechten,
karige toelagen, luttel betaalde lessen moesten hem vrijwaren voor
ellende. Hij kloeg dan ook, steeds denzelfden strijd te moeten
herbeginnen. In 1870 schreef hij: "Hoewel ik veel gewerkt heb
uit lust en uit liefde, begrijp ik, sedert minder dan drie jaar,
de schrikverwekkende waarde van het geld en de noodwendigheid van
een arbeid, die, genoegzaam betaald, den mensch, met den welstand,
ook vrijheid en vreugde schenkt".

Maar daarom legde hij zijne fierheid niet af.

Toen eindelijk de regeering, een tiental jaren vóór zijnen dood, er
aan dacht de verstandelijke hulpmiddelen van den grooten schrijver
ten behoeve van het onderwijs aan te wenden, was het te laat. Hij
stak zoo diep in schulden, dat zijne benoeming geen anderen uitslag
opleverde dan eene opschudding te verwekken onder zijne schuldeischers,
die zijn traktement aansloegen en hunne prooi niet meer loslieten.

Toen hij stierf, op 7 Mei 1879, verkeerde hij in de diepste ellende.

                   *       *       *       *       *

Den 22n Juli 1894 werd door het gemeentebestuur van Eisene een
eenvoudig doch treffend gedenkteeken van den beeldhouwer Samuel ter
nagedachtenis van De Coster ingehuldigd.







DE LAATSTE OOGENBLIKKEN VAN CHARLES DE COSTER.


Charles De Coster stierf op 7 Mei 1879, te Elsene, in het huis, dat
den hoek uitmaakt van de Gewijde-Boomstraat, en toen gehuurd werd
door een fruitverkooper. Heel de woning van den grooten kunstenaar
bestond uit de twee kamers op de eerste verdieping: de grootste was
zijn werkkabinet, de andere zijne slaapkamer; daarin stonden een
ijzeren bed, een kleine tafel, een houten kast, eenige stoelen.

Hij had zich den dag te voren te bed gelegd: de pisvloed waaraan
hij leed, en diens noodlottige gezellin, de longtering, waren
plotseling verergerd. Charles De Coster nam zelden zijne toevlucht tot
geneesheeren; een zijner vrienden nochtans, M. Kirkpatrick, verschrikt
over den voortgang van de kwaal, had den heer dokter Vaucleroy,
geneesheer aan de Krijgsschool, ontboden. Toen deze kwam, vond hij
aan de sponde van den zieke eene oppasster, die De Coster in zijn
verheven en grenzenloos medelijden met de onterfden en ongelukkigen,
bij zich genomen had. Deze arme vrouw, die bij den zieltogende waakte,
was zelve het toonbeeld des doods; heel haar aangezicht was ingevreten
door zweren. De geneesheer ging heen zonder hoop den zieke te redden,
maar hij voorzag toc