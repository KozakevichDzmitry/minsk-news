<?php

function render_main_template($tax_name = '')
{
?>
	<?php $primary_attached_posts = get_attached_news(1, 'primary', null, false, false); ?>
	<div class="box-column-gap" style="height: 100%;">
		<div class="box primary" data-postid="<?php echo $primary_attached_posts['posts'][0]->ID?>" style="padding: 10px;height: 50%;">
			<?php render_new_template_image($primary_attached_posts['posts'][0]->ID); ?>
		</div>
    <?php $main_attached_posts = get_attached_news(2, 'glavnoe', null, false, false); ?>
		<div class="box additional_box glavnoe">
			<?php render_news_template_line($main_attached_posts['posts'][0]->ID, true, false, true); ?>
			<?php render_news_template_line($main_attached_posts['posts'][1]->ID, true, false, true); ?>
		</div>
	</div>
<?php
}
