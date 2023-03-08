# Mihdan: MailRu Rss
WordPress-плагин, генерирующий фид для [Турбо-страниц](https://yandex.ru/adv/turbo) от компании Яндекс

![Mihdan: Yandex Turbo Feed](./screenshot-1.png)

## Автора ##
"Писатель" - [Кобзарёв Михаил](https://www.kobzarev.com/)

## Автоматическая установка Yandex Turbo Feed ##
1. Зайдите в дминке в *Плагины* → *Добавить новый*
2. В поиске введите `Mihdan: Yandex Turbo Feed`
3. Активируйте плагин `Mihdan: Yandex Turbo Feed`
4. [Необязательно] Найстройте плагин.

## Ручная установка Yandex Turbo Feed ##

1. [Скачайте](https://github.com/mihdan/mihdan-yandex-turbo-feed/archive/master.zip) последнюю стабильную версию в zip-архиве
2. Распакуйте архив, переименуйте папку в `mihdan-yandex-turbo-feed` и зазуипуйте её обратно
3. Перейдите в *Плагины* -> *Добавить новый* -> *Загрузить новый*
4. Загрузите скачанный архив
5. Перейдите в *Плагины* и активируйте установленный плагин

После установки фид станет доступным по адресу `http://example.com/feed/mihdan-yandex-turbo-feed/`

## Настройка плагина ##

На текущий момент плагин проходит стадию активной разработки, поэтому в нем отсутствует страница с настройками, но эти самые настройки можно задавать через фильтры внутри вашей темы в файле `functions.php`.

### Количество постов в ленте ###

Согласно [спеке](https://yandex.ru/support/webmaster/turbo/feed.html) Яндекса, материалов в RSS-ленте для Турбо-страниц может быть до 500. Добавил фильтр на тот случай, если вы хотите выводить их меньше:

```
add_filter( 'mihdan_mail_ru_feed_posts_per_rss', function( $posts_per_rss ) {
  return 500;
} );
```

### Ярлык ленты ###

По умолчанию ярлык для ленты выглядит как `mihdan-yandex-turbo-feed`, если вам не нравится такое название, можете его переименовать через фильтр:

```
add_filter( 'mihdan_mail_ru_feed_feedname', function( $slug ) {
  return 'yandex-turbo';
} );
```

Стоит отметить, что в качестве разделителя всегда используется тире, подчеркивание запрещено, это связано с некоторыми конфигурациями старых серверов, мало ли 🙂

### Список разрешенных тегов Yandex Turbo Feed ###

По спеке внутри тега `<turbo:content>` не должно быть никаких лишних тегов, типа `<iframe>`, поэтому плагин вырезает лишнее, оставляя только необходимый для разметки минимум. Для переопределения есть фильтр:

```
add_filter( 'mihdan_mail_ru_feed_allowable_tags', function( $allowable_tags ) {
  // Добавить тег <kbd>
  $allowable_tags[] = 'kbd';
 
  return $allowable_tags;
} );
```

### Аргументы поиска похожих постов ###

```
add_filter( 'mihdan_mail_ru_feed_related_args', function( $args ) {
    // Делаем что-то с запросом
    return $args;
} );
```

### Таксономии для вывода категорий ###

По умолчанию для вывода категорий используется таксономия `category`, которая переопределяется через фильтр:

```
add_filter( 'mihdan_mail_ru_feed_taxonomy', function( $taxonomy ) {
  return array( 'tag' );
} );
```

## Лицензия ##

Данный WordPress-плагин с открытым исходным кодом под лицензией [MIT](https://opensource.org/licenses/MIT).

## Подробности ##

Более подробную информацию о проекте вы можете найти у меня в [блоге](https://www.kobzarev.com/projects/yandex-turbo-feed/).

## Помочь проекту

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BENCPARA8S224)
