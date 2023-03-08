<?php
/**
 * Mihdan: Mail Ru Feed Edition
 *
 * @package   mihdan-mail-ru-feed
 * @author    Mikhail Kobzarev
 * @link      https://github.com/mihdan/mihdan-yandex-turbo-feed/
 * @link      https://yandex.ru/support/webmaster/turbo/rss-elements.html
 * @copyright Copyright (c) 2017
 * @license   GPL-2.0+
 * @wordpress-plugin
 */

/**
 * Plugin Name: Mihdan: Mail Ru Feed Edition
 * Plugin URI: https://minsknews.by/about/
 * Description: Плагин генерирует фид для сервиса News Mail.Ru
 * Version: 1.1.6
 * Author: Mikhail Kobzarev
 * Author URI: https://www.kobzarev.com/
 * License: GNU General Public License v2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mihdan-mail-ru-feed 
 * Requires WP:       4.6
 * Requires PHP:      5.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Mihdan_Mail_Ru_Feed' ) ) {

	// Слюг плагина
	define( 'MIHDAN_MAIL_RU_FEED_SLUG', 'mihdan_mail_ru_feed' );
	define( 'MIHDAN_MAIL_RU_FEED_VERSION', '1.1.6' );

	/**
	 * Class Mihdan_Mail_Ru_Feed
	 */
	class Mihdan_Mail_Ru_Feed {

		/**
		 * @var string слюг плагина
		 */
		private $slug = 'mihdan_mail_ru_feed';

		/**
		 * @var string $feedname слюг фида
		 */
		public $feedname;

		/**
		 * @var array $allowable_tags массив разрешенных тегов для контента
		 */
		private $allowable_tags = array(
			'<p>'
		);

		/**
		 * @var array $enclosure для хранения фото у поста
		 */
		private $enclosure = array();

		/**
		 * @var array Массив похожих постов
		 */
		private $related = array();

		/**
		 * Путь к плагину
		 *
		 * @var string
		 */
		public $dir_path;

		/**
		 * URL до плагина
		 *
		 * @var string
		 */
		public $dir_uri;

		/**
		 * Хранит экземпляр класса
		 *
		 * @var $instance
		 */
		private static $instance;

		/**
		 * Соотношение категорий.
		 *
		 * @var
		 */
		private $categories;

		/**
		 * Таксономия для соотношений.
		 *
		 * @var array
		 */
		private $taxonomy = array( 'category', 'post_tag' );

		/**
		 * @var array список постов для вывода
		 */
		private $post_type = array( 'post' );

		/**
		 * Вернуть единственный экземпляр класса
		 *
		 * @return mihdan_mail_ru_feed
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Инициализируем нужные методы
		 *
		 * Mihdan_FAQ constructor.
		 */
		private function __construct() {
			$this->includes();
			$this->setup();
			$this->hooks();
		}

		/**
		 * Установка основных переменных плагина
		 */
		private function setup() {
			$this->dir_path = trailingslashit( plugin_dir_path( __FILE__ ) );
			$this->dir_uri  = trailingslashit( plugin_dir_url( __FILE__ ) );
		}

		/**
		 * Фильтры для переопределения настроек внутри темы
		 */
		public function after_setup_theme() {

			// Подключить конфиг Redux после фильтрации,
			// чтобы работали переопределения полей, сделанный фильтрами ранее.
			require_once $this->dir_path . 'includes/redux-config.php';


			$this->categories = apply_filters( 'mihdan_mail_ru_feed_categories', array() );

			$this->post_type = $this->get_option( 'feed_post_type' );
			$this->taxonomy  = $this->get_option( 'feed_taxonomy' );
			$this->feedname  = $this->get_option( 'feed_slug' );
		}

		/**
		 * Регистрируем новую область меню
		 * для создания меню в админке
		 */
		//public function register_nav_menu() {
		//	register_nav_menu( $this->slug, 'Mail.ru' );
		//}

		/**
		 * Подключаем зависимости
		 */
		private function includes() {

			// Для работы с переводами.
			require_once ABSPATH . 'wp-admin/includes/translation-install.php';

			// Redux Framework.
			require_once $this->dir_path . 'vendor/redux/framework.php';
		}

		/**
		 * Хукаем.
		 */
		private function hooks() {
			add_action( 'init', array( $this, 'add_feed' ) );
			add_action( 'init', array( $this, 'flush_rewrite_rules' ), 99 );
			add_action( 'pre_get_posts', array( $this, 'alter_query' ) );
			add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
			//add_action( 'after_setup_theme', array( $this, 'register_nav_menu' ) );
			add_action( 'plugins_loaded', array( $this, 'load_translations' ) );
			add_action( 'redux/options/' . $this->slug . '/saved', array( $this, 'on_redux_saved' ) );
			add_action( 'mihdan_mail_ru_feed_enclosure', array( $this, 'insert_enclosure' ) );
			//add_action( 'mihdan_mail_ru_feed_item', array( $this, 'insert_related' ) );
			add_action( 'mihdan_mail_ru_feed_category', array( $this, 'insert_category' ) );
			//add_action( 'mihdan_mail_ru_feed_item_header', array( $this, 'insert_menu' ) );
			add_action( 'mihdan_mail_ru_feed_item_content', array( $this, 'insert_share' ) );
			add_action( 'mihdan_mail_ru_feed_item_content', array( $this, 'insert_comments' ) );
			//add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
			//add_action( 'save_post', array( $this, 'save_meta_box' ) );
			add_filter( 'the_content_feed', array( $this, 'content_feed' ) );
			add_filter( 'wp_get_attachment_image_attributes', array( $this, 'image_attributes' ), 10, 3 );
			add_filter( 'wpseo_include_rss_footer', array( $this, 'hide_wpseo_rss_footer' ) );

			register_activation_hook( __FILE__, array( $this, 'on_activate' ) );
			register_deactivation_hook( __FILE__, array( $this, 'on_deactivate' ) );
		}

		/**
		 * Всплывает при сохранении настроек в Redux.
		 */
		public function on_redux_saved() {
			update_option( $this->slug . '_flush_rewrite_rules', 1, true );
		}

		/**
		 * Регистрируем переводы.
		 */
		public function load_translations() {
			load_plugin_textdomain( 'mihdan-mail-ru-feed', false, $this->dir_path . 'languages' );
		}

		/**
		 * Скидываем реврайты, если в базе есть опция.
		 */
		public function flush_rewrite_rules() {

			// Ищем опцию.
			if ( get_option( $this->slug . '_flush_rewrite_rules' ) ) {

				// Скидываем реврайты.
				flush_rewrite_rules();

				// Удаляем опцию.
				delete_option( $this->slug . '_flush_rewrite_rules' );
			}
		}

		/**
		 * Получаем данные из поля Redux по ключу.
		 *
		 * @param string $key ключ поля.
		 * @return string|array
		 */
		public function get_option( $key ) {
			$option = Redux::getOption( $this->slug, $key );

			// Если пусто - берем настройку по дефолту.
			if ( empty( $option ) ) {
				$field = Redux::getField( $this->slug, $key );

				if ( $field ) {
					$option = $field['default'];
				}
			}

			return $option;
		}

		/**
		 * Генерим тег категории
		 *
		 * @param string $category название категории
		 *
		 * @return string
		 */
		public function create_category( $category ) {
			return sprintf( '<category>%s</category>', html_entity_decode( $category, ENT_COMPAT, 'UTF-8' ) );
		}

		/**
		 * Вставляем категории поста в фид
		 *
		 * @param integer $post_id идентификатор поста
		 */
		public function insert_category( $post_id ) {

			// Получить категории текущего поста
			$categories = $this->get_categories( array(
				'post_id' => $post_id,
				'fields'  => 'names',
			) );

			// Сгенерить тег категории
			if ( $categories ) {
				// Выбрать уникальные термы, так как они
				// могут совпадать в разных таксономиях
				$categories = array_unique( $categories );
				foreach ( $categories as $category ) {
					echo $this->create_category( $category );
				}
			}
		}

		/**
		 * Удалить ненужные атрибуты при генерации картинок
		 *
		 * @param array $attr
		 * @param WP_Post $attachment объект вложения
		 * @param string|array $size размер
		 *
		 * @return array
		 */
		public function image_attributes( $attr, $attachment, $size ) {

			if ( is_feed( $this->feedname ) ) {
				unset( $attr['srcset'] );
				unset( $attr['sizes'] );
			}

			return $attr;
		}

		/**
		 * Хелпер для создания тега <enclosure>
		 *
		 * @param string $url ссылка
		 *
		 * @return string
		 */
		public function create_enclosure( $url ) {
			$filetype = wp_check_filetype( $url );
			return sprintf( '<enclosure url="%s" type="%s" header="%s"/>', esc_url( $url ), esc_attr( $filetype['type'] ), esc_html(get_the_title()) );
		}

		/**
		 * Вставка <enclosure> в шаблон
		 */
		public function insert_enclosure() {
			foreach ( $this->enclosure as $image ) {
				echo $this->create_enclosure( $image['src'] );
			}

			

			$this->enclosure = array();
		}

		/**
		 * Генерит валидный тег <link />
		 *
		 * @param string $url ссылка на пост
		 * @param string $src ссылка на кртинку
		 * @param string $title текст ссылки
		 *
		 * @return string
		 */
		public function create_related( $url, $src, $title ) {
			if ( ! empty( $title ) && ! empty( $src ) ) {
				return sprintf( '<link url="%s" img="%s"><![CDATA[%s]]></link>', esc_url( $url ), esc_url( $src ), esc_html( $title ) );
			}
		}

		public function insert_related() {
			$related = $this->get_related();

			if ( $related->have_posts() ) {
				echo '<yandex:related>';
				while ( $related->have_posts() ) {
					$related->the_post();
					echo $this->create_related(
						get_permalink(),
						get_the_post_thumbnail_url(),
						get_the_title()
					);
				}
				echo '</yandex:related>';
			}
		}

		public function insert_comments() {

			if ( comments_open() || have_comments() ) {

				// Аргументы получения комментариев
				$comments_args = array(
					'post_id' => get_the_ID(),
					'status'  => 'approve',
					'type'    => 'comment',
				);

				// Фильтруем аргументы получения комментариев
				$comments_args = apply_filters( 'mihdan_mail_ru_feed_comments_args', $comments_args );

				// Получаем комментарии
				$comments = get_comments( $comments_args );

				$args = array(
					'style'        => 'div',
					'avatar_size'  => 64,
					'per_page'     => 40, // яндекс обрабатывает не более 40 комментов
					'callback'     => array( $this, 'comments_callback' ),
					'end-callback' => array( $this, 'comments_end_callback' ),
				);

				printf( '<div data-block="comments" data-url="%s#comments">', get_permalink() );
					wp_list_comments( $args, $comments );
				echo '</div>';
			}
		}

		public function comments_callback( $comment, $args, $depth ) {
			?>
			<div
				data-block="comment"
				data-author="<?php comment_author(); ?>"
				data-avatar-url="<?php echo esc_url( get_avatar_url( $comment, 64 ) ); ?>"
				data-subtitle="<?php echo get_comment_date(); ?> в <?php echo get_comment_time(); ?>"
			>
				<div data-block="content">
					<?php comment_text(); ?>
				</div>
				<?php if ( $args['has_children'] ) : ?>
					<div data-block="comments">
				<?php endif; ?>
			<?php

			return;
		}

		public function comments_end_callback( $comment, $args, $depth ) {
			?>
			</div>
			<?php if ( 1 === $depth ) : ?>
				</div>
			<?php endif; ?>
			<?php
		}

		/**
		 * Генерим тег <menu>
		 *
		 * @param string $menu строка с меню
		 *
		 * @return string
		 */
		public function create_menu( $menu ) {
			return sprintf( '<menu>%s</menu>', $menu );
		}

		/**
		 * Вставлем пользовательское меню
		 * в каждый item фида
		 */
		public function insert_menu() {

			// Если юзер сделал меню
			if ( has_nav_menu( $this->slug ) ) {

				// Получить меню
				$menu = wp_nav_menu( array(
					'theme_location' => $this->slug,
					'container'      => false,
					'echo'           => false,
					'depth'          => 1,
				) );

				// Оставить в меню только ссылки
				$menu = strip_tags( $menu, '<a>' );

				// Вывести меню
				echo $this->create_menu( $menu );
			}
		}

		/**
		 * Вставляет блок с шерами
		 */
		public function insert_share() {

			// Массив предустановленных социальных сетей
			$networks = array(
				'facebook',
				'google',
				'odnoklassniki',
				'telegram',
				'twitter',
				'vkontakte',
			);

			// Возможность отфильтровать соцсети
			$network = apply_filters( 'mihdan_mail_ru_feed_networks', $networks );

			echo sprintf( '<div data-block="share" data-network="%s"></div>', implode( ',', $network ) );
		}

		/**
		 * Превращаем абсолютный URL в относительный
		 *
		 * @param string $url исходный URL
		 *
		 * @return mixed
		 */
		public function get_relative_url( $url ) {
			$upload_dir = wp_upload_dir();
			return $upload_dir['basedir'] . str_replace( $upload_dir['baseurl'], '', $url );
		}


		/**
		 * Получить размеры фотки по абсолютному URL
		 *
		 * @param string $url абсолютный URL
		 *
		 * @return array|bool
		 */
		public function get_image_size( $url ) {
			$relative = $this->get_relative_url( $url );

			return getimagesize( $relative );
		}

		/**
		 * Получить тумбочку поста по его ID
		 *
		 * @param integer $post_id идентификатор поста
		 */
		public function get_futured_image( $post_id ) {

			$url = get_the_post_thumbnail_url( $post_id, 'large' );

			$this->enclosure[] = array(
				'src'     => $url,
				'caption' => esc_attr( get_the_title( $post_id ) ),
			);

		}

		/**
		 * Форматируем контент <item>'а в соответствии со спекой
		 *
		 * Преобразуем HTML-контент в DOM-дерево,
		 * проводим нужные манипуляции с тегами,
		 * преобразуем DOM-дерево обратно в HTML-контент
		 *
		 * @param string $content содержимое <item> фида
		 *
		 * @return string
		 */
		public function content_feed( $content ) {

			if ( is_feed( $this->feedname ) ) {

				$content = substr( $content, strpos( $content, '</p>' ) + 4 );
				$content = $this->strip_tags( $content, $this->allowable_tags );

				$content = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $content);

				
				/**
				 * Получить тумбочку поста
				 */
				if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail() ) {
					$this->get_futured_image( get_the_ID() );
				}

				
				
				
			}
			
			return $content;
		}

		/**
		 * Регистрация нашего фида
		 */
		public function add_feed() {

			// Добавить новый фид
			add_feed( $this->feedname, array( $this, 'require_feed_template' ) );
		}

		/**
		 * Hide RSS footer created by WordPress SEO from our RSS feed
		 *
		 * @param  boolean $include_footer Default inclusion value
		 *
		 * @return boolean                 Modified inclusion value
		 */
		public function hide_wpseo_rss_footer( $include_footer = true ) {

			if ( is_feed( $this->feedname ) ) {
				$include_footer = false;
			}

			return $include_footer;
		}

		/**
		 * Подправляем основной луп фида
		 *
		 * @param WP_Query $wp_query объект запроса
		 */
		public function alter_query( WP_Query $wp_query ) {

			if ( $wp_query->is_main_query() && $wp_query->is_feed( $this->feedname ) ) {

				// Ограничить посты 50-ю
				$wp_query->set( 'posts_per_rss', $this->get_option( 'feed_total_posts' ) );

				// Впариваем нужные нам типы постов
				$wp_query->set( 'post_type', $this->post_type );

				// Указываем поле для сортировки.
				$wp_query->set( 'orderby', $this->get_option( 'feed_orderby' ) );

				// Указываем направление сортировки.
				$wp_query->set( 'order', $this->get_option( 'feed_order' ) );

				// Получаем текущие мета запросы.
				$meta_query = $wp_query->get( 'meta_query' );

				if ( empty( $meta_query ) ) {
					$meta_query = array();
				}
				
				// Добавляем исключения.
				$meta_query[] = array(
					'key' => 'layf_exclude_from_feed',
					'value' => true,
					'compare' => '!='
				);

				// Исключаем записи с галочкой в админке
				$wp_query->set( 'meta_query', $meta_query );


				
			}
		}

		/**
		 * Подключаем шаблон фида
		 */
		public function require_feed_template() {
			require $this->dir_path . 'templates/feed.php';
		}

		/**
		 * Удалить все теги из строки
		 *
		 * Расширенная версия функции `strip_tags` в PHP,
		 * но удаляет также <script>, <style>
		 *
		 * @param string $string исходная строка
		 * @param null|array $allowable_tags массив разрешенных тегов
		 *
		 * @return string
		 */
		public function strip_tags( $string, $allowable_tags = null ) {
			$string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
			$string  = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $string);
			$string  = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $string);
			$string = strip_tags( $string, implode( ',', $allowable_tags ) );

			return $string;
		}

		/**
		 * Чистит контент фида от грязи наших плагинов.
		 *
		 * @param string $str строка для очистки
		 * @author mikhail@kobzarev.com
		 * @return string
		 */
		public function clear_xml( $str ) {

			$str = strtr(
				$str,
				array(
					'&'      => '&amp;',
					'>'      => '&gt;',
					'<'      => '&lt;',
					'"'      => '&quot;',
					'\''     => '&apos;',
					'&nbsp;' => ' ',
//					'…'      => '&#133;',
//					'–'      => '&#150;',
//					'—'      => '&#151;',
//					'«'      => '&#171;',
//					'»'      => '&#187;',
//					'№'      => '&#8470;',
				)
			);

			$str = force_balance_tags( $str );

			return trim( $str );
		}

		/**
		 * Найти название категории, исходя из соотношений в теме сайта.
		 *
		 * @param integer $category_id идентификатор категории.
		 *
		 * @return bool|int|string
		 */
		public function get_category( $category_id ) {

			return $this->array_search( $category_id, $this->categories );
		}

		/**
		 * Получить название такосномии для соотношений.
		 * По-умолчанию, это category.
		 *
		 * @return array
		 */
		public function get_taxonomy() {
			return (array) $this->taxonomy;
		}

		/**
		 * Рекурсивный поиск в массиве.
		 * Возвращает ключ первого найденного вхождения.
		 *
		 * @param string $needle строка поиска.
		 * @param array $haystack массив, в котором искать.
		 *
		 * @return bool|int|string
		 */
		public function array_search( $needle, $haystack ) {

			foreach ( $haystack as $key => $value ) {
				$current_key = $key;
				if ( $needle === $value or ( is_array( $value ) && $this->array_search( $needle, $value ) !== false ) ) {
					return $current_key;
				}
			}

			return false;
		}

		/**
		 * Сбросить реврайты при активации плагина.
		 */
		public function on_activate() {

			// Добавим флаг, свидетельствующий о том,
			// что нужно сбросить реврайты.
			update_option( $this->slug . '_flush_rewrite_rules', 1, true );
		}

		/**
		 * Сбросить реврайты при деактивации плагина.
		 */
		public function on_deactivate() {

			// Сбросить правила реврайтов
			flush_rewrite_rules();
		}

		public function get_categories( $args = [] ) {

			$taxonomy = $this->get_taxonomy();

			$default = [
				'hide_empty' => false,
			];

			$args = wp_parse_args( $args, $default );

			if ( ! empty( $args['post_id'] ) ) {
				$result = wp_get_object_terms( $args['post_id'], $taxonomy, $args );
			} else {
				$result = get_terms( $taxonomy, $args );
			}

			if ( is_wp_error( $result ) ) {
				$result = false;
			}

			return $result;
		}

		/**
		 * Получить массив похожих постов
		 *
		 * @return WP_Query
		 */
		public function get_related() {

			$post = get_post();

			$args = array(
				'post_type'           => $this->post_type,
				'posts_per_page'      => 10,
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
				'post__not_in'        => array( $post->ID ),
			);

			// Получить ID всех термов поста
			// во всех его таксономиях
			$ids = $this->get_categories( array(
				'post_id' => $post->ID,
				'fields'  => 'ids',
			) );

			if ( ! empty( $ids ) ) {

				// Получить массив слагов таксономий
				$taxonomies = $this->get_taxonomy();

				// Если переданы таксономии
				if ( $taxonomies ) {

					// Если таксономий больше одной,
					// ставим логику ИЛИ
					if ( count( $taxonomies ) > 1 ) {
						$args['tax_query']['relation'] = 'OR';
					}

					// Формируем запрос на поиск по термам
					// для каждой таксономии
					foreach ( $taxonomies as $taxonomy ) {
						$args['tax_query'][] = array(
							'taxonomy' => $taxonomy,
							'field'    => 'id',
							'terms'    => $ids,
						);
					}
				}
			}

			// Фильтруем аргументы запроса похожих постов.
			$args = apply_filters( 'mihdan_mail_ru_feed_related_args', $args );

			$query = new WP_Query( $args );

			return $query;
		}
	}

	/**
	 * Инициализирем плагин
	 *
	 * @return mihdan_mail_ru_feed
	 */
	function mihdan_mail_ru_feed() {
		return mihdan_mail_ru_feed::get_instance();
	}

	mihdan_mail_ru_feed();
}

// eof;
