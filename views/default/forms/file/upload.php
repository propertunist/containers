<?php
/**
 * Elgg file upload/save form
 *
 * @package ElggFile
 */

// once elgg_view stops throwing all sorts of junk into $vars, we can use 
$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);

$guid = elgg_extract('guid', $vars, null);

if ($guid) {
	$file_label = elgg_echo("file:replace");
	$submit_label = elgg_echo('save');
} else {
	$file_label = elgg_echo("file:file");
	$submit_label = elgg_echo('upload');
}

?>
<div>
	<label><?php echo $file_label; ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'upload')); ?>
</div>
<div>
	<label><?php echo elgg_echo('title'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>
<div>
	<label><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>
<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>
<?php
if(elgg_is_active_plugin('file_tools'))
{
    if (file_tools_use_folder_structure()){
        $parent_guid = 0;
        if($file = elgg_extract("entity", $vars)){
            if($folders = $file->getEntitiesFromRelationship(FILE_TOOLS_RELATIONSHIP, true, 1)){
                $parent_guid = $folders[0]->getGUID();
            }
        }
        ?>
        <div>
            <label><?php echo elgg_echo("file_tools:forms:edit:parent"); ?><br />
            <?php
                echo elgg_view("input/folder_select", array("name" => "folder_guid", "value" => $parent_guid));     
            ?>
            </label>
        </div>
    <?php 
    }
}
$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}
$containers = elgg_view('input/containers', $vars);
if ($containers){
    echo $containers;
}

?>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>
<div class="elgg-foot">
<?php

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'file_guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => $submit_label));

?>
</div>
