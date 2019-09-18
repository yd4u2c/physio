�άκη', 'Καπνού', 'Καρσιβάνη', 'Κοκκίνου', 'Κωνσταντινίδου', 'Κωνσταντίνου', 'Κυριακοπούλου', 'Λάσκαρη', 'Λασκαρού', 'Μάκρη', 'Μακρή', 'Μοραΐτη', 'Μπόγρη', 'Μυλωνά',
        'Νικολάου', 'Νικολοπούλου', 'Ξανθοπούλου', 'Οικονομίδου', 'Οικονομοπούλου', 'Οικονόμου', 'Παπαδοπούλου', 'Παπακιρίσκου', 'Παπακωνσταντίνου', 'Παπαμάρκου', 'Παπαστάμου', 'Ράφτη', 'Σακελλαρίου', 'Σελινά', 'Σκουτέρη',
        'Σπανού', 'Σταματιάδου', 'Σωπολιάτη', 'Τριανταφυλλίδου', 'Φοσκιά', 'Φωτιάδου', 'Χαραλαμπίδου', 'Χατζηιωάννου',
    );

    protected static $titleMale = array('κος.', 'κ.');
    protected static $titleFemale = array('δις.', 'δνις.', 'κα.');

    /**
     * @param string|null $gender 'male', 'female' or null for any
     * @example 'Αγγελόπουλος'
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

    /**
     * @example 'Θεωδωρόπουλος'
     */
    public static function lastNameMale()
    {
        return static::randomElement(static::$lastNameMale);
    }

    /**
     * @example 'Κοκκίνου'
     */
    public static function lastNameFemale()
    {
        return static::randomElement(static::$lastNameFemale);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

namespace Faker\Provider\el_GR;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    /**
     * @link https://en.wikipedia.org/wiki/Telephone_numbers_in_Greece
     */
    protected static $formats = array(
        // International formats
        '+30 2# ########',
        '+30 2## #######',
        '+30 2### ######',
        '+302#########',

        '+3069########',
        '+30 69 ########',
        '+30 69########',
        '+30 69# #######',
        '+30 69# ### ####',
        '+30 69# #### ###',
        '+30 69## ######',
        '+30 69## ## ## ##',
        '+30 69## ### ###',

        // Standard format
        '2#########',
        '2## #######',
        '2### ######',

        '69########',
        '69# #######',
        '69# ### ####',
        '69# #### ###',
        '69## ######',
        '69## ## ## ##',
        '69## ### ###',
    );

    protected static $mobileFormats = array(
        // International formats
        '+3069########',
        '+30 69########',
        '+30 69# #######',
        '+30 69# ### ####',
        '+30 69# #### ###',
        '+30 69## ######',
        '+30 69## ## ## ##',
        '+30 69## ### ###',

        // Standard formats
        '69########',
        '69# #######',
        '69# ### ####',
        '69# #### ###',
        '69## ######',
        '69## ## ## ##',
        '69## ### ###',
    );

    public static function mobilePhoneNumber()
    {
        return static::numerify(static::randomElement(static::$mobileFormats));
    }

    protected static $tollFreeFormats = array(
        // International formats
        '+30 800#######',
        '+30 800 #######',
        '+30 800 ## #####',
        '+30 800 ### ####',

        // Standard formats
        '800#######',
        '800 #######',
        '800 ## #####',
        '800 ### ####',
    );

    public static function tollFreeNumber()
    {
        return static::numerify(static::randomElement(static::$tollFreeFormats));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

namespace Faker\Provider\el_GR;

class Text extends \Faker\Provider\Text
{
    /**
     * From el.wikisource.org.
     *
     * The text is licensed under the Creative Commons Attribution / Share-Alike,
     * Also additional terms may apply. For details, see. Terms of Use.
     *
     *
     * Title: Τρελαντώνης
     *
     * Author: Πηνελόπη Δέλτα
     *
     * Posting Date: January 6, 2016
     * Release Date: 1932
     * [Last updated: September 1, 2013]
     *
     * Language: Greek
     *
     * @licence Creative Commons Attribution-ShareAlike https://creativecommons.org/licenses/by-sa/3.0/deed.el
     *
     * @see     https://wikimediafoundation.org/wiki/Terms_of_Use/
     * @link    https://el.wikisource.org/wiki/%CE%A4%CF%81%CE%B5%CE%BB%CE%B1%CE%BD%CF%84%CF%8E%CE%BD%CE%B7%CF%82
     *
     * @var string
     */
    protected static $baseText = <<<'EOT'
Ο Αντώνης ήταν πολύ σκάνταλος και πολύ άτακτος και κάθε λίγο έβρισκε τον μπελά του. Δεν περνούσε μέρα που να μην έτρωγε δυο τρεις κατσάδες, πότε από τη θεία του, πότε από τη μαγείρισσα, πότε από την Αγγλίδα δασκάλα και πότε από την τραπεζιέρα, και κάθε λίγο αναγκάζουνταν ν' ανακατώνεται ο θείος. Σαν έφθανε απέξω ο θείος και άκουε την καινούρια αταξία του Αντώνη, το αγαθό του πρόσωπο αγρίευε όσο μπορούσε, σούρωνε τ' άσπρα του φρύδια και, κουνώντας το σταχτί του κεφάλι, έλεγε αυστηρά:
- Αντώνη, ακούω πάλι πως έκανες αταξίες! Φοβούμαι πως δε θα τα πάμε καλά!
Αυτές ήταν οι σοβαρές περιστάσεις. Άκουε η Αλεξάνδρα, η μεγάλη αδελφή, και ντρέπουνταν για τον αδελφό της. Άκουε η Πουλουδιά, η μικρότερη αδελφή, κι ένιωθε την καρδιά της να παίζει τούμπανο. Άκουε και ο μικρός ο Αλέξανδρος, καθισμένος στο πάτωμα, με το δάχτυλο στο στόμα, και αποφάσιζε μέσα του πως εκείνος δεν ήθελε να γίνει έτσι κακό παιδί σαν τον Αντώνη.
Και όμως πώς ήθελε να μπορεί να κάνει όσα έκανε ο Αντώνης! Γιατί ο Αντώνης έκανε πολλά δύσκολα πράματα. Έκανε τούμπες τρεις στη σειρά και θα έκανε, λέει, και τέσσερις, αν ήταν πιο μεγάλη η κάμαρα και αν δε χτυπούσε ο τοίχος στα ποδάρια του· σκαρφάλωνε στη γαζία της αυλής· καβαλίκευε στην κουπαστή της σκάλας και κατέβαινε γλιστρώντας ως κάτω - έκανε, πηδώντας με το ένα πόδι, τρεις φορές το γύρο της αυλής του σπιτιού, χωρίς ν' αγγίξει τον τοίχο - κάθε πρωί, στη θάλασσα, βουτούσε το κεφάλι του στο νερό κι έμενε τόση ώρα με κλειστό στόμα και ανοιχτά μάτια, και δεν πνίγουνταν ποτέ. Και' άλλα πολλά έκανε ο Αντώνης. Έπειτα είχε πάντα γεμάτες τις τσέπες του από τόσους θησαυρούς. Τι δεν έβρισκες μέσα! Καρφιά, βόλους, βότσαλα, σπάγκους, κάποτε και κανένα κομμάτι μαστίχα μασημένη, και, πάνω απ' όλα, το τρίγωνο γυαλί που είχε πέσει από τον πολυέλαιο της εκκλησίας και που έκανε τόσα ωραία χρώματα σαν το έβαζες στον ήλιο. Ολόκληρο πλούτο είχαν αυτές οι τσέπες του Αντώνη.
Οι γονείς του Αντώνη, που ζούσαν στην Αίγυπτο, δεν μπόρεσαν να ταξιδέψουν εκείνο το καλοκαίρι, κι εκείνος και τ' αδέλφια του είχαν έλθει στον Πειραιά με το θείο Ζωρζή και τη θεία Μαριέτα, που δεν είχαν παιδιά, και κάθουνταν σ' ένα από τα σπίτια του Τσίλερ. Επτά ήταν τα σπίτια του Τσίλερ, όλα στην αράδα κι ενωμένα· το πρώτο, το ακριανό, μεγάλο, με τρία πρόσωπα, τ' άλλα όλα όμοια, με μια βεραντούλα προς τη θάλασσα και μιαν αυλή στο πίσω μέρος, προς το λόφο.
Στο πρώτο, το μεγάλο σπίτι, κάθουνταν ο βασιλέας· στο δεύτερο μια Ρωσίδα, κυρία της Τιμής της βασίλισσας· στο τρίτο ο Αντώνης με τ' αδέλφια του και το θείο του και τη θεία, και στ' άλλα παρακάτω διάφοροι άλλοι που, σαν το βασιλέα, είχαν κατέβει από τας Αθήνας να περάσουν τους ζεστούς μήνες του καλοκαιριού κοντά στην πειραιώτικη θάλασσα.
Κάθε μέρα ο Αντώνης και τ' αδέλφια του πήγαιναν περίπατο με την Εγγλέζα τους δασκάλα και περνούσαν εμπρός στο μεγάλο σπίτι όπου κάθουνταν ο βασιλέας, που είχε μεγάλα σκυλιά του κυνηγιού. Τ' άκουε ο Αντώνης που γάβγιζαν και τραβούσαν τις αλυσίδες τους, κλεισμένα στην αυλή τους την περιτοιχισμένη, και κάθε φορά ο κρότος αυτός και τα γαβγίσματα ήταν μεγάλος πειρασμός. Και τα τέσσερα αδέλφια γνώριζαν καλά τα σκυλιά αυτά και ιδιαίτερα ένα, τον Ντον. Τα έβλεπαν συχνά με το βασιλέα, που τα έπαιρνε μαζί του, λυτά, ελεύθερα, κάθε φορά που έβγαινε περίπατο μονάχος.
Ήταν μεγάλος πειρασμός για τον Αντώνη τα σκυλιά αυτά και κάθε φορά που περνούσε μπρος στο σπίτι του βασιλέα με την Εγγλέζα δασκάλα του, έμενε πίσω, έκανε ελιγμούς, έβρισκε διάφορες προφάσεις για να πλησιάσει την πόρτα της αυλής, μήπως και τύχει να είναι μισάνοιχτη ή μήπως και βρει καμιά χαραματιά που να τον αφήσει να δει τον Ντον, το μεγάλο κανελί σκυλί με τα παράταιρα μάτια, το ένα γαλάζιο και το άλλο πράσινο. Μα πού να ξεφύγει από το βλέμμα της Εγγλέζας! Ξερή και μονοκόμματη γύριζε αυτή, τη στιγμή που νόμιζε κείνος πως είχε γλιτώσει, τον κεραυνοβολούσε με μια ματιά και τον συμμάζευε, κατσουφιασμένο μα δαμασμένο, στο μπουλούκι των τριών πιο φρόνιμων.
- Είναι κακιά και γρουσούζα... μουρμούριζε ο Αντώνης στις αδελφές του, καμτσικώνοντας τις πέτρες του δρόμου με κανένα μαδημένο από τα φύλλα του χλωρό κλαδί, που πάντα βρίσκουνταν ανάμεσα στους θησαυρούς του Αντώνη, προς μεγάλο θαυμασμό του Αλέξανδρου. Είναι τσίφνα και γρινιάρα...
- Τι είναι; ρωτούσε ο Αλέξανδρος γέρνοντας ολόκληρος εμπρός από τη δασκάλα, που τον βαστούσε σφιχτά από το χέρι, για ν' ακούσει τη λέξη που του ξέφυγε. Μ' αμέσως τον τίναζε πίσω η Εγγλέζα, που δεν καταλάβαινε τα ελληνικά, και τον ξανάφερνε στη θέση του πλάγι της.
- Σπίκ Ίνγκλις! πρόσταζε με το πιο αυστηρό της ύφος!
Και μαζεμένα πάλι, την ακολουθούσαν τα τέσσερα αδέλφια, με ίσιες τις ράχες και σφιγμένα τα χείλια, παρατώντας κάθε αρχισμένη κουβέντα, για να της δείξουν την αποδοκιμασία τους. Κι έτσι, σιωπηλά, έκαναν το γύρο του βράχου, ανέβαιναν στο λόφο, απομακρύνουνταν από τον περαστικό δρόμο. Κι εκεί στη μοναξιά, στις πέτρες και στα ξερά χαμόκλαρα, κάθουνταν όλα τ' αδέλφια στην αράδα, με τα πόδια ενωμένα και τα χέρια σταυρωμένα φρόνιμα μπροστά τους, και κοίταζαν από πάνω, ψηλά, τις βαρκούλες που αρμένιζαν μακριά στο πέλ