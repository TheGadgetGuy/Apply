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
 * Battle.net WoW API PHP SDK
 *
 * @throws Exception If requirements are not met.
 */
class WowAPI 
{
	protected $region;
	
	protected $Resources_allowed = array(
		'guild', 'realm', 'character'
	);
	
	/**
	 * Realm object instance
	 *
	 */
	public $Realm;
	
	/**
	 * Guild object instance
	 *
	 * @var class
	 */
	public $Guild;

	
	/**
	 * Character object instance
	 *
	 * @var class
	 */
	public $Character;
	
	/**
	 * WoWApi Class. 
	 * 
	 * $resource, : one of : "'guild', 'realm', 'character' "
	 * if realm then $parameters array must look like : 
	 * $region = array ('region'  => one of 'en', 'us', 'tw', 'sea', 'kr')
	 * 
	 * @param string $resource, 
	 * @param string $region
	 * 
	 */
	public function __construct($resource, $region) 
	{
		global $user, $phpEx, $phpbb_root_path; 
		$user->add_lang ( array ('mods/wowapi'));
		
		// check for correct resource call
		if (!in_array($resource, $this->Resources_allowed)) 
		{
			trigger_error($user->lang['WOWAPI_RESOURCE_NOTALLOWED']);
		}
		
		// Check for required extensions
		if (!function_exists('curl_init')) 
		{
			trigger_error($user->lang['CURL_REQUIRED'], E_USER_WARNING);

		}

		if (!function_exists('json_decode')) 
		{
			trigger_error($user->lang['JSON_REQUIRED'], E_USER_WARNING);			
		}
		
		
		switch ($resource)
		{
			case 'realm':
				if (!class_exists('Realm')) 
				{
					require($phpbb_root_path . "includes/bbdkp/wowapi/Resource/Realm.$phpEx");
				}
				$this->Realm = new Realm($region);
				break;
			case 'guild':
				if (!class_exists('Guild')) 
				{
					require($phpbb_root_path . "includes/bbdkp/wowapi/Resource/Guild.$phpEx");
				}				
				$this->Guild = new Guild($region);
				break;
			case 'character':
				if (!class_exists('Character')) 
				{
					require($phpbb_root_path . "includes/bbdkp/wowapi/Resource/Character.$phpEx");
				}				
				$this->Character = new Character($region);
				break;
				
		}
	}
}
