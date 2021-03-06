ho PHP_EOL.PHP_EOL;
}

function extractLocaleFromFilePath($filePath)
{
    $parts = explode('.', $filePath);

    return $parts[count($parts) - 2];
}

function extractTranslationKeys($filePath)
{
    $translationKeys = [];
    $contents = new \SimpleXMLElement(file_get_contents($filePath));

    foreach ($contents->file->body->{'trans-unit'} as $translationKey) {
        $translationId = (string) $translationKey['id'];
        $translationKey = (string) $translationKey->source;

        $translationKeys[$translationId] = $translationKey;
    }

    return $translationKeys;
}

function printTitle($title)
{
    echo $title.PHP_EOL;
    echo str_repeat('=', strlen($title)).PHP_EOL.PHP_EOL;
}

function printTable($translations, $verboseOutput)
{
    if (0 === count($translations)) {
        echo 'No translations found';

        return;
    }
    $longestLocaleNameLength = max(array_map('strlen', array_keys($translations)));

    foreach ($translations as $locale => $translation) {
        $isTranslationCompleted = $translation['translated'] === $translation['total'];
        if ($isTranslationCompleted) {
            textColorGreen();
        }

        echo sprintf('| Locale: %-'.$longestLocaleNameLength.'s | Translated: %d/%d', $locale, $translation['translated'], $translation['total']).PHP_EOL;

        textColorNormal();

        if (true === $verboseOutput && \count($translation['missingKeys']) > 0) {
            echo str_repeat('-', 80).PHP_EOL;
            echo '| Missing Translations:'.PHP_EOL;

            foreach ($translation['missingKeys'] as $id => $content) {
                echo sprintf('|   (id=%s) %s', $id, $content).PHP_EOL;
            }

            echo str_repeat('-', 80).PHP_EOL;
        }
    }
}

function textColorGreen()
{
    echo "\033[32m";
}

function textColorNormal()
{
    echo "\033[0m";
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     {
    "az_Cyrl": "root",
    "bs_Cyrl": "root",
    "en_150": "en_001",
    "en_AG": "en_001",
    "en_AI": "en_001",
    "en_AT": "en_150",
    "en_AU": "en_001",
    "en_BB": "en_001",
    "en_BE": "en_150",
    "en_BM": "en_001",
    "en_BS": "en_001",
    "en_BW": "en_001",
    "en_BZ": "en_001",
    "en_CA": "en_001",
    "en_CC": "en_001",
    "en_CH": "en_150",
    "en_CK": "en_001",
    "en_CM": "en_001",
    "en_CX": "en_001",
    "en_CY": "en_001",
    "en_DE": "en_150",
    "en_DG": "en_001",
    "en_DK": "en_150",
    "en_DM": "en_001",
    "en_ER": "en_001",
    "en_FI": "en_150",
    "en_FJ": "en_001",
    "en_FK": "en_001",
    "en_FM": "en_001",
    "en_GB": "en_001",
    "en_GD": "en_001",
    "en_GG": "en_001",
    "en_GH": "en_001",
    "en_GI": "en_001",
    "en_GM": "en_001",
    "en_GY": "en_001",
    "en_HK": "en_001",
    "en_IE": "en_001",
    "en_IL": "en_001",
    "en_IM": "en_001",
    "en_IN": "en_001",
    "en_IO": "en_001",
    "en_JE": "en_001",
    "en_JM": "en_001",
    "en_KE": "en_001",
    "en_KI": "en_001",
    "en_KN": "en_001",
    "en_KY": "en_001",
    "en_LC": "en_001",
    "en_LR": "en_001",
    "en_LS": "en_001",
    "en_MG": "en_001",
    "en_MO": "en_001",
    "en_MS": "en_001",
    "en_MT": "en_001",
    "en_MU": "en_001",
    "en_MW": "en_001",
    "en_MY": "en_001",
    "en_NA": "en_001",
    "en_NF": "en_001",
    "en_NG": "en_001",
    "en_NL": "en_150",
    "en_NR": "en_001",
    "en_NU": "en_001",
    "en_NZ": "en_001",
    "en_PG": "en_001",
    "en_PH": "en_001",
    "en_PK": "en_001",
    "en_PN": "en_001",
    "en_PW": "en_001",
    "en_RW": "en_001",
    "en_SB": "en_001",
    "en_SC": "en_001",
    "en_SD": "en_001",
    "en_SE": "en_150",
    "en_SG": "en_001",
    "en_SH": "en_001",
    "en_SI": "en_150",
    "en_SL": "en_001",
    "en_SS": "en_001",
    "en_SX": "en_001",
    "en_SZ": "en_001",
    "en_TC": "en_001",
    "en_TK": "en_001",
    "en_TO": "en_001",
    "en_TT": "en_001",
    "en_TV": "en_001",
    "en_TZ": "en_001",
    "en_UG": "en_001",
    "en_VC": "en_001",
    "en_VG": "en_001",
    "en_VU": "en_001",
    "en_WS": "en_001",
    "en_ZA": "en_001",
    "en_ZM": "en_001",
    "en_ZW": "en_001",
    "es_AR": "es_419",
    "es_BO": "es_419",
    "es_BR": "es_419",
    "es_BZ": "es_419",
    "es_CL": "es_419",
    "es_CO": "es_419",
    "es_CR": "es_419",
    "es_CU": "es_419",
    "es_DO": "es_419",
    "es_EC": "es_419",
    "es_GT": "es_419",
    "es_HN": "es_419",
    "es_MX": "es_419",
    "es_NI": "es_419",
    "es_PA": "es_419",
    "es_PE": "es_419",
    "es_PR": "es_419",
    "es_PY": "es_419",
    "es_SV": "es_419",
    "es_US": "es_419",
    "es_UY": "es_419",
    "es_VE": "es_419",
    "pa_Arab": "root",
    "pt_AO": "pt_PT",
    "pt_CH": "pt_PT",
    "pt_CV": "pt_PT",
    "pt_GQ": "pt_PT",
    "pt_GW": "pt_PT",
    "pt_LU": "pt_PT",
    "pt_MO": "pt_PT",
    "pt_MZ": "pt_PT",
    "pt_ST": "pt_PT",
    "pt_TL": "pt_PT",
    "sr_Latn": "root",
    "uz_Arab": "root",
    "uz_Cyrl": "root",
    "zh_Hant": "root",
    "zh_Hant_MO": "zh_Hant_HK"
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?xml version="1.0" encoding="UTF-8"?>

<!--

May-19-2004:
- Changed the <choice> for ElemType_header, moving minOccurs="0" maxOccurs="unbounded" from its elements
to <choice> itself.
- Added <choice> for ElemType_trans-unit to allow "any order" for <context-group>, <count-group>, <prop-group>, <note>, and
<alt-trans>.

Oct-2005
- updated version info to 1.2
- equiv-trans attribute to <trans-unit> element
- merged-trans attribute for <group> element
- Add the <seg-source> element as optional in the <trans-unit> and <alt-trans> content models, at the same level as <source>
- Create a new value "seg" for the mtype attribute of the <mrk> element
- Add mid as an optional attribute for the <alt-trans> element

Nov-14-2005
- Changed name attribute for <context-group> from required to optional
- Added extension point at <xliff>

Jan-9-2006
- Added alttranstype type attribute to <alt-trans>, and values

Jan-10-2006
- Corrected error with overwritten purposeValueList
- Corrected name="AttrType_Version",  attribute should have been "name"

-->
<xsd:schema xmlns:xlf="urn:oasis:names:tc:xliff:document:1.2" xmlns:xsd="http://www.w3.org/2001/XMLSchema" elementF