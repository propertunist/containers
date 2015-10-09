<?php
$poll = elgg_extract('entity', $vars);
if ($poll) {
	$guid = $poll->guid;
} else  {
	$guid = 0;
}

$question = $vars['fd']['question'];
$description = $vars['fd']['description'];
$tags = $vars['fd']['tags'];
$access_id = $vars['fd']['access_id'];
?>

<div>
	<label><?php echo elgg_echo('poll:question'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'question', 'value' => $question)); ?>
</div>

<div>
	<label><?php echo elgg_echo('poll:description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $description)); ?>
</div>

<div>
	<label><?php echo elgg_echo('poll:responses'); ?></label>
	<?php echo elgg_view('poll/input/choices', array('poll' => $poll)); ?>
</div>

<?php
$allow_close_date = elgg_get_plugin_setting('allow_close_date','poll');
if ($allow_close_date == 'yes') {
	$close_date = $vars['fd']['close_date'];
?>
<div>
	<label><?php echo elgg_echo('poll:close_date'); ?></label>
	<?php echo  elgg_view('input/date', array('name' => 'close_date', 'timestamp' => true, 'value' => $close_date)); ?>
</div>
<?php
}
?>

<?php
$allow_open_poll = elgg_get_plugin_setting('allow_open_poll','poll');
if($allow_open_poll == 'yes') {
	$open_poll_input = '<p>';
	if ($vars['fd']['open_poll']) {
		$open_poll_input .= elgg_view('input/checkbox', array('name' => 'open_poll','value' => 1, 'checked' => 'checked'));
	} else {
		$open_poll_input .= elgg_view('input/checkbox', array('name' => 'open_poll','value' => 1));
	}
	$open_poll_input .= elgg_echo('poll:open_poll_label');
	$open_poll_input .= '</p>';
} else {
	$open_poll_input = '';
}
echo $open_poll_input;
?>

<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo  elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>

<div>
	<label><?php echo elgg_echo('access'); ?></label>
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>
<?php
$containers = elgg_view('input/containers', $vars);
if ($containers){
    echo $containers;
}

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

$poll_front_page = elgg_get_plugin_setting('front_page','poll');

if(elgg_is_admin_logged_in() && ($poll_front_page == 'yes')) {
	$front_page_input = '<p>';
	if ($vars['fd']['front_page']) {
		$front_page_input .= elgg_view('input/checkbox', array('name' => 'front_page','value' => 1, 'checked' => 'checked'));
	} else {
		$front_page_input .= elgg_view('input/checkbox', array('name' => 'front_page','value' => 1));
	}
	$front_page_input .= elgg_echo('poll:front_page_label');
	$front_page_input .= '</p>';
} else {
	$front_page_input = '';
}

echo $front_page_input . "<br>";

if (isset($vars['entity'])) {
	$entity_hidden = elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
} else {
	$entity_hidden = '';
}

$submit_input = elgg_view('input/submit', array('name' => 'submit', 'class' => 'elgg-button elgg-button-submit', 'value' => elgg_echo('save')));
$submit_input .= ' '.elgg_view('input/button', array('name' => 'cancel', 'id' => 'poll_edit_cancel', 'type'=> 'button', 'class' => 'elgg-button elgg-button-cancel', 'value' => elgg_echo('cancel')));

?>

<div class="elgg-foot">
<?php
echo $entity_hidden;
echo $submit_input;
?>
</div>

<script type="text/javascript">
$('#poll_edit_cancel').click(
	function() {
		window.location.href="<?php echo elgg_get_site_url().'poll/owner/'.(elgg_get_page_owner_entity()->username); ?>";
	}
);
</script>
