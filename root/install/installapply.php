<?php
/**
* bbdkp Apply plugin Installer
* Powered by bbDkp (c) 2009 The bbDkp Project Team 
* @version $Id$
* @package umil
* @copyright (c) 2008 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
define('UMIL_AUTO', true);
define('IN_PHPBB', true);
define('ADMIN_START', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// We only allow a founder install this MOD
if ($user->data['user_type'] != USER_FOUNDER)
{
    if ($user->data['user_id'] == ANONYMOUS)
    {
        login_box('', 'LOGIN');
    }
    trigger_error('NOT_AUTHORISED');
}

if(!defined("EMED_BBDKP"))
{
    trigger_error('Cannot launch Application plugin Installer because bbDKP is not installed. 
    This mod depends on the ACP from bbdkp, you need to install bbDkp first. ', E_USER_WARNING); 
}

if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// The name of the mod to be displayed during installation.
$mod_name = 'bbDKP Recruitment Application Plugin';

/*
* The name of the config variable which will hold the currently installed version
* You do not need to set this yourself, UMIL will handle setting and updating the version itself.
*/
$version_config_name = 'bbdkp_apply_version';

/*
* The language file which will be included when installing
* Language entries that should exist in the language file for UMIL (replace $mod_name with the mod's name you set to $mod_name above)
* $mod_name
* 'INSTALL_' . $mod_name
* 'INSTALL_' . $mod_name . '_CONFIRM'
* 'UPDATE_' . $mod_name
* 'UPDATE_' . $mod_name . '_CONFIRM'
* 'UNINSTALL_' . $mod_name
* 'UNINSTALL_' . $mod_name . '_CONFIRM'
*/
$language_file = 'mods/apply';

/*
* Options to display to the user (this is purely optional, if you do not need the options you do not have to set up this variable at all)
* Uses the acp_board style of outputting information, with some extras (such as the 'default' and 'select_user' options)

$options = array(
	'test_username'	=> array('lang' => 'TEST_USERNAME', 'type' => 'text:40:255', 'explain' => true, 'default' => $user->data['username'], 'select_user' => true),
	'test_boolean'	=> array('lang' => 'TEST_BOOLEAN', 'type' => 'radio:yes_no', 'default' => true),
);
*/

/*
* Optionally we may specify our own logo image to show in the upper corner instead of the default logo.
* $phpbb_root_path will get prepended to the path specified
* Image height should be 50px to prevent cut-off or stretching.
*/
//$logo_img = 'styles/prosilver/imageset/site_logo.gif';

/*
* The array of versions and actions within each.
* You do not need to order it a specific way (it will be sorted automatically), however, you must enter every version, even if no actions are done for it.
*
* You must use correct version numbering.  Unless you know exactly what you can use, only use X.X.X (replacing X with an integer).
* The version numbering must otherwise be compatible with the version_compare function - http://php.net/manual/en/function.version-compare.php
*/

$bbdkp_table_prefix = "bbeqdkp_";
$versions = array(
	
			
	'1.1.1' =>array(
		//no db changes
	),
	
	
	'1.2.0' => array(

		// do this first
		'custom' => array('applyupdater120'), 
	
		'module_add' => array(
				array('acp', 'ACP_DKP_MEMBER', array(
	           		'module_basename'	=> 'dkp_apply',
					'modes'				=> array('apply_settings')),
	           	 )
	           ),
            
		'table_add' => array(
			array($bbdkp_table_prefix . 'apptemplate', array(
						'COLUMNS'		=> array(
							'qorder'	=> array('UINT', 0),
							'question'	=> array('VCHAR:255', ''),
							'type'		=> array('VCHAR:255', ''),
							'mandatory'	=> array('VCHAR:255', ''),
							'options'	=> array('MTEXT_UNI', ''),
						),
						'PRIMARY_KEY'	=> 'qorder',),
					),
			), 
		
		'config_add' => array(
				array('bbdkp_apply_forum_id', '2', true),
				array('bbdkp_apply_realm', 'Lightbringer', true),
				array('bbdkp_apply_region', 'EU'),
				array('bbdkp_apply_charconnectcheck', 'Tenarae'),
				array('bbdkp_apply_guests', 'True', true),
				array('bbdkp_apply_simplerecruit', 'True', true),
				), 	
			
		'table_row_insert' => array(
			array($bbdkp_table_prefix . 'apptemplate', 
				array(
					//MANDATORY - do not remove	or change		
					array(
						'qorder'		=> 1,
						'question'		=> 'Character name',
						'type'			=> 'Inputbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
					
					//MANDATORY - do not remove or change
					array(
						'qorder'		=> 2,
						'question'		=> 'Realm',
						'type'			=> 'Inputbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
				
					
					//demo questions start from index 3 - feel free to change  
					array(
						'qorder'		=> 3,
						'question'		=> 'Race, Class, Talentsetup. What is your main role and spec and why did you choose this ?',
						'type'			=> 'Textbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
	
					array(
						'qorder'		=>  4,
						'question'		=> 'Gearing. How have you chosen to itemise (gem, enchant) your gear and why ?',
						'type'			=> 'Textbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
	
					array(
						'qorder'		=> 5,
						'question'		=> 'What are your professions and level ? Does your character hold any special patterns or designs ?',
						'type'			=> 'Inputbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
	
					array(
						'qorder'		=> 6,
						'question'		=> 'Do you have any alts and if you do who are they ? Do you play with any characters other than the one you\'re applying with ?',
						'type'			=> 'Textbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
					
					array(
						'qorder'		=> 7,
						'question'		=> 'What is your total playtime for your main and alts? 
						(To get this log on your character and do /played for each character.)',
						'type'			=> 'Inputbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
								
					array(
						'qorder'		=> 8,
						'question'		=> 'Why did you choose our Guild ? Do you know anyone in the guild ? 
						Why do you think you will fit in with our guild, and what can you bring to us ?',
						'type'			=> 'Textbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
	
					array(
						'qorder'		=> 9,
						'question'		=> 'What are your previous guilds, (name classleader and GM) and why are you no longer a part of them.',
						'type'			=> 'Textbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
	
					array(
						'qorder'		=> 10,
						'question'		=> 'Are you a true Raider ? ',
						'type'			=> 'Radiobuttons',
						'mandatory'		=> 'True',
						'options'		=> 'Yes,No,Maybe',
					),	
		
					array(
						'qorder'		=> 11,
						'question'		=> 'Do you have any raid experience? If yes, what instances and what role did you play ? ',
						'type'			=> 'Textbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
	
					array(
						'qorder'		=> 12,
						'question'		=> 'What days do you play ? ',
						'type'			=> 'Checkboxes',
						'mandatory'		=> 'True',
						'options'		=> 'monday,tuesday,wednesday,thursday,friday,saturday,sunday',
					),	
	
					array(
						'qorder'		=> 13,
						'question'		=> 'We raid from 9pm to midnight. Please describe your evening Raiding availability. ',
						'type'			=> 'Textbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),	
	
					array(
						'qorder'		=> 14,
						'question'		=> 'Tell us a bit about yourself ',
						'type'			=> 'Textbox',
						'mandatory'		=> 'False',
						'options'		=> ' ',
					),	
									
					array(
						'qorder'		=> 15,
						'question'		=> 'Are you older than 18 ? ',
						'type'			=> 'Radiobuttons',
						'mandatory'		=> 'False',
						'options'		=> 'Yes,No',
					),	
				
				))
				
	), 
	),
			
			
	'1.2.1' => array(
	
		// do this first
		'custom' => array('applyupdater'), 

		//remove single forum selection
		'config_remove' => array('bbdkp_apply_forum_id'), 
		
		//add multiple forum selection
		// set to same id -> dont forget to change this in your ACP !
		 'config_add' => array(
          array('bbdkp_apply_forum_id_private', '2', true),
          array('bbdkp_apply_forum_id_public', '2', true),
          array('bbdkp_apply_visibilitypref', '1', true),
			),
			

	),	

	'1.2.2' => array(
	
		// do this first
		'custom' => array('applyupdater', 'bbdkp_caches'), 

		 'config_add' => array(
          array('bbdkp_apply_forumchoice', '1', true),
			),
			

	),		
	
		'1.2.3' => array(
	
		// do this first
		'custom' => array('applyupdater', 'bbdkp_caches'), 
			

	),		

		'1.2.4' => array(
	
		// do this first
		'custom' => array('applyupdater', 'bbdkp_caches'), 
	),
	
	    '1.2.5' => array(
	
		// do this first
		'custom' => array('applyupdater', 'bbdkp_caches'), 
	),
	
	
);

// We include the UMIF Auto file and everything else will be handled automatically.
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);

function applyupdater($action, $version)
{
	global $db, $table_prefix, $user, $umil, $bbdkp_table_prefix, $phpbb_root_path, $phpEx;
	switch ($action)
	{
		case 'install' :
		case 'update' :

			$umil->table_row_remove($bbdkp_table_prefix . 'plugins',
	            array('name'  => 'apply')
			);	
				
			// We insert new data in the plugin table
			$umil->table_row_insert($bbdkp_table_prefix . 'plugins',
			array(
				array( 
					'name'  => 'apply', 
					'value'  => '1', 
					'version'  => $version, 								
					'orginal_copyright'  => 'Kapli, Malfate', 				
					'bbdkp_copyright'  => 'bbDKP Team', 				
					),
			));
			
			return array('command' => sprintf($user->lang['APPLY_UPD_MOD'], $version) , 'result' => 'SUCCESS');
			
			break;
		
		case 'uninstall' :
		
			return array(
					'command' => sprintf($user->lang['APPLY_UNINSTALL_MOD'], $version) ,  
					'result' => 'SUCCESS');
			break;
	
	}
}


function applyupdater120($action, $version)
{
	global $db, $table_prefix, $umil, $user, $bbdkp_table_prefix, $phpbb_root_path, $phpEx;
	switch ($action)
	{
		case 'install' :
		case 'update' :

		    // If there are tables from the old apply module then delete them
		    if ($umil->table_exists($bbdkp_table_prefix . 'appconfig'))
		    {
		        // drop it, config is done with phpbb $config
		        $umil->table_remove($bbdkp_table_prefix . 'appconfig');
		    }
		    
			if ($umil->table_exists($bbdkp_table_prefix . 'apptemplate'))
		    {
		        // drop it
		        $umil->table_remove($bbdkp_table_prefix . 'apptemplate');
		    }

			
            $umil->table_row_remove($bbdkp_table_prefix . 'plugins',
                array('name'  => 'apply')
			);
			
			
			// We insert new data in the plugin table
			$umil->table_row_insert($bbdkp_table_prefix . 'plugins',
		    array(
				array( 
				'name'  => 'apply', 
				'value'  => '1', 
				'version'  => '1.2.0', 								
				'orginal_copyright'  => 'Kapli, Malfate', 				
				'bbdkp_copyright'  => 'bbDKP Team', 				
				),
			));

			//remove old module
		    $umil->table_row_remove($table_prefix . 'modules',
                array('module_basename'  => 'dkp_apply')
            );

		return array('command' => sprintf($user->lang['APPLY_UPD_MOD'], $version) , 'result' => 'SUCCESS');
		
		break;
		
		case 'uninstall' :
			// Run this when uninstalling
			
			// If there are tables from the old apply module then delete them
		    if ($umil->table_exists($bbdkp_table_prefix . 'appconfig'))
		    {
		        // drop it, config is done with phpbb $config
		        $umil->table_remove($bbdkp_table_prefix . 'appconfig');
		    }
		    
			if ($umil->table_exists($bbdkp_table_prefix . 'apptemplate'))
		    {
		        // drop it
		        $umil->table_remove($bbdkp_table_prefix . 'apptemplate');
		    }
			
		    $umil->table_row_remove($bbdkp_table_prefix . 'plugins',
                array('name'  => 'apply')
                );
		
			return array(
					'command' => sprintf($user->lang['APPLY_UNINSTALL_MOD'], $version)  , 
					'result' => 'SUCCESS');
			break;
	
	}
}

/**************************************
 *  
 * global function for clearing cache
 * 
 */
function bbdkp_caches($action, $version)
{
    global $db, $table_prefix, $umil, $bbdkp_table_prefix;
    
    $umil->cache_purge();
    $umil->cache_purge('imageset');
    $umil->cache_purge('template');
    $umil->cache_purge('theme');
    $umil->cache_purge('auth');
    
    return 'UMIL_CACHECLEARED';
}


?>