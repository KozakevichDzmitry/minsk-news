<?php
/*
Plugin Name: MAIL.RU Informer
Description: Creating a JSON file for mail.ru informer
Version: 2.0.0
Author: Roman Strah
*/

/*  Copyright 2019  Nikita Kukshynsky

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
*/

class mail_json_informer
{
	function __construct()
	{
		add_option('mail1_title', '');
		add_option('mail1_url', '');
		add_option('mail2_title', '');
		add_option('mail2_url', '');
		add_option('mail3_title', '');
		add_option('mail3_url', '');
		add_option('mail4_title', '');
		add_option('mail4_url', '');
		
		if (function_exists ('add_shortcode') )
		{
			add_action('admin_menu',  array (&$this, 'admin') );
		}
	}
	
	function admin ()
	{
		if ( function_exists('add_options_page') ) 
		{
			add_options_page( 'Опции MAIL.RU ИНФОРМЕР', 'MAIL.RU ИНФОРМЕР', 'administrator', basename(__FILE__), array (&$this, 'admin_form') );
		}
	}
	
	function admin_form()
	{
		$mail1_title = get_option('mail1_title');
        $postid1 = get_option('postid1');
		$mail2_title = get_option('mail2_title');
        $postid2 = get_option('postid2');
		$mail3_title = get_option('mail3_title');
        $postid3 = get_option('postid3');
		$mail4_title = get_option('mail4_title');
        $postid4 = get_option('postid4');
		
		if ( isset($_POST['submit']) ) 
		{	
		   if ( function_exists('current_user_can') && !current_user_can('manage_options') )
			  die ( _e('Hacker?', 'mail_json_informer') );
			
			if (function_exists ('check_admin_referer') )
			{
				check_admin_referer('mail_json_informer_form');
			}
			$dateformat = 'F j, Y';
			$imgsize = 'td_324x235';

			$mail1_title = $_POST['mail1_title'];
			$mail2_title = $_POST['mail2_title'];
			$mail3_title = $_POST['mail3_title'];
			$mail4_title = $_POST['mail4_title'];

            $postid1 = $_POST['postid1'];
            $postid2 = $_POST['postid2'];
            $postid3 = $_POST['postid3'];
            $postid4 = $_POST['postid4'];

            $mail1_url = get_permalink( $postid1 );
            $mail2_url = get_permalink( $postid2 );
            $mail3_url = get_permalink( $postid3 );
            $mail4_url = get_permalink( $postid4 );



			$mail1_date = get_the_date( $dateformat, $postid1 );
			$mail1_img = get_the_post_thumbnail_url( $postid1, $imgsize );

			$mail2_date = get_the_date( $dateformat, $postid2 );
			$mail2_img = get_the_post_thumbnail_url( $postid2, $imgsize );

			$mail3_date = get_the_date( $dateformat, $postid3 );
			$mail4_date = get_the_date( $dateformat, $postid4 );

			$mailru = array(
				"logo" => "https://minsknews.by/wp-content/uploads/2022/12/logo-mail.jpg",
				"news" => array(
				  array(
					"img_retina" => "$mail1_img",
					"title" => "$mail1_title",
					"datetime" => "$mail1_date",
					"url" => "$mail1_url"
				  ),
				  array(
					"img_retina" => "$mail2_img",
					"title" => "$mail2_title",
					"datetime" => "$mail2_date",
					"url" => "$mail2_url"
				  ),
				  array(
					"title" => "$mail3_title",
					"datetime" => "$mail3_date",
					"url" => "$mail3_url"
					),
				  array(
					"title" => "$mail4_title",
					"datetime" => "$mail4_date",
					"url" => "$mail4_url"
					)
				)
			  );

			  $fp = fopen(ABSPATH . "/mail-ru.json", 'w');
			  fwrite($fp, json_encode($mailru, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
			  fclose($fp);
			
			  update_option('mail1_title', $mail1_title);
			  update_option('postid1', $postid1);
			  update_option('mail2_title', $mail2_title);
			  update_option('postid2', $postid2);
			  update_option('mail3_title', $mail3_title);
			  update_option('postid3', $postid3);
			  update_option('mail4_title', $mail4_title);
			  update_option('postid4', $postid4);
  
		}
		?>
		<div class='wrap'>
			<h2><?php _e('Настройки MAIL.RU ИНФОРМЕР', 'mail_json_informer'); ?></h2>
           
			<form name="mail_json_informer" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=mail-json-informer.php&amp;updated=true">
			
				<!-- Имя mail_json_informer_form используется в check_admin_referer -->
				<?php 
					if (function_exists ('wp_nonce_field') )
					{
						wp_nonce_field('mail_json_informer_form'); 
					}
				?>
				
				<table class="form-table">	
				<tr valign="top" >					
						<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Новость 1 (с картинкой)', ''); ?></th>
						
					</tr>				
					<tr valign="top">

						<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Заголовок новости (максимум 75 с пробелами):', ''); ?></th>
						
						<td style="padding: 15px 0px">
							<input type="text" name="mail1_title" size="100" value="<?php echo $mail1_title; ?>" maxlength="75" required />
						</td>
					</tr>
						<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Post ID (копируется из вкладки в браузере):', ''); ?></th>
						
						<td style="padding: 15px 0px">
							<input type="text" name="postid1" size="100" value="<?php echo $postid1; ?>" />
						</td>
					</tr>
					
					<tr valign="top" >					
						<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Новость 2 (с картинкой)', ''); ?></th>
						
					</tr>				
					<tr valign="top">

						<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Заголовок новости (максимум 75 с пробелами):', ''); ?></th>
						
						<td style="padding: 15px 0px">
							<input type="text" name="mail2_title" size="100" value="<?php echo $mail2_title; ?>" maxlength="75" required />
						</td>
					</tr>
						<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Post ID (копируется из вкладки в браузере):', ''); ?></th>
						
						<td style="padding: 15px 0px">
							<input type="text" name="postid2" size="100" value="<?php echo $postid2; ?>" />
						</td>
					</tr>

					<tr valign="top" >					
						<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Новость 3', ''); ?></th>
						
					</tr>				
					<tr valign="top">

						<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Заголовок новости (максимум 75 с пробелами):', ''); ?></th>
						
						<td style="padding: 15px 0px">
							<input type="text" name="mail3_title" size="100" value="<?php echo $mail3_title; ?>" maxlength="75" required />
						</td>
					</tr>
						<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Post ID (копируется из вкладки в браузере):', ''); ?></th>
						
						<td style="padding: 15px 0px">
							<input type="text" name="postid3" size="100" value="<?php echo $postid3; ?>" />
						</td>
					</tr>

					<tr valign="top" >					
						<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Новость 4', ''); ?></th>
						
					</tr>				
					<tr valign="top">

						<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Заголовок новости (максимум 75 с пробелами):', ''); ?></th>
						
						<td style="padding: 15px 0px">
							<input type="text" name="mail4_title" size="100" value="<?php echo $mail4_title; ?>" maxlength="75" required />
						</td>
					</tr>
						<th scope="row" style="padding: 20px 10px 5px 0px; width: 350px"><?php _e('Post ID (копируется из вкладки в браузере):', ''); ?></th>
						
						<td style="padding: 15px 0px">
							<input type="text" name="postid4" size="100" value="<?php echo $postid4; ?>" />
						</td>
					</tr>
				</table>
				
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="page_options" value="mail1_title,postid1,mail2_title,postid2,mail3_title,postid3,mail4_title,postid4" />
		
				<p class="submit">
				<input type="submit" name="submit" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
		</div>
		<?php
	}
}

$mail_json_informer = new mail_json_informer();

?>