  /**
     * This array should contain all currently known langcodes.
     *
     * As it is impossible to have this ever complete we should try as hard as possible to have it almost complete.
     *
     * @return array
     */
    public function successLangcodes()
    {
        return [
            ['1', ['ay', 'bo', 'cgg', 'dz', 'id', 'ja', 'jbo', 'ka', 'kk', 'km', 'ko', 'ky']],
            ['2', ['nl', 'fr', 'en', 'de', 'de_GE', 'hy', 'hy_AM']],
            ['3', ['be', 'bs', 'cs', 'hr']],
            ['4', ['cy', 'mt', 'sl']],
            ['6', ['ar']],
        ];
    }

    /**
     * This array should be at least empty within the near future.
     *
     * This both depends on a complete list trying to add above as understanding
     * the plural rules of the current failing languages.
     *
     * @return array with nplural together with langcodes
     */
    public function failingLangcodes()
    {
        return [
            ['1', ['fa']],
            ['2', ['jbo']],
            ['3', ['cbs']],
            ['4', ['gd', 'kw']],
            ['5', ['ga']],
        ];
    }

    /**
     * We validate only on the plural coverage. Thus the real rules is not tested.
     *
     * @param string $nplural       Plural expected
     * @param array  $matrix        Containing langcodes and their plural index values
     * @param bool   $expectSuccess
     */
    protected function validateMatrix($nplural, $matrix, $expectSuccess = true)
    {
        foreach ($matrix as $langCode => $data) {
            $indexes = array_flip($data);
            if ($expectSuccess) {
                $this->assertEquals($nplural, \count($indexes), "Langcode '$langCode' has '$nplural' plural forms.");
            } else {
                $this->assertNotEquals((int) $nplural, \count($indexes), "Langcode '$langCode' has '$nplural' plural forms.");
            }
        }
    }

    protected function generateTestData($langCodes)
    {
        $translator = new class() {
            use TranslatorTrait {
                getPluralizationRule as public;
            }
        };

        $matrix = [];
        foreach ($langCodes as $langCode) {
            for ($count = 0; $count < 200; ++$count) {
                $plural = $translator->getPluralizationRule($count, $langCode);
                $matrix[$langCode][$count] = $plural;
            }
        }

        return $matrix;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           CHANGELOG
=========

4.2.0
-----

 * support selecting the format to use by setting the environment variable `VAR_DUMPER_FORMAT` to `html` or `cli`

4.1.0
-----

 * added a `ServerDumper` to send serialized Data clones to a server
 * added a `ServerDumpCommand` and `DumpServer` to run a server collecting
   and displaying dumps on