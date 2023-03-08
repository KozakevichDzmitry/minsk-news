<?php

function render_topic_minibar($title, $url)
{
?>
	<div class="topic-minibar">
		<div class="topic-minibar__container">
			<a href="<?php echo $url; ?>" class="topic-minibar__title"><?php echo $title; ?></a>
		</div>
	</div>
<?php
}
