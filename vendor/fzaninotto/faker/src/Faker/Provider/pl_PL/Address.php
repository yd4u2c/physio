
         gross profits you derive calculated using the method you
         already use to calculate your applicable taxes.  If you
         don't derive profits, no royalty is due.  Royalties are
         payable to "Project Gutenberg Literary Archive Foundation"
         the 60 days following each date you prepare (or were
         legally required to prepare) your annual (or equivalent
         periodic) tax return.  Please contact us beforehand to
         let us know your plans and to work out the details.

    WHAT IF YOU *WANT* TO SEND MONEY EVEN IF YOU DON'T HAVE TO?
    Project Gutenberg is dedicated to increasing the number of
    public domain and licensed works that can be freely distributed
    in machine readable form.

    The Project gratefully accepts contributions of money, time,
    public domain materials, or royalty free copyright licenses.
    Money should be paid to the:
    "Project Gutenberg Literary Archive Foundation."

    If you are interested in contributing scanning equipment or
    software or other items, please contact Michael Hart at:
    hart@pobox.com

    [Portions of this eBook's header and trailer may be reprinted only
    when distributed free of all fees.  Copyright (C) 2001, 2002 by
    Michael S. Hart.  Project Gutenberg is a TradeMark and may not be
    used in any sales of Project Gutenberg eBooks or other materials be
    they hardware or software or any other related product without
    express permission.]

    *END THE SMALL PRINT! FOR PUBLIC DOMAIN EBOOKS*Ver.02/11/02*END*

    */
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         INDX( 	 ��l             (      �                            x     h X     w     pn�ok� Uze�<}��<�pn�ok� P      -B               A d d r e s s . p h p y     h X     w     D9u�ok� Uze�Ӝ���<�D9u�ok�       c	               C o m p a n y . p h p z     p Z     w     ����ok� Uze�Ӝ���<�����ok�P      L               I n t e r n e t . p h p       {     h X     w     E��ok� Uze�7 ���<�E��ok�        �               P a y m e n t . p h p |     h V     w     ����ok� Uze��a���<�����ok� 0      $*              
 P e r s o n . p h p   }     p `     w     ����ok� Uze��a���<�����ok��      {               P h o n e N u m b e r . p h p ~     h R     w     :q��ok� Uze��ĥ��<�:q��ok�                    T e x t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

namespace Faker\Provider\pt_BR;

class Address extends \Faker\Provider\Address
{
    protected static $cityPrefix = array('São', 'Porto', 'Vila', 'Santa');
    protected static $citySuffix = array('do Norte', 'do Leste', 'do Sul', 'd\'Oeste');
    protected static $streetPrefix = array(
        'Av.', 'Avenida', 'R.', 'Rua', 'Travessa', 'Largo'
    );
    protected static $buildingNumber = array('#####', '####', '###', '##', '#');
    protected static $postcode = array('#####-###');
    protected static $state = array(
        'Acre', 'Alagoas', 'Amapá', 'Amazonas', 'Bahia', 'Ceará',
        'Distrito Federal', 'Espírito Santo', 'Goiás', 'Maranhão',
        'Mato Grosso', 'Mato Grosso do Sul', 'Minas Gerais', 'Pará', 'Paraíba',
        'Paraná', 'Pernambuco', 'Piauí', 'Rio de Janeiro',
        'Rio Grande do Norte', 'Rio Grande do Sul', 'Rondônia', 'Roraima',
        'Santa Catarina', 'São Paulo', 'Sergipe', 'Tocantins'
    );
    protected static $stateAbbr = array(
        'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS',
        'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC',
        'SP', 'SE', 'TO'
    );
    protected static $region = array(
        'Centro-Oeste', 'Nordeste', 'Norte', 'Sudeste', 'Sul'
    );
    protected static $regionAbbr = array(
        'CO', 'N', 'NE', 'SE', 'S'
    );
    protected static $country = array(
        'Afeganistão', 'África do Sul', 'Albânia', 'Alemanha', 'Andorra',
        'Angola', 'Antigua e Barbuda', 'Arabia Saudita', 'Argélia',
        'Argentina', 'Armênia', 'Austrália', 'Áustria', 'Azerbaijão',
        'Bahamas', 'Bangladesh', 'Barbados', 'Barein', 'Belize', 'Benin',
        'Bielorrússia', 'Birmânia', 'Bolívia', 'Bósnia e Herzegovina',
        'Botsuana', 'Brasil', 'Brunei', 'Bulgária', 'Burkina Faso',
        'Burundi', 'Butão', 'Bélgica', 'Cabo Verde', 'Camboja', 'Camarões',
        'Canadá', 'Cazaquistão', 'Chad', 'Chile', 'China', 'Chipre',
        'Colômbia', 'Comoras', 'Congo', 'Coréia do Norte', 'Coréia do Sul',
        'Costa Rica', 'Costa do Marfim', 'Croácia', 'Cuba', 'Dinamarca',
        'Djibouti', 'Domênica', 'Equador', 'Egito', 'El Salvador',
        'Emirados Árabes Unidos', 'Eritrea', 'Eslováquia', 'Eslovênia',
        'Espanha', 'Estados Unidos da América', 'Estônia', 'Etiópia',
        'Filipinas', 'Finlândia', 'Fiji','França', 'Gabão', 'Gâmbia',
        'Georgia', 'Gana', 'Granada', 'Grécia', 'Guatemala',
        'Guiné Equatorial', 'Guiné Bissau', 'Guiana', 'Haiti', 'Honduras',
        'Hungria', 'Índia', 'Indonésia', 'Iraque', 'Irlanda', 'Irã',
        'Islândia', 'Ilhas Marshall', 'Ilhas Maurício', 'Ilhas Salomão',
        'Ilhas Samoa', 'Israel', 'Itália', 'Jamaica', 'Japão', 'Jordânia',
        'Kiribati', 'Kwait', 'Laos', 'Lesoto', 'Letônia', 'Libéria', 'Líbia',
        'Liechtenstein', 'Lituânia', 'Luxemburgo', 'Líbano', 'Macedônia',
        'Madagascar', 'Malásia', 'Malauí', 'Maldivas', 'Mali', 'Malta',
        'Marrocos', 'Mauritânia', 'Micronésia', 'Moldávia', 'Mongólia',
        'Montenegro', 'Moçambique', 'México', 'Mônaco', 'Namíbia', 'Nauru',
        'Nepal', 'Nicarágua', 'Nigéria', 'Noruega', 'Nova Guiné',
        'Nova Zelândia', 'Níger', 'Omã', 'Qatar', 'Quênia','Quirguistão',
        'Paquistão', 'Palaos', 'Panamá', 'Papua Nova Guiné', 'Paraguai',
        'Países Baixos', 'Peru', 'Polônia', 'Portugal', 'Reino Unido',
        'Reino Unido da Grã Bretanha e Irlanda do Norte',
        'República Centroafricana', 'República Checa',
        'República Democrática do Congo', 'República Dominicana', 'Ruanda',
        'Romênia', 'Rússia', 'San Cristõvao e Neves', 'San Marino',
        'São Vicente e as Granadinas', 'Santa Luzia', 'São Tomé e Príncipe',
        'Senegal', 'Sérvia', 'Seychelles', 'Serra Leoa', 'Singapura', 'Síria',
        'Somália', 'Sri Lanka', 'Suazilândia', 'Sudão', 'Suécia', 'Suiça',
        'Suriname', 'Tailândia', 'Tanzânia', 'Tajiquistão', 'Timor Leste',
        'Togo', 'Tonga', 'Trinidad e Tobago', 'Turcomenistão', 'Turquia',
        'Tuvalu', 'Tunísia', 'Ucrânia', 'Uganda', 'Uruguai', 'Uzbequistão',
        'Vaticano', 'Vanuatu', 'Venezuela', 'Vietnã', 'Yemen', 'Zâmbia',
        'Zimbábue'
    );
    protected static $cityFormats = array(
        '{{cityPrefix}} {{firstName}} {{citySuffix}}',
        '{{cityPrefix}} {{firstName}}',
        '{{firstName}} {{citySuffix}}',
        '{{lastName}} {{citySuffix}}',
    );
    protected static $streetNameFormats = array(
        '{{streetPrefix}} {{firstName}}',
        '{{streetPrefix}} {{lastName}}',
        '{{streetPrefix}} {{firstName}} {{lastName}}'
    );
    protected static $streetAddressFormats = array(
        '{{streetName}}, {{buildingNumber}}',
        '{{streetName}}, {{buildingNumber}}. {{secondaryAddress}}',
    );
    protected static $addressFormats = array(
        "{{postcode}}, {{streetAddress}}\n{{city}} - {{stateAbbr}}",
    );
    protected static $secondaryAddressFormats = array(
        'Bloco A', 'Bloco B', 'Bloco C', 'Bc. # Ap. ##', 'Bc. ## Ap. ##',
        '#º Andar', '##º Andar', '###º Andar', 'Apto #', 'Apto ##', 'Apto ###',
        'Apto ####', 'F', 'Fundos', 'Anexo'
    );

    /**
     * @example 'Avenida'
     */
    public static function streetPrefix()
    {
        return static::randomElement(static::$streetPrefix);
    }

    /**
     * @example 'São'
     */
    public static function cityPrefix()
    {
        return static::randomElement(static::$cityPrefix);
    }

    /**
     * @example '6º Andar'
     */
    public static function secondaryAddress()
    {
        return static::numerify(static::randomElement(static::$secondaryAddressFormats));
    }

    /**
     * @example 'Brasília'
     */
    public static function state()
    {
        return static::randomElement(static::$state);
    }

    /**
     * @example 'DF'
     */
    public static function stateAbbr()
    {
        return static::randomElement(static::$stateAbbr);
    }
    
    /**
     * @example 'Nordeste'
     */
    public static function region()
    {
        return static::randomElement(static::$region);
    }
    
    /**
     * @example 'NE'
     */
    public static function regionAbbr()
    {
        return static::randomElement(static::$regionAbbr);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

namespace Faker\Provider\pt_BR;

/**
 * Calculates one MOD 11 check digit based on customary Brazilian algorithms.
 * @link http://en.wikipedia.org/wiki/Check_digit
 * @link http://pt.wikipedia.org/wiki/CNPJ#Algoritmo_de_Valida.C3.A7.C3.A3o
 * @link http://en.wikipedia.org/wiki/Cadastro_de_Pessoas_F%C3%ADsicas#Validation
 *
 * @param string|integer $numbers Numbers on which generate the check digit
 * @return integer
 */
function check_digit($numbers)
{
    $length = strlen($numbers);
    $second_algorithm = $length >= 12;
    $verifier = 0;

 