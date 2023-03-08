<?php

function extrenal_radio_player()
{
?>
	<div class="erp-scn box">
		<div class="erp-scn__title">
			<span>Прямой эфир</span>
		</div>
		<div class="erp-scn__player-container">
			<div class="erp-scn__player" style="background: url(<?php echo get_template_directory_uri() . '/assets/images/ext-player.png'; ?>);"></div>
			<button class="erp-scn__player-btn">
				<img class="play_icon" src="<?php echo get_template_directory_uri() . '/assets/images/play_icon.png'; ?>" alt="play icon"/>
				<img class="pause_icon" src="<?php echo get_template_directory_uri() . '/assets/images/stop_icon.png'; ?>" alt="pause icon"/>
			</button>
		</div>
		<audio id="ext_radio_minsk" preload="metadata">
			<source src="https://radio.mk.by:8443/mk128" type="audio/mpeg">
		</audio>
	</div>
<?php
}

add_shortcode("extrenal_radio_player_scn", "extrenal_radio_player");

