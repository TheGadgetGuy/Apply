<?php
/**
* Apply Installer
* Powered by bbDkp (c) 2009 www.bbdkp.com
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

if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// The name of the mod to be displayed during installation.
$mod_name = 'Recruitment Application';

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

$versions = array(
		'1.3.0' => array(

		// adding configs
		'config_add' => array(
			 array('bbdkp_apply_realm', 'Realmname', true),
			 array('bbdkp_apply_region', 'us'),
			 array('bbdkp_apply_guests', 'True', true),
			 array('bbdkp_apply_simplerecruit', 'True', true),			
	         array('bbdkp_apply_forum_id_private', '2', true),
	         array('bbdkp_apply_forum_id_public', '2', true),
	         array('bbdkp_apply_visibilitypref', '1', true),	
	         array('bbdkp_apply_pqcolor', '#68f3f8', true),
	         array('bbdkp_apply_pacolor', '#FFFFFF', true),
	         array('bbdkp_apply_fqcolor', '#68f3f8', true),
	         array('bbdkp_apply_forumchoice', '1', true),
			),
          			
		'module_add' => array(
				array('acp', 'ACP_DKP_MEMBER', array(
	           		'module_basename'	=> 'dkp_apply',
					'modes'				=> array('apply_settings')),
	           	 )
	           ),
            
		'table_add' => array(
			array($table_prefix . 'bbdkp_apptemplate', array(
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
 		
		'table_row_insert' => array(
			array($table_prefix . 'bbdkp_apptemplate', 
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
						'question'		=> 'Do you have any alts and if you do who are they ? Do you play with any characters other than the one you’re applying with ?',
						'type'			=> 'Textbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
					
					array(
						'qorder'		=> 7,
						'question'		=> 'Why did you choose our Guild ? Do you know anyone in the guild ? 
						Why do you think you will fit in with our guild, and what can you bring to us ?',
						'type'			=> 'Textbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
	
					array(
						'qorder'		=> 8,
						'question'		=> 'What are your previous guilds, (name classleader and GM) and why are you no longer a part of them.',
						'type'			=> 'Textbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
	
					array(
						'qorder'		=> 9,
						'question'		=> 'Do you have any raid experience? If yes, what instances and what role did you play ? ',
						'type'			=> 'Textbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),
	
					array(
						'qorder'		=> 10,
						'question'		=> 'What days can you play ? ',
						'type'			=> 'Checkboxes',
						'mandatory'		=> 'True',
						'options'		=> 'monday,tuesday,wednesday,thursday,friday,saturday,sunday',
					),	
	
					array(
						'qorder'		=> 11,
						'question'		=> 'We raid from 7:30pm to 11pm Server time (UTC+1). Please describe your evening Raiding availability. ',
						'type'			=> 'Textbox',
						'mandatory'		=> 'True',
						'options'		=> ' ',
					),	
	
					array(
						'qorder'		=> 12,
						'question'		=> 'Tell us a bit about yourself ',
						'type'			=> 'Textbox',
						'mandatory'		=> 'False',
						'options'		=> ' ',
					),	
									
					array(
						'qorder'		=> 13,
						'question'		=> 'Are you older than 18 ? ',
						'type'			=> 'Radiobuttons',
						'mandatory'		=> 'False',
						'options'		=> 'Yes,No',
					),	
				
				))
		), 
		
		'custom' => array('applyupdater', 'bbdkp_caches'), 
	),
			
			

);

// We include the UMIF Auto file and everything else will be handled automatically.
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);


/**
 * this function fills the plugin table.
 *
 * @param string $action
 * @param string $version
 * @return string
 */
function applyupdater($action, $version)
{
	global $db, $table_prefix, $user, $umil, $bbdkp_table_prefix, $phpbb_root_path, $phpEx;
	switch ($action)
	{
		case 'install' :
		case 'update' :
				
			// We insert new data in the plugin table
			$umil->table_row_insert($table_prefix . 'bbdkp_plugins',
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

/**************************************
 * global function for clearing cache
 */
function clearcaches($action, $version)
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