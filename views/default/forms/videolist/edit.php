<?php
/**
 * Videolist edit form body
 *
 * @package ElggVideolist
 */

$variables = elgg_get_config('videolist');

if(empty($vars['guid'])){
	unset($variables['title']);
	unset($variables['description']);
} else {
	unset($variables['video_url']);
}

foreach ($variables as $name => $type) {
?>
<div>
	<label><?php echo elgg_echo("videolist:$name") ?></label>
	<?php
		if ($type != 'longtext') {
			echo '<br />';
		}
	?>
	<?php echo elgg_view("input/$type", array(
			'name' => $name,
			'value' => $vars[$name],
		));
	?>
</div>
<?php
}

$cats = elgg_view('categories', $vars);
if (!empty($cats)) {
	echo $cats;
}

echo elgg_view('input/containers', $vars);

echo '<div class="elgg-foot">';
if ($vars['guid']) {
	echo elgg_view('input/hidden', array(
		'name' => 'video_guid',
		'value' => $vars['guid'],
	));
}


echo elgg_view('input/submit', array('value' => elgg_echo('save')));

echo '</div>';
