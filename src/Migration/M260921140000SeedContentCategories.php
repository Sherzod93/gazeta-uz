<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

/**
 * Seeds 10 demo items per section (news, reportings, articles), spread across
 * all 6 categories, so the "/category/{slug}" pages have something to show.
 */
final class M260921140000SeedContentCategories implements RevertibleMigrationInterface
{
    private const CATEGORY_POLITICS = 1;
    private const CATEGORY_ECONOMY = 2;
    private const CATEGORY_SOCIETY = 3;
    private const CATEGORY_CULTURE = 4;
    private const CATEGORY_WORLD = 5;
    private const CATEGORY_COLUMNS = 6;

    public function up(MigrationBuilder $b): void
    {
        $now = '2026-09-21 09:00:00';

        $news = [
            ['parlament-prinyal-popravki-k-zakonu-o-vyborah', 'Парламент принял поправки к закону о выборах', 'Депутаты одобрили изменения, упрощающие процедуру регистрации кандидатов.', 'Законодательная палата приняла в окончательном чтении поправки к закону о выборах. Изменения упрощают процедуру регистрации кандидатов и сокращают сроки рассмотрения документов.', self::CATEGORY_POLITICS, '2026-09-20 09:00:00'],
            ['centrobank-snizil-bazovuyu-stavku-do-13-protsentov', 'Центробанк снизил базовую ставку до 13%', 'Регулятор объяснил решение замедлением инфляции последних месяцев.', 'Центральный банк снизил базовую ставку на один процентный пункт, до 13% годовых. В пресс-релизе отмечается, что решение принято на фоне устойчивого замедления инфляции.', self::CATEGORY_ECONOMY, '2026-09-19 09:00:00'],
            ['v-tashkente-otkroyut-desyat-novyh-shkol-k-sentyabryu', 'В Ташкенте откроют десять новых школ к сентябрю', 'Строительство ведётся в районах с наибольшим приростом населения.', 'Хокимият Ташкента сообщил о завершении строительства десяти новых школ, которые примут первых учеников в новом учебном году. Объекты возводились в районах с наибольшим приростом населения.', self::CATEGORY_SOCIETY, '2026-09-18 09:00:00'],
            ['natsionalnyy-teatr-predstavit-premeru-baleta', 'Национальный театр представит премьеру балета', 'Постановка готовилась приглашённой труппой более полугода.', 'Национальный театр оперы и балета анонсировал премьеру нового спектакля. Над постановкой более полугода работала приглашённая творческая группа.', self::CATEGORY_CULTURE, '2026-09-17 09:00:00'],
            ['sosednie-strany-dogovorilis-ob-uproshchenii-vizovogo-rezhima', 'Соседние страны договорились об упрощении визового режима', 'Соглашение вступит в силу с начала следующего года.', 'Главы внешнеполитических ведомств двух стран подписали соглашение об упрощении визового режима для деловых поездок. Документ вступит в силу с начала следующего года.', self::CATEGORY_WORLD, '2026-09-16 09:00:00'],
            ['kolonka-pochemu-reformy-buksuyut-na-mestah', 'Колонка: почему реформы буксуют на местах', 'Автор разбирает разрыв между решениями центра и их исполнением на местах.', 'В новой колонке автор разбирает, почему реформы, принятые на уровне правительства, часто буксуют при исполнении на местах, и что можно сделать для сокращения этого разрыва.', self::CATEGORY_COLUMNS, '2026-09-15 09:00:00'],
            ['prezident-podpisal-ukaz-o-tsifrovizatsii-gosuslug', 'Президент подписал указ о цифровизации госуслуг', 'Документ предусматривает перевод трети услуг в онлайн-формат за два года.', 'Подписан указ о дальнейшей цифровизации государственных услуг. Документ предусматривает перевод не менее трети услуг в полностью онлайн-формат в течение двух лет.', self::CATEGORY_POLITICS, '2026-09-14 09:00:00'],
            ['eksport-tekstilya-vyros-na-18-protsentov-za-god', 'Экспорт текстиля вырос на 18% за год', 'Основной прирост обеспечили поставки в страны Персидского залива.', 'По данным статистического комитета, экспорт текстильной продукции вырос на 18% по сравнению с прошлым годом. Основной прирост обеспечили поставки в страны Персидского залива.', self::CATEGORY_ECONOMY, '2026-09-13 09:00:00'],
            ['volontery-vysadili-tysyachu-dereviev-v-parke-pobedy', 'Волонтёры высадили тысячу деревьев в парке Победы', 'Акция собрала несколько сотен участников со всего города.', 'В парке Победы прошла масштабная акция по озеленению: волонтёры высадили более тысячи саженцев. Организаторы отмечают рекордное число участников.', self::CATEGORY_SOCIETY, '2026-09-12 09:00:00'],
            ['mezhdunarodnaya-delegatsiya-posetila-samarkand', 'Международная делегация посетила Самарканд', 'В рамках визита обсуждались туристические и культурные проекты.', 'Делегация из нескольких стран посетила Самарканд в рамках рабочего визита. Стороны обсудили совместные туристические и культурные проекты.', self::CATEGORY_WORLD, '2026-09-11 09:00:00'],
        ];

        foreach ($news as [$slug, $title, $summary, $content, $categoryId, $publishedAt]) {
            $b->insert('news', [
                'title' => $title,
                'slug' => $slug,
                'summary' => $summary,
                'content' => $content,
                'image' => null,
                'published_at' => $publishedAt,
                'category_id' => $categoryId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $reportings = [
            ['reportazh-s-zasedaniya-parlamenta-kak-prinimalsya-byudzhet', 'Репортаж с заседания парламента: как принимался бюджет', 'Корреспондент провёл в зале заседаний весь день голосования.', 'Наш корреспондент провёл в зале заседаний весь день, пока депутаты обсуждали и голосовали за проект бюджета. В репортаже — детали закулисных переговоров и ключевые поправки.', self::CATEGORY_POLITICS, '2026-09-20 12:00:00'],
            ['kak-ustroen-rynok-taksi-v-tashkente-reportazh', 'Как устроен рынок такси в Ташкенте: репортаж', 'Журналист провёл смену вместе с водителем службы такси.', 'Чтобы разобраться, как устроен рынок такси изнутри, журналист провёл смену вместе с одним из водителей. Итог — репортаж о доходах, конкуренции и новых правилах работы.', self::CATEGORY_ECONOMY, '2026-09-19 12:00:00'],
            ['odin-den-v-priemnom-pokoe-reportazh-iz-bolnitsy', 'Один день в приёмном покое: репортаж из больницы', 'Автор провёл смену вместе с врачами приёмного отделения.', 'Автор провёл сутки в приёмном покое одной из крупных больниц города, наблюдая за работой врачей и медсестёр в условиях постоянной нагрузки.', self::CATEGORY_SOCIETY, '2026-09-18 12:00:00'],
            ['za-kulisami-opery-reportazh-s-repetitsii', 'За кулисами оперы: репортаж с репетиции', 'Корреспондент побывал на закрытой репетиции перед премьерой.', 'Корреспондент побывал на закрытой репетиции оперной постановки и поговорил с артистами о том, как готовится премьера.', self::CATEGORY_CULTURE, '2026-09-17 12:00:00'],
            ['reportazh-s-granitsy-kak-rabotaet-novyy-punkt-propuska', 'Репортаж с границы: как работает новый пункт пропуска', 'Журналист прошёл весь путь пересечения границы вместе с пассажирами.', 'Журналист проехал через новый пограничный пункт пропуска вместе с обычными пассажирами, чтобы оценить, насколько ускорилось прохождение контроля.', self::CATEGORY_WORLD, '2026-09-16 12:00:00'],
            ['vzglyad-iznutri-reportazh-iz-redaktsii-kolumnista', 'Взгляд изнутри: репортаж из редакции колумниста', 'Материал показывает, как рождается еженедельная авторская колонка.', 'Материал показывает, как рождается еженедельная авторская колонка — от идеи до финальной правки текста в номер.', self::CATEGORY_COLUMNS, '2026-09-15 12:00:00'],
            ['reportazh-s-mitinga-u-hokimiyata', 'Репортаж с митинга у хокимията', 'Жители собрались, чтобы обсудить план реконструкции квартала.', 'У здания хокимията собрались жители соседних кварталов, чтобы обсудить план реконструкции территории. Наш корреспондент записал основные требования собравшихся.', self::CATEGORY_POLITICS, '2026-09-14 12:00:00'],
            ['na-zavode-kak-sobirayut-avtomobili-v-horezme', 'На заводе: как собирают автомобили в Хорезме', 'Репортаж с производственной линии одного из автозаводов.', 'Репортаж с производственной линии автомобильного завода: как устроен цикл сборки и сколько машин выходит с конвейера за смену.', self::CATEGORY_ECONOMY, '2026-09-13 12:00:00'],
            ['reportazh-iz-shkoly-dlya-detey-s-osobymi-potrebnostyami', 'Репортаж из школы для детей с особыми потребностями', 'Автор провёл день среди учеников и педагогов инклюзивной школы.', 'Автор провёл день в школе, где учатся дети с особыми потребностями, и поговорил с педагогами об организации инклюзивного образования.', self::CATEGORY_SOCIETY, '2026-09-12 12:00:00'],
            ['noch-muzeev-reportazh-s-glavnoy-kulturnoy-ploshchadki', 'Ночь музеев: репортаж с главной культурной площадки', 'Тысячи горожан посетили музеи бесплатно в рамках акции.', 'В городе прошла акция «Ночь музеев»: тысячи горожан бесплатно посетили экспозиции. Наш корреспондент прошёл по самым популярным залам.', self::CATEGORY_CULTURE, '2026-09-11 12:00:00'],
        ];

        foreach ($reportings as [$slug, $title, $summary, $content, $categoryId, $publishedAt]) {
            $b->insert('reportings', [
                'title' => $title,
                'slug' => $slug,
                'summary' => $summary,
                'content' => $content,
                'image' => null,
                'published_at' => $publishedAt,
                'category_id' => $categoryId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $articles = [
            ['pyat-grafikov-o-sostoyanii-bankovskogo-sektora', 'Пять графиков о состоянии банковского сектора', 'Разбираем ключевые показатели банков за последний год.', 'Мы собрали пять графиков, которые показывают, как менялись основные показатели банковского сектора за последний год: кредитование, депозиты и просроченная задолженность.', self::CATEGORY_ECONOMY, '2026-09-20 15:00:00'],
            ['chto-izmenit-novaya-redaktsiya-konstitutsii', 'Что изменит новая редакция конституции', 'Разбор ключевых поправок и их практических последствий.', 'Разбираем ключевые поправки к конституции и объясняем, как они могут повлиять на работу государственных органов и права граждан.', self::CATEGORY_POLITICS, '2026-09-19 15:00:00'],
            ['demografiya-uzbekistana-trendy-sleduyushchego-desyatiletiya', 'Демография Узбекистана: тренды следующего десятилетия', 'Аналитики прогнозируют изменение возрастной структуры населения.', 'Аналитики изучили демографические тренды и спрогнозировали, как изменится возрастная структура населения в ближайшее десятилетие.', self::CATEGORY_SOCIETY, '2026-09-18 15:00:00'],
            ['kak-menyaetsya-sovremennoe-uzbekskoe-kino', 'Как меняется современное узбекское кино', 'Обзор новых имён и тенденций в национальном кинематографе.', 'Обзор новых имён и тенденций в национальном кинематографе: от независимых режиссёров до крупных студийных проектов.', self::CATEGORY_CULTURE, '2026-09-17 15:00:00'],
            ['geopolitika-tsentralnoy-azii-glavnye-trendy', 'Геополитика Центральной Азии: главные тренды', 'Эксперты объясняют, как меняется баланс интересов в регионе.', 'Эксперты объясняют, как меняется баланс интересов крупных игроков в Центральной Азии и что это значит для региона.', self::CATEGORY_WORLD, '2026-09-16 15:00:00'],
            ['kolonka-pochemu-vazhno-investirovat-v-obrazovanie', 'Колонка: почему важно инвестировать в образование', 'Автор аргументирует, почему расходы на школы окупаются в долгую.', 'В авторской колонке разбирается, почему инвестиции в школьное образование окупаются в долгосрочной перспективе сильнее, чем многие другие статьи расходов.', self::CATEGORY_COLUMNS, '2026-09-15 15:00:00'],
            ['analiz-mestnoe-samoupravlenie-posle-reformy', 'Анализ: местное самоуправление после реформы', 'Что изменилось в полномочиях местных органов власти.', 'Анализируем, что изменилось в полномочиях местных органов власти после недавней реформы, и как это отразилось на скорости решения бытовых вопросов.', self::CATEGORY_POLITICS, '2026-09-14 15:00:00'],
            ['inflyatsiya-i-realnye-dohody-chto-govoryat-tsifry', 'Инфляция и реальные доходы: что говорят цифры', 'Сопоставляем официальную статистику с ощущениями населения.', 'Сопоставляем официальную статистику по инфляции с реальными доходами населения и объясняем, почему цифры иногда расходятся с ощущениями.', self::CATEGORY_ECONOMY, '2026-09-13 15:00:00'],
            ['urbanizatsiya-tashkenta-vyzovy-i-vozmozhnosti', 'Урбанизация Ташкента: вызовы и возможности', 'Город растёт быстрее, чем успевает развиваться инфраструктура.', 'Ташкент растёт быстрее, чем успевает развиваться инфраструктура. Разбираем, какие решения предлагают urbanists для устойчивого роста города.', self::CATEGORY_SOCIETY, '2026-09-12 15:00:00'],
            ['torgovye-puti-regiona-analiz-logistiki', 'Торговые пути региона: анализ логистики', 'Как новые маршруты меняют торговые потоки Центральной Азии.', 'Анализируем, как новые транспортные коридоры меняют торговые потоки региона и какие страны выигрывают от этих изменений больше других.', self::CATEGORY_WORLD, '2026-09-11 15:00:00'],
        ];

        foreach ($articles as [$slug, $title, $summary, $content, $categoryId, $publishedAt]) {
            $b->insert('articles', [
                'title' => $title,
                'slug' => $slug,
                'summary' => $summary,
                'content' => $content,
                'image' => null,
                'published_at' => $publishedAt,
                'category_id' => $categoryId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(MigrationBuilder $b): void
    {
        $slugs = [
            'news' => [
                'parlament-prinyal-popravki-k-zakonu-o-vyborah',
                'centrobank-snizil-bazovuyu-stavku-do-13-protsentov',
                'v-tashkente-otkroyut-desyat-novyh-shkol-k-sentyabryu',
                'natsionalnyy-teatr-predstavit-premeru-baleta',
                'sosednie-strany-dogovorilis-ob-uproshchenii-vizovogo-rezhima',
                'kolonka-pochemu-reformy-buksuyut-na-mestah',
                'prezident-podpisal-ukaz-o-tsifrovizatsii-gosuslug',
                'eksport-tekstilya-vyros-na-18-protsentov-za-god',
                'volontery-vysadili-tysyachu-dereviev-v-parke-pobedy',
                'mezhdunarodnaya-delegatsiya-posetila-samarkand',
            ],
            'reportings' => [
                'reportazh-s-zasedaniya-parlamenta-kak-prinimalsya-byudzhet',
                'kak-ustroen-rynok-taksi-v-tashkente-reportazh',
                'odin-den-v-priemnom-pokoe-reportazh-iz-bolnitsy',
                'za-kulisami-opery-reportazh-s-repetitsii',
                'reportazh-s-granitsy-kak-rabotaet-novyy-punkt-propuska',
                'vzglyad-iznutri-reportazh-iz-redaktsii-kolumnista',
                'reportazh-s-mitinga-u-hokimiyata',
                'na-zavode-kak-sobirayut-avtomobili-v-horezme',
                'reportazh-iz-shkoly-dlya-detey-s-osobymi-potrebnostyami',
                'noch-muzeev-reportazh-s-glavnoy-kulturnoy-ploshchadki',
            ],
            'articles' => [
                'pyat-grafikov-o-sostoyanii-bankovskogo-sektora',
                'chto-izmenit-novaya-redaktsiya-konstitutsii',
                'demografiya-uzbekistana-trendy-sleduyushchego-desyatiletiya',
                'kak-menyaetsya-sovremennoe-uzbekskoe-kino',
                'geopolitika-tsentralnoy-azii-glavnye-trendy',
                'kolonka-pochemu-vazhno-investirovat-v-obrazovanie',
                'analiz-mestnoe-samoupravlenie-posle-reformy',
                'inflyatsiya-i-realnye-dohody-chto-govoryat-tsifry',
                'urbanizatsiya-tashkenta-vyzovy-i-vozmozhnosti',
                'torgovye-puti-regiona-analiz-logistiki',
            ],
        ];

        foreach ($slugs as $table => $tableSlugs) {
            $b->delete($table, ['slug' => $tableSlugs]);
        }
    }
}
