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

	elgg_register_event_handler('update', 'all', 'container_save');
	elgg_register_event_handler('create', 'all', 'container_save');

}

/**
 * Save containers to object upon save / edit
 *
 */
 
function container_save($event, $object_type, $object) {

	if ($object instanceof ElggEntity) {
		$marker = get_input('container_marker');
    		if ($marker == 'on') {
	            $container = get_input('container_guid');

			$object->setContainerGUID($container);
		}
       return TRUE;
    }
 
}
