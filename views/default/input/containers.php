<?php
/**
 * containers input view
 *
 * @package Elggcontainers
 *
 * @uses $vars['entity'] The entity being edited or created
 */

if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
	$selected_container = $vars['entity']->getContainerEntity();
}

elgg_dump('selected container : ' . $selected_container->name);
// use sticky values if set
//if (isset($vars['universal_containers_list'])) {
//	$selected_containers = $vars['universal_containers_list'];
//}

   
    $viewer = elgg_get_logged_in_user_entity();

    //read viewer's groups
    $content = elgg_get_entities_from_relationship(array(
        'type' => 'group',
        'relationship' => 'member',
        'relationship_guid' => elgg_get_logged_in_user_guid(),
        'inverse_relationship' => false,
        'limit' => 0,
    ));
    if (empty($content)) {
    $content = array();
    }

    //create array of entries ($content object had duplicate entries, array keys prevent duplicates
    

    foreach ($content as $container) {
        $groups[$container->guid] = elgg_echo('group') . ': ' . $container->get('name');
    }
   if (!empty($groups)){
    //sort array while keeping the IDs
    asort($groups);
    $container = array(elgg_get_logged_in_user_guid() => elgg_echo('profile') . ': ' .  elgg_get_logged_in_user_entity()->name);
   $containers = array_merge($container,$groups);
    $vars = array('value' => $selected_container->guid, 'options_values'=> $containers, 'name'=>'container_guid');
  $container_selector = elgg_view('input/dropdown',$vars);

/*
        $container_selector =  elgg_view('input/checkboxes', array(
            'options' => $containers,
            'value' => $selected_containers,
            'name' => 'containers',
            'align' => 'vertical',
        ));

*/

	// checkboxes want Label => value, so in our case we need container => container
//	$containers = array_flip($containers);
//	array_walk($containers, create_function('&$v, $k', '$v = $k;'));

	?>

<div class="elgg-containers">
	<label><?php echo elgg_echo('container'); ?></label>
	<?php
    echo $container_selector;
	?>
	<input type="hidden" name="container_marker" value="on" /> 
</div>


    <?php

} else {
    echo '<input type="hidden" name="universal_category_marker" value="on" />';
}
