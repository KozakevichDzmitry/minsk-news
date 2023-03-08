<?php

require_once(COMPONENTS_PATH . "icons/play-icon.php");
require_once(COMPONENTS_PATH . "icons/volume-sound-icon.php");

function render_mn_player($post_ID)
{
?>
	<div class="mn-player">
		<?php $audio_src = wp_get_attachment_url(carbon_get_post_meta($post_ID, 'crb_podcast_file')[0]); ?>
		<audio id="audio" src="<?php echo $audio_src; ?>"></audio>
		<div class="mn-player__controls">
			<button class="player-controls__play-btn" id="playBtn">
				<img class="cae_play_icon" src="<?php echo get_template_directory_uri() . '/assets/images/cae_play_icon.svg'; ?>" alt="play icon" />
				<img class="cae_pause_icon" src="<?php echo get_template_directory_uri() . '/assets/images/stop.svg'; ?>" alt="pause icon" />
			</button>
			<div class="player-controls__time" id="time">
				00:00 &mdash; 00:00
			</div>
			<div class="player-controls__volume">
				<button>
					<?php render_volume_sound_icon(); ?>
				</button>
				<input type="range" min="0" max="100" value="50" id="volume">
			</div>
		</div>
		<div class="mn-player__track-bar">
			<input type="range" min="0" max="100" value="0" id="trackBar">
		</div>
	</div>
<?php
}
