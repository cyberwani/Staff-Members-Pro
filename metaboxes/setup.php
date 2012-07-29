<?php
$jmsmp_meta = array();

$jmsmp_meta['name'] = new WPAlchemy_MetaBox(array
(
	'id' => '_jmsmp_name',
	'title' => 'Name',
	'template' =>  JMSMP_DIR . '/metaboxes/names-meta.php',
	'types' => array('staff-member'),
	'context' => 'normal',
	'priority' => 'high',
	'autosave' => 'true',
	'lock' => WPALCHEMY_LOCK_AFTER_POST_TITLE,
	'view' => WPALCHEMY_VIEW_ALWAYS_OPENED 
));
$jmsmp_meta['contact'] = new WPAlchemy_MetaBox(array
(
	'id' => '_jmsmp_contact',
	'title' => 'Contact Details',
	'template' =>  JMSMP_DIR . '/metaboxes/contact-meta.php',
	'types' => array('staff-member'),
	'context' => 'side',
	'priority' => 'high'
));
