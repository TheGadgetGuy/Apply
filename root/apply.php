<?php
/**
* Application form created by Kapli (bbDKP developer)
* 
* @package bbDkp
* @copyright (c) 2009 bbDkp <http://code.google.com/p/bbdkp/>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @version $Id$
* @author Kapli, Malfate, Sajaki, Blazeflack, Twizted
* 
*/

/**
* @ignore
*/ 
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/functions_posting.' . $phpEx);
include($phpbb_root_path . 'includes/functions_display.' . $phpEx);
include($phpbb_root_path . 'includes/message_parser.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);

$error = array();
$current_time = $user->time_now; 

$user->setup(array('posting', 'mcp', 'viewtopic', 'mods/apply', 'mods/dkp_common', 'mods/dkp_admin'), false);

// declare captcha class
if (!class_exists('phpbb_captcha_factory'))
{
	include($phpbb_root_path . 'includes/captcha/captcha_factory.' . $phpEx);
}

// make captcha object
$captcha =& phpbb_captcha_factory::get_instance($config['captcha_plugin']);

// if "enable visual confirmation for guest postings" is set to "ON"
// and the user is not registered then set up captcha  
if ($config['enable_post_confirm'] && !$user->data['is_registered'])  
{
	$captcha->init(CONFIRM_POST);
}

//check if visitor can access the form
$post_data = check_apply_form_access();

//request variables
$submit	= (isset($_POST['post'])) ? true : false;

if ($submit)
{
	// first validate captcha 
	
	// if "enable visual confirmation for guest postings" is set to "ON"
	// and mode is set to posting 
	// and the user is not registered 
	// then captcha will be validated
	if ($config['enable_post_confirm'] && in_array('post', array('post')) && !$user->data['is_registered'] )
	{
		$vc_response = $captcha->validate();
		if ($vc_response)
		{
			$error[] = $vc_response;
		}
	}
	
	if(!sizeof($error) && check_form_key('applyposting'))
	{
		make_apply_posting($post_data, $current_time);
	}
	
}

fill_application_form($post_data, $submit, $error, $captcha);

/**
 * post application on forum
 *
 */
function make_apply_posting($post_data, $current_time)
{
	global $auth, $config, $db, $user, $phpbb_root_path, $phpEx;
	
	$board_url = generate_board_url() . '/';
	
	//check if user forgot to enter a required field other than those covered with js
	$sql = "SELECT * FROM " . APPTEMPLATE_TABLE . " where mandatory = 'True' ORDER BY qorder   ";
	$result = $db->sql_query_limit($sql, 100, 1);
	while ( $row = $db->sql_fetchrow($result))
	{
		if ($row['type']=='Checkboxes')
		{
			if ( request_var('templatefield_' .$row['qorder'],  array('' => '')) == '') 
			{
				// return user to index
				$message = $user->lang['APPLY_REQUIRED'];
				$message = $message . '<br /><br />' . sprintf($user->lang['RETURN_APPLY'], '<a href="' . append_sid("{$phpbb_root_path}apply.$phpEx") . '">', '</a>');
				$db->sql_freeresult($result);
				trigger_error($message);		 
			}
		}
		else 
		{
			if ( request_var('templatefield_' . $row['qorder'], '') == '') 
			{
				// return user to index
				$message = $user->lang['APPLY_REQUIRED'];
				$message = $message . '<br /><br />' . sprintf($user->lang['RETURN_APPLY'], '<a href="' . append_sid("{$phpbb_root_path}apply.$phpEx") . '">', '</a>');
				$db->sql_freeresult($result);
				trigger_error($message);		 
			}
		
		}
		
	}
	$db->sql_freeresult($result);

	 
	$candidate_name = utf8_normalize_nfc(request_var('templatefield_1', ' ', true));
	// check for validate name. name can only be alphanumeric without spaces or special characters
	//if this preg_match returns true then there is something other than letters
   if (preg_match('/[^a-zA-ZàäåâÅÂçÇéèëËêÊïÏîÎæŒæÆÅóòÓÒöÖôÔøØüÜ\s]+/', $candidate_name  ))
   {
	  $message = $user->lang['ERROR_NAME']. $candidate_name . ' ';  
	  $message = $message . '<br /><br />' . sprintf($user->lang['RETURN_APPLY'], '<a href="' . append_sid("{$phpbb_root_path}apply.$phpEx") . '">', '</a>');
   	  trigger_error($message);	
   }

    $candidate_realm = trim(utf8_normalize_nfc(request_var('templatefield_2', $config['bbdkp_apply_realm'], true))); 
	$candidate_level = utf8_normalize_nfc(request_var('candidate_level', ' ', true));
	$candidate_game = request_var('game_id', '');
	$candidate_genderid = request_var('candidate_gender', 0);
	$candidate_raceid = request_var('candidate_race_id', 0);
			//character class
	$sql_array = array(
		'SELECT'	=>	' r.race_id, r.image_female_small, r.image_male_small, l.name as race_name ', 	 
		'FROM'		=> array(
				RACE_TABLE		=> 'r',
				BB_LANGUAGE		=> 'l', 
				),
		'WHERE'		=> " l.game_id = r.game_id AND r.race_id = '". $candidate_raceid ."' AND r.game_id = '" . $candidate_game . "' 
		AND l.attribute_id = r.race_id  AND l.language= '" . $config['bbdkp_lang'] . "' AND l.attribute = 'race' ",					 
		);
	$sql = $db->sql_build_query('SELECT', $sql_array);		
	$result = $db->sql_query($sql);	
	$row = $db->sql_fetchrow($result);
	if(isset($row))
	{
		$race_name = $row['race_name']; 
		$race_image = (string) (($candidate_genderid == 0) ? $row['image_male_small'] : $row['image_female_small']); 
		$race_image = (strlen($race_image) > 1) ? $board_url . "images/race_images/" . $race_image . ".png" : ''; 
		$race_image_exists = (strlen($race_image) > 1) ? true : false;
	}
	unset($row);
	$db->sql_freeresult($result);
	
	$candidate_classid = request_var('candidate_class_id', 0);
	//character class
	$sql_array = array(
		'SELECT'	=>	' c.class_armor_type AS armor_type , c.colorcode, c.imagename,  c.class_id, l.name as class_name ', 	 
		'FROM'		=> array(
				CLASS_TABLE		=> 'c',
				BB_LANGUAGE		=> 'l', 
				),
		'WHERE'		=> " l.game_id = c.game_id AND c.class_id = '". $candidate_classid ."' AND c.game_id = '" . $candidate_game . "' 
		AND l.attribute_id = c.class_id  AND l.language= '" . $config['bbdkp_lang'] . "' AND l.attribute = 'class' ",					 
		);
	$sql = $db->sql_build_query('SELECT', $sql_array);		
	$result = $db->sql_query($sql);	
	$row = $db->sql_fetchrow($result);
	if(isset($row))
	{
		$class_name =	$row['class_name']; 
		$class_color =  (strlen($row['colorcode']) > 1) ? $row['colorcode'] : '';
		$class_color_exists =  (strlen($row['colorcode']) > 1) ?  true : false;
		$class_image = 	strlen($row['imagename']) > 1 ? $board_url . "images/class_images/" . $row['imagename'] . ".png" : '';
		$class_image_exists =    (strlen($row['imagename']) > 1) ? true : false;
	}
	unset($row);
	$db->sql_freeresult($result);
	
	// if user belongs to group that can add a character then attempt to register a dkp character
	// guests should never be able to register characters (i.e user anonymous)
	if($auth->acl_get('u_dkp_charadd') )
	{
		if(!class_exists('dkp_character'))
		{
			include($phpbb_root_path . 'includes/bbdkp/apply/dkp_character.' . $phpEx);
		}
		$candidate = new dkp_character();
		$candidate->name = $candidate_name;
		$candidate->level = $candidate_level;
		$candidate->realm = $candidate_realm;
		$candidate->game = $candidate_game;
		$candidate->genderid = $candidate_genderid;
		$candidate->raceid = $candidate_raceid;
		$candidate->classid = $candidate_classid;
		register_bbdkp($candidate);
	}
		
	// build post
	$apply_post = '';
	
	$apply_post .= '[size=150][b]' .$user->lang['APPLY_CHAR_OVERVIEW'] . '[/b][/size]
	'; 
	$apply_post .= '<br />';
	
	// name
	$apply_post .= '[color='. $config['bbdkp_apply_pqcolor'] .']' . $user->lang['APPLY_NAME'] . '[/color]';
	if($class_color_exists)
	{
		$apply_post .= '[b][color='. $class_color .']' . $candidate_name . '[/color][/b]' ;
	}
	else
	{
		$apply_post .= '[b]' . $candidate_name . '[/b]' ;
	}
	$apply_post .= '<br />'; 

	//Realm
	$apply_post .= '[color='. $config['bbdkp_apply_pqcolor'] .']' . $user->lang['APPLY_REALM1'] . '[/color]' . '[color='. $config['bbdkp_apply_pacolor'] .']' . $candidate_realm . '[/color]' ;
	$apply_post .= '<br />'; 

	// level
	$apply_post .= '[color='. $config['bbdkp_apply_pqcolor'] .']' . $user->lang['APPLY_LEVEL'] . '[/color]' . '[color='. $config['bbdkp_apply_pacolor'] .']' . $candidate_level. '[/color]' ;
	$apply_post .= '<br />'; 
	
	// class
	$apply_post .= '[color='. $config['bbdkp_apply_pqcolor'] .']' . $user->lang['APPLY_CLASS'] . '[/color] ';
	if($class_image_exists )
	{
		$apply_post .= '[img]' .$class_image . '[/img] ';
	}
	if($class_color_exists)
	{
		$apply_post .= ' [color='. $class_color .']' . $class_name . '[/color]' ;
	}
	else
	{
		$apply_post .= $class_name;
	}
	$apply_post .= '<br />'; 

	//race
	$apply_post .= '[color='. $config['bbdkp_apply_pqcolor'] .']' . $user->lang['APPLY_RACE'] . '[/color] ';
	if($race_image_exists )
	{
		$apply_post .= '[img]' .$race_image . '[/img] ';
	}
	if($class_color_exists)
	{
		$apply_post .= ' [color='. $class_color .']' . $race_name . '[/color]' ;
	}
	else
	{
		$apply_post .= $race_name;
	}
	$apply_post .= '<br />';
	$apply_post .= '<br />';

	
	// Motivation	
	$apply_post .= '[size=150][b]' .$user->lang['APPLY_CHAR_MOTIVATION'] . '[/b][/size]';
	$apply_post .= '<br />';
	$apply_post .= '<br />';
	
	//$apply_post .= '[list]';
	// complete with formatted questions and answers
	$sql = "SELECT * FROM " . APPTEMPLATE_TABLE . ' ORDER BY qorder' ;
	$result = $db->sql_query_limit($sql, 100, 2);
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( isset($_POST['templatefield_' . $row['qorder']]) )
		{
			
			switch ($row['type'])
			{
					
				case 'Checkboxes':
					 $cb_countis = count( request_var('templatefield_' . $row['qorder'], array(0 => 0)) );  
                     $cb_count = 0;
						                                           
                        $apply_post .= '[size=120][color='. $config['bbdkp_apply_pqcolor'] .'][b]' . $row['question'] . ': [/b][/color][/size]
                        ';
                        
                        $checkboxes = utf8_normalize_nfc( request_var('templatefield_' . $row['qorder'], array(0 => '') , true));
                        foreach($checkboxes as $value) 
                        {
                            $apply_post .= $value;
                            if ($cb_count < $cb_countis-1)
                            {
                                $apply_post .= ',  ';
                            }
                            $cb_count++;
                        }
                        $apply_post .= '<br /><br />';                         
					
					break;
				case 'Inputbox':
				case 'Textbox':
				case 'Selectbox':					
				case 'Radiobuttons':			
					$fieldcontents = utf8_normalize_nfc(request_var('templatefield_' . $row['qorder'], ' ', true));	
						
					$apply_post .= '[size=120][color='. $config['bbdkp_apply_pqcolor'] .'][b]' . $row['question'] . ': [/b][/color][/size]
					';
					 
					$apply_post .=	$fieldcontents;
					
					$apply_post .= '<br /><br />'; 
					break;
					
					
			}

		}
	}
	$db->sql_freeresult($result);

	//$apply_post .= '[/list]';
	
	// variables to hold the parameters for submit_post
	$poll = $uid = $bitfield = $options = ''; 
	
	// parsed code
	generate_text_for_storage($apply_post, $uid, $bitfield, $options, true, true, true);

	// subject & username
	$post_data['post_subject']	= $candidate_name . " - " . $candidate_level . " " . $race_name . " ". $class_name;
	$post_data['username']	= $user->data['username'];
	
	// Store message, sync counters
	
		$data = array( 
		'forum_id'			=> (int) $post_data['forum_id'],
		'topic_first_post_id'	=> 0,
		'topic_last_post_id'	=> 0,
		'topic_attachment'		=> 0,		
		'icon_id'			=> false,
		'enable_bbcode'		=> true,
		'enable_smilies'	=> true,
		'enable_urls'		=> true,
		'enable_sig'		=> true,
		'message'			=> $apply_post,
		'message_md5'		=> md5($apply_post),
		'bbcode_bitfield'	=> $bitfield,
		'bbcode_uid'		=> $uid,
		'post_edit_locked'	=> 0,
		'topic_title'		=> $post_data['post_subject'],
		'notify_set'		=> false,
		'notify'			=> false,
		'post_time' 		=> $current_time,
		'poster_ip'			=> $user->ip,
		'forum_name'		=> '',
		'post_edit_locked'	=> 1,
		'enable_indexing'	=> true,
		'post_approved'        => 1,
		);
		
		
		//submit post
		$post_url = submit_post('post', $post_data['post_subject'], $post_data['username'], POST_NORMAL, $poll, $data);
		
		//if we're posting to private forum then redirect to portal, else redirect to post
		if($post_data['forum_id'] == $config['bbdkp_apply_forum_id_private'])
		{
			$redirect_url = append_sid("{$phpbb_root_path}portal.$phpEx"); 
		}
		else
		{
			$redirect_url = $post_url;
		}
			
		if ($config['enable_post_confirm'] && (isset($captcha) && $captcha->is_solved() === true))
		{
			$captcha->reset();
		}
		
		//redirect to post
		meta_refresh(3, $redirect_url);

		$message = 'POST_STORED';
		$message = $user->lang[$message] . '<br /><br />' . sprintf($user->lang['VIEW_MESSAGE'], '<a href="' . $redirect_url . '">', '</a>');
		$message .= '<br /><br />' . sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $data['forum_id']) . '">', '</a>');
		trigger_error($message);

}

/**
 * registers a bbDKP character 
 *
 * @param dkp_character $candidate
 */
function register_bbdkp(dkp_character $candidate)
{
	global $db, $auth, $user, $config, $phpbb_root_path, $phpEx;
	
	// check if user exceeded allowed character count, to prevent alt spamming
	$sql = 'SELECT count(*) as charcount
			FROM ' . MEMBER_LIST_TABLE . '	
			WHERE phpbb_user_id = ' . (int) $user->data['user_id'];
	$result = $db->sql_query($sql);
	$countc = $db->sql_fetchfield('charcount');
	$db->sql_freeresult($result);
	if ($countc >= $config['bbdkp_maxchars'])
	{
		//do nothing
		return;
	}
	
	// check if membername exists
	$sql = 'SELECT count(*) as memberexists 
			FROM ' . MEMBER_LIST_TABLE . "	
			WHERE ucase(member_name)= ucase('" . $db->sql_escape($candidate->name) . "')"; 
	$result = $db->sql_query($sql);
	$countm = $db->sql_fetchfield('memberexists');
	$db->sql_freeresult($result);
	if ($countm != 0)
	{
		// give a nice alert and stop right here.
		 trigger_error($user->lang['ERROR_MEMBEREXIST'], E_USER_WARNING);
	}
	
	$member_comment = 'candidate'; 
	
	// add the char
	if (! class_exists ( 'acp_dkp_mm' ))
	{
		include ($phpbb_root_path . 'includes/acp/acp_dkp_mm.' . $phpEx);
	}
	$acp_dkp_mm = new acp_dkp_mm ( );
		
	$member_id = $acp_dkp_mm->insertnewmember(
		$candidate->name,
		 1,
		$candidate->level,
		$candidate->raceid,
		$candidate->classid,
		99,
		$member_comment, 
		time(), 
		0, 
		0, 
		$candidate->genderid, 0, ' ', ' ', 
		$candidate->realm, 
		$candidate->game, 
		$user->data['user_id']
	);
	
	return $member_id;
	
}

/**
 *  build Application form 
 *
 */
function fill_application_form($post_data, $submit, $error, $captcha)
{
	global $user, $template, $config, $phpbb_root_path, $phpEx, $auth, $db;
	
	// Page title & action URL, include session_id for security purpose
	$s_action = append_sid("{$phpbb_root_path}apply.$phpEx", "", true, $user->session_id);
	
	$page_title = $user->lang['APPLY_MENU'];

	if ($config['enable_post_confirm'] && !$user->data['is_registered'] ) 
    {
    	if ((!$submit || !$captcha->is_solved()) )
    	{
	        // ... display the CAPTCHA
	        $template->assign_vars(array(
	            'S_CONFIRM_CODE'                => true,
	            'CAPTCHA_TEMPLATE'              => $captcha->get_template(),
	        ));
    	}
    }
	
	$s_hidden_fields =array(); 
	// Add the confirm id/code pair to the hidden fields, else an error is displayed on next submit/preview
	if (isset($captcha))
	{
		if ($captcha->is_solved() !== false)
		{
			$s_hidden_fields .= build_hidden_fields($captcha->get_hidden_fields());
		}
	}
	
	//get the hightest guildid with members
	$sql_array = array(
	    'SELECT'    => 'a.id, a.name, a.realm, a.region ',
	    'FROM'      => array(
	        GUILD_TABLE => 'a',
	        MEMBER_LIST_TABLE => 'b'
	    ),
	    'WHERE'     =>  'a.id = b.member_guild_id ',
	    'GROUP_BY'  =>  'a.id, a.name, a.realm, a.region', 
	    'ORDER_BY'	=>  'a.id DESC'
	);
	$sql = $db->sql_build_query('SELECT', $sql_array);
	$result = $db->sql_query($sql);

	$i=0;
	$guild_id = 0;
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ($i==0)
		{
			$guild_id = (int) $row['id']; 
			break;
		}
		$i+=1;
	}
	$db->sql_freeresult($result);
	
	//game
	$games = array(
		'aion'       => $user->lang['AION'],
		'daoc'       => $user->lang['DAOC'], 
		'eq'         => $user->lang['EQ'], 
		'eq2'        => $user->lang['EQ2'],
		'FFXI'       => $user->lang['FFXI'],
		'lotro'      => $user->lang['LOTRO'], 
		'rift'       => $user->lang['RIFT'],
		'swtor'      => $user->lang['SWTOR'], 
		'vanguard' 	 => $user->lang['VANGUARD'],
		'warhammer'  => $user->lang['WARHAMMER'],
		'wow'        => $user->lang['WOW'], 
      );
    $installed_games = array();
    foreach($games as $gameid => $gamename)
    {
     	//add value to dropdown when the game config value is 1
     	if ($config['bbdkp_games_' . $gameid] == 1)
     	{
     		$template->assign_block_vars('game_row', array(
				'VALUE' => $gameid,
				'SELECTED' => ( (isset($member['game_id']) ? $member['game_id'] : '') == $gameid ) ? ' selected="selected"' : '',
				'OPTION'   => $gamename, 
		));
      		$installed_games[] = $gameid; 
    	} 
    }
     
	// Race dropdown
	// reloading is done from ajax to prevent redraw
    $gamepreset = $installed_games[0];
	$sql_array = array(
	'SELECT'	=>	'  r.race_id, l.name as race_name ', 
	'FROM'		=> array(
			RACE_TABLE		=> 'r',
			BB_LANGUAGE		=> 'l',
				),
	'WHERE'		=> " r.race_id = l.attribute_id 
					AND r.game_id = '" . $gamepreset . "' 
					AND l.attribute='race' 
					AND l.game_id = r.game_id 
					AND l.language= '" . $config['bbdkp_lang'] ."'",
	);
	$sql = $db->sql_build_query('SELECT', $sql_array);
	$result = $db->sql_query($sql);
	while ( $row = $db->sql_fetchrow($result) )
	{
		$template->assign_block_vars('race_row', array(
		'VALUE' => $row['race_id'],
		'SELECTED' =>  '',
		'OPTION'   => ( !empty($row['race_name']) ) ? $row['race_name'] : '(None)')
		);
	}

	// Class dropdown
	// reloading is done from ajax to prevent redraw
	$sql_array = array(
		'SELECT'	=>	' c.class_id, l.name as class_name, c.class_hide,
						  c.class_min_level, class_max_level, c.class_armor_type , c.imagename ', 
		'FROM'		=> array(
			CLASS_TABLE		=> 'c',
			BB_LANGUAGE		=> 'l', 
			),
		'WHERE'		=> " l.game_id = c.game_id  AND c.game_id = '" . $gamepreset . "' 
		AND l.attribute_id = c.class_id  AND l.language= '" . $config['bbdkp_lang'] . "' AND l.attribute = 'class' ",					 
	);
	
	$sql = $db->sql_build_query('SELECT', $sql_array);					
	$result = $db->sql_query($sql);
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['class_min_level'] <= 1  ) 
		{
			 $option = ( !empty($row['class_name']) ) ? $row['class_name'] . " 
			 Level (". $row['class_min_level'] . " - ".$row['class_max_level'].")" : '(None)';
		}
		else
		{
			 $option = ( !empty($row['class_name']) ) ? $row['class_name'] . " 
			 Level ". $row['class_min_level'] . "+" : '(None)';
		}
		
		$template->assign_block_vars('class_row', array(
		'VALUE' => $row['class_id'],
		'SELECTED' => '',
		'OPTION'   => $option ));
		
	}
	$db->sql_freeresult($result);
             	
	
	
	// Start assigning vars for main posting page ...
	// main questionnaire 
	$sql = "SELECT * FROM " . APPTEMPLATE_TABLE . ' ORDER BY qorder';
	$result = $db->sql_query($sql);
					
	while ( $row = $db->sql_fetchrow($result) )
	{
		switch($row['type'])
		{
			case 'Inputbox':
				$type = '<input class="inputbox" style="width:300px;" 
				type="text" name="templatefield_' . $row['qorder'] . '" 
				size="40" maxlength="60" tabindex="' . $row['qorder'] . '" />';
				break;
			case 'Textbox':
				$type = '<textarea class="inputbox" name="templatefield_' . $row['qorder'] . '" rows="3" cols="76" 
				tabindex="' . $row['qorder'] . '" onselect="storeCaret(this);" 
				onclick="storeCaret(this);" 
				onkeyup="storeCaret(this);" ></textarea>';
				break;
			case 'Selectbox':
			    $type = '<select class="inputbox" name="templatefield_' . $row['qorder'] . '" tabindex="' . $row['qorder'] . '">';
			    $type .= '<option value="">----------------</option>';
			         $select_option = explode(',', $row['options']);
			         foreach($select_option as $value) 
			         {
			             $type .='<option value="'. $value .'">'. $value .'</option>';
			         }           
			    $type .= '</select>';             
				break;
			case 'Radiobuttons':
			    $radio_option = explode(',', $row['options']);
			  
			    $type = '';
			    foreach($radio_option as $value) 
			    {
			       $type .='<input type="radio" name="templatefield_'. $row['qorder'] .'" value="'. $value .'"/>&nbsp;'. $value .'&nbsp;&nbsp;';
			    }           
				break;
			case 'Checkboxes':
		        $check_option = explode(',', $row['options']);
		         
		        $type = '';
		        foreach($check_option as $value) 
		        {
		           $type .='<input type="checkbox" name="templatefield_'. $row['qorder'] .'[]" value="'. $value .'"/>&nbsp;'. $value .'&nbsp;&nbsp;';
		        }           
				break;
		}
		
		$mandatory = '';
		
		if ( $row['mandatory'] == 'True' )
		{
			$mandatory = '&nbsp;<span style="color:red">' . $user->lang['MANDATORY']. '</span>';
		}
		
		if ((int) $row['qorder'] <= 2)
		{
			// Character Name and Realm, put on top
			$template->assign_block_vars('templatestart', array(
				'QORDER'		=> $row['qorder'],
				'QUESTION'		=> $row['question'],
				'EXPLAIN'		=> $row['explainstr'],
				'OPTIONS'   	=> $row['options'],
				'TYPE'			=> $type,
				'MANDATORY' 	=> $mandatory)
			);					
			
		}
		else 
		{
			// main questionnaire put below
			$template->assign_block_vars('apptemplate', array(
				'QORDER'		=> $row['qorder'],
				'QUESTION'		=> $row['question'],
				'EXPLAINSTR'		=> $row['explainstr'],
				'OPTIONS'   	=> $row['options'],
				'TYPE'			=> $type,
				'MANDATORY' 	=> $mandatory)
			);					
		}
			
	}
	$db->sql_freeresult($result);
	
	$form_enctype = (@ini_get('file_uploads') == '0' || strtolower(@ini_get('file_uploads')) == 'off' || !$config['allow_attachments'] || !$auth->acl_get('u_attach') || !$auth->acl_get('f_attach', $post_data['forum_id'])) ? '' : ' enctype="multipart/form-data"';
	add_form_key('applyposting');
	
	// assign global template vars to questionnaire
	$template->assign_vars(array(
		'S_SHOW_FORUMCHOICE'	=> ( $config['bbdkp_apply_forumchoice'] == '1' ) ? TRUE : FALSE,
		'PUBLIC_YES_CHECKED' 	=> ( $config['bbdkp_apply_visibilitypref'] == '1' ) ? ' checked="checked"' : '',
		'PUBLIC_NO_CHECKED'  	=> ( $config['bbdkp_apply_visibilitypref'] == '0' ) ? ' checked="checked"' : '', 
		'L_POST_A'				=> $page_title,
		'ERROR'					=> (sizeof($error)) ? implode('<br />', $error) : '',
		'S_POST_ACTION'     	=> $s_action,
		'S_HIDDEN_FIELDS'   	=> $s_hidden_fields,
		'APPLY_REALM'			=> str_replace("+", " ", $config['bbdkp_apply_realm']), 
		'FORMQCOLOR'			=> $config['bbdkp_apply_fqcolor'], 
		'S_FORM_ENCTYPE'		=> $form_enctype,
		// javascript
		'LA_ALERT_AJAX'		  => $user->lang['ALERT_AJAX'],
		'LA_ALERT_OLDBROWSER' => $user->lang['ALERT_OLDBROWSER'],
		'LA_MSG_NAME_EMPTY'	  => $user->lang['FV_REQUIRED_NAME'],
		'LA_MSG_LEVEL_EMPTY'  => $user->lang['FV_REQUIRED_LEVEL'],	
		
		)
	);
		
	// Output application form
	page_header($page_title);
	
	$template->set_filenames(array(
		'body' => 'dkp/application.html')
	);
	
	page_footer();
	
	
}
	
/**
 * check form access before even posting. 
 *
 * @return array $post_data
 */
function check_apply_form_access()
{
	global $auth, $db, $config, $user;		
	
	$user->add_lang(array('posting'));
	//find out which forum we will be posting to
	if($config['bbdkp_apply_forumchoice'] == '1')
	{
		//user can choose
		if(request_var('publ', 1) == 1 )
		{
			// if user made choice for public or if it is a guest then get public forumid 
			$forum_id = $config['bbdkp_apply_forum_id_public'];
		}
		else 
		{
			$forum_id = $config['bbdkp_apply_forum_id_private'];
		}
	}
	else
	{
		//fetch forum from $config
		if($config['bbdkp_apply_visibilitypref'] == '1')  
		{
			$forum_id = $config['bbdkp_apply_forum_id_public'];
		}
		else 
		{
			$forum_id = $config['bbdkp_apply_forum_id_private'];
		}
	}
	
	$sql = 'SELECT * FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $forum_id;
	$result = $db->sql_query($sql);
	$post_data = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	
	// Check permissions
	if ($user->data['is_bot'])
	{
		redirect(append_sid("{$phpbb_root_path}index.$phpEx"));
	}
		
	//set up style vars
	$user->setup(false, $post_data['forum_style']);	
	
	// check authorisations
	$is_authed = false;
	// user has posting permission to the forum ?  
	if ($auth->acl_get('f_post', $forum_id))
	{
		//user is authorised for the forum
		$is_authed = true;
	}
	else
	{
		//user has no posting rights in the requested forum
		if ($user->data['is_registered'])
		{
			trigger_error('USER_CANNOT_' . strtoupper($check_auth));
		}
		
		//it's a guest and theres no guest access for the forum so ask for a valid login
		login_box('', $user->lang['LOGIN_EXPLAIN_POST']);
	}
	
	// even if guest user has posting rights, we still want to check in our config 
	// if he actually may use the application
	if ($config['bbdkp_apply_guests'] == 'False' && !$user->data['is_registered'])
	{
		$is_authed = false;
	}
	
	// Is the user able to post within this forum? (i.e it's a category)
	if ($post_data['forum_type'] != FORUM_POST)
	{
		trigger_error('USER_CANNOT_FORUM_POST');
	}
	
	// is Forum locked ?
	if (($post_data['forum_status'] == ITEM_LOCKED || (isset($post_data['topic_status']) && $post_data['topic_status'] == ITEM_LOCKED)) && !$auth->acl_get('m_edit', $forum_id))
	{
		trigger_error(($post_data['forum_status'] == ITEM_LOCKED) ? 'FORUM_LOCKED' : 'TOPIC_LOCKED');
	}
	
	return $post_data;
		
	
}
