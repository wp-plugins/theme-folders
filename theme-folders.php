<?php
/*
Plugin Name: Theme Folders
Plugin URI: http://www.wp-plugin-dev.com
Description: Add folders to themes
Author: wp-plugin-dev.com
Version: 0.11
Author URI: http://www.wp-plugin-dev.com
*/

//apply_filters("theme_root","tr");
global $wp_theme_directories;


$theme_folders=explode(", ", get_option('design_folders'));
foreach ($theme_folders as $theme_register_dir){
register_theme_directory("".$theme_register_dir."");
}
//register_theme_directory

//echo "<hr>";
//$wp_theme_directories[0]="/Applications/MAMP/htdocs/tt/wp-content/designs";
//$wp_theme_directories[1]="/Applications/MAMP/htdocs/tt/wp-content/themes";;
//print_r($wp_theme_directories);
//array_pop ($wp_theme_directories);
//echo "<style>.theme-browser{display:none;}</style>";

function remove_menus(){
  
  //remove_submenu_page( 'themes.php','themes.php' );                  //Dashboard
  add_theme_page(__('Theme Folders'), __('Theme Folders'), 'edit_theme_options', 'themes-in-folders','themes_in_folders');

}
add_action( 'admin_menu', 'remove_menus' );

function themes_in_folders(){
global $wp_theme_directories;


if(isset($_POST['design_folders'])){
$folder_vars=update_option("design_folders",$_POST['design_folders']);
$folder_vars=get_option("design_folders");

}else{
$folder_vars=get_option("design_folders");
}
echo "<div id=\"wrap\">";
?>
<div class="wrap">

<h2><img src="<?php echo $icons_url=get_bloginfo('url')."/wp-content/plugins/theme-folders/icons/"; echo "folder32.png"; ?>" /><?php _e('Theme Folders'); ?></h2>
<form method="post">
Theme Folders <input type="text" value="<?php echo $folder_vars; ?>" size=50 name="design_folders" /><small>(divided by comma + space ", ")</small><br />
<input type="submit" class="button" />
</form>
<style>
#theme_folder_item{display:inline-block;background: white; width:102px; border: 2px solid lightgray; padding:3px; margin:5px;vertical-align:middle;}
</style><br /><br />
<?php
echo "<hr>";
/*
print_r($wp_theme_directories);
echo "<hr>";*/
foreach ($wp_theme_directories as $themes){

$themefolder=explode("/",$themes);
$last=count($themefolder);
$themefolder=$themefolder[$last-1];

echo "<img src='".$icons_url."folder.png' /> ";
echo "<b>".$themefolder."</b><br>";
$my_theme_folders=glob($themes."/*");
foreach ($my_theme_folders as $theme){
$themefolder2=explode("/",$theme);
$last=count($themefolder2);
$nonce=wp_nonce_url("".get_bloginfo('url')."/wp-content/".$themefolder."/".$themefolder2[$last-1]."");
echo "<div id=\"theme_folder_item\">";
echo "".$themefolder2[$last-1]."";

// http://192.168.222.30:8888/tt/wp-admin/customize.php?theme=bluex
//http://192.168.222.30:8888/tt/wp-admin/themes.php?action=delete&stylesheet=bluesky&_wpnonce=delete-theme_bluesky
//http://192.168.222.30:8888/tt/wp-admin/theme-editor.php

echo "<img alt='".$themefolder2[$last-1]."' src='".get_bloginfo('url')."/wp-content/".$themefolder."/".$themefolder2[$last-1]."/screenshot.png' width=100 height=50 /></a>";
echo "<a href='".get_bloginfo('url')."/wp-admin/themes.php?action=activate&stylesheet=".$themefolder2[$last-1]."&_wpnonce=".wp_create_nonce("switch-theme_".$themefolder2[$last-1])."' >";
echo "<img src='".$icons_url."document-save.png' /></a> ";
echo "<a href='".get_bloginfo('url')."/wp-admin/customize.php?theme=".$themefolder2[$last-1]."' >";
echo "<img src='".$icons_url."edit-find.png' /></a>";

echo "<form action='../wp-admin/theme-editor.php' method='post'>";
echo "<input type=\"hidden\" name=\"theme\" value=\"".$themefolder2[$last-1]."\" />";
echo "<input type='image' name='cmdSubmit' alt='Submit Form' src='".$icons_url."document-properties.png' value='Submit' style='height:20px;' /></form>";

echo "<a href='".get_bloginfo('url')."/wp-admin/themes.php?action=delete&stylesheet=".$themefolder2[$last-1]."&_wpnonce=".wp_create_nonce("delete-theme_".$themefolder2[$last-1])."' >";
echo "<img src='".$icons_url."edit-delete.png' /></a>";

echo "</div>";
//echo "idi=".wp_create_nonce('twentytwelve')." = 01b31ef862<br>";
}

echo "<hr>";
}
echo "</div>";
}

?>