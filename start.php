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
    $root = dirname(__FILE__);

    // actions
    $action_path = "$root/actions/bookmarks";
	elgg_extend_view('css/elgg', 'containers/css');
    elgg_extend_view('object/summary/extend', 'output/containers', 0);
    elgg_unregister_action('bookmarks/save');
    elgg_register_action('bookmarks/save', "$action_path/save.php");
}
