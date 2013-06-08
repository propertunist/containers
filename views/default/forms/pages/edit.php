<?php
/**
 * Page edit form body
 *
 * @package ElggPages
 */

$variables = elgg_get_config('pages');
$user = elgg_get_logged_in_user_entity();
$entity = elgg_extract('entity', $vars);
if (elgg_is_active_plugin('pages_tools'))
{
    $yesno_options = array(
        "yes" => elgg_echo("option:yes"),
        "no" => elgg_echo("option:no")
    );
    
    // comments allowed
    $allow_comments = "yes";
    if(!empty($entity)){
        $allow_comments = $entity->allow_comments;
    }
}    

$can_change_access = true;
if ($user && $entity) {
	$can_change_access = ($user->isAdmin() || $user->getGUID() == $entity->owner_guid);
}

foreach ($variables as $name => $type) {
	// don't show read / write access inputs for non-owners or admin when editing
	if (($type == 'access' || $type == 'write_access') && !$can_change_access) {
		continue;
	}
	
	// don't show parent picker input for top or new pages.
	if ($name == 'parent_guid' && (!$vars['parent_guid'] || !$vars['guid'])) {
		continue;
	}

	if ($type == 'parent') {
		$input_view = "pages/input/$type";
	} else {
		$input_view = "input/$type";
	}

?>
<div>
	<label><?php echo elgg_echo("pages:$name") ?></label>
	<?php
		if ($type != 'longtext') {
			echo '<br />';
		}

		echo elgg_view($input_view, array(
			'name' => $name,
			'value' => $vars[$name],
			'entity' => ($name == 'parent_guid') ? $vars['entity'] : null,
		));
	?>
</div>
<?php
}

$cats = elgg_view('input/categories', $vars);
if (!empty($cats)) {
	echo $cats;
}

$containers = elgg_view('input/containers', $vars);
if ($containers){
    echo $containers;
}

if (elgg_is_active_plugin('pages_tools')){
    // add support to disable commenting
    echo "<div>";
    echo "<label>" . elgg_echo("pages_tools:allow_comments") . "</label>";
    echo "<br />";
    echo elgg_view("input/dropdown", array("name" => "allow_comments", "value" => $allow_comments, "options_values" => $yesno_options));
    echo "</div>";
    
    // advanced puplication options
    if(pages_tools_use_advanced_publication_options()){
        if(!empty($entity)){
            $publication_date_value = $entity->publication_date;
            $expiration_date_value = $entity->expiration_date;
        }
        
        if(empty($publication_date_value)){
            $publication_date_value = "";
        }
        
        if(empty($expiration_date_value)){
            $expiration_date_value = "";
        }
        
        $publication_date = "<div class='mbs'>";
        $publication_date .= "<label for='publication_date'>" . elgg_echo("pages_tools:label:publication_date") . "</label>";
        $publication_date .= elgg_view("input/date", array(
                                        "name" => "publication_date", 
                                        "value" => $publication_date_value));
        $publication_date .= "<div class='elgg-subtext'>" . elgg_echo("pages_tools:publication_date:description") . "</div>";
        $publication_date .= "</div>";
        
        $expiration_date = "<div class='mbs'>";
        $expiration_date .= "<label for='expiration_date'>" . elgg_echo("pages_tools:label:expiration_date") . "</label>";
        $expiration_date .= elgg_view("input/date", array(
                                        "name" => "expiration_date", 
                                        "value" => $expiration_date_value));
        $expiration_date .= "<div class='elgg-subtext'>" . elgg_echo("pages_tools:expiration_date:description") . "</div>";
        $expiration_date .= "</div>";
        
        echo elgg_view_module("info", elgg_echo("pages_tools:label:publication_options"), $publication_date . $expiration_date);
    }
    
    // final part of the form
    echo "<div class='elgg-foot'>";
    // send the guid of the page we"re editing
    if ($guid = elgg_extract("guid", $vars)) {
        echo elgg_view("input/hidden", array("name" => "page_guid", "value" => $guid));
    }

    // send the parent guid of the page (on new pages only)
    if (!$vars["guid"] && ($parent_guid = elgg_extract("parent_guid", $vars))) {
        echo elgg_view("input/hidden", array("name" => "parent_guid", "value" => $parent_guid));
    }
}
else 
{
    echo '<div class="elgg-foot">';
    if ($vars['guid']) {
    	echo elgg_view('input/hidden', array(
    		'name' => 'page_guid',
    		'value' => $vars['guid'],
    	));
    }
    
    if (!$vars['guid']) {
    	echo elgg_view('input/hidden', array(
    		'name' => 'parent_guid',
    		'value' => $vars['parent_guid'],
    	));
    }
}
echo elgg_view('input/submit', array('value' => elgg_echo('save')));

echo '</div>';
