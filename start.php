<?php
/**
 * Elgg containers plugin
 *
 * @package Elggcontainers
 */

elgg_register_event_handler('init', 'system', 'containers_init');

/**
 * Initialise containers plugin
 *
 */
function containers_init() {

	elgg_extend_view('css/elgg', 'containers/css');
    elgg_extend_view('object/summary/extend', 'output/containers', 0);
    //elgg_extend_view('forms/blog/save', 'input/containers', 500);
	//elgg_register_page_handler('containers', 'containers_page_handler');

	elgg_register_event_handler('update', 'all', 'container_save');
	elgg_register_event_handler('create', 'all', 'container_save');

	// To keep the container plugins in the settings area and because we have to do special stuff,
	// handle saving ourself.
	//elgg_register_plugin_hook_handler('action', 'plugins/settings/save', 'containers_save_site_containers');
}


/**
 * container page handler
 * @return bool
 */
//function containers_page_handler() {
//	include(dirname(__FILE__) . "/pages/containers/listing.php");
//	return true;
//}

/**
 * Save containers to object upon save / edit
 *
 */
function container_save($event, $object_type, $object) {
    ?>
    <script language="javascript">
alert('test')
</script>
<?php
    
	if ($object instanceof ElggEntity) {
		//$marker = get_input('container_marker');
    	//	if ($marker == 'on') {
	            $container = get_input('container_guid');
			if (!empty($container)) {
	//			$container = array();
	//	}

			$object->setContainerGUID($container);
		}
	return TRUE;
    }
}

/**
 * Saves the site containers.
 *
 * @param type $hook
 * @param type $type
 * @param type $value
 * @param type $params
 */
 /*
function containers_save_site_containers($hook, $type, $value, $params) {
	$plugin_id = get_input('plugin_id');
	if ($plugin_id != 'containers') {
		return $value;
	}

	$containers = get_input('containers');
	$containers = string_to_tag_array($containers);

	$site = elgg_get_site_entity();
	$site->containers = $containers;
	system_message(elgg_echo("containers:save:success"));

	elgg_delete_admin_notice('containers_admin_notice_no_containers');

	forward(REFERER);
}

  */