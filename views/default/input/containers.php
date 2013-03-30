<?php
/**
 * containers input view
 *
 * @package Elggcontainers
 *
 * @uses $vars['entity'] The entity being edited or created
 */
$logged_in_user = elgg_get_logged_in_user_entity();
if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
	$selected_container = $vars['entity']->getContainerEntity();
}

if (empty($selected_container))
{
    $selected_container = elgg_get_page_owner_entity();
}

 $content = elgg_get_entities_from_relationship(array(
        'type' => 'group',
        'relationship' => 'member',
        'relationship_guid' => $logged_in_user->guid,
        'inverse_relationship' => false,
        'limit' => 0,
    ));
    if (empty($content)) {
    $content = array();
    }

    $containers[$logged_in_user->guid] =  elgg_echo('profile') . ': ' .  $logged_in_user->name;
     foreach ($content as $container) {
        $containers[$container->guid ] =   elgg_echo('group') . ': ' . $container->get('name');
    }

    $vars = array(
    'value' => $selected_container->guid, 
    'options_values'=> $containers, 
    'name'=>'container_guid');
  $container_selector = elgg_view('input/dropdown',$vars);
	?>

<div class="elgg-containers">
	<label><?php echo elgg_echo('container'); ?></label><br/>
	<?php
    echo $container_selector;
	?>
</div>