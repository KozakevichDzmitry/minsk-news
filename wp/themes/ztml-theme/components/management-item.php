<?php

function render_management_item($fio, $role, $bio, $photo_url, $recep)
{
?>
	<div class="management-item">
		<div class="image-wrapper">
			<img src="<?php echo $photo_url; ?>" />
		</div>
		<div class="info">
			<div class="info__field">
				<h2 class="name"><?php echo $fio; ?></h2>
			</div>
			<div class="info__field">
				<h3 class="role"><?php echo $role; ?></h3>
			</div>
			<div class="info__field">
				<span class="text">
					<?php echo $bio; ?>
				</span>
			</div>
			<?php if (strlen($bio) > 215) : ?><a class="only-mobile mob-get-more read-more">Читать все</a><?php endif; ?>
			<div class="info__field">
				<span class="text"><?php echo $recep; ?></span>
			</div>
		</div>
	</div>
<?php
}
