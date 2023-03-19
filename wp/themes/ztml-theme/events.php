<?php

/*
 * Template Name: Мероприятия
*/

?>

<?php get_header(); ?>

<?php require_once(COMPONENTS_PATH . 'topic-bar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'pdf-attachments.php'); ?>
<?php require_once(COMPONENTS_PATH . 'satms-list-tem.php'); ?>
<?php require_once(COMPONENTS_PATH . 'sidebar.php'); ?>
<?php require_once(COMPONENTS_PATH . 'calendar.php'); ?>


<?php require_once(COMPONENTS_PATH . 'line-news-list-item.php'); ?>

<?php require_once(COMPONENTS_PATH . 'news-templates.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/top-three-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/newspapers-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/most-read-news-template.php'); ?>


<?php require_once(COMPONENTS_PATH . "topic-minibar.php"); ?>

<?php require_once(COMPONENTS_PATH . 'news-templates/culture-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/district-news-template.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/economy-tempalte.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/society-news-tempalte.php'); ?>
<?php require_once(COMPONENTS_PATH . 'news-templates/urban-economy-news-template.php'); ?>

<?php
$show_count = 27;
$load_count = 27;

$event_args = array(
	'post_status' => 'publish',
	'posts_per_page' => $show_count,
	'post_type' => 'event',
);

$event_posts = get_posts($event_args);
$count_posts = wp_count_posts('event')->publish;

?>

<?php
$first_post_id = get_posts(array(
	'numberposts' => 1,
	'post_type' => 'event',
	'post_status' => 'publish',
	'order' => 'DESC'
))[0]->ID;

$last_post_id = get_posts(array(
	'numberposts' => 1,
	'post_type' => 'event',
	'post_status' => 'publish',
	'order' => 'ASC'
))[0]->ID;
?>

<?php
$images = array("https://klike.net/uploads/posts/2020-05/1590042521_4.jpg",
"https://art-assorty.ru/wp-content/uploads/2019/05/10-5.jpg",
"https://deita.ru/images/articles/2018-10-17_17-27-19_439500_lg.jpg",
"https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13",
"https://klike.net/uploads/posts/2020-05/1590042521_4.jpg",
);

$events_data = array(
    array(
        "time" => "13.01",
        "title" => "Начало первого периода",
        "data" => array(
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),
            array(
                "type" => "video",
                "src" => "https://www.youtube.com/embed/-7n4t0cbVD4"
            ),
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),    
        ),
    ),
    array(
        "time" => "13.01",
        "title" => "Начало первого периода",
        "data" => array(
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),
            array(
                "type" => "video",
                "src" => "https://www.youtube.com/embed/-7n4t0cbVD4"
            ),
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),    
        ),
    ),
    array(
        "time" => "13.01",
        "title" => "Начало первого периода",
        "data" => array(
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),
            array(
                "type" => "video",
                "src" => "https://www.youtube.com/embed/-7n4t0cbVD4"
            ),
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),    
        ),
    ),
    array(
        "time" => "13.01",
        "title" => "Начало первого периода",
        "data" => array(
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),
            array(
                "type" => "video",
                "src" => "https://www.youtube.com/embed/-7n4t0cbVD4"
            ),
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),    
        ),
    ),
    array(
        "time" => "13.01",
        "title" => "Начало первого периода",
        "data" => array(
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),
            array(
                "type" => "video",
                "src" => "https://www.youtube.com/embed/-7n4t0cbVD4"
            ),
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),    
        ),
    ),
    array(
        "time" => "13.01",
        "title" => "Начало первого периода",
        "data" => array(
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),
            array(
                "type" => "video",
                "src" => "https://www.youtube.com/embed/-7n4t0cbVD4"
            ),
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),    
        ),
    ),
    array(
        "time" => "13.01",
        "title" => "Начало первого периода",
        "data" => array(
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),
            array(
                "type" => "video",
                "src" => "https://www.youtube.com/embed/-7n4t0cbVD4"
            ),
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),    
        ),
    ),
    array(
        "time" => "13.01",
        "title" => "Начало первого периода",
        "data" => array(
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),
            array(
                "type" => "video",
                "src" => "https://www.youtube.com/embed/-7n4t0cbVD4"
            ),
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),    
        ),
    ),
    array(
        "time" => "13.01",
        "title" => "Начало первого периода",
        "data" => array(
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),
            array(
                "type" => "video",
                "src" => "https://www.youtube.com/embed/-7n4t0cbVD4"
            ),
            array(
                "type" => "image",
                "src" => "https://avatars.mds.yandex.net/i?id=31b42dbbb8d899aabb8542229fc06d36_l-5490649-images-thumbs&n=13"
            ),    
        ),
    ),
)

?>





<main class="events" id="events">
	<div class="container main-container">
		<div class="content-wrapper">
            <div class="main-content">			
            <?php render_topic_bar(get_the_title(), false); ?>
                <p class="events-color">Для современного мира постоянное информационно-пропагандистское обеспечение нашей деятельности, а также свежий взгляд на привычные вещи - безусловно открывает новые горизонты для позиций, занимаемых участниками в отношении поставленных задач. Банальные, но неопровержимые выводы, а также элементы политического процесса, превозмогая сложившуюся непростую экономическую ситуацию, призваны к ответу. Задача организации, в особенности же социально-экономическое развитие позволяет выполнить важные задания по разработке экономической целесообразности принимаемых решений. Прежде всего, внедрение современных методик говорит о возможностях экспериментов, поражающих по своей масштабности.</p>
				<div class="district__slider">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/-7n4t0cbVD4" title="YouTube video player" style="border:0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<?php foreach ($images as $image) : ?>
						<div>
							<img class="fill zoom-img" src="<?php echo $image ?>" />
						</div>
					<?php endforeach; ?>
				</div>
                <div class="events-content">
                <?php 
                    foreach($events_data as $event) : ?>
                    <div class="events-header">
                        <p class="events-time"><?php echo $event["time"] ?></p>
                        <p class="events-title"><?php echo $event["title"] ?></p>
                    </div> 
                    <div class="img-container">
                        <?php foreach ($event["data"] as $item) : ?>
                            <?php if ($item["type"] == "image"): ?>
                                <img class="event-img zoom-img" src="<?php echo $item['src']?>"/>
                            <?php elseif ($item["type"] == "video"): ?>
                                <iframe class="event-video" src="<?php echo $item['src']?>" title="YouTube video player" style="border:0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
			</div>
            <div class="second-content">
				<?php render_most_read_news_template(true); ?>
				<?php render_top_three_news_template(); ?>
				<?php render_newspapers_template(); ?>
			</div>
		</div>
		<?php render_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>