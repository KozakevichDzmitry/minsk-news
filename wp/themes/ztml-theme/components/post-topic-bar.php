<?php

require_once(COMPONENTS_PATH . 'content-exist-markers.php');

function render_post_topic_bar($post_ID)
{
?>
	<div class="post-topic-bar">
		<div class="content-exists">
            <?php $exist_markers = render_content_exist_markers($post_ID); ?>
            <?php if($exist_markers): ?>
                <div class="content-exist">
                    <?php  echo $exist_markers; ?>
                </div>
            <?php endif;?>
			<div class="tags">
				<?php
				$terms = get_the_terms($post_ID, 'news-list');
				$term = '';
				?>
				<?php if (!empty($terms)) :
					foreach ($terms as $t) {
						if ($t->name == 'Главное' || $t->name == 'Лента') {
							continue;
						} else {
							$term = $t->name;
							break;
						}
					}
				?>
					<span><?php echo $term; ?></span>
				<?php endif; ?>
			</div>
		</div>

		<div class="title">
			<span>
				<?php echo get_the_title($post_ID); ?>
			</span>
		</div>

		<div class="date">
			<span>
				<?php echo get_the_date('h:i', $post_ID); ?>
			</span>
			<span>
				<?php echo get_the_date('d.m.Y', $post_ID); ?>
			</span>
		</div>
	</div>
<?php
}
