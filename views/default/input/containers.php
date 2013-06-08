<?php
/**
 * containers input view
 *
 * @package Elggcontainers
 *
 * @uses $vars['entity'] The entity being edited or created
 */
$logged_in_user = elgg_get_logged_in_user_entity();
 $page_owner = elgg_get_page_owner_entity();
//elgg_dump(var_dump($vars));
if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
    $in_container = $vars['entity']->getContainerEntity();
 //   elgg_dump('in : entityname = ' . $in_container->name);
}
else {
 //   elgg_dump('in : no entity');
        $in_container = $page_owner;
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
    if (($page_owner->guid <> $logged_in_user->guid)&& ($page_owner instanceof ElggUser)){ // if the logged in user is not the page owning user, then add the page owning user as an option - for 'login as' plugin and maybe others.
    $containers[$page_owner->guid] = elgg_echo('profile') . ': ' . $page_owner->name;
    }

     foreach ($content as $container) {
        $containers[$container->guid ] =   elgg_echo('group') . ': ' . $container->get('name');
    }

    $vars = array(
    'value' => $in_container->guid, 
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