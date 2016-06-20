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
$upload_guids = (int) get_input('upload_guids');
$guid = elgg_extract('guid', $vars, null);

if ($guid) {
	$file_label = elgg_echo("file:replace");
	$submit_label = elgg_echo('save');
} else {
	$file_label = elgg_echo("file:file");
	$submit_label = elgg_echo('upload');
}

// Get post_max_size and upload_max_filesize
$post_max_size = elgg_get_ini_setting_in_bytes('post_max_size');
$upload_max_filesize = elgg_get_ini_setting_in_bytes('upload_max_filesize');

// Determine the correct value
$max_upload = $upload_max_filesize > $post_max_size ? $post_max_size : $upload_max_filesize;

$upload_limit = elgg_echo('file:upload_limit', array(elgg_format_bytes($max_upload)));

?>
<div class="mbm elgg-text-help">
	<?php echo $upload_limit; ?>
</div>
<div>
	<label><?php echo $file_label; ?></label><br />
	<?php 
        if (elgg_is_active_plugin('hypeDropzone'))
        {
            echo elgg_view('input/dropzone', array(
            'name' => 'upload_guids',
            'accept' => "*",
            'max' => 1,
            'multiple' => false,
            'container_guid' => $container_guid, // optional file container
            'subtype' => $subtype, // subtype of the file entities to be created
            ));
        }
        else
        {
            echo elgg_view('input/file', array('name' => 'upload')); 
        }?>
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

$containers = elgg_view('input/containers', $vars);
if ($containers){
    echo $containers;
}

?>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array(
		'name' => 'access_id',
		'value' => $access_id,
		'entity' => get_entity($guid),
		'entity_type' => 'object',
		'entity_subtype' => 'file',
	)); ?>
</div>
<?php
$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}
?>
<div class="elgg-foot">
<?php

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'file_guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => $submit_label));

?>
</div>
