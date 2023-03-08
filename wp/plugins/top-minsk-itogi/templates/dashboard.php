<div class='wrap'>
	<h2><?php _e('Настройки Топ-3 новостей', 'top_minsk_itogi'); ?></h2>

	<form name="top_minsk_itogi" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=top-minsk-itogi.php&amp;updated=true">

		<?php
		if (function_exists('wp_nonce_field')) {
			wp_nonce_field('top_minsk_itogi_form');
		}
		?>

		<table class="form-table">
			<tr valign="top">
				<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Текст', ''); ?></th>
			</tr>
			<tr valign="top">

				<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Заголовок:', ''); ?></th>

				<td style="padding: 15px 0px">
					<input type="text" name="top_itogi_name" size="30" value="<?php echo $top_itogi_name; ?>" required />
				</td>
			</tr>
			<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Подзаголовок:', ''); ?></th>

			<td style="padding: 15px 0px">
				<input type="text" name="top_itogi_name2" size="30" value="<?php echo $top_itogi_name2; ?>" />
			</td>
			</tr>

			<tr valign="top">
				<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Новость 1', ''); ?></th>

			</tr>
			<tr valign="top">

				<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Просмотры:', ''); ?></th>

				<td style="padding: 15px 0px">
					<input type="text" name="top1_views" size="20" value="<?php echo $top1_views; ?>" maxlength="20" required />
				</td>
			</tr>
			<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Ссылка URL (копируется из вкладки в браузере):', ''); ?></th>

			<td style="padding: 15px 0px">
				<input type="text" name="top1_url" size="120" value="<?php echo $top1_url; ?>" required />
			</td>
			</tr>
			</tr>
			<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Заголовок (максимум 90 символов):', ''); ?></th>

			<td style="padding: 15px 0px">
				<input type="text" name="top1_title" size="120" value="<?php echo $top1_title; ?>" maxlength="90" required />
			</td>
			</tr>

			<tr valign="top">
				<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Новость 2', ''); ?></th>

			</tr>

			<tr valign="top">

				<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Просмотры:', ''); ?></th>

				<td style="padding: 15px 0px">
					<input type="text" name="top2_views" size="20" value="<?php echo $top2_views; ?>" maxlength="20" required />
				</td>
			</tr>
			<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Ссылка URL (копируется из вкладки в браузере):', ''); ?></th>

			<td style="padding: 15px 0px">
				<input type="text" name="top2_url" size="120" value="<?php echo $top2_url; ?>" required />
			</td>
			</tr>
			</tr>
			<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Заголовок (максимум 90 символов):', ''); ?></th>

			<td style="padding: 15px 0px">
				<input type="text" name="top2_title" size="120" value="<?php echo $top2_title; ?>" maxlength="90" required />
			</td>
			</tr>

			<tr valign="top">
				<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Новость 3', ''); ?></th>

			</tr>

			<tr valign="top">

				<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Просмотры:', ''); ?></th>

				<td style="padding: 15px 0px">
					<input type="text" name="top3_views" size="20" value="<?php echo $top3_views; ?>" maxlength="20" required />
				</td>
			</tr>
			<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Ссылка URL (копируется из вкладки в браузере):', ''); ?></th>

			<td style="padding: 15px 0px">
				<input type="text" name="top3_url" size="120" value="<?php echo $top3_url; ?>" required />
			</td>
			</tr>
			</tr>
			<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Заголовок (максимум 90 символов):', ''); ?></th>

			<td style="padding: 15px 0px">
				<input type="text" name="top3_title" size="120" value="<?php echo $top3_title; ?>" maxlength="90" required />
			</td>
			</tr>
		</table>

		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="top_itogi_name,top_itogi_name2,top1_url,top1_views,top1_title,top2_url,top2_views,top2_title,top3_url,top3_views,top3_title" />

		<p class="submit">
			<input type="submit" name="submit" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>