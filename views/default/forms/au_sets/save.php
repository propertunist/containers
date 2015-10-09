<?php

$set = get_entity($vars['guid']);
$vars['entity'] = $set;
$pin = get_input('pin');

$action_buttons = '';
$delete_link = '';

if ($vars['guid']
	&& (($set->owner_guid == elgg_get_logged_in_user_guid())
		|| elgg_is_admin_logged_in()
			)) {
	// add a delete button if editing AND we're the owner
	$delete_url = "action/au_set/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/url', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete float-alt',
		'confirm' => elgg_echo('deleteconfirm')
	));
}

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
	'name' => 'save',
));
$action_buttons = $save_button . $delete_link;

$icon_label = elgg_echo('au_sets:label:icon');
$icon_input = elgg_view("input/file", array('name' => 'icon'));

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'au_set_title',
	'value' => $vars['title']
));


$body_label = elgg_echo('au_sets:body');
$body_input = elgg_view('input/longtext', array(
	'name' => 'description',
	'id' => 'au_set_description',
	'value' => $vars['description']
));


$comments_label = elgg_echo('comments');
$comments_input = elgg_view('input/dropdown', array(
	'name' => 'comments_on',
	'id' => 'au_set_comments_on',
	'value' => $vars['comments_on'],
	'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off'))
));

$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array(
	'name' => 'tags',
	'id' => 'au_set_tags',
	'value' => $vars['tags']
));

$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array(
	'name' => 'access_id',
	'id' => 'au_set_access_id',
	'value' => $vars['access_id']
));

$access_options = get_write_access_array();
unset($access_options[ACCESS_PUBLIC]);
$write_access_label = elgg_echo('au_sets:label:write_access');
$write_access_input = elgg_view('input/access', array(
	'name' => 'write_access_id',
	'id' => 'au_set_write_access_id',
	'value' => $vars['write_access_id'],
	'options_values' => $access_options
));
$write_access_help = elgg_view('output/longtext', array(
	'value' => elgg_echo('au_sets:write_access:help'),
	'class' => 'elgg-subtext'
));

$categories_input = elgg_view('input/categories', $vars);
$container_input = elgg_view('input/containers', $vars);
// hidden inputs
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));


// Layout
$layout_label = elgg_echo('au_sets:label:layout');
$layout_input = elgg_view('au_sets/input/layout', $vars);
$layout_help = elgg_view('output/longtext', array(
	'value' => elgg_echo('au_sets:label:layout:helptext'),
	'class' => 'elgg-subtext'
));

// autopin
$pin_input = '';
if ($pin) {
	$pin_input = elgg_view('input/hidden', array('name' => 'pin', 'value' => $pin));
}

echo <<<___HTML

<div>
	<label for="au_set_icon">$icon_label</label>
	$icon_input
</div>

<div>
	<label for="au_set_title">$title_label</label>
	$title_input
</div>

<div>
	<label for="au_set_description">$body_label</label>
	$body_input
</div>

<div>
	<label for="au_set_tags">$tags_label</label>
	$tags_input
</div>
        
<div>
	<label for="au_set_access_id">$access_label</label>
	$access_input
</div>

<div>
	<label for="au_set_write_access_id">$write_access_label</label>
	$write_access_input
	$write_access_help
</div>   
        
$container_input

<div>
	<label for="au_set_comments_on">$comments_label</label>
	$comments_input
</div>

$categories_input        
        
   <div>
	<label for="au_set_layout">$layout_label</label>
	$layout_help
	$layout_input
</div>

<div class="elgg-foot">

	$guid_input

	$pin_input
	$action_buttons
</div>

___HTML;
