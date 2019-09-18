ردين', 'ناريمان', 'نانسي', 'نبال', 'نبراس', 'نبيله', 'نجاة', 'نجاح', 'نجلاء', 'نجوان', 'نجود', 'نجوى', 'نداء', 'ندى', 'ندين', 'نرمين', 'نزميه', 'نسرين', 'نسيمة', 'نعمت', 'نعمه', 'نهاد', 'نهى', 'نهيدة', 'نوال', 'نور', 'نور الهدى', 'نورا', 'نوران', 'نيروز', 'نيفين',
        'هادلين', 'هازار', 'هالة', 'هانيا', 'هايدي', 'هبة', 'هدايه', 'هدى', 'هديل', 'هزار', 'هلا', 'هلين', 'هنا', 'هناء', 'هنادا', 'هنادي', 'هند', 'هيا', 'هيفا', 'هيفاء', 'هيلين',
        'وئام', 'وجدان', 'وداد', 'ورود', 'وسام', 'وسن', 'وسيم', 'وعد', 'وفاء', 'ولاء',
        'ىمنة', 'يارا', 'ياسمين', 'يافا', 'يسرى', 'ينان', 'ﻟﻮﺗﺸﻴﺎ',
    );

    protected static $lastName = array(
        'آلهامي', 'أبو الرب', 'ابو رحمة', 'ابو سعده', 'ابو يوسف', 'ابوالحاج', 'الامام', 'البتراء', 'البلبيسي', 'الترابين', 'التلهوني', 'الجبارات', 'الجرَّاح', 'الجوابره', 'الجوالدة', 'الحجايا', 'الحوراني', 'الدعجة', 'الردايدة', 'الرشدان', 'الرفاعي', 'الروابدة', 'الروسان', 'الريماوي', 'الزعبية', 'الزوربا', 'السحاقات', 'السحيمات', 'السراج', 'السعد', 'السلطية', 'السيوف', 'الشامي', 'الشريدة', 'الشريف', 'الشطناوي', 'الشمالي', 'الصرايرة', 'الصمادي', 'الصنات', 'الضمور', 'الطباع', 'الطراونة', 'الطويسات', 'الطويل', 'العدوان', 'العضيبات', 'العلامي', 'العمري', 'العمرية', 'العناسوة', 'العنانبه', 'الغريب', 'الفاخوري', 'الفاعوري', 'الفناطسة', 'القطيشات', 'الكردي', 'الكركي', 'المبيضين', 'المجالي', 'المحاميد', 'المساعيد', 'المشاهره', 'المصري', 'المعشر', 'المواجدة', 'المومنى', 'المومنية', 'النسور', 'النشاشيبي', 'النعيمات', 'الهلسة', 'الوشاح',
        'بني حسن', 'بني صقر',
        'سحاب',
        'شمر',
        'ضميدات',
        'طلفاح',
        'عابدين', 'عباد', 'عجلون', 'عقلة', 'عناسوة',
        'مطير', 'معاني',
        'وادي',
    );

    protected static $titleMale = array('السيد', 'الأستاذ', 'الدكتور', 'المهندس');
    protected static $titleFemale = array('السيدة', 'الآنسة', 'الدكتورة', 'المهندسة');
    private static $prefix = array('أ.', 'د.', 'أ.د', 'م.');

    /**
     * @example 'أ.'
     */
    public static function prefix()
    {
        return static::randomElement(static::$prefix);
    }
}
                                                                                                                                                                                                                                                                                                     