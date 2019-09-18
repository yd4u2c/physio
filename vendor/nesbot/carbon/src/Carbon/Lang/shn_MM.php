sFunction) {
            return $processHoursFunction($date, '[Вчора ');
        },
        'lastWeek' => function (\Carbon\CarbonInterface $date) use ($processHoursFunction) {
            switch ($date->dayOfWeek) {
                case 0:
                case 3:
                case 5:
                case 6:
                    return $processHoursFunction($date, '[Минулої] dddd [');
                default:
                    return $processHoursFunction($date, '[Минулого] dddd [');
            }
        },
        'sameElse' => 'L',
    ],
    'ordinal' => function ($number, $period) {
        switch ($period) {
            case 'M':
            case 'd':
            case 'DDD':
            case 'w':
            case 'W':
                return $number.'-й';
            case 'D':
                return $number.'-го';
            default:
                return $number;
        }
    },
    'meridiem' => function ($hour) {
        if ($hour < 4) {
            return 'ночі';
        }
        if ($hour < 12) {
            return 'ранку';
        }
        if ($hour < 17) {
            return 'дня';
        }

        return 'вечора';
    },
    'months' => ['січня', 'лютого', 'березня', 'квітня', 'травня', 'червня', 'липня', 'серпня', 'вересня', 'жовтня', 'листопада', 'грудня'],
    'months_standalone' => ['січень', 'лютий', 'березень', 'квітень', 'травень', 'червень', 'липень', 'серпень', 'вересень', 'жовтень', 'листопад', 'грудень'],
    'months_short' => ['січ', 'лют', 'бер', 'кві', 'тра', 'чер', 'лип', 'сер', 'вер', 'жов', 'лис', 'гру'],
    'months_regexp' => '/D[oD]?(\[[^\[\]]*\]|\s)+MMMM?/',
    'weekdays' => function (\Carbon\CarbonInterface $date, $format, $index) {
        static $words = [
            'nominative' => ['неділя', 'понеділок', 'вівторок', 'середа', 'четвер', 'п’ятниця', 'субота'],
            'accusative' => ['неділю', 'понеділок', 'вівторок', 'середу', 'четвер', 'п’ятницю', 'суботу'],
            'genitive' => ['неділі', 'понеділка', 'вівторка', 'середи', 'четверга', 'п’ятниці', 'суботи'],
        ];

        $nounCase = preg_match('/(\[(В|в|У|у)\])\s+dddd/', $format) ?
            'accusative' :
            (preg_match('/\[?(?:минулої|наступної)?\s*\]\s+dddd/', $format) ?
                'genitive' :
                'nominative'
            );

        return $words[$nounCase][$index] ?? null;
    },
    'weekdays_short' => ['нд', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'],
    'weekdays_min' => ['нд', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'],
    'first_day_of_week' => 1,
    'day_of_first_week_of_year' => 1,
    'list' => [', ', ' i '],
];
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  