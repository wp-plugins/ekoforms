<?php

/*
Plugin Name: Axial EKOForms
Plugin URI: http://ekoforms.com/
Description: Embed your EKOForms using shortcodes within seconds.
Author: David Gagnon Marchand
Author URI: http://gagnongraphisme.startlogic.com/dgm/
Version: 1.0
*/

register_activation_hook ( __FILE__, 'dgm_axialekoforms_install' );

function dgm_axialekoforms_install() {
	if ( version_compare( get_bloginfo( 'version' ), '3.1', '<' ) ) {
		deactivate_plugins( basename( __FILE__ ) );
	}	
}

add_action( 'admin_menu', 'dgm_axialekoforms_create_menu' );

function dgm_axialekoforms_create_menu() {
	//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	add_menu_page( __('Axial EKOForms Information'), __('Axial EKOForms'), 'manage_options', __FILE__, 'dgm_axialekoforms_info_page', plugins_url( '/images/wp-icon.png', __FILE__ ) ); 
}


function dgm_axialekoforms_info_page() {
	echo '<div class="wrap">';
	echo '<div id="icon-edit-pages" class="icon32"><br /></div>';
	echo '<h2>'; _e( 'Axial EKOForms Documentation'); echo '</h2>';
	echo '<table class="widefat">';
	echo '<thead>';
	echo '	<tr>';
	echo '		<th>Shortcode</th>';
	echo '		<th>Definition</th>';
	echo '		<th>Default</th>';
	echo '		<th>Example</th>';
	echo '	</tr>';
	echo '</thead>';
	echo '<tbody>';
	echo '	<tr>';
	echo '		<th>[eko]</th>';
	echo '		<td>This is the most basic usage of this plugin. <strong>It doesn\'t do anything on it\'s own.</strong></td>';
	echo '		<td></td>';
	echo '		<td>[eko]</td>';
	echo '	</tr>';
	echo '</tbody>';
	echo '<thead>';
	echo '	<tr>';
	echo '		<th>Attribute</th>';
	echo '		<th>Definition</th>';
	echo '		<th>Default</th>';
	echo '		<th>Example</th>';
	echo '	</tr>';
	echo '</thead>';
	echo '<tbody>';
	echo '	<tr>';
	echo '		<th>url</th>';
	echo '		<td>Used to specify which website to embed.</td>';
	echo '		<td>http://www.google.com</td>';
	echo '		<td>[eko url=http://ekoforms.com/your-form]</td>';
	echo '	</tr>';
	echo '	<tr>';
	echo '		<th>width</th>';
	echo '		<td>Used to specify the form\'s width in pixels or percentage. If not specified, the form will use 100% of the space available.</td>';
	echo '		<td>100%</td>';
	echo '		<td>[eko width=800]</td>';
	echo '	</tr>';
	echo '	<tr>';
	echo '		<th>height</th>';
	echo '		<td>Used to specify the form\'s height in pixels <strong>only</strong>. If not specified, it will be set to 650px.</td>';
	echo '		<td>100%</td>';
	echo '		<td>[eko height=600]</td>';
	echo '	</tr>';
	echo '	<tr>';
	echo '		<th>border</th>';
	echo '		<td>Choosing between yes or no will make the border appear or hide.</td>';
	echo '		<td>no</td>';
	echo '		<td>[eko border=yes]</td>';
	echo '	</tr>';
	echo '	<tr>';
	echo '		<th>scrolling</th>';
	echo '		<td>Choosing between yes or no will make the scrollbar appear or hide. "Auto" will make the scrollbar appear only if the content overflows the form\'s container.</td>';
	echo '		<td>auto</td>';
	echo '		<td>[eko scrolling=yes]</td>';
	echo '	</tr>';
	echo '		<th>transparency</th>';
	echo '		<td>If you form is using transparent background, you may not specify this, because it forces transparency by default. Choose no if the page you want to embed your form in make the design clash.</td>';
	echo '		<td>yes</td>';
	echo '		<td>[eko transparency=no]</td>';
	echo '	</tr>';
	echo '		<th>id</th>';
	echo '		<td>Use this ID to style your iframe as you wish.</td>';
	echo '		<td>axialdev-ekoforms-iframe</td>';
	echo '		<td>[eko id=custom-id]</td>';
	echo '	</tr>';
	echo '	</tr>';
	echo '		<th>class</th>';
	echo '		<td>Use this CLASS to style your iframe as you wish.</td>';
	echo '		<td>axialdev-ekoforms-iframe-class</td>';
	echo '		<td>[eko class=custom-class]</td>';
	echo '	</tr>';
	echo '</tbody>';
	echo '</table>';
	
	//echo '<p>'; _e( 'Here is where we teach people how to use the shortcode and what options are available to them.', 'dgm-axialekoforms' ); echo '</p>';
	echo '<p>To do : formulaire pour g&eacute;n&eacute;rer automatiquement le iframe avec un preview et le code pour embed.</p>';
	echo '</div>';
}

add_shortcode( 'eko', 'dgm_axialekoforms_eko' );

function dgm_axialekoforms_eko( $attr ) {

// marginwidth, marginheight ??

	if ( isset( $attr['url'] ) ) {
		//$url = preg_replace( '/[^\d]/', '', $attr['url'] );
		$url = esc_html($attr['url']);
	} else {
		$url = 'http://www.google.com';
	}
	
	if ( isset( $attr['width'] ) && !preg_match('/[^0-9]/', $attr['width'] ) ) {
		$width = $attr['width'];
	} else {
		$width = '100%';
	}
	
	if ( isset( $attr['height'] ) && !preg_match('/[^0-9]/', $attr['height'] ) && $attr['height']) {
		$height = $attr['height'];
	} else {
		$height = '650';
	}
	
	if ( isset( $attr['border'] ) && ( $attr['border'] == 'yes' || $attr['border'] == 'no' ) ) { 
		if ( $attr['border'] == 'yes' ) {
			$border = '1';
		} else {
			$border = '0';
		}
	} else {
		$border = '0';
	}
	
	if ( isset( $attr['scrolling'] ) && ( $attr['scrolling'] == 'yes' || $attr['scrolling'] == 'no' || $attr['scrolling'] == 'auto' ) ) {
		$scrolling = $attr['scrolling'];
	} else {
		$scrolling = 'auto';
	}
	
	if ( isset( $attr['transparency'] ) && ( $attr['transparency'] == 'yes' || $attr['transparency'] == 'no' ) ) {
		if ( $attr['transparency'] == 'yes' ) {
			$transparency = 'true';
		} else {
			$transparency = 'false';
		}
	} else {
		$transparency = 'true';
	}
	
	if ( isset( $attr['id'] ) ) {
		$id = esc_html($attr['id']);
	} else {
		$id = 'axialdev-ekoforms-iframe';
	}
	
	if ( isset( $attr['class'] ) ) {
		$class = esc_html($attr['class']);
	} else {
		$class = 'axialdev-ekoforms-iframe-class';
	}
	
	

	
	return "<iframe src='$url' width='$width' height='$height' frameborder='$border' scrolling='$scrolling' allowTransparency='$transparency' id='$id' class='$class'><p>Your browser does not support iframes.</p></iframe>";
}



?>
