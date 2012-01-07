<?php
/*
Plugin Name: CategoryTinymce
Plugin URI: http://ypraise.com/2012/01/wordpress-plugin-categorytinymce/
Description: Adds a tinymce enable box to the category descriptions page.
Version: 1.0
Author: Kevin Heath
Author URI: http://ypraise.com
License: GPL
*/
/*  Copyright 2011  Kevin Heath  (email : kevin@ypraise.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// lets remove the html filtering
   
	remove_filter( 'pre_term_description', 'wp_filter_kses' );
	remove_filter( 'term_description', 'wp_kses_data' );
	
// lets add our new cat description box	
   
define('description1', 'Category_Description_option');
add_filter('edit_category_form_fields', 'description1');

function description1($tag) {
    $tag_extra_fields = get_option(description1);
    ?>

<table class="form-table">
        <tr class="form-field">
            <th scope="row" valign="top"><label for="description"><?php _ex('Description', 'Taxonomy Description'); ?></label></th>
			<td>
	<?php  
	$settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'description' );	
	wp_editor(html_entity_decode($tag->description ), 'description1', $settings); ?>	
	<br />
	<span class="description"><?php _e('The description is not prominent by default, however some themes may show it.'); ?></span>
	</td>	
        </tr>
     
</table>
    <?php

}

// quick jquery to hide the default cat description box

function hide_category_description() {
      global $current_screen;
if ( $current_screen->id == 'edit-category' ) { 
?>
<script type="text/javascript">
jQuery(function($) {
 $('select#parent').closest('tr.form-field, div.form-field').hide(); $('textarea#description, textarea#tag-description').closest('tr.form-field, div.form-field').hide(); 
 }); 
 </script> <?php
 } 
	  } 
	  
// lets hide the cat description from the category admin page

add_action('admin_head', 'hide_category_description'); 


function manage_my_category_columns($columns)
{
 // only edit the columns on the current taxonomy
 if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'category' )
 return $columns;
 
 // unset the description columns
 if ( $posts = $columns['description'] ){ unset($columns['description']); }
 
 return $columns;
}
add_filter('manage_edit-category_columns','manage_my_category_columns');


// when a category is removed delete the new box

add_filter('deleted_term_taxonomy', 'remove_Category_Extras');
function remove_Category_Extras($term_id) {
  if($_POST['taxonomy'] == 'category'):
    $tag_extra_fields = get_option(Category_Extras);
    unset($tag_extra_fields[$term_id]);
    update_option(Category_Extras, $tag_extra_fields);
  endif;
}
?>