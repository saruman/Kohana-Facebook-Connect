<?php defined('SYSPATH') or die('No direct script access.');
/**
* Facebook authentication module
*
* @package		Kohana_FBConnect
* @author		Pap Tamas
* @copyright	(c) 2011 Pap Tamas
* @website		http://github.com/paptamas/Kohana-Facebook-Connect
* @license		http://www.opensource.org/licenses/isc-license.txt
*/
class Kohana_FBConnect
{
	public static $_instance;

	protected $_facebook;
	
	protected $_user_id;

	protected $_config;
	
	/**
	 * Create the Facebook object
	 */
	protected function __construct()
	{
		// Load config
		$this->_config = Kohana::$config->load('facebook');

        include Kohana::find_file('vendor', 'facebook/facebook');

		// Create Facebook object
		$this->_facebook = new Facebook(
			array(
				'appId'  => $this->_config->appId,
				'secret' => $this->_config->secret,
				'cookie' => $this->_config->cookie
			)
		);

        $this->_user_id = $this->_facebook->getUser();
	}
	
	/**
	 * Check if user is logged
	 *
	 * @return	bool
	 */
	public function logged_in()
	{
		return $this->_user_id != NULL;
	}

	/**
	 * Return the user id in case of success, NULL otherwise
	 *
	 * @return	mixed
	 */
	public function user_id()
	{
		return ($this->_user_id) ? $this->_user_id : NULL;
	}

    /**
     * Get the basic info about the logged user
     *
     * @return mixed
     */
    public function user_info() {
        return $this->graph('/me');
    }

    /**
     * Create a login url, based on req_perms, next, and cancel_url
     *
     * @return	string
     */
    public function login_url()
    {
        return $this->_facebook->getLoginUrl(
            array
            (
                'req_perms'		=> $this->_config->req_perms,
                'next'			=> $this->_config->next,
                'cancel_url'	=> $this->_config->cancel_url
            ));
    }

    /**
     * Create a logout url
     *
     * @param $next_url
     * @return	string
     */
    public function logout_url($next_url)
    {
        return $this->_facebook->getLogoutUrl(array(
            'next' => $next_url
        ));
    }

    /**
     * Return the access token
     *
     * @return string
     */
    public function access_token() {
        return $this->_facebook->getAccessToken();
    }

    /**
     * Get facebook session
     *
     * @return array
     */
    public function session() {
        return $this->_facebook->getSession();
    }

    /**
     * Performs an fql query
     *
     * example:
     *  $fbconnect->fql('SELECT uid2 FROM friend WHERE uid1 = me()'); //gets the list of friends of the user
     *
     * @param $query
     * @return mixed
     * @throws Kohana_Exception
     */
    public function fql($query) {
        if ( ! $this->logged_in())
        {
            throw new Kohana_Exception('User is not logged in.');
        }
        else
        {
            $fql_query  =   array(
                'method' => 'fql.query',
                'query' => $query
            );

            return $this->_facebook->api($fql_query);
        }
    }

    /**
     * Performs a request to graph api
     * example:
     *  $fbconnect->graph('/me/friends'); // gets the list of friends of the user
     *  $fbconnect->graph('/me/feed', 'POST', array('link' => 'www.example.com', 'message' => 'Posting with the PHP SDK!' )); // posts to users wall
     *
     * @param $segment
     * @param string $method
     * @param null $parameters
     * @return mixed
     * @throws Kohana_Exception
     */
    public function graph($segment, $method = 'GET', $parameters = NULL) {
        if ( ! $this->logged_in())
        {
            throw new Kohana_Exception('User is not logged in.');
        }
        else
        {
            return $this->_facebook->api($segment, $method, $parameters);
        }
    }

    /**
   	 * Creates a singleton instance of the class
   	 *
   	 * @return	Kohana_FBConnect
   	 */
   	public static function instance()
   	{
   		if ( ! isset(self::$_instance))
           {
   			self::$_instance = new self;
           }

   		return self::$_instance;
   	}
	
}
// END Kohana_FBConnect
