<?php

function render_adv($type, $id, $location)
{
	$class_name = 'adfox__' . $location;
	if ($type == 'post') {
		$is_disable = carbon_get_post_meta($id, 'crb_adfox_disable');

		if (!$is_disable) {
			$post_name = get_post_type($id);
			$is_origin = carbon_get_post_meta($id, 'crb_adfox_origin');

			if ($is_origin) {
				$banner = carbon_get_post_meta($id, 'crb_adf_banner_' . $location);
				$is_shortcode = carbon_get_post_meta($id, 'crb_banner_' . $location . '_shortcode');

				if ($is_shortcode) { ?>
					<div class="<?php echo $class_name ?>"><?php echo do_shortcode($banner); ?></div>
				<?php   } else { ?>
					<div class="<?php echo $class_name ?>"><?php echo $banner; ?></div>
				<?php }
			} else {
				//  Если у текущего поста не установлена реклама, тогда будет отображаться
				//  общая реклама для этого типа постов. Общая реклама устанавливается в разделе "Реклама"
				$banner = carbon_get_theme_option('crb_adf_' . $post_name . '_banner_' . $location);
				$is_shortcode = carbon_get_theme_option('crb_' . $post_name . '_banners_' . $location . '_shortcode');
				if ($is_shortcode) { ?>
					<div class="<?php echo $class_name ?>"><?php echo do_shortcode($banner); ?></div>
				<?php   } else { ?>
					<div class="<?php echo $class_name ?>"><?php echo $banner; ?></div>
			<?php }
			}
		}
	} elseif ($type == 'page') {
		$banner = carbon_get_theme_option('crb_adf_' . $id . '_banner_' . $location);
		$is_shortcode = carbon_get_theme_option('crb_' . $id . '_banners_' . $location . '_shortcode');
		if ($is_shortcode) { ?>
			<div class="<?php echo $class_name ?>"><?php echo do_shortcode($banner); ?></div>
		<?php   } else { ?>
			<div class="<?php echo $class_name ?>"><?php echo $banner; ?></div>
<?php }
	}
}
