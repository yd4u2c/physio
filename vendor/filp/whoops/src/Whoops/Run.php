variableName]) ?
            $this->variables[$variableName] : $defaultValue;
    }

    /**
     * Unsets a single template variable, by its name
     *
     * @param string $variableName
     */
    public function delVariable($variableName)
    {
        unset($this->variables[$variableName]);
    }

    /**
     * Returns all variables for this helper
     *
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * Set the cloner used for dumping variables.
     *
     * @param AbstractCloner $cloner
     */
    public function setCloner($cloner)
    {
        $this->cloner = $cloner;
    }

    /**
     * Get the cloner used for dumping variables.
     *
     * @return AbstractCloner
     */
    public function getCloner()
    {
        if (!$this->cloner) {
            $this->cloner = new VarCloner();
        }
        return $this->cloner;
    }

    /**
     * Set the application root path.
     *
     * @param string $applicationRootPath
     */
    public function setApplicationRootPath($applicationRootPath)
    {
        $this->applicationRootPath = $applicationRootPath;
    }

    /**
     * Return the application root path.
     *
     * @return string
     */
    public function getApplicationRootPath()
    {
        return $this->applicationRootPath;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               CHANGELOG
=========

2018-07-12, v1.8.0
------------------

- Typo in readme [\#1521](https://github.com/fzaninotto/Faker/pull/1521) ([jmhobbs](https://github.com/jmhobbs))
- Replaced Hilll with Hill [\#1516](https://github.com/fzaninotto/Faker/pull/1516) ([MarkVaughn](https://github.com/MarkVaughn))
- \[it\_IT\] Improve vat ID generated using official rules [\#1508](https://github.com/fzaninotto/Faker/pull/1508) ([mavimo](https://github.com/mavimo))
- \[hu\_HU\] Address: Fix unnecessary new line in string [\#1507](https://github.com/fzaninotto/Faker/pull/1507) ([ntomka](https://github.com/ntomka))
- add phone numer format [\#1506](https://github.com/fzaninotto/Faker/pull/1506) ([Enosh-Yu](https://github.com/Enosh-Yu))
- Fix typo in fr\_CA Provider [\#1505](https://github.com/fzaninotto/Faker/pull/1505) ([ultreson](https://github.com/ultreson))
- Add fake-car provider link [\#1497](https://github.com/fzaninotto/Faker/pull/1497) ([pelmered](https://github.com/pelmered))
- create `passthrough` function [\#1493](https://github.com/fzaninotto/Faker/pull/1493) ([browner12](https://github.com/browner12))
- update Polish bank list [\#1482](https://github.com/fzaninotto/Faker/pull/1482) ([IonBazan](https://github.com/IonBazan))
- Update the parameters to check if the setter is callable [\#1470](https://github.com/fzaninotto/Faker/pull/1470) ([rossmitchell](https://github.com/rossmitchell))
- Push the max date far into the future so the test can pass [\#1469](https://github.com/fzaninotto/Faker/pull/1469) ([rossmitchell](https://github.com/rossmitchell))
- Update Address.php [\#1465](https://github.com/fzaninotto/Faker/pull/1465) ([Saibamen](https://github.com/Saibamen))
- Turkish identity number for tr\_TR [\#1462](https://github.com/fzaninotto/Faker/pull/1462) ([aykutaras](https://github.com/aykutaras))
- Fixing rare iin with 13-digits. [\#1450](https://github.com/fzaninotto/Faker/pull/1450) ([vadimonus](https://github.com/vadimonus))
- Fix Polish PESEL faker [\#1449](https://github.com/fzaninotto/Faker/pull/1449) ([Dartui](https://github.com/Dartui))
- Adds valid 08 number formats for fr\_FR [\#1439](https://github.com/fzaninotto/Faker/pull/1439) ([ppelgrims](https://github.com/ppelgrims))
- Add YouTube provider link [\#1422](https://github.com/fzaninotto/Faker/pull/1422) ([aalaap](https://github.com/aalaap))
- Update PHPDoc of the DateTime provider. [\#1419](https://github.com/fzaninotto/Faker/pull/1419) ([tomzx](https://github.com/tomzx))
- Normalize name of variable [\#1412](https://github.com/fzaninotto/Faker/pull/1412) ([eaglewu](https://github.com/eaglewu))
- Added "blockchain" to en-us company provider catchPhrase method [\#1411](https://github.com/fzaninotto/Faker/pull/1411) ([samoldenburg](https://github.com/samoldenburg))
- Fix for Spot2 ORM EntityPopulator [\#1408](https://github.com/fzaninotto/Faker/pull/1408) ([michal-borek](https://github.com/michal-borek))
- TH color name [\#1404](https://github.com/fzaninotto/Faker/pull/1404) ([Naruedom](https://github.com/Naruedom))
- added Malaysia \[ms\_MY\] locale [\#1403](https://github.com/fzaninotto/Faker/pull/1403) ([kenfai](https://github.com/kenfai))
- Implementation of the function that generates Brazilian area codes fixed. [\#1401](https://github.com/fzaninotto/Faker/pull/1401) ([jackmiras](https://github.com/jackmiras))
- VISA retired the 13 digit PAN moved to new cardParams [\#1400](https://github.com/fzaninotto/Faker/pull/1400) ([hppycoder](https://github.com/hppycoder))
- Remove unused variable inside closure [\#1395](https://github.com/fzaninotto/Faker/pull/1395) ([carusogabriel](https://github.com/carusogabriel))
- .nz domain updates [\#1393](https://github.com/fzaninotto/Faker/pull/1393) ([xurizaemon](https://github.com/xurizaemon))
- Add licenceCode method in the to es\_ES person provider [\#1392](https://github.com/fzaninotto/Faker/pull/1392) ([ffiguereo](https://github.com/ffiguereo))
- allow `randomElements` to accept a Traversable object [\#1389](https://github.com/fzaninotto/Faker/pull/1389) ([browner12](https://github.com/browner12))
- Doc: rg remove formatting [\#1387](https://github.com/fzaninotto/Faker/pull/1387) ([emtudo](https://github.com/emtudo))
- Add numbers with start 4 [\#1386](https://github.com/fzaninotto/Faker/pull/1386) ([emtudo](https://github.com/emtudo))
- update th\_TH mobile number format [\#1385](https://github.com/fzaninotto/Faker/pull/1385) ([earthpyy](https://github.com/earthpyy))
- Translate country names for lv\_LV provider. [\#1383](https://github.com/fzaninotto/Faker/pull/1383) ([ronaldsgailis](https://github.com/ronaldsgailis))
- Clean elses [\#1382](https://github.com/fzaninotto/Faker/pull/1382) ([carusogabriel](https://github.com/carusogabriel))
- French vat formatter [\#1381](https://github.com/fzaninotto/Faker/pull/1381) ([ppelgrims](https://github.com/ppelgrims))
- Replaces rtrim with preg\_replace [\#1380](https://github.com/fzaninotto/Faker/pull/1380) ([ppelgrims](https://github.com/ppelgrims))
- Refactoring tests [\#1375](https://github.com/fzaninotto/Faker/pull/1375) ([carusogabriel](https://github.com/carusogabriel))
- Added link in readme to provider FakerRestaurant [\#1374](https://github.com/fzaninotto/Faker/pull/1374) ([jzonta](https://github.com/jzonta))
- Remove obsolete currency codes [\#1373](https://github.com/fzaninotto/Faker/pull/1373) ([tpraxl](https://github.com/tpraxl))
- \[ru\_RU\] Updated countries and added source link [\#1372](https://github.com/fzaninotto/Faker/pull/1372) ([ilyahoilik](https://github.com/ilyahoilik))
- Test against PHP 7.2 [\#1371](https://github.com/fzaninotto/Faker/pull/1371) ([carusogabriel](https://github.com/carusogabriel))
- Feature: nl\_BE text provider [\#1370](https://github.com/fzaninotto/Faker/pull/1370) ([rauwebieten](https://github.com/rauwebieten))
- default value for Payment::iban\(\) country code [\#1369](https://github.com/fzaninotto/Faker/pull/1369) ([madmanmax](https://github.com/madmanmax))
- skip test failing on bigendian [\#1365](https://github.com/fzaninotto/Faker/pull/1365) ([remicollet](https://github.com/remicollet))
- Update Person.php [\#1364](https://github.com/fzaninotto/Faker/pull/1364) ([majamusan](https://github.com/majamusan))
- Prevent errors on private methods [\#1363](https://github.com/fzaninotto/Faker/pull/1363) ([petecoop](https://github.com/petecoop))
- adds rijksregisternummer [\#1361](https://github.com/fzaninotto/Faker/pull/1361) ([ppelgrims](https://github.com/ppelgrims))
- Add secondary address to fr\_FR provider [\#1356](https://github.com/fzaninotto/Faker/pull/1356) ([nicodmf](https://github.com/nicodmf))
- Add company provider for tr\_TR [\#1355](https://github.com/fzaninotto/Faker/pull/1355) ([yuks](https://github.com/yuks))
- nb\_NO provider updates [\#1350](https://github.com/fzaninotto/Faker/pull/1350) ([alexqhj](https://github.com/alexqhj))
- only test available date range on 32-bit [\#1348](https://github.com/fzaninotto/Faker/pull/1348) ([remicollet](https://github.com/remicollet))
- Bump PHPUnit version for namespace compatibility [\#1345](https://github.com/fzaninotto/Faker/pull/1345) ([carusogabriel](https://github.com/carusogabriel))
- Use PSR-1 for PHPUnit TestCase [\#1344](https://github.com/fzaninotto/Faker/pull/1344) ([carusogabriel](https://github.com/carusogabriel))
- Fix FR\_fr 07 prefix mobile number generation [\#1343](https://github.com/fzaninotto/Faker/pull/1343) ([svanpoeck](https://github.com/svanpoeck))
- Update Text.php [\#1339](https://github.com/fzaninotto/Faker/pull/1339) ([gulaandrij](https://github.com/gulaandrij))
- Add two new company type in the Swiss Provider [\#1336](https://github.com/fzaninotto/Faker/pull/1336) ([pvullioud](https://github.com/pvullioud))
- Change symbol 'minus' with code 226 to 'minus' with code 45 [\#1333](https://github.com/fzaninotto/Faker/pull/1333) ([Negasus](https://github.com/Negasus))
- \[sl\_SI\] Created provider for Company [\#1331](https://github.com/fzaninotto/Faker/pull/1331) ([alesvaupotic](https://github.com/alesvaupotic))
- Update city name [\#1328](https://github.com/fzaninott