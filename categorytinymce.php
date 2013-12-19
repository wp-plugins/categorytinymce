<?php
/*
Plugin Name: CategoryTinymce
Plugin URI: http://ypraise.com/2012/01/wordpress-plugin-categorytinymce/
Description: Adds a tinymce enable box to the category descriptions and taxonomy page.
Version: 2.1
Author: Kevin Heath
Author URI: http://ypraise.com
License: GPL
*/
/*  Copyright 2013  Kevin Heath  (email : kevin@ypraise.com)

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

	
// add extra css to display quicktags correctly
add_action( 'admin_print_styles', 'categorytinymce_admin_head' );


function categorytinymce_admin_head() { ?>
<style type="text/css">
  .quicktags-toolbar input{float:left !important; width:auto !important;}
  </style>
<?php	} 

	
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
		wp_editor(html_entity_decode($tag->description , ENT_QUOTES, 'UTF-8'), 'description1', $settings); ?>	
	<br />
	<span class="description"><?php _e('The description is not prominent by default, however some themes may show it.'); ?></span>
	</td>	
        </tr>
     
</table>
    <?php

}

//add extra fields to category edit form hook
add_action ( 'edit_category_form_fields', 'extra_category_fields');
//add extra fields to category edit form callback function
function extra_category_fields( $tag ) {    //check for existing featured ID
    $t_id = $tag->term_id;
    $cat_meta = get_option( "category_$t_id");
?>
<table class="form-table">
<tr class="form-field">
<th scope="row" valign="top"><label for="bottomdescription"><?php _e('Bottom Description'); ?></label></th>
<td>
<?php  
	$settings = array('wpautop' => false, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'Cat_meta[bottomdescription]' );	
		wp_editor(html_entity_decode($cat_meta['bottomdescription'] , ENT_QUOTES, 'UTF-8'), 'Cat_meta[bottomdescription]', $settings); ?>	
	<br />


            <span class="description"><?php _e('Bottom description'); ?></span><div style="both:clear;"></div>
        </td>
</tr>

<tr></tr>
<tr class="form-field">
<th scope="row" valign="top"><label for="cat_Image_url"><?php _e('Category Image Url'); ?></label></th>
<td>
<input type="text" name="Cat_meta[img]" id="Cat_meta[img]" size="3" style="width:60%;" value="<?php echo $cat_meta['img'] ? $cat_meta['img'] : ''; ?>"><br />
            <span class="description"><?php _e('Image for category: use full url with http://'); ?></span>
        </td>
</tr>
</table>
<?php
}



// save extra category extra fields hook
add_action ( 'edited_category', 'save_extra_category_fileds');
   // save extra category extra fields callback function
function save_extra_category_fileds( $term_id ) {
    if ( isset( $_POST['Cat_meta'] ) ) {
        $t_id = $term_id;
        $cat_meta = get_option( "category_$t_id");
        $cat_keys = array_keys($_POST['Cat_meta']);
            foreach ($cat_keys as $key){
            if (isset($_POST['Cat_meta'][$key])){
                $cat_meta[$key] = $_POST['Cat_meta'][$key];
            }
        }
        //save the option array
        update_option( "category_$t_id", $cat_meta );
    }
}







// lets add our new tag description box	
   
define('description2', 'Tag_Description_option');
add_filter('edit_tag_form_fields', 'description2');

function description2($tag) {
    $tag_extra_fields = get_option(description1);
    ?>

<table class="form-table">
        <tr class="form-field">
            <th scope="row" valign="top"><label for="description"><?php _ex('Description', 'Taxonomy Description'); ?></label></th>
			<td>
	<?php  
	$settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'description' );	
	wp_editor(html_entity_decode($tag->description , ENT_QUOTES, 'UTF-8'), 'description2', $settings ); ?>	
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
 $('select#description').closest('tr.form-field').hide(); $('textarea#description, textarea#tag-description').closest('tr.form-field').hide(); 
 }); 
 </script> <?php
 } 
	  } 
	  
	  // quick jquery to hide the default tag description box

function hide_tag_description() {
      global $current_screen;
if ( $current_screen->id == 'edit-'.$current_screen->taxonomy ) {
?>
<script type="text/javascript">
jQuery(function($) {
 $('select#description').closest('tr.form-field').hide(); $('textarea#description, textarea#tag-description').closest('tr.form-field').hide(); 
 }); 
 </script> <?php
 } 
	  } 
	  
// lets hide the cat description from the category admin page

add_action('admin_head', 'hide_category_description'); 
add_action('admin_head', 'hide_tag_description'); 




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

function manage_my_tag_columns($columns)
{
 // only edit the columns on the current taxonomy
 if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'post_tag' )
 return $columns;
 
 // unset the description columns
 if ( $posts = $columns['description'] ){ unset($columns['description']); }
 
 return $columns;
}
add_filter('manage_edit-post_tag_columns','manage_my_tag_columns');

add_filter('term_description', 'do_shortcode');
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