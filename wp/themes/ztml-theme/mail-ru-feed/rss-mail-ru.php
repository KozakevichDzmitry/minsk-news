<?php
/**
 * Template Name: Custom RSS Template - Feedname
 */
$postCount = 1000; // The number of posts to show in the feed
$q_args = array(
    'post_type' => 'news',
    'posts_per_page' => $postCount,
    'no_found_rows' => true,
    'post_status' => 'publish',
    'orderby' => 'publish_date',
    'order' => 'DESC',
    'meta_query' => array(
        array(
        'key' => '_layf_exclude_from_feed',
        'value' => 'true',
        'compare' => '!='
        )
    )
);
$posts = query_posts($q_args);
header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?' . '>';
?>
<rss version="2.0" xmlns:mailru="http://news.mail.ru/">
    <channel>
        <title><?php bloginfo_rss('name'); ?></title>
        <link><?php echo get_site_url();; ?></link>
        <description><?php bloginfo_rss('description'); ?></description>
        <language><?php echo get_option('rss_language'); ?></language>
        <?php do_action('rss2_head'); ?>
        <?php while (have_posts()) : the_post(); ?>
            <item>
                <title><![CDATA[<?php the_title_rss(); ?>]]></title>
                <description><![CDATA[<?php the_content_feed(); ?>]]></description>
                <source><?php the_permalink_rss(); ?></source>
                <pubDate><?php echo get_post_time('D, d M Y H:i:s', true, get_the_ID()); ?> GMT</pubDate>
                <mailru:full-text>
                    <![CDATA[<?php echo esc_html(strip_shortcodes( get_post(get_the_ID())->post_content)); ?>]]>
                </mailru:full-text>
                <?php $hasMailRuBreaking = get_post_meta(get_the_ID(), '_mail_ru_breaking', true); ?>
                <breaking><?php echo $hasMailRuBreaking ? "1" : "0"; ?></breaking>
                <?php $hasMailExclusive = get_post_meta(get_the_ID(), '_mail_ru_exclusive', true); ?>
                <exclusive><?php echo $hasMailExclusive ? "1" : "0"; ?></exclusive>
                <?php $images = get_attached_media('image', $post->ID);
                foreach ($images as $image) { ?>
                    <enclosure url="<?php echo wp_get_attachment_image_src($image->ID, 'full')[0]; ?>"
                               type="image/jpeg"/>
                <?php } ?>
            </item>
        <?php endwhile; ?>

    </channel>
</rss>
