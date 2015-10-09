<?php
/**
 * View containers on an entity
 *
 * @uses $vars['entity']
 */

if (elgg_get_page_owner_entity() instanceof ElggGroup)
{
	return false;
}
else 
{
	$linkstr = '';
	if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) 
	{
		
		
		$containers =  $vars['entity']->getContainerEntity();
		if (!empty($containers)) {
			if (!is_array($containers)) {
				$containers = array($containers);
			}
			foreach($containers as $container) {
			    if ($container instanceof ElggGroup){
	                $link = elgg_get_site_url() . 'groups/profile/' . $container->guid;
	        		if (!empty($linkstr)) {
	    				$linkstr .= ', ';
	    			}
	    			$linkstr .= '<a href="'.$link.'">' . $container->name . '</a>';
	            }
			}
		}
	}
	
	if ($linkstr) {
		echo ('<div class="elgg-output-container">' . elgg_echo('container:in-group') . ': ' . $linkstr . '</div>');
		return true;
	}
	return false;
}