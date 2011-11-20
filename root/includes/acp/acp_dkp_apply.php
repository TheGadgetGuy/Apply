<?php
/**
* This acp manages Guild Applications 
* Application form created by Kapli (bbDKP developer)
*
* @package bbDkp.acp
* @author Kapli
* @version $Id$
* @copyright (c) 2009 bbdkp http://code.google.com/p/bbdkp/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* 
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}
if (! defined('EMED_BBDKP')) 
{
    trigger_error($user->lang['BBDKPDISABLED'], E_USER_WARNING);
}

class acp_dkp_apply extends bbDkp_Admin
{
   var $u_action;
   function main($id, $mode)
   {
      global $db, $user, $auth, $template,  $sid, $cache;
      global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx; 
      $user->add_lang(array('common'));
	  $user->add_lang(array('mods/dkp_admin'));
	  $user->add_lang(array('mods/dkp_common'));
	  $user->add_lang(array('mods/apply'));

	  switch($mode)
      {
       		/***
             * APPLICATIONCONFIG
             * 
             */
            case 'apply_settings' :
                $link = '<br /><a href="' . append_sid("index.$phpEx", "i=dkp_apply&amp;mode=apply_settings") . '">' . $user->lang['APPLY_ACP_RETURN'] . '</a>';
                $armsettings = (isset($_POST['savearm'])) ? true : false;
                $prisettings = (isset($_POST['savepri'])) ? true : false; 
                $update = (isset($_POST['update'])) ? true : false;
                $addnew = (isset($_POST['add'])) ? true : false;
				$colorsettings = (isset($_POST['updatecolor'])) ? true : false;
                /*
                 * privacy settings handler
                 */
               if($prisettings)
               {
                    set_config('bbdkp_apply_forum_id_public', request_var('app_id_pub', 0), true );	
                    set_config('bbdkp_apply_forum_id_private', request_var('app_id_pri', 0), true );	
                    set_config('bbdkp_apply_visibilitypref', request_var('priv', 0), true );
                    set_config('bbdkp_apply_forumchoice', request_var('forumchoice', 0), true );
                    set_config('bbdkp_apply_guests', request_var('guests', ''), true );	
                    $cache->destroy('config');
                    trigger_error($user->lang['APPLY_ACP_SETTINGSAVED'] . $link);
               }
                /*
                 * armory settings handler
                 */
               if($armsettings)
               {
                    if (!isset($_POST['realm']) or request_var('realm', '') == '') 
                    {
                        trigger_error( $user->lang['APPLY_ACP_REALMBLANKWARN'] . adm_back_link($this->u_action), E_USER_WARNING);
                    }
                    set_config('bbdkp_apply_realm', utf8_normalize_nfc(str_replace(" ", "+", request_var('realm','', true)))  , true );	
                    set_config('bbdkp_apply_region', request_var('region', ''), true );	
                    $cache->destroy('config');
                    trigger_error($user->lang['APPLY_ACP_SETTINGSAVED'] . $link);
               }
                               
               if ($update) 
                {
                    /* updating questions */
                    $sql = "SELECT * FROM " . APPTEMPLATE_TABLE . ' ORDER BY qorder';

                    // return 100 questions - lol ;)
                    $result = $db->sql_query_limit($sql, 100, 2);
                    
                    while ($row = $db->sql_fetchrow($result)) 
                    {
                        if ( !isset($_POST[$row['qorder']]) || !isset($_POST[$row['qorder'] . 'question'])) 
                        {
                            trigger_error( $user->lang['APPLY_ACP_ORDQU_NOTEMPTY']  . adm_back_link($this->u_action), E_USER_WARNING);
                        }
                        
                        if (request_var($row['qorder'], 0) == 0 ) 
                        {
                            trigger_error( $user->lang['APPLY_ACP_ORDQU_NUMB'] . adm_back_link($this->u_action), E_USER_WARNING);
                        }
                        
                        if (request_var($row['qorder'], 0) == 1 or request_var($row['qorder'], 0) ==2 ) 
                        {
                            trigger_error(  $user->lang['APPLY_ACP_ORDQU_NUMBRES'] . adm_back_link($this->u_action), E_USER_WARNING);
                        }
                        
                        if ( request_var($row['qorder'] . 'question', ' ') == $user->lang['APPLY_ACP_REALM'] || request_var($row['qorder'] . 'question', ' ') == $user->lang['APPLY_ACP_CHARNAME']) 
                        {
                            trigger_error($user->lang['APPLY_ACP_TWOREALM'] . adm_back_link($this->u_action), E_USER_WARNING);
                        }
                        
                        $mandatory = 'False';
                        
                        if ( request_var($row['qorder'] . 'mandatory', ' ') == 'True') 
                        {
                            $mandatory = 'True';
                        }
                        
                        $queries = array(
                                "UPDATE " . APPTEMPLATE_TABLE . " SET qorder = '" .  request_var($row['qorder'],0) . "' WHERE qorder = " . (int) $row['qorder'] ,
                    			"UPDATE " . APPTEMPLATE_TABLE . " SET question = '" . $db->sql_escape( utf8_normalize_nfc(request_var($row['qorder'] . 'question','' , true))) . "' WHERE qorder = " . (int) $row['qorder'] ,
                        		"UPDATE " . APPTEMPLATE_TABLE . " SET explainstr = '" . $db->sql_escape( utf8_normalize_nfc(request_var($row['qorder'] . 'explainstr','' , true))) . "' WHERE qorder = " . (int) $row['qorder'] , 
                			    "UPDATE " . APPTEMPLATE_TABLE . " SET options = '" . $db->sql_escape( utf8_normalize_nfc(request_var($row['qorder'] . 'options','' , true))) . "' WHERE qorder = " . (int) $row['qorder'] ,
                    			"UPDATE " . APPTEMPLATE_TABLE . " SET type = '" . $db->sql_escape(request_var($row['qorder'] . 'type', '')) . "' WHERE qorder = " . (int) $row['qorder'] ,
                    			"UPDATE " . APPTEMPLATE_TABLE . " SET mandatory = '" . $db->sql_escape($mandatory) . "' WHERE qorder = " . (int) $row['qorder'],
                        ); 
                        foreach ($queries as $sql) 
                        {
                            $db->sql_query($sql);
                        }
                    }
                    $db->sql_freeresult($result);
                    
                    trigger_error( $user->lang['APPLY_ACP_QUESTUPD']  . $link);    
                }
                
                if ($addnew) 
                {
                	
                	/* validation */
                	
                    /* adding order and question */
                	if ( request_var('app_add_question', '') == '' ) 
                    {
                        trigger_error( $user->lang['APPLY_ACP_ORDQUEST'] . adm_back_link($this->u_action), E_USER_WARNING);
                    }
                    
					if ( request_var('app_add_options', '') == '' )
					{
					    trigger_error( $user->lang['APPLY_ACP_ORDQUEST'] . adm_back_link($this->u_action), E_USER_WARNING);
					}
                    
                    /* Order can only be numbers and not zero. */
                    if ( request_var('app_add_order', 0) == 0 ) 
                    {
                        trigger_error(  $user->lang['APPLY_ACP_ORDQU_NUMB']  . adm_back_link($this->u_action), E_USER_WARNING);
                    }
                    
                    /* Reserved. Order can not be 1 or 2. */
                    if ( request_var('app_add_order',0) == 1 || request_var('app_add_order',0) == 2) 
                    {
                        trigger_error( $user->lang['APPLY_ACP_ORDQU_NUMBRES'] . adm_back_link($this->u_action), E_USER_WARNING);
                    }
                    
                    /* You can not have two of realms or character names. */
                    if (request_var('app_add_question','') == $user->lang['APPLY_ACP_REALM'] || request_var('app_add_question','') == $user->lang['APPLY_ACP_CHARNAME']) 
                    {
                        trigger_error($user->lang['APPLY_ACP_TWOREALM']  . adm_back_link($this->u_action), E_USER_WARNING);
                    }
                    
                    $mandatory = (isset($_POST['app_add_mandatory']) ? 'True': 'False'); 
                    
                    $sql_ary = array(
                        'qorder'     	=> (int) request_var('app_add_order', 0),
    				 	'question'   	=> utf8_normalize_nfc (request_var('app_add_question', ' ', true )),
                    	'explainstr'   	=> utf8_normalize_nfc (request_var('app_add_explainstr', ' ', true )),
                        'options'   	=> utf8_normalize_nfc (request_var('app_add_options', ' ', true )),                    
                        'type'       	=> utf8_normalize_nfc (request_var('app_add_type', ' ', true )),
                        'mandatory' 	=> $mandatory
                    );
                    
                    //first delete old question with that number if there were one
                    $sql = 'DELETE FROM ' . APPTEMPLATE_TABLE . ' where qorder = ' . (int) request_var('app_add_order', 0); 
                    $result = $db->sql_query($sql);

                    // insert new question
                    $sql = 'INSERT INTO ' . APPTEMPLATE_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
                    $result = $db->sql_query($sql);
                    
                    if (!$result)
                    {
                        trigger_error( $user->lang['APPLY_ACP_QUESTNOTADD'] . $link, E_USER_WARNING);
                    }
                    else 
                    {
                        trigger_error( $user->lang['APPLY_ACP_QUESTNADD']  .  $link);    
                    }
                        
                    
                }
                
         		/*
                 * color settings handler
                 */
               if($colorsettings)
               {
					$colorid = request_var('app_textcolors', ''); 
					$newcolor = request_var('applyquestioncolor', '');
					switch 	($colorid)
					{
						case 'postqcolor':
		               		set_config('bbdkp_apply_pqcolor', $newcolor, true );	
							break;
						case 'postacolor':
		               		set_config('bbdkp_apply_pacolor', $newcolor, true );	
		               		break;
						case 'formqcolor':
		               		set_config('bbdkp_apply_fqcolor', $newcolor, true );	
							break;
					}
                    $cache->destroy('config');
               }
                
                /* delete question handler */
                $sql = "SELECT * FROM " . APPTEMPLATE_TABLE . ' ORDER BY qorder';
                $result = $db->sql_query($sql);
                while ($row = $db->sql_fetchrow($result)) 
                {
                    if (isset($_POST[$row['qorder'] . 'delete'])) 
                    {
                        $sql = "DELETE FROM " . APPTEMPLATE_TABLE . " WHERE qorder = '" . $row['qorder'] . "'";
                        $db->sql_query($sql);
                        trigger_error("Question " . $row['qorder'] . " deleted" . $link, E_USER_WARNING);
                    }
                }
                unset($row); 
                $db->sql_freeresult($result);

                
                /*
				 * loading config
				 */

                $template->assign_vars(array(
                	'REALM'        			=> str_replace("+", " ", $config['bbdkp_apply_realm']), 
                	'PUBLIC_YES_CHECKED' 	=> ( $config['bbdkp_apply_visibilitypref'] == '1' ) ? ' checked="checked"' : '',
    				'PUBLIC_NO_CHECKED'  	=> ( $config['bbdkp_apply_visibilitypref'] == '0' ) ? ' checked="checked"' : '', 
                	'FORUM_CHOICE_YES_CHECKED' 	=> ( $config['bbdkp_apply_forumchoice'] == '1' ) ? ' checked="checked"' : '',
    				'FORUM_CHOICE_NO_CHECKED' 	=> ( $config['bbdkp_apply_forumchoice'] == '0' ) ? ' checked="checked"' : '',                 
                	'APPLY_VERS' 		 	=> $config['bbdkp_apply_version'], 
      				'POSTQCOLOR'			=> $config['bbdkp_apply_pqcolor'],
	                'POSTACOLOR'			=> $config['bbdkp_apply_pacolor'],
	                'FORMQCOLOR'			=> $config['bbdkp_apply_fqcolor'], 
					// loading forumlist
					'APPLY_FORUM_PUB_OPTIONS' => make_forum_select($config['bbdkp_apply_forum_id_public'],false, false, true),
					'APPLY_FORUM_PRIV_OPTIONS' => make_forum_select($config['bbdkp_apply_forum_id_private'],false, false, true),
                
                ));
                
                //region
                $template->assign_block_vars('region', array(
                	'VALUE' 	=> 'EU' , 
                	'SELECTED' 	=> ('EU' == $config['bbdkp_apply_region']) ? ' selected="selected"' : '' , 
                	'OPTION' 	=> 'EU'));
                
                $template->assign_block_vars('region', array(
                	'VALUE' 	=> 'US' , 
                	'SELECTED' 	=> ('US' == $config['bbdkp_apply_region']) ? ' selected="selected"' : '' , 
                	'OPTION' 	=> 'US'));
                
                //guests
				$template->assign_block_vars('guests', array(
                	'VALUE' 	=> 'True' , 
                	'SELECTED' 	=> ('True' == $config['bbdkp_apply_guests']) ? ' selected="selected"' : '' , 
                	'OPTION' 	=> 'True'));
                
                $template->assign_block_vars('guests', array(
                	'VALUE' 	=> 'False' , 
                	'SELECTED' 	=> ('False' == $config['bbdkp_apply_guests']) ? ' selected="selected"' : '' , 
                	'OPTION' 	=> 'False'));
                
               /*
                * loading questions
                */
                $sql = 'SELECT * FROM ' . APPTEMPLATE_TABLE . ' ORDER BY qorder';
                
                $result = $db->sql_query($sql);
                while ($row = $db->sql_fetchrow($result)) 
                {
                    $disabled = '';
                    if ($row['question'] == $user->lang['APPLY_ACP_CHARNAME'] or $row['question'] == $user->lang['APPLY_ACP_REALM']) 
                    {
                        $disabled = 'disabled="disabled"';
                    }
                    
                    $checked = '';
                    if ($row['mandatory'] == 'True') 
                    {
                        $checked = 'checked="checked"';
                    }
                    
                    $template->assign_block_vars('apptemplate', array(
                    	'QORDER'         => $row['qorder'] , 
                    	'QUESTION'       => $row['question'] ,
                    	'EXPLAINSTR'     => $row['explainstr'] , 
                    	'DISABLED'       => $disabled , 
                    	'MANDATORY'      => $row['mandatory'] , 
                        'OPTIONS'        => $row['options'] ,
                    	'CHECKED'        => $checked));
                    
                    $type = array('Inputbox' , 'Textbox', 'Selectbox', 'Radiobuttons', 'Checkboxes');
                    foreach ($type as $t_name => $t_value) 
                    {
                        $template->assign_block_vars('apptemplate.template_type', array(
                        	'TYPE' => $t_value , 
                        	'SELECTED' => ($t_value == $row['type']) ? ' selected="selected"' : '' , 
                        	'DISABLED' => $disabled));
                    }
                }
                $db->sql_freeresult($result);
                
                
                $this->page_title = $user->lang['ACP_DKP_APPLY']; 
                $this->tpl_name = 'dkp/acp_' . $mode;
                break;
      }
   }
 
}

?>