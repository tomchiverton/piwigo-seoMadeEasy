<?php
/*
Version: 0.1
Plugin Name: SeoMadeEasy
Plugin URI: // Here comes a link to the Piwigo extension gallery, after
Author: // Good practice to put your forum username here.
Description: The 
*/

function seoMadeEasy_make_index_url($params = array())
{

if(	!array_key_exists('category', $params) or
	array_key_exists('permalink', $params['category'])) 
{
	return make_index_url($params,1);
}

#return '/gallery3/v/TODO'.$params['name'];

  global $conf;
  $url = get_root_url().'index';
  if ($conf['php_extension_in_urls'])
  {
    $url .= '.php';
  }
  if ($conf['question_mark_in_urls'])
  {
    $url .= '?';
  }

  $url_before_params = $url;

  $url.= make_section_in_url($params);
  $url = add_well_known_params_in_url($url, $params);

  if ($url == $url_before_params)
  {
    $url = get_absolute_root_url( url_is_remote($url) );
  }

  return $url;
}
?>
