<?php
/**
 * Edit blog form
 *
 * @package Blog
 */

$blog = get_entity($vars['guid']);
$vars['entity'] = $blog;

$draft_warning = $vars['draft_warning'];
if ($draft_warning) {
	$draft_warning = '<span class="mbm elgg-text-help">' . $draft_warning . '</span>';
}

$action_buttons = '';
$delete_link = '';
$preview_button = '';

if ($vars['guid']) {
	// add a delete button if editing
	$delete_url = "action/blog/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/url', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete float-alt',
		'confirm' => elgg_echo('deleteconfirm')
	));
}

// published blogs do not get the preview button
if (!$vars['guid'] || ($blog && $blog->status != 'published')) {
	$preview_button = elgg_view('input/submit', array(
		'value' => elgg_echo('preview'),
		'name' => 'preview',
		'class' => 'elgg-button-action mls',
	));
}

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
	'name' => 'save',
));

$action_buttons = $save_button . $preview_button . $delete_link;

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'blog_title',
	'value' => $vars['title']
));

$excerpt_label = elgg_echo('blog:excerpt');
$excerpt_input = elgg_view('input/text', array(
	'name' => 'excerpt',
	'id' => 'blog_excerpt',
	'value' => elgg_html_decode($vars['excerpt'])
));


if (elgg_plugin_exists('blog_tools'))
{
  $icon_remove_input = "";
  if($vars["guid"]){
      $icon_label = elgg_echo("blog_tools:label:icon:exists");

	if ($blog->icontime) {
		$icon_remove_input = '<br />';
		$icon_remove_input .= elgg_view('output/img', [
			'src' => $blog->getIconURL(),
			'alt' => $blog->title,
		]);
		$icon_remove_input .= '<br />';
		$icon_remove_input .= elgg_view('input/checkbox', [
			'name' => 'remove_icon',
			'value' => 'yes',
			'label' => elgg_echo('blog_tools:label:icon:remove'),
		]);
		}
    } else {
        $icon_label = elgg_echo("blog_tools:label:icon:new");
    }
    $icon_input = elgg_view("input/file", array(
        "name" => "icon",
        "id" => "blog_icon",
    ));
}

$body_label = elgg_echo('blog:body');
$body_input = elgg_view('input/longtext', array(
	'name' => 'description',
	'id' => 'blog_description',
	'value' => $vars['description']
));

$save_status = elgg_echo('blog:save_status');
if ($vars['guid']) {
	$entity = get_entity($vars['guid']);
	$saved = date('F j, Y @ H:i', $entity->time_created);
} else {
	$saved = elgg_echo('never');
}

// advanced publication options
if(elgg_is_active_plugin('blog_tools'))
{
    // publication options
    $status = "<div class='mbs'>";
    $status .= "<label for='blog_status'>" . elgg_echo('status') . "</label><br/>";
    $status .=  elgg_view('input/dropdown', array(
        'name' => 'status',
        'id' => 'blog_status',
        'value' => $vars['status'],
        'options_values' => array(
            'draft' => elgg_echo('status:draft'),
            'published' => elgg_echo('status:published')
        ),
				'class' => 'mls',
    ));
    $status .= "</div>";

		// advanced publication options
		$publication_options = $status;
    if(blog_tools_use_advanced_publication_options()){
        if(!empty($blog)){
            $publication_date_value = elgg_extract("publication_date", $vars, $blog->publication_date);
            $expiration_date_value = elgg_extract("expiration_date", $vars, $blog->expiration_date);
        } else {
            $publication_date_value = elgg_extract("publication_date", $vars);
            $expiration_date_value = elgg_extract("expiration_date", $vars);
        }

        if(empty($publication_date_value)){
            $publication_date_value = "";
        }
        if(empty($expiration_date_value)){
            $expiration_date_value = "";
        }

        $publication_date = "<div class='mbs'>";
        $publication_date .= "<label for='publication_date'>" . elgg_echo("blog_tools:label:publication_date") . "</label>";
        $publication_date .= elgg_view("input/date", array(
                                    "name" => "publication_date",
                                    "value" => $publication_date_value));
        $publication_date .= "<div class='elgg-subtext'>" . elgg_echo("blog_tools:publication_date:description") . "</div>";
        $publication_date .= "</div>";

        $expiration_date = "<div class='mbs'>";
        $expiration_date .= "<label for='expiration_date'>" . elgg_echo("blog_tools:label:expiration_date") . "</label>";
        $expiration_date .= elgg_view("input/date", array(
                                    "name" => "expiration_date",
                                    "value" => $expiration_date_value));
        $expiration_date .= "<div class='elgg-subtext'>" . elgg_echo("blog_tools:expiration_date:description") . "</div>";
        $expiration_date .= "</div>";

        $publication_options = elgg_view_module("info", elgg_echo("blog_tools:label:publication_options"), $status . $publication_date . $expiration_date);
    } else {
        $publication_options = $status;
    }

		// show owner
	$show_owner_setting = elgg_get_plugin_setting("show_full_owner", "blog_tools");

	if (empty($show_owner_setting)) {
		$show_owner_setting = "no";
	}

	if (empty($blog)) {
		$show_owner_value = elgg_extract("show_owner", $vars, $show_owner_setting);
	} else {
		$show_owner_value = elgg_extract('show_owner', $vars, $blog->show_owner);
	}

	if ($show_owner_setting == "optional") {
		$show_owner_input = elgg_view('input/select', [
			'name' => 'show_owner',
			'id' => 'blog_show_owner',
			'class' => 'mls',
			'value' => $show_owner_value,
			'options_values' => [
				'no' => elgg_echo('option:no'),
				'yes' => elgg_echo('option:yes'),
			],
		]);
	} else {
		$show_owner_input = elgg_view('input/hidden', array(
			'name' => 'show_owner',
			'id' => 'blog_show_owner',
			'value' => $show_owner_value,
		));
	}
}
else
{
    $status_label = elgg_echo('status');
    $status_input = elgg_view('input/select', array(
    'name' => 'status',
    'id' => 'blog_status',
    'value' => $vars['status'],
    'options_values' => array(
        'draft' => elgg_echo('status:draft'),
        'published' => elgg_echo('status:published')
    )
));

}

$comments_label = elgg_echo('comments');
$comments_input = elgg_view('input/select', array(
	'name' => 'comments_on',
	'id' => 'blog_comments_on',
	'value' => $vars['comments_on'],
	'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off'))
));

$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array(
	'name' => 'tags',
	'id' => 'blog_tags',
	'value' => $vars['tags']
));

$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array(
	'name' => 'access_id',
	'id' => 'blog_access_id',
	'value' => $vars['access_id'],
	'entity' => $vars['entity'],
	'entity_type' => 'object',
	'entity_subtype' => 'blog',
));

$categories_input = elgg_view('input/categories', $vars);
$container_input = elgg_view('input/containers', $vars);
// hidden inputs
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));


echo ($draft_warning .
'<div>
	<label for="blog_title">' . $title_label . '</label><br/>' .
	$title_input .
'</div>

<div>
	<label for="blog_excerpt">' . $excerpt_label . '</label><br/>' .
	$excerpt_input .
'</div>');

if (elgg_is_active_plugin('blog_tools'))
{
echo '<div>
    <label for="blog_icon">' . $icon_label . '</label><br/>' .
    $icon_input .
    $icon_remove_input .
'</div>';
}

echo '<div>
	<label for="blog_description">' . $body_label . '</label>' .
	$body_input .
'</div>' .

'<div>
	<label for="blog_tags">' . $tags_label . '</label><br/>' .
	$tags_input .
'</div>';
echo '<div>
	<label for="blog_access_id">' . $access_label . '</label><br/>' .
	$access_input .
'</div>' .
$container_input .
'<div>
	<label for="blog_comments_on">' . $comments_label . '</label><br/>' .
	$comments_input .
'</div>';
if (elgg_is_active_plugin('blog_tools'))
{
	// show owner information
	if ($show_owner_setting == "optional") {
		echo "<div>";
		echo "<label for='blog_show_owner'>" . elgg_echo('blog_tools:label:show_owner') . "</label>";
		echo $show_owner_input;
		echo "</div>";
	} else {
		echo $show_owner_input;
	}
}

echo $categories_input;
if (elgg_is_active_plugin('blog_tools'))
    echo $publication_options;
else {
	echo '<div>
    <label for="blog_status">' . $status_label . '</label><br/>' .
    $status_input .
'</div>';
}
echo '<div class="elgg-foot">
	<div class="elgg-subtext mbm">' .
	$save_status . '<span class="blog-save-status-time">' . $saved . '</span>
	</div>' .

	$guid_input .

	$action_buttons .
'</div>';
