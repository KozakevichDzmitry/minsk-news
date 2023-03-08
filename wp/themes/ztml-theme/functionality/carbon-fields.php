<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

require_once(FUNC_PATH . 'getWpadcenterPostData.php');

function addcontainer_adv_for_post($post_type, $locations)
{
    $fields = array(
        Field::make('checkbox', 'crb_adfox_disable', __('Отключить рекламу')),
        Field::make('checkbox', 'crb_adfox_origin', __('Использовать уникальную рекламу для этого поста')),
        Field::make('html', 'crb_adfox_header-adv')
            ->set_html('<h2>Вставьте HTML-код рекламного блока Adfox или шорткод и установите галочку \'Использовать шорткод\'</h2>')
            ->set_conditional_logic(array(
                'relation' => 'AND',
                array(
                    'field' => 'crb_adfox_disable',
                    'value' => false,
                ),
                array(
                    'field' => 'crb_adfox_origin',
                    'value' => true,
                )
            )),
    );
    foreach ($locations as $location) {
        $label = '';
        if ($location == 'background') {
            $label = 'Код брендированной рекламы';
            $fields[] = Field::make('textarea', 'crb_adf_banner_' . $location, __($label))
                ->set_conditional_logic(array(
                    'relation' => 'AND',
                    array(
                        'field' => 'crb_adfox_disable',
                        'value' => false,
                    ),
                    array(
                        'field' => 'crb_adfox_origin',
                        'value' => true,
                    )
                ));
            $fields[] = Field::make('checkbox', 'crb_banners_' . $location . '_shortcode', __('Использовать шорткод'))
                ->set_conditional_logic(array(
                    'relation' => 'AND',
                    array(
                        'field' => 'crb_adfox_disable',
                        'value' => false,
                    ),
                    array(
                        'field' => 'crb_adfox_origin',
                        'value' => true,
                    )
                ));
            continue;
        } else if ($location == 'main') $label = 'Код баннера до основного контента';
        else  $label = 'Код баннера до ' . $location;

        $fields[] = Field::make('textarea', 'crb_adf_banner_before_' . $location, __($label))
            ->set_conditional_logic(array(
                'relation' => 'AND',
                array(
                    'field' => 'crb_adfox_disable',
                    'value' => false,
                ),
                array(
                    'field' => 'crb_adfox_origin',
                    'value' => true,
                )
            ));
        $fields[] = Field::make('checkbox', 'crb_banner_before_' . $location . '_shortcode', __('Использовать шорткод'))
            ->set_conditional_logic(array(
                'relation' => 'AND',
                array(
                    'field' => 'crb_adfox_disable',
                    'value' => false,
                ),
                array(
                    'field' => 'crb_adfox_origin',
                    'value' => true,
                )
            ));
    }

    $container = Container::make('post_meta', 'Добавление рекламы')
        ->show_on_post_type($post_type)
        ->add_fields($fields);

    return $container;
}

function add_tab_generic_adv($container, $name, $locations)
{
    $fields = array();
    foreach ($locations as $location) {
        if ($location == 'background') {
            $label = 'Код брендированной рекламы';
            $fields[] = Field::make('textarea', 'crb_adf_' . $name . '_banner_' . $location, __($label));
            $fields[] = Field::make('checkbox', 'crb_' . $name . '_banners_' . $location . '_shortcode', __('Использовать шорткод'));
        } else if ($location == 'main') {
            $label = 'Код баннера до основного контента';
            $fields[] = Field::make('textarea', 'crb_adf_' . $name . '_banner_before_' . $location, __($label));
            $fields[] = Field::make('checkbox', 'crb_' . $name . '_banners_before_' . $location . '_shortcode', __('Использовать шорткод'));
        } else {
            $label = 'Код баннера до ' . $location;
            $fields[] = Field::make('textarea', 'crb_adf_' . $name . '_banner_before_' . $location, __($label));
            $fields[] = Field::make('checkbox', 'crb_' . $name . '_banners_before_' . $location . '_shortcode', __('Использовать шорткод'));
        }
    }
    $container->add_tab('Общая реклама для всех постов данного типа', $fields);
}

function add_tab_adv($container, $arr, $type, $supplements = array())
{
    foreach ($arr as $item) {
        if ($type == 'post_type') {
            $id = $item->ID;
            $name = $item->post_title;
        } elseif ($type == 'taxonomy') {
            $id = $item->term_id;
            $name = $item->name;
        } else {
            return;
        }

        $fields = array(
            Field::make('textarea', 'crb_adf_' . $id . '_banner_background', __('Код брендированной рекламы')),
            Field::make('checkbox', 'crb_' . $id . '_banners_background_shortcode', __('Использовать шорткод')),

        );
        foreach ($supplements as $supplement) {
            $fields[] = Field::make('textarea', 'crb_adf_' . $id . '_banner_before_' . $supplement, __('Код баннера до ' . $supplement));
            $fields[] = Field::make('checkbox', 'crb_' . $id . '_banners_before_' . $supplement . '_shortcode', __('Использовать шорткод'));
        }
        $container->add_tab($name, $fields);
    }
}

function crb_attach_theme_options()
{
    Container::make('post_meta', 'PDF')
        ->where('post_type', '=', 'newspaper')
        ->add_fields(
            array(
                Field::make('file', 'crb_pdf_attachment', 'PDF файл')
            )
        );

    Container::make('post_meta', 'Файл программы')
        ->where('post_template', '=', 'tv-programme.php')
        ->add_fields(
            array(
                Field::make('file', 'crb_tv_programms', 'Архив програм (zip)')->set_width(100)
            )
        );

    Container::make('term_meta', __('Term Options', 'crb'))
        ->where('term_taxonomy', '=', 'newspapers')
        ->add_fields(array(
            Field::make('text', 'crb_newspapers_taxonomy_show_count', 'Показывать шт.')
                ->set_attribute('min', '0'),
            Field::make('text', 'crb_newspapers_taxonomy_load_count', 'Загружать шт.')
                ->set_attribute('min', '1'),
        ));

    Container::make('term_meta', __('Term Options', 'crb'))
        ->where('term_taxonomy', '=', 'news-list')
        ->add_fields(array(
            Field::make('checkbox', 'crb_taxonomy_news-list_attachment', 'Закрепить категорию')
                ->set_option_value('true')
        ));

    addcontainer_adv_for_post('satm', array('background', 'main', 'most_read_news', 'top_three_news', 'vminsk', 'zhurnal-kacheli', 'mk'));
    addcontainer_adv_for_post('cae', array('background', 'main', 'vminsk', 'zhurnal-kacheli', 'mk'));
    addcontainer_adv_for_post('aaq', array('background', 'main', 'vminsk', 'zhurnal-kacheli', 'mk'));
    addcontainer_adv_for_post('meri', array('background', 'main', 'vminsk', 'zhurnal-kacheli', 'mk'));
    addcontainer_adv_for_post('authors-column', array('background', 'main', 'most_read_news', 'top_three_news', 'vminsk', 'zhurnal-kacheli', 'mk'));
    addcontainer_adv_for_post('video', array('background', 'main', 'vminsk', 'zhurnal-kacheli', 'mk'));
    addcontainer_adv_for_post('news', array('background', 'main', 'most_read_news',));
    addcontainer_adv_for_post('see', array('background', 'main', 'vminsk', 'zhurnal-kacheli', 'mk'));


    $adv_options_container = Container::make('theme_options', __('Реклама'))
        ->add_fields(array(
            Field::make('html', 'crb_adfox_header-adv')
                ->set_html('<p>Во вкладках ниже можно вставить HTML код или шорткод рекламы для отдельных архивных страниц (страниц категорий) или для всех постов относящихся к одной рубрике. Если рекламный блок вставлен в отдельном посте, общая реклама не будет отображаться, а отобразиться реклама в из данного поста.</p>')
        ));

    $adv_page_container = Container::make('theme_options', __('Страницы'))
        ->set_page_parent($adv_options_container);
    add_tab_adv($adv_page_container, get_pages([
        'post_type' => 'page',
        'post_status' => 'publish',
        'exclude' => '8',
        'posts_per_page' => -1
    ]), 'post_type', array('main', 'most_read_news', 'top_three_news', 'vminsk', 'zhurnal-kacheli', 'mk'));
    wp_reset_postdata();

    $adv_newspapers_container = Container::make('theme_options', __('Издательства'))
        ->set_page_parent($adv_options_container);
    add_tab_adv($adv_newspapers_container, get_categories([
        'taxonomy' => 'newspapers',
        'type' => 'newspaper',
        'posts_per_page' => -1
    ]), 'taxonomy', array('main', 'most_read_news', 'top_three_news', 'vminsk', 'zhurnal-kacheli', 'mk'));
    wp_reset_postdata();

    $adv_district_container = Container::make('theme_options', __('Районы'))
        ->set_page_parent($adv_options_container);
    add_tab_adv($adv_district_container, get_posts([
        'post_type' => 'district',
        'post_status' => 'publish',
        'posts_per_page' => -1
    ]), 'post_type', array('main', 'most_read_news', 'top_three_news', 'vminsk', 'zhurnal-kacheli', 'mk', 'society_news', 'urban_economy_news', 'economy_news'));
    wp_reset_postdata();

    $adv_my_container = Container::make('theme_options', __('Cледствие'))
        ->set_page_parent($adv_options_container);
    add_tab_generic_adv($adv_my_container, 'cae', array('background', 'main', 'vminsk', 'zhurnal-kacheli', 'mk'));

//	$adv_aaq_container = Container::make('theme_options', __('Обращения'))
//		->set_page_parent($adv_options_container);
//	add_tab_generic_adv($adv_aaq_container, 'aaq', array('background', 'main', 'vminsk', 'zhurnal-kacheli', 'mk'));

    $adv_meri_container = Container::make('theme_options', __('Примите меры'))
        ->set_page_parent($adv_options_container);
    add_tab_generic_adv($adv_meri_container, 'meri', array('background','main', 'vminsk', 'zhurnal-kacheli', 'mk'));


    $adv_authors_column_container = Container::make('theme_options', __('Авторская колонка'))
        ->set_page_parent($adv_options_container);
    add_tab_generic_adv($adv_authors_column_container, 'authors-column', array('background', 'main', 'most_read_news', 'top_three_news', 'vminsk', 'zhurnal-kacheli', 'mk'));

    $adv_video_container = Container::make('theme_options', __('Видео'))
        ->set_page_parent($adv_options_container);
    add_tab_generic_adv($adv_video_container, 'video', array('background','main', 'vminsk', 'zhurnal-kacheli', 'mk'));
    add_tab_adv($adv_video_container, get_categories([
        'taxonomy' => 'videos',
        'type' => 'video',
        'posts_per_page' => -1
    ]), 'taxonomy', array('main', 'vminsk', 'zhurnal-kacheli', 'mk'));
    wp_reset_postdata();

    $adv_news_container = Container::make('theme_options', __('Новости'))
        ->set_page_parent($adv_options_container);
    add_tab_generic_adv($adv_news_container, 'news', array('background','main', 'top_three_news'));
    add_tab_adv($adv_news_container, get_categories([
        'taxonomy' => 'news-list',
        'type' => 'news',
        'posts_per_page' => -1
    ]), 'taxonomy', array('main', 'most_read_news', 'top_three_news', 'vminsk', 'zhurnal-kacheli', 'mk'));
    add_tab_adv($adv_news_container, get_categories([
        'taxonomy' => 'news-district',
        'type' => 'news',
        'posts_per_page' => -1
    ]), 'taxonomy', array('main', 'most_read_news', 'top_three_news', 'vminsk', 'zhurnal-kacheli', 'mk'));
    wp_reset_postdata();


    Container::make('post_meta', __('Руководители', 'crb'))
        ->where('post_template', '=', 'management.php')
        ->add_fields(
            array(
                Field::make('complex', 'crb_manager_description', 'Руководитель')
                    ->add_fields(
                        array(
                            Field::make('image', 'manager_photo', 'Фото')->set_value_type('url'),
                            Field::make('text', 'manager_name', 'Фио'),
                            Field::make('text', 'manager_role', 'Должность'),
                            Field::make('rich_text', 'manager_bio', 'Биография'),
                            Field::make('rich_text', 'manager_reception', 'Время приёма'),
                        )
                    )
            )
        );

    Container::make('post_meta', __('Текст после руководителей', 'crb'))
        ->where('post_type', '=', 'page')
        ->where('post_template', '=', 'management.php')
        ->add_fields(
            array(
                Field::make('rich_text', 'crb_managet_last_block', 'Текст')
            )
        );

    Container::make('post_meta', __('Текст после заголовка', 'crb'))
        ->where('post_type', '=', 'page')
        ->where('post_template', '=', 'printing.php')
        ->add_fields(
            array(
                Field::make('rich_text', 'crb_title', 'Текст')
            )
        );

    Container::make('post_meta', __('Полный список услуг', 'crb'))
        ->where('post_template', '=', 'printing.php')
        ->add_fields(
            array(
                Field::make('text', 'crb_services_caption', 'Заголовок'),
                Field::make('complex', 'crb_printing_services', 'Услуги')
                    ->add_fields(
                        array(
                            Field::make('text', 'crb_service', 'Название услуги'),
                        )
                    )
            )
        );

    Container::make('post_meta', __('Контакты:', 'crb'))
        ->where('post_template', '=', 'printing.php')
        ->add_fields(
            array(
                Field::make('text', 'crb_contacts_caption', 'Заголовок'),
                Field::make('complex', 'crb_contacts', 'Контакты')
                    ->add_fields(
                        array(
                            Field::make('text', 'crb_contact', 'Контакт'),
                            Field::make('text', 'crb_link', 'Ссылка'),
                        )
                    )
            )
        );

    Container::make('post_meta', 'Галерея')
        ->where('post_type', '=', 'district')
        ->add_fields(
            array(
                Field::make('media_gallery', 'crb_district_gallery_iamges', 'Изображения')
                    ->set_type(array('image'))
            )
        );

    Container::make('post_meta', 'Ссылка на сайт администрации')
        ->where('post_type', '=', 'district')
        ->add_fields(
            array(
                Field::make('text', 'crb_gov_link_text', 'Текст'),
                Field::make('text', 'crb_gov_link_url', 'Ссылка'),
            )
        );

    Container::make('post_meta', __('Форма обращения:', 'crb'))
        ->where('post_template', '=', 'appeal.php')
        ->add_fields(
            array(
                Field::make('text', 'crb_apeal_form', 'Шорткод формы'),
            )
        );

    Container::make('post_meta', __('Радио-Минск:'))
        ->where('post_template', '=', 'radio-minsk.php')
        ->add_fields(
            array(
                Field::make('text', 'program_title', 'Заголовок списка программ'),
                Field::make('complex', 'contacts', 'Контакты')->add_fields(array(
                    Field::make('text', 'title', 'Заголовок'),
                    Field::make('rich_text', 'content', 'Описание')
                ))->set_width(50),
                Field::make('complex', 'socials', 'Соцсети')->add_fields(array(
                    Field::make('image', 'icon', 'Иконка'),
                    Field::make('text', 'link', 'Ссылка'),
                )),
                Field::make('text', 'search_sound_title', 'Заголовок поиска песен'),
                Field::make('rich_text', 'search_sound_content', 'Описание поиска песен')
            )
        );

    Container::make('post_meta', __('Программы:'))
        ->where('post_type', '=', 'programs')
        ->add_fields(
            array(
                Field::make('text', 'subtitle', 'Подзаголовок')
            )
        );

    Container::make('post_meta', __('Команда:'))
        ->where('post_template', '=', 'radio-minsk.php')
        ->add_fields(
            array(
                Field::make('complex', 'crb_radio_minsk_team', '')
                    ->add_fields(
                        array(
                            Field::make('image', 'crb_radio_minsk_member_photo', 'Фото')->set_value_type('url'),
                            Field::make('text', 'crb_radio_minsk_member_fio', 'Фио'),
                            Field::make('rich_text', 'crb_radio_minsk_member_short', 'Краткое описание'),
                        )
                    )
            )
        );

    Container::make('post_meta', 'Видео')
        ->where('post_type', '=', 'satm')
        ->add_fields(
            array(
                Field::make('text', 'crb_youtube_code', 'Код с видео'),
                Field::make('media_gallery', 'crb_simple_video', 'Файл видео')
                    ->set_type(array('video'))
            )
        );

    Container::make('post_meta', 'Запись подкста')
        ->where('post_type', '=', 'cae')
        ->add_fields(
            array(
                Field::make('media_gallery', 'crb_podcast_file', 'Файл записи подкаста')
                    ->set_type(array('audio'))
            )
        );

    Container::make('post_meta', 'Запись подкаста')
        ->where('post_type', '=', 'aaq')
        ->add_fields(
            array(
                Field::make('text', 'crb_youtube_code_aqq', 'Код с видео'),
                Field::make('media_gallery', 'crb_aqq_video', 'Файл видео')
                    ->set_type(array('video'))
            )
        );
    Container::make('post_meta', 'О нас')
        ->show_on_page('ob-agentstve')
        ->add_fields(
            array(
                Field::make('complex', 'numbers', '')->add_fields(array(
                    Field::make('image', 'image', 'Изображение'),
                    Field::make('text', 'title', 'Заголовок'),
                    Field::make('text', 'text', 'Текст'),
                )),
                Field::make('rich_text', 'content2', ''),
                Field::make('complex', 'about_socials', 'Соцсети')->add_fields(array(
                    Field::make('image', 'icon', 'Иконка'),
                    Field::make('text', 'link', 'Ссылка')
                )),
                Field::make('rich_text', 'content3', ''),
                Field::make('complex', 'cities', '')->add_fields(array(
                    Field::make('text', 'title', 'Название города'),
                    Field::make('text', 'text', 'Число'),
                )),
                Field::make('complex', 'numbers2', '')->add_fields(array(
                    Field::make('image', 'image', 'Изображение'),
                    Field::make('text', 'title', 'Заголовок'),
                    Field::make('rich_text', 'text', 'Текст'),
                )),
                Field::make('rich_text', 'content4', ''),
            )
        );

    Container::make('post_meta', 'Насткройки новости')
        ->where('post_type', '=', 'news')
        ->add_fields(
            array(
                Field::make('checkbox', 'news_is_advertising', 'Реклама?')
                    ->set_option_value('yes')->set_default_value('no'),
                Field::make('text', 'news_text_advertising', 'Подпись')
                    ->set_conditional_logic(array(
                        'relation' => 'AND',
                        array(
                            'field' => 'news_is_advertising',
                            'value' => true,
                        ),
                    ))
                    ->set_default_value('На правах рекламы'),
            )
        );
    Container::make('post_meta', 'Насткройки закрепления')
        ->where('post_type', '=', 'news')
        ->add_fields(
            array(
                Field::make('checkbox', 'news_is_attached', 'Закрепленная?')
                    ->set_option_value('yes')->set_default_value('no'),
                Field::make('checkbox', 'news_is_attached_status', 'Текущее состояние(тех. поле)')
                    ->set_default_value('no')->set_option_value('yes'),
                Field::make('date_time', 'news_is_attached_time_from', 'Закрепить с:')
                    ->set_picker_options(array(
                        'time_24hr' => true,
                    )),
                Field::make('date_time', 'news_is_attached_time_to', 'Держать закрепленной до:')
                    ->set_picker_options(array(
                        'time_24hr' => true,
                    ))
            )
        );

    Container::make('post_meta', 'Место размещения рекламных блоков')
        ->where('post_template', '=', 'index-page.php')
        ->add_fields(
            array(
                Field::make("select", "crb_adv_block", 'Реклама до блока "Главное"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block1", 'Реклама после блока "Новости"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block2", 'Реклама после блока "Ваш район"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block3", 'Реклама после блока "Самое читаемое"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block4", 'Реклама после блока "Общество"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block5", 'Реклама после блока "Смотрите"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block6", 'Реклама после блока "Городское хозяйство"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block7", 'Реклама после блока "Экономика"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block8", 'Реклама после блока "Культура"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block9", 'Реклама после блока "Спорт"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block10", 'Реклама после блока "Происшествия"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block11", 'Реклама после блока "Новости мира"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block12", 'Реклама после блока "Палитра дня"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block13", 'Реклама после блока "Авторская колонка"')
                    ->add_options('getWpadcenterPostData'),
                Field::make("select", "crb_adv_block14", 'Реклама после блока "Газеты"')
                    ->add_options('getWpadcenterPostData')
            )
        );

    Container::make('post_meta', 'Закрепленные авторы на главной')
        ->where('post_template', '=', 'authors-column.php')
        ->add_fields(
            array(
                Field::make('association', 'authors_column_sticked_authors')
                    ->set_types(
                        array(
                            array(
                                'type' => 'user',
                            ),
                        )
                    )
            )
        );

    Container::make('post_meta', 'Превью')
        ->where('post_type', '=', 'video')
        ->add_fields(
            array(
                Field::make('media_gallery', 'video_post_type_eternal_video', 'Встроенное видео')
                    ->set_type(array('video')),
                Field::make('text', 'video_post_type_youtube-link', 'Код Iframe из YouTube'),
                Field::make('complex', 'video_post_list', 'Видео')
                    ->add_fields(array(
                        Field::make('media_gallery', 'video_post_type_eternal_video_item', 'Встроенное видео')
                            ->set_type(array('video')),
                        Field::make('text', 'video_post_type_youtube-link_item', 'Код Iframe из YouTube'),
                    ))->set_layout('tabbed-horizontal')
            )
        );
    Container::make('post_meta', 'Анонс')
        ->where('post_type', '=', 'video')
        ->add_fields(
            array(
                Field::make('text', 'video_post_type_announce_label', 'Подпись анонса'),
            )
        );

    Container::make('post_meta', 'Блок "Контакты"')
        ->where('post_template', '=', 'page-about.php')
        ->add_fields(
            array(
                Field::make('text', 'page_about_contacts_title', 'Заголовок'),
                Field::make('rich_text', 'page_about_contacts_content', 'Контент'),
            )
        );

    Container::make('post_meta', 'Блок "Руководство УП «Агентство «Минск-Новости»"')
        ->where('post_template', '=', 'page-about.php')
        ->add_fields(
            array(
                Field::make('text', 'page_about_managment_title', 'Заголовок'),
                Field::make('rich_text', 'page_about_managment_content', 'Контент'),
            )
        );

    Container::make('post_meta', 'Блок "Печатные сми"')
        ->where('post_template', '=', 'page-about.php')
        ->add_fields(array(
            Field::make('text', 'page_about_psmi_title', 'Заголовок'),
            Field::make('complex', 'page_about_psmi_cards', 'СМИ')->add_fields(array(
                Field::make('text', 'page_about_psmi_card_title', 'Заголовок'),
                Field::make('rich_text', 'page_about_psmi_card_text', 'Контент')
            ))->set_layout('tabbed-horizontal')
        ));

    Container::make('post_meta', 'Блок "Информационное агентство «Минск новости»"')
        ->where('post_template', '=', 'page-about.php')
        ->add_fields(
            array(
                Field::make('text', 'page_about_info_title', 'Заголовок блока'),
                Field::make('rich_text', 'page_about_info_text', 'Описание'),
                Field::make('complex', 'page_about_info_cards', 'Карточки')->add_fields(array(
                    Field::make('text', 'page_about_info_card_image', 'Картинка'),
                    Field::make('text', 'page_about_info_card_numbers', 'Кол-во'),
                    Field::make('rich_text', 'page_about_info_card_text', 'Описание'),
                ))->set_layout('tabbed-horizontal'),
            )
        );

    Container::make('post_meta', 'Блок "Структура медихолдинга"')
        ->where('post_template', '=', 'page-about.php')
        ->add_fields(
            array(
                Field::make('text', 'page_about_struct_title', 'Заголовок блока'),
                Field::make('complex', 'page_about_struct_images', 'Логоотипы')->add_fields(array(
                    Field::make('image', 'page_about_struct_single_image', 'Изображение')->set_value_type('url'),
                ))->set_layout('tabbed-horizontal'),
            )
        );

    Container::make('post_meta', 'Прейскурант')
        ->where('post_template', '=', 'page-advertisement.php')
        ->add_fields(
            array(
                Field::make('complex', 'page_advertisement_block', 'Аккардион')->add_fields(array(
                    Field::make('text', 'page_advertisement_block_title', 'Заголовок'),
                    Field::make('rich_text', 'page_advertisement_block_content', 'Контент')
                ))->set_layout('tabbed-horizontal')
            )
        );

    Container::make('post_meta', 'Настройки скрытия блоков')
        ->where('post_template', '=', 'ask-a-question.php')
        ->add_fields(
            array(
                Field::make('checkbox', 'crb_aaq_show_description', 'Скрыть описание')->set_option_value("true"),
                Field::make('checkbox', 'crb_aaq_show_appeals', 'Скрыть обращения')->set_option_value("true"),
                Field::make('checkbox', 'crb_aaq_show_ethers', 'Скрыть эфиры')->set_option_value("true"),
            )
        );

    Container::make('post_meta', 'Свойства публикации')
        ->show_on_post_type(
            array(
                'news', 'video', 'authors-column', 'meri', 'cae', 'newspaper', 'aaq'
            )
        )
        ->add_fields(
            array(
                Field::make('checkbox', 'layf_exclude_from_feed', 'Не добавлять эту публикацию в RSS Mail.ru ленту')
                    ->set_option_value('true')
                    ->set_help_text('Отметьте данный флажок, если эта статья не должна попадать в ленту RSS Mail.ru (рекламный материал).'),
                Field::make('checkbox', 'mail_ru_breaking', 'Срочная новость Mail.ru')
                    ->set_option_value('true'),
                Field::make('checkbox', 'mail_ru_exclusive', 'Эксклюзивная новость Mail.ru')
                    ->set_option_value('true')
            )
        );

    Container::make('post_meta', 'Наличие контента')
        ->show_on_post_type(
            array(
                'news', 'video', 'authors-column', 'meri', 'cae', 'newspaper', 'aaq'
            )
        )
        ->add_fields(
            array(
                Field::make('checkbox', 'crb_post_extist_content_photo', 'Изображения')->set_option_value("true"),
                Field::make('checkbox', 'crb_post_extist_content_video', 'Видео')->set_option_value("true"),
                Field::make('checkbox', 'crb_post_extist_content_places', 'Гео')->set_option_value("true"),
            )
        );
}

function events_carbon()
{
    $elemets_labels = array(
        'plural_name' => 'Элементы', //entries
        'singular_name' => 'Элемент', //entry
    );

    Container::make('post_meta', 'Мероприятия')
        ->where('post_type', '=', 'event')
        ->add_fields(array(
            Field::make('complex', 'crb_event', 'Мероприятия')
                ->setup_labels($elemets_labels)
                ->add_fields(array(
                    Field::make('time', 'event_time', 'Время события')->set_default_value(date("H:i:s", time()))
                        ->set_attribute('placeholder', 'Time of event start'),
                    Field::make('text', 'title', 'Заголовок'),
                    Field::make('media_gallery', 'crb_media_gallery', "Выбор изображений")
                ))
        ));

    Container::make('post_meta', 'Мероприятия')
        ->where('post_type', '=', 'event')
        ->add_fields(array(
            Field::make('media_gallery', 'slider_gallery', 'Слайдер')
                ->set_type(array('image', 'video'))
        ));
}

add_action('carbon_fields_register_fields', 'crb_attach_theme_options');
add_action('carbon_fields_register_fields', 'events_carbon');
