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
	    // Post to a user's friend's wall
	    $fbauth->graph('/FRIEND_ID_HERE/feed', 'POST', array('link' => 'www.example.com', 'message' => 'Posting with the PHP SDK!' )); // posts to users wall
	    
	    // Get the list of friends of the logged user
	    print_r($fbconnect->graph('/me/friends'));
	}