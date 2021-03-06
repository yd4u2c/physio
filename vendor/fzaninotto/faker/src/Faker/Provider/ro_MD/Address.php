<?php

namespace Faker\Provider\ru_RU;

class Payment extends \Faker\Provider\Payment
{
    /**
     * @see list of Russian banks (2015-04-04), source: http://www.banki.ru/banks/
     * @example "cat *.html | grep 'b-cb-list__name' | iconv --f windows-1251 --t utf-8 | grep -o '>.*<' | \
     * sed -r 's/&mdash;//' | sed -r 's/[\<\>]//g' | sed -r "s/(^|$)/'/g" | sed -r 's/$/,/' | sed -r 's/\&(laquo|raquo);/"/g' | \
     * sed -r 's/\s+/ /g'"
     */
    protected static $banks = array(
        'Новый Промышленный Банк',
        'Новый Символ',
        'Нокссбанк',
        'Ноосфера',
        'Нордеа Банк',
        'Нота-Банк',
        'НС Банк',
        'НСТ-Банк',
        'Нэклис-Банк',
        'Образование',
        'Объединенный Банк Промышленных Инвестиций',
        'Объединенный Банк Республики',
        'Объединенный Капитал',
        'Объединенный Кредитный Банк',
        'Объединенный Кредитный Банк  Московский филиал',
        'Объединенный Национальный Банк',
        'Объединенный Резервный Банк',
        'Океан Банк',
        'ОЛМА-Банк',
        'Онего',
        'Оней Банк',
        'ОПМ-Банк',
        'Оргбанк',
        'Оренбург',
        'ОТП Банк',
        'ОФК Банк',
        'Охабанк',
        'Первобанк',
        'Первомайский',
        'Первоуральскбанк',
        'Первый Дортрансбанк',
        'Первый Инвестиционный банк',
        'Первый Клиентский Банк',
        'Первый Чешско-Российский Банк',
        'Пересвет',
        'Пермь',
        'Петербургский Социальный Коммерческий Банк',
        'Петрокоммерц',
        'ПИР Банк',
        'Платина',
        'Плато-Банк',
        'Плюс Банк',
        'Пойдем!',
        'Почтобанк',
        'Прайм Финанс',
        'Преодоление',
        'Приморье',
        'Примсоцбанк',
        'Примтеркомбанк',
        'Прио-Внешторгбанк',
        'Приобье',
        'Приполярный',
        'Приско Капитал Банк',
        'Пробизнесбанк',
        'Проинвестбанк',
        'Прокоммерцбанк',
        'Проминвестбанк',
        'Промрегионбанк',
        'Промсвязьбанк',
        'Промсвязьинвестбанк',
        'Промсельхозбанк',
        'Промтрансбанк',
        'Промышленно-Финансовое Сотрудничество',
        'Промэнергобанк',
        'Профессионал Банк',
        'Профит Банк',
        'Прохладный',
        'Пульс Столицы',
        'Радиотехбанк',
        'Развитие',
        'Развитие-Столица',
        'Райффайзенбанк',
        'Расчетно-Кредитный Банк',
        'Расчетный Дом',
        'РБА',
        'Региональный Банк Развития',
        'Региональный Банк Сбережений',
        'Региональный Коммерческий Банк',
        'Региональный Кредит',
        'Регионфинансбанк',
        'Регнум',
        'Резерв',
        'Ренессанс',
        'Ренессанс Кредит',
        'Рента-Банк',
        'РЕСО Кредит',
        'Республиканский Кредитный Альянс',
        'Ресурс-Траст',
        'Риабанк',
        'Риал-Кредит',
        'Ринвестбанк',
        'Ринвестбанк Московский офис',
        'РИТ-Банк',
        'РН Банк',
        'Росавтобанк',
        'Росбанк',
        'Росбизнесбанк',
        'Росгосстрах Банк',
        'Росдорбанк',
        'РосЕвроБанк',
        'РосинтерБанк',
        'Роспромбанк',
        'Россельхозбанк',
        'Российская Финансовая Корпорация',
        'Российский Капитал',
        'Российский Кредит',
        'Российский Национальный Коммерческий Банк',
        'Россита-Банк',
        'Россия',
        'Рост Банк',
        'Ростфинанс',
        'Росэксимбанк',
        'Росэнергобанк',
        'Роял Кредит Банк',
        'РСКБ',
        'РТС-Банк',
        'РУБанк',
        'Рублев',
        'Руна-Банк',
        'Рунэтбанк',
        'Рускобанк',
        'Руснарбанк',
        'Русский Банк Сбережений',
        'Русский Ипотечный Банк',
        'Русский Международный Банк',
        'Русский Национальный Банк',
        'Русский Стандарт',
        'Русский Торговый Банк',
        'Русский Трастовый Банк',
        'Русский Финансовый Альянс',
        'Русский Элитарный Банк',
        'Русславбанк',
        'Руссобанк',
        'Русстройбанк',
        'Русфинанс Банк',
        'Русь',
        'РусьРегионБанк',
        'Русьуниверсалбанк',
        'РусЮгбанк',
        'РФИ Банк',
        'Саммит Банк',
        'Санкт-Петербургский Банк Инвестиций',
        'Саратов',
        'Саровбизнесбанк',
        'Сбербанк России',
        'Связной Банк',
        'Связь-Банк',
        'СДМ-Банк',
        'Севастопольский Морской банк',
        'Северный Кредит',
        'Северный Народный Банк',
        'Северо-Восточный Альянс',
        'Северо-Западный 1 Альянс Банк',
        'Северстройбанк',
        'Севзапинвестпромбанк',
        'Сельмашбанк',
        'Сервис-Резерв',
        'Сетелем Банк',
        'СИАБ',
        'Сибирский Банк Реконструкции и Развития',
        'Сибнефтебанк',
        'Сибсоцбанк',
        'Сибэс',
        'Сибэс Московский офис',
        'Синергия',
        'Синко-Банк',
        'Система',
        'Сити Инвест Банк',
        'Ситибанк',
        'СКА-Банк',
        'СКБ-Банк',
        'Славия',
        'Славянбанк',
        'Славянский Кредит',
        'Смартбанк',
        'СМБ-Банк',
        'Смолевич',
        'СМП Банк',
     