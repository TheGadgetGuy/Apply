<?php
/**
 * Battle.net WoW API PHP SDK
 *
 * This software is not affiliated with Battle.net, and all references
 * to Battle.net and World of Warcraft are copyrighted by Blizzard Entertainment.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   WoWAPI-PHP-SDK
 * @author	  Chris Saylor
 * @author	  Daniel Cannon <daniel@danielcannon.co.uk>
 * @author	  Andy Vandenberghe <sajaki9@gmail.com> 
 * @copyright Copyright (c) 2011, Chris Saylor, Daniel Cannon,  Andy Vandenberghe
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link	  https://github.com/bbDKP/WoWAPI-PHP-SDK/
 */


/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (!class_exists('Curl')) 
{
	require($phpbb_root_path . "includes/bbdkp/wowapi/Component/Curl.$phpEx");
}

/**
 * Resource skeleton
 * 
 * @throws ResourceException If no methods are defined.
 */
abstract class Resource 
{
	const API_URI = 'http://%s.battle.net/api/wow/';
	
	/**
	 * Methods allowed by this resource (or available).
	 *
	 * @var array
	 */
	protected $methods_allowed;

	/**
	 * Curl object instance.
	 *
	 * @var \Curl
	 */
	protected $Curl;
	
	/**
	 * @param string $region Server region(`us` or `eu`)
	 */
	public function __construct($region='us') 
	{
		global $user;
		$user->add_lang ( array ('mods/wowapi'));
		if (empty($this->methods_allowed)) 
		{
			trigger_error($user->lang['NO_METHODS']);
		}
		$this->region = $region;
		$this->Curl = new Curl();
	}

	/**
	 * Consumes the resource by method and returns the results of the request.
	 *
	 * @param string $method Request method
	 * @param array $params Parameters
	 * @throws ResourceException If request method is not allowed
	 * @return array Request data
	 */
	public function consume($method, $params=array()) 
	{
		global $user;
		$user->add_lang ( array ('mods/wowapi' ) );
		// either a valid method is required or an asterisk 
		if (!in_array($method, $this->methods_allowed)  && !in_array('*', $this->methods_allowed) ) 
		{
			trigger_error($user->lang['WOWAPI_METH_NOTALLOWED']);
		}
		$url = $this->getResourceUri($method);
		$data = $this->Curl->makeRequest($url, 'GET', $params);

		//cURL returned an error code
		if ($this->Curl->errno !== CURLE_OK) 
		{
			trigger_error($this->Curl->error . ': ' . $this->Curl->errno);
		}
		
		//Battle.net returned a HTTP error code
		if (!isset($data['response_headers']['http_code']) || $data['response_headers']['http_code'] !== 200) 
		{
			switch ($data['response_headers']['http_code'] )
			{
				case 404:
					trigger_error($user->lang['WOWAPIERR404'] . ': ' . $data['response']['reason'] );
					break;
				case 500:
					trigger_error($user->lang['WOWAPIERR500'] . ': ' . $data['response']['reason'] );
					break;
				default:
					trigger_error($user->lang['WOWAPIERROTH'] . ':' . $data['response']['reason'] );
			}
		}
		return $data['response'];
	}

	/**
	 * Returns the URI for use with the request object
	 *
	 * @param string $method
	 * @return string API URI
	 */
	private function getResourceUri($method) 
	{
		return sprintf(self::API_URI, $this->region) . strtolower(get_class($this)) . '/' . $method;
	}
}
