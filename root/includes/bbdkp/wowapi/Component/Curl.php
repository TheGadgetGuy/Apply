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

/**
 * Curl component
 *
 * Generic PHP curl component used to make system level curl commands.
 */
class Curl 
{
	public $errno = CURLE_OK;
	public $error = '';

	/**
	 * Executes a curl request.
	 *
	 * @param string $url URL to make the request
	 * @param string $method Method to make (GET, POST, etc)
	 * @param array $options Various options for the request (including data)
	 * @return array Array containing the 'response' and the 'code'
	 */
	public function makeRequest($url, $method='GET', $options=array()) 
	{
		global $user;
		
		if ( !function_exists ( 'curl_init' ))
		{
			 trigger_error($user->lang['CURL_REQUIRED']);
		}
		 
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		// if safemode or openbasedir is on then no redirection is possible. 
		// the wowapi does not need redirection at this point so we don't really need it. 
		if (!(ini_get("safe_mode") || ini_get("open_basedir"))) 
		{
			@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		}
			
		curl_setopt($ch, CURLOPT_TIMEOUT,		 isset($options['timeout']) ? $options['timeout'] : 10);
		curl_setopt($ch, CURLOPT_VERBOSE,		 isset($options['verbose']) ? $options['verbose'] : false);

		// spoof the useragent because curl doesn't send one by default
		$useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:6.0.2) Gecko/20100101 Firefox/6.0.2';
		@curl_setopt ( $ch, CURLOPT_USERAGENT, $useragent );
		
		// Prepare data (if applicable)
		if (isset($options['data']) && !empty($options['data'])) 
		{
			if (isset($options['data_type'])) 
			{
				switch($options['data_type']) 
				{
					case 'json':
						$data = json_encode($options['data']);
						break;
				}
			} 
			else 
			{
				if (is_array($options['data'])) 
				{
					$data = '';
					foreach($options['data'] as $key => $value) 
					{
						$data .= $key.'='.$value.'&';
					}
					$data = rtrim($data, '&');
				} 
				else 
				{
					$data = $options['data'];
				}
			}
		}
		
		// Prepare headers (if applicable)
		if (isset($options['headers'])) 
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $options['headers']);
		}		
		
		// Setup methods
		switch($method) 
		{
			case 'GET':
				if(!empty($data)) 
				{
					curl_setopt($ch, CURLOPT_URL, $url . '?' . $data);
				}
				break;
			case 'POST':
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				break;
			case 'PUT':
				$file_handle = fopen($data, 'r');
				curl_setopt($ch, CURLOPT_PUT, true);
				curl_setopt($ch, CURLOPT_INFILE, $file_handle);
				break;
			case 'DELETE':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
		}

		// Execute
		$response	    = curl_exec($ch);
		$headers		= curl_getinfo($ch);
 		//Deal with HTTP errors
		$this->errno	= curl_errno($ch);
		$this->error	= curl_error($ch);

		curl_close($ch);

		if ($this->errno) 
		{
			return false;
		}
		else
		{
			return array(
				'response'		    => (array) json_decode($response, true),
				'response_headers'  => $headers,
			);
		}
	}

}