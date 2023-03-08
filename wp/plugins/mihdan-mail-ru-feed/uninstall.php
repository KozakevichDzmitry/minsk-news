<?php
/**
 * Fired when the plugin is uninstalled.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Удалить все настройки плагина.
delete_option( 'mihdan_mail_ru_feed' );
delete_option( 'mihdan_mail_ru_feed-transients' );

// eof;
