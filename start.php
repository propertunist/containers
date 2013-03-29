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
}

