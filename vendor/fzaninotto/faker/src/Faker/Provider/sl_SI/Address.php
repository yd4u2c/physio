'Шобачић', 'Шоргић', 'Шошкић', 'Шпирић', 'Штакић', 'Штулић', 'Шубакић', 'Шубарић', 'Шубић', 'Шулеић', 'Шулејић', 'Шулетић', 'Шулкић', 'Шулубурић', 'Шуљагић', 'Шуматић', 'Шундерић', 'Шункић', 'Шуњеварић', 'Шутуљић', 'Шушић', 'Шушулић',
    );
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

namespace Faker\Provider\sv_SE;

class Address extends \Faker\Provider\Address
{
    protected static $buildingNumber = array('%###', '%##', '%#', '%#?', '%', '%?');

    protected static $streetPrefix = array(
        'Stor', 'Små', 'Lill', 'Sjö', 'Kungs', 'Drottning', 'Hamn', 'Brunns', 'Linné', 'Vasa', 'Ring', 'Freds'
    );

    protected static $streetSuffix = array(
        'vägen', 'gatan', 'gränd', 'stigen', 'backen', 'liden'
    );

    protected static $streetSuffixWord = array(
        'Allé', 'Gata', 'Väg', 'Backe'
    );

    protected static $postcode = array('%####', '%## ##');

    /**
     * @var array Swedish city names
     * @link http://sv.wikipedia.org/wiki/Lista_%C3%B6ver_Sveriges_t%C3%A4torter
     */
    protected static $cityNames = array(
        'Abbekås', 'Abborrberget', 'Agunnaryd', 'Alberga', 'Alby', 'Alfta', 'Algutsrum', 'Alingsås', 'Allerum', 'Almunge', 'Alsike', 'Alstad', 'Alster', 'Alsterbro', 'Alstermo', 'Alunda', 'Alvesta', 'Alvhem', 'Alvik', 'Alvik', 'Ambjörby', 'Ambjörnarp', 'Ammenäs', 'Andalen', 'Anderslöv', 'Anderstorp', 'Aneby', 'Angelstad', 'Angered', 'Ankarsrum', 'Ankarsvik', 'Anneberg', 'Anneberg', 'Annelund', 'Annelöv', 'Antnäs', 'Aplared', 'Arboga', 'Arbrå', 'Ardala', 'Arentorp', 'Arild', 'Arjeplog', 'Arkelstorp', 'Arnäsvall', 'Arnö', 'Arontorp', 'Arvidsjaur', 'Arvika', 'Aröd och Timmervik', 'Askeby', 'Askersby', 'Askersund', 'Asmundtorp', 'Asperö', 'Aspås', 'Avan', 'Avesta', 'Axvall',
        'Backa', 'Backaryd', 'Backberg', 'Backe', 'Baggetorp', 'Ballingslöv', 'Balsby', 'Bammarboda', 'Bankekind', 'Bankeryd', 'Bara', 'Barkarö', 'Barsebäck', 'Barsebäckshamn', 'Bastuträsk', 'Beddingestrand', 'Benareby', 'Bengtsfors', 'Bengtsheden', 'Bensbyn', 'Berg', 'Berg', 'Berg', 'Berga', 'Bergagård', 'Bergby', 'Bergeforsen', 'Berghem', 'Bergkvara', 'Bergnäset', 'Bergsbyn', 'Bergshammar', 'Bergshamra', 'Bergsjö', 'Bergströmshusen', 'Bergsviken', 'Bergvik', 'Bestorp', 'Bettna', 'Bie', 'Billdal', 'Billeberga', 'Billesholm', 'Billinge', 'Billingsfors', 'Billsta', 'Bjurholm', 'Bjursås', 'Bjuv', 'Bjärnum', 'Bjärred', 'Bjärsjölagård', 'Bjästa', 'Björbo', 'Björboholm', 'Björke', 'Björketorp', 'Björklinge', 'Björkvik', 'Björkviken', 'Björkö', 'Björköby', 'Björlanda', 'Björna', 'Björneborg', 'Björnlunda', 'Björnänge', 'Björnö', 'Björnömalmen och Klacknäset', 'Björsäter', 'Blackstalund', 'Bleket', 'Blentarp', 'Blidsberg', 'Blikstorp', 'Blombacka', 'Blomstermåla', 'Blåsmark', 'Blötberget', 'Bockara', 'Boda', 'Bodafors', 'Boden', 'Boholmarna', 'Boliden', 'Bollebygd', 'Bollnäs', 'Bollstabruk', 'Bonäs', 'Boo', 'Bor', 'Borensberg', 'Borggård', 'Borgholm', 'Borgstena', 'Borlänge', 'Borrby', 'Borås', 'Bosnäs', 'Botsmark', 'Bottnaryd', 'Bovallstrand', 'Boxholm', 'Brantevik', 'Brastad', 'Brattås', 'Braås', 'Bredared', 'Bredaryd', 'Bredbyn', 'Bredsand', 'Bredviken', 'Brevik', 'Brevikshalvön', 'Bro', 'Broaryd', 'Broby', 'Brokind', 'Bromölla', 'Brottby', 'Brunflo', 'Brunn', 'Brunna', 'Brunnsberg', 'Bruzaholm', 'Brålanda', 'Bräcke', 'Bräkne-Hoby', 'Brändön', 'Brännland', 'Brännö', 'Brösarp', 'Bua', 'Buerås', 'Bullmark', 'Bunkeflostrand', 'Bureå', 'Burgsvik', 'Burlövs egnahem', 'Burseryd', 'Burträsk', 'Buskhyttan', 'Butbro', 'Bygdeå', 'Bygdsiljum', 'Byske', 'Bålsta', 'Bårslöv', 'Båstad', 'Båtskärsnäs', 'Bäckaskog', 'Bäckebo', 'Bäckefors', 'Bäckhammar', 'Bälgviken', 'Bälinge', 'Bälinge', 'Bärby', 'Bäsna', 'Böle', 'Bönan',
        'Charlottenberg',
        'Dalarö', 'Dalby', 'Dals Långed', 'Dals Rostock', 'Dalsjöfors', 'Dalstorp', 'Dalum', 'Danholn', 'Dannemora', 'Dannike', 'Degeberga', 'Degerfors', 'Degerhamn', 'Deje', 'Delary', 'Delsbo', 'Dingersjö', 'Dingle', 'Dingtuna', 'Diseröd', 'Diö', 'Djulö kvarn', 'Djura', 'Djurmo', 'Djurås', 'Djurö', 'Docksta', 'Domsten', 'Donsö', 'Dorotea', 'Drag', 'Drottningholm', 'Drängsmark', 'Dunö', 'Duved', 'Duvesjön', 'Dvärsätt', 'Dyvelsten', 'Dösjebro',
        'Ed', 'Eda glasbruk', 'Edane', 'Ed