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

if (!$page_owner)
    $page_owner = $logged_in_user;
elgg_require_js("containers/container_access");

if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
    $in_container = $vars['entity']->getContainerEntity();
    $entity_owner = $vars['entity']->getOwnerEntity();

}
else {
    $in_container = $page_owner;
    $entity_owner = $page_owner;
}

 $content = elgg_get_entities_from_relationship(array(
        'type' => 'group',
        'relationship' => 'member',
        'relationship_guid' => $entity_owner->guid,
        'inverse_relationship' => false,
        'limit' => 0,
    ));

    if (empty($content)) {
        $content = array();
    }
    if ($entity_owner instanceof ElggUser)
    {
      $containers[$entity_owner->guid] =  elgg_echo('profile') . ': ' .  $entity_owner->name;
    }
    elseif ($entity_owner instanceof ElggGroup) {
      $containers[$entity_owner->guid] =  elgg_echo('group') . ': ' .  $entity_owner->name;
    }

   // if the logged in user is not the page owning user, then add the page owning user as an option - for 'login as' plugin and admins.
     if (($entity_owner->guid <> $logged_in_user->guid)&& ($entity_owner instanceof ElggUser)){ // if t
        $containers[$logged_in_user->guid] = elgg_echo('profile') . ': ' . $logged_in_user->name;
    }

     foreach ($content as $container) {
        $containers[$container->guid ] =   elgg_echo('group') . ': ' . $container->name;
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
