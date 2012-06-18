<?php defined('SYSPATH') or die('No direct access allowed.');

return array(

	'appId'			=> 'YOUR_APP_ID',
	'secret'		=> 'YOUR_SECRET',
	'cookie'		=> TRUE,
	'next'			=> 'http://www.example.com/fbconnect',
	'cancel_url'	=> 'http://www.example.com/fbconnect/cancel',
	'req_perms'		=> 'email,publish_stream,read_friendlists',
	// Full list of permission available here: https://developers.facebook.com/docs/reference/api/permissions/	
);
