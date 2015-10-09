<?php

/* 
 * get_access - action for updating access levels via AJAX for specific containers
 * @package - containers
 */

$containerGUID = (int) get_input('containerGUID', 'all');
$elementID = get_input('elementID');

// set default access to private
$logged_in_user = elgg_get_logged_in_user_entity();
$default_access = get_default_access($logged_in_user);

$site = elgg_get_site_entity();
$access_id = (int) get_input('access_id');

$GUID = (int) get_input('GUID');
$entity = get_entity($GUID);
$params = array(
    'container_guid' => $containerGUID,
    'entity' => $entity
    );

//if the access id that is passed in via AJAX is not a valid access id then use the default
if (!in_array($access_id, get_write_access_array($logged_in_user->guid,  $site->getGUID(),TRUE, $params)))
        $access_id = $default_access;

if ($container = get_entity($containerGUID))
{
    if ($container instanceof ElggGroup)
    {
        elgg_push_context('groups');
        elgg_set_page_owner_guid($containerGUID);
    }
    elseif ($container instanceof ElggUser)
    {
        elgg_set_page_owner_guid($containerGUID);
    }
    else
    {
        error_log('containers: container GUID was not valid: ' . $containerGUID);
    }
    
     $options = array(
	'name' => 'access_id',
	'id' => $elementID,
	'value' => $access_id,
        'container_guid' => $containerGUID,
        );
    if ($entity)
        $options['entity'] = $entity;
    
    $output = '<result>';
    $output .= '<access>' . elgg_view('input/access', $options) . '</access>'; 
    $output .= '</result>';
}
else
{
    error_log('containers: could not retrieve access levels for entity GUID: ' . $GUID . '; and containerGUID: ' . $containerGUID);
    $output = '';
}
echo $output;
forward(REFERER);