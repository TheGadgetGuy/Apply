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
if(!defined("EMED_BBDKP"))
{
    trigger_error('bbDkp is currently disabled.', E_USER_WARNING); 
}

// Start session management
$user->session_begin();
$auth->acl($user->data);
include($phpbb_root_path . 'includes/bbdkp/apply/apply.' . $phpEx);

$mode = 'post';
$error = $post_data = array();
$current_time = $user->time_now; 
//set up language vars
$user->setup(array('posting', 'mcp', 'viewtopic', 'mods/apply'), false);

// if "enable visual confirmation for guest postings" is set to "ON"
// and the user is not registered 
// then set up captcha  
if ($config['enable_post_confirm'] && !$user->data['is_registered'])  
{
	include($phpbb_root_path . 'includes/captcha/captcha_factory.' . $phpEx);
	$captcha =& phpbb_captcha_factory::get_instance($config['captcha_plugin']);
	$captcha->init(CONFIRM_POST);
}

//request variables
$submit	= (isset($_POST['post'])) ? true : false;

//find out which forum we will be posting to
if($config['bbdkp_apply_forumchoice'] == '1')
{
	//fetch forum from user input
	if(request_var('publ', 1) == 1 )
	{
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
	//user has no posting rights in the recruitment forum

	if ($user->data['is_registered'])
	{
		trigger_error('USER_CANNOT_' . strtoupper($check_auth));
	}
	
	//it's a guest and theres no guest access for the forum so ask for a valid login
	login_box('', $user->lang['LOGIN_EXPLAIN_' . strtoupper($mode)]);
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


if ($submit)
{
	// validate captcha 
	
	// if "enable visual confirmation for guest postings" is set to "ON"
	// and mode is set to posting 
	// and the user is not registered 
	// then captcha will be validated
	if ($config['enable_post_confirm'] && in_array($mode, array('post')) && !$user->data['is_registered'] )
	{
		$vc_response = $captcha->validate();
		if ($vc_response)
		{
			$error[] = $vc_response;
		}
	}
	
}


if ($submit && !sizeof($error) && check_form_key('applyposting') )
{

	//check if user forgot to enter a required field
	$empty = FALSE;
	//select all required fields
	$sql = "SELECT * FROM " . APPTEMPLATE_TABLE . " where mandatory = 'True' ORDER BY qorder   ";
	$result = $db->sql_query_limit($sql, 100, 1);
	while ( $row = $db->sql_fetchrow($result) )
	{
		
		if ($row['type']=='Checkboxes')
		{
			if ( request_var($row['qorder'],  array('' => '')) == '') 
			{
				// return user to index
				$message = $user->lang['APPLY_REQUIRED'];
				$message = $message . '<br /><br />' . sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>');
				$db->sql_freeresult($result);
				trigger_error($message);		 
			}
		}
		else 
		{
			if ( request_var($row['qorder'], '') == '') 
			{
				// return user to index
				$message = $user->lang['APPLY_REQUIRED'];
				$message = $message . '<br /><br />' . sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>');
				$db->sql_freeresult($result);
				trigger_error($message);		 
			}
		}
		
		
	}
	$db->sql_freeresult($result);
	
	// retrieve parameters
	// declare class
	$candidate = new dkp_character();
	$candidate->name = utf8_normalize_nfc(request_var('1', ' ', true));
	
	//get realm (replace this with dropdown ??)
	$candidate->realm = trim(utf8_normalize_nfc(request_var('2', $config['bbdkp_apply_realm'], true))); 
	if ( $candidate->realm == '')
	{
		//get from $config
		$candidate->realm = str_replace(" ", "+", $config['bbdkp_apply_realm']);
	}

	// build post
	$apply_post = '';
	
	// if armory is down or simplerecruit mode is 'on' then get data from apply form
	if (request_var('gethidden', '') == '1' or $config['bbdkp_apply_simplerecruit'] == 'True' )
	{
		//character name
		$apply_post .= '[color=#105289]' . $user->lang['APPLY_NAME'] . '[/color]' .  $candidate->name ;
		$apply_post .= '<br />'; 
		
		$candidate->level = utf8_normalize_nfc(request_var('level', ' ', true));
		//character level
		$apply_post .= '[color=#105289]' . $user->lang['APPLY_LEVEL'] . '[/color]' .  $candidate->level ;
		$apply_post .= '<br />'; 

		//character Realm
		$apply_post .= '[color=#105289]' . $user->lang['APPLY_REALM1'] . '[/color]' .  $candidate->realm ;
		$apply_post .= '<br />'; 
		
		//character class
		$class = utf8_normalize_nfc(request_var('class', ' ', true));
		switch 	($class)
		{
			case 'SR_DK': $candidate->class = $user->lang['SR_DK'];
				break;
			case 'SR_DRUID':  $candidate->class = $user->lang['SR_DRUID'];
				break;
			case 'SR_HUNTER': $candidate->class = $user->lang['SR_HUNTER'];
				break;
			case 'SR_MAGE': $candidate->class = $user->lang['SR_MAGE'];
				break;
			case 'SR_PALADIN': $candidate->class = $user->lang['SR_PALADIN'];
				break;
			case 'SR_PRIEST': $candidate->class = $user->lang['SR_PRIEST'];
				break;
			case 'SR_ROGUE': $candidate->class = $user->lang['SR_ROGUE'];
				break;
			case 'SR_SHAMAN': $candidate->class = $user->lang['SR_SHAMAN'];
				break;
			case 'SR_WARLOCK': $candidate->class = $user->lang['SR_WARLOCK'];
				break;
			case 'SR_WARRIOR': $candidate->class = $user->lang['SR_WARRIOR'];
				break;								
		}
		$apply_post .= '[color=#105289]' . $user->lang['APPLY_CLASS'] . '[/color] ' .  $candidate->class ;
		$apply_post .= '<br />'; 
	
		$candidate->professions = utf8_normalize_nfc(request_var('professions', ' ', true));
		$apply_post .= '[color=#105289]' . $user->lang['APPLY_PROFF'] . '[/color] ' .  $candidate->professions ;
		$apply_post .= '<br />'; 
		
		$candidate->talents = utf8_normalize_nfc(request_var('talents', ' ', true));
		$apply_post .= '[color=#105289]' . $user->lang['APPLY_TALENT'] . '[/color] ' .  $candidate->talents ;
		$apply_post .= '<br /><br />'; 
	}
	else 
	{
		// get data from Blizz armory
		if ($candidate->GetChar1($candidate->name, $candidate->realm) == true )
		{
			//if this returns true then the modeltemplate property of candidate is filled and we add it to apply post. 
			$apply_post = $candidate->modeltemplate; 
		}
		else 
		{
			// some error happened. only questions will be inserted to topic
		}
	}
	
	$apply_post .= '<br /><br />';
	
	// complete with questions
	$sql = "SELECT * FROM " . APPTEMPLATE_TABLE . ' ORDER BY qorder' ;
	$result = $db->sql_query_limit($sql, 100, 2);
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( isset($_POST[$row['qorder']]) )
		{
			
			switch ($row['type'])
			{
					
				case 'Checkboxes':
					 $cb_countis = count( request_var('qorder', array(0 => 0)) );
                     $cb_count = 0;
                                           
                        $apply_post .= '[color=#105289][b]' . $row['question'] . ': [/b][/color]';
                       
                        foreach(request_var($row['qorder'], array(0 => '')) as $value) 
                        {
                            $apply_post .= $value;
                            if ($cb_count < $cb_countis-1)
                            {
                                $apply_post .= ', ';
                            }
                            $cb_count++;
                        }
                        $apply_post .= '<br /><br />';                         
					
					break;
				case 'Inputbox':
				case 'Textbox':
				case 'Selectbox':					
				case 'Radiobuttons':					
					$apply_post .= '[color=#105289][b]' . $row['question'] . ': [/b][/color]<br />' . utf8_normalize_nfc(request_var($row['qorder'], ' ', true));
					$apply_post .= '<br /><br />'; 
					break;
					
					
			}

		}
	}
	$db->sql_freeresult($result);

	// variables to hold the parameters for submit_post
	$poll = $uid = $bitfield = $options = ''; 
	
	// parsed code
	generate_text_for_storage($apply_post, $uid, $bitfield, $options, true, true, true);

	// subject & username
	$post_data['post_subject']	= $candidate->name . " - " . $candidate->level . " " . $candidate->race . " ". $candidate->class;
	$post_data['username']		= $candidate->name;
	
	// Store message, sync counters

	
		$data = array( 
		'forum_id'			=> (int)$forum_id,
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
		//if we're posting to private forum then redirect to portal, else redirect to post
		if($forum_id == $config['bbdkp_apply_forum_id_private'])
		{
			$redirect_url = append_sid("{$phpbb_root_path}portal.$phpEx"); 
			submit_post($mode, $post_data['post_subject'], $post_data['username'], POST_NORMAL, $poll, $data);
		}
		else
		{
			$redirect_url = submit_post($mode, $post_data['post_subject'], $post_data['username'], POST_NORMAL, $poll, $data);
		}
			
		if ($config['enable_post_confirm'] && (isset($captcha) && $captcha->is_solved() === true) && ($mode == 'post'))
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

	// build form 
	
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
	if (isset($captcha) && $captcha->is_solved() !== false)
	{
		$s_hidden_fields .= build_hidden_fields($captcha->get_hidden_fields());
	}
	
	// Start assigning vars for main posting page ...
	// main questionnaire 
	$sql = "SELECT * FROM " . APPTEMPLATE_TABLE . ' ORDER BY qorder';
	$result = $db->sql_query($sql);
					
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['type'] == 'Inputbox' )
		{
			$type = '<input class="inputbox" style="width:300px;" 
			type="text" name="' . $row['qorder'] . '" 
			size="40" maxlength="60" tabindex="' . $row['qorder'] . '" />';
		}
		elseif ( $row['type'] == 'Textbox' ) 
		{
			$type = '<textarea class="inputbox" name="' . $row['qorder'] . '" rows="3" cols="76" 
			tabindex="' . $row['qorder'] . '" onselect="storeCaret(this);" 
			onclick="storeCaret(this);" 
			onkeyup="storeCaret(this);" 
			style="width: 100%;"></textarea>';
		}
		elseif ( $row['type'] == 'Selectbox' )
		{
		   $type = '<select class="inputbox" name="' . $row['qorder'] . '" tabindex="' . $row['qorder'] . '">';
		   $type .= '<option value="">----------------</option>';
		         $select_option = explode(',', $row['options']);
		         foreach($select_option as $value) 
		         {
		             $type .='<option value="'. $value .'">'. $value .'</option>';
		         }           
		   $type .= '</select>';             
		}
		elseif ( $row['type'] == 'Radiobuttons' )
		{
		   $radio_option = explode(',', $row['options']);
		  
		   $type = '';
		   foreach($radio_option as $value) 
		   {
		       $type .='<input type="radio" name="'. $row['qorder'] .'" value="'. $value .'">&nbsp;'. $value .'&nbsp;&nbsp;';
		   }           
		}
       elseif ( $row['type'] == 'Checkboxes' )
       {
          $check_option = explode(',', $row['options']);
         
          $type = '';
          foreach($check_option as $value) 
          {
              $type .='<input type="checkbox" name="'. $row['qorder'] .'[]" value="'. $value .'">&nbsp;'. $value .'&nbsp;&nbsp;';
          }           
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
				'OPTIONS'   	=> $row['options'],
				'TYPE'			=> $type,
				'MANDATORY' 	=> $mandatory)
			);					
			
		}
		else 
		{
			// main questionnaire put below
			$template->assign_block_vars('template', array(
				'QORDER'		=> $row['qorder'],
				'QUESTION'		=> $row['question'],
				'OPTIONS'   	=> $row['options'],
				'TYPE'			=> $type,
				'MANDATORY' 	=> $mandatory)
			);					
		}
			
	}
	$db->sql_freeresult($result);
	
	/*
	 * simplerecruit or initial armory down check
	 */
	$simplemode = true;
	if( $config['bbdkp_apply_simplerecruit'] == 'False')
	{
		//check if Armory is online
		$applyclass = new applycore();
		if($applyclass->armoryonline == true)
		{
			$simplemode = false;
		}
	}
	
	add_form_key('applyposting');
	
	$template->assign_vars(array(
		'S_SHOW_FORUMCHOICE'	=> ( $config['bbdkp_apply_forumchoice'] == '1' ) ? TRUE : FALSE,
		'PUBLIC_YES_CHECKED' 	=> ( $config['bbdkp_apply_visibilitypref'] == '1' ) ? ' checked="checked"' : '',
		'PUBLIC_NO_CHECKED'  	=> ( $config['bbdkp_apply_visibilitypref'] == '0' ) ? ' checked="checked"' : '', 
     	'S_ARMORY_DOWN'			=> $simplemode,
		'L_POST_A'				=> $page_title,
		'ERROR'					=> (sizeof($error)) ? implode('<br />', $error) : '',
		'S_POST_ACTION'     	=> $s_action,
		'S_HIDDEN_FIELDS'   	=> $s_hidden_fields,
		'APPLY_REALM'			=> str_replace("+", " ", $config['bbdkp_apply_realm']))
	);
		
	// Output application form
	page_header($page_title);
	
	$template->set_filenames(array(
		'body' => 'dkp/application.html')
	);
	
	page_footer();


