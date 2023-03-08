<?php
/**
 * @link https://help.mail.ru/feed/rss
 *
 * @var mihdan_mail_ru_feed $this
 */
header( 'Content-Type: ' . feed_content_type( 'rss-http' ) . '; charset=' . $this->get_option( 'feed_charset' ), true );
echo '<?xml version="1.0" encoding="' . esc_html( $this->get_option( 'feed_charset' ) ) . '"?' . '>';
?>
<rss version="2.0" xmlns:mailru="http://news.mail.ru/">
	<channel>
		<title><?php echo esc_html( $this->get_option( 'channel_title' ) ); ?></title>
		<link><?php echo esc_html( $this->get_option( 'channel_link' ) ); ?></link>
		<description><?php echo esc_html( $this->get_option( 'channel_description' ) ); ?></description>
		<language><?php echo esc_html( $this->get_option( 'channel_language' ) ); ?></language>
		<?php do_action( 'rss2_head' ); ?>
		<?php do_action( 'mihdan_mail_ru_feed_channel' ); ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<item>
				<title><![CDATA[<?php the_title_rss(); ?>]]></title>
				<description><![CDATA[<?php echo esc_html(wp_strip_all_tags(strip_shortcodes(apply_filters('mailru_description', get_post( get_the_ID())->post_content) ))); ?>]]></description>
				<link><?php the_permalink_rss(); ?></link>
				<pubDate><?php echo get_post_rfc_time(); ?></pubDate>
				<mailru:full-text><![CDATA[<?php the_content_feed(); ?>]]></mailru:full-text>
				<?php $hasMailRuBreaking = get_post_meta( get_the_ID(), 'mail_ru_breaking' ,true ); ?>
				<breaking><?php echo $hasMailRuBreaking ? "1" : "0"; ?></breaking> 
				<?php $hasMailExclusive = get_post_meta( get_the_ID(), 'mail_ru_exclusive' ,true ); ?>
				<exclusive><?php echo $hasMailExclusive ? "1" : "0"; ?></exclusive> 		
				<?php do_action( 'mihdan_mail_ru_feed_enclosure', get_the_ID() ); ?>
				<?php $images = get_attached_media('image', $post->ID);
					foreach($images as $image) { ?>
				<enclosure url="<?php echo wp_get_attachment_image_src($image->ID,'full')[0]; ?>" type="image/jpeg" />
				<?php } ?>				
			</item>
		<?php endwhile; ?>
	</channel>
</rss>


			<?php
$thumb_id = get_post_thumbnail_id(get_the_ID());
$alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
if(count($alt)) echo $alt;
?>
			