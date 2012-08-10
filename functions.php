<?php
/*****************************************************
Pimp out this page with an endless amount of widget sections.
*****************************************************/

function getcustom($name){
	$name = get_post_custom_values($name);
	if ($name) return $name[0];
	else return false;
}

function outputcustom($name) {
	$output = getcustom($name);
	echo $output;
}

function get_category_id($cat_name) {
	$term = get_term_by('name', $cat_name, 'category');
	return $term->term_id;
}

if(function_exists('register_sidebar')) {

// Create widget names and put them in array
    $my_widget_name = array(
        __('Header'),
        __('Right Sidebar'),
        __('Footer'),
    );

// Define how we want our widgets to display
// Replace ridiculous list items with custom style
    foreach($my_widget_name as $my_widget) :
        register_sidebar(array(
            'name' => $my_widget,
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>', ));
    endforeach;
} 
?>
