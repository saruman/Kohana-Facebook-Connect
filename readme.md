# Kohana Facebook Connect module
Kohana 3.x module for connecting to facebook.

##Set up
Edit the config file, to personalize the module.

##Example of usage
(See the code for more information)

	$fbconnect = FBConnect::instance();
	if ( ! $fbconnect->logged_in())
	{
	    echo '<a href="'.$fbconnect->login_url().'">Log in.</a>';
	}
	else {
	    //$fbauth->graph('/FRIEND_ID/feed', 'POST', array('link' => 'www.example.com', 'message' => 'Posting with the PHP SDK!' )); // posts to users wall
	    print_r($fbconnect->graph('/me'));
	}