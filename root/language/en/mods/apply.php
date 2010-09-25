<?php
/**
* language file Application form English
* @author Sajaki
* @package bbDkp
* @copyright (c) 2009 bbDkp <http://code.google.com/p/bbdkp/>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @version $Id$
* 
*/
 
/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

/*  here you change the fixed strings  for the recruitment page */

$lang = array_merge($lang, array(

/****** installer ********/
'APPLY_INSTALL_MOD' =>  'Application Mod version %s installed successfully. ',
'APPLY_UNINSTALL_MOD' =>  'Application Mod version %s uninstalled successfully. ',
'APPLY_UPD_MOD' =>  'Application Mod updated successfully to version %s',
'UMIL_CACHECLEARED' => 'Template, Theme, Imageset caches cleared', 

/***** Questionnaire ******/
'APPLY_MENU' => 'Application Form',
'APPLY_TITLE' => 'Application Form',
'APPLY_INFO' => 'Welcome and thank you for choosing us as a possible home for your character. 
To help us with your application please answer the questions below. Enter your character name exactly as it appears in the armory.  ',
'APPLY_PUBLICQUESTION' => 'Visible Application ?', 
'APPLY_REQUIRED'  => 'You need to fill in all required fields. ', 
'MANDATORY'	=> 'Required',	
'APPLY_REALM' => 'Realm (blank for ',
'APPLY_REALM1' => 'Realm : ',
'APPLY_NAME' => ' Character name: ',
'APPLY_QUESTION'  => 'Question ',
'APPLY_ANSWER'  => 'Answer ',
'APPLY_REALM1' => 'Realm : ',
'APPLY_LEVEL'  => 'Level (1-80): ',
'APPLY_CLASS'  => 'Class: ',
'APPLY_TALENT'  => 'Talent: ',
'APPLY_PROFF'  =>  'Profession: ',

// classes for simplerecruit
'SR_DK' => 'Death Knight', 
'SR_DRUID' => 'Druid', 
'SR_HUNTER' => 'Hunter', 
'SR_MAGE' => 'Mage', 
'SR_PALADIN' => 'Paladin', 
'SR_PRIEST' => 'Priest', 
'SR_ROGUE' => 'Rogue', 
'SR_SHAMAN'=> 'Shaman',
'SR_WARLOCK'=> 'Warlock',
'SR_WARRIOR'=> 'Warrior',

/***** ACP Privacy settings *****/
'APPLY_ACP_PRISETTING'		=> 'Privacy Settings',
'APPLY_ACP_FORUM_PUB'		=> 'Recruitment forum (Public) ',
'APPLY_ACP_FORUM_PRI'		=> 'Recruitment forum (Private) ',
'APPLY_ACP_FORUM_PRI_EXPLAIN'	=> 'Set Group forum permission of Guests and Applicants to: <br />"Post"->"Can start new topics"->"Yes",<br/> "Can read forum" -> "No" ',
'APPLY_ACP_FORUM_PREF'		=> 'User preference (Private or Public) ',
'APPLY_ACP_FORUM_PREF_EXPLAIN'		=> 'decides in which forum the application will be published.',
'APPLY_ACP_FORUM_CHOICE' =>  'Allow User to choose Privacy setting ?',
'APPLY_ACP_FORUM_CHOICE_EXPLAIN' =>  'If your guild does not allow public applications, set this to "No"',
'APPLY_ACP_PUBLIC'			=> 'Public',
'APPLY_ACP_PRIVATE'			=> 'Private',
'APPLY_ACP_GUESTPOST' 		=> 'Can guests posts? :',
'APPLY_ACP_GUESTPOST_EXPLAIN' 	=> 'If you set Guest posting On, don\'t forget to set "Enable visual confirmation for guest postings:" to "Yes".' ,  

/***** ACP Privacy settings *****/
'APPLY_ACP_CHARNAME' 		=> 'Character name',
'APPLY_ACP_ARMSETTING'		=> 'Armory Settings',
'APPLY_ACP_SIMPLERECRUIT'   => 'Simplerecruit or Armorycheck', 
'APPLY_ACP_SIMPLERECRUIT_EXPLAIN'   => 'Armory check will fetch character information from Blizzard. Simplerecruit will not check the Armory. Use this for other games than Wow', 
'APPLY_ACP_ARMORYONLINENAME' => 'Character name to check the Armory connection ',
'APPLY_ACP_ARMORYONLINENAME_EXPLAIN' => 'Put here the name of a random character to test the Armory connection. This char will be checked when Apply loads and Simplerecruit will be activated when Armory is down.', 

'APPLY_ACP_REALM' 			=> 'Realm',
'APPLY_ACP_REGION' 			=> 'Region',
'APPLY_ACP_APPTEMPLATEUPD'	=> 'Update Application template', 

/***** ACP template settings *****/
'APPLY_ACP_APPTEMPLATENEW'  => 'Application template New item', 
'APPLY_CHGMAND' 			=> 'Change Questionnaire here. ',
'APPLY_CHGMAND_EXPLAIN' 	=> 'Change the mandatory check, order, question and type. Separate the options with a comma "," with no spaces. The two first questions are reserved.',
'APPLY_ACP_NEWQUESTION' 	=> 'Enter new questions here.',
'APPLY_ACP_NEWQUESTION_EXPLAIN' => 'Check if mandatory, enter the order, question and type. Separate the options with a comma "," with no spaces.', 
'APPLY_ACP_INPUTBOX' 		=> 'Inputbox',	
'APPLY_ACP_TXTBOX' 			=> 'Textbox', 
'APPLY_ACP_SELECTBOX' 		=> 'Selectbox',
'APPLY_ACP_RADIOBOX' 		=> 'Radiobuttons',
'APPLY_ACP_CHECKBOX' 		=> 'Checkboxes',

//warnings
'APPLY_ACP_RETURN' 			=> '<h3>Return to Application config.</h3>',
'APPLY_ACP_REALMBLANKWARN' 	=> 'Realm field cannot be blank.', 
'APPLY_ACP_SETTINGSAVED' 	=> 'Application form general settings saved',
//upd
'APPLY_ACP_ORDQU_NOTEMPTY' 	=> 'Order and/or question can not be empty.',
'APPLY_ACP_ORDQU_NUMB' 		=> 'Order can only be numbers and not zero.',
'APPLY_ACP_ORDQU_NUMBRES' 	=> 'Reserved. Order can not be 1 or 2.', 
'APPLY_ACP_TWOREALM' 		=> 'You can not have two of realms or character names.', 
'APPLY_ACP_QUESTUPD' 		=> 'Apply Questions Updated',
//addnew
'APPLY_ACP_ORDQUEST' 		=> 'You need to fill out order, question and options before adding.',
'APPLY_ACP_QUESTNOTADD' 	=> 'ERROR : New question not saved !', 
'APPLY_ACP_QUESTNADD' 		=> 'New question Saved !',   
'APPLY_ACP_EXPLAINOPTIONS' 	=> 'Seperate Options with a comma "," with no spaces.',  

/** ACP settings for posting template **/
'JQUERY_MISSING'		=> 'jquery.js is not present. You must install jquery.js in adm/style/dkp for the colorwheel to work.', 
'APPLY_COLORSETTINGS' 		=> 'Apply Color Settings',
'APPLY_POST_ANSWERCOLOR' 	=> 'Posting Answers color',
'APPLY_POST_QUESTIONCOLOR' 	=> 'Posting Questions color',
'APPLY_FORMCOLOR'			=> 'Form Questions Color',
'APPLY_POSTCOLOR'			=> 'Apply Posting and Application Form Colors',
'APPLY_POSTCOLOR_EXPLAIN' 	=> 'Color of texts used in the Form and Recruitment post. If you use a dark Style, you can vary the text color to be used here.',

/** posting template **/
'APPLY_CHAR_NAME' 	=> '[color=%s][b]Character name : [/b][/color]%s',
'APPLY_CHAR_LEVEL' 	=> '[color=%s]Character level : [/color]%s',  
'APPLY_CHAR_CLASS' 	=> '[color=%s]Character class : [/color]%s' ,
'APPLY_CHAR_PROFF' 	=> '[color=%s][u]Professions :[/u][/color]
%s',
'APPLY_CHAR_BUILD' 	=> '[color=%s][u]Talent build : [/u][/color]%s',

'APPLY_CHAR_MANA' 	=> '[color=%s]Mana : [/color]%s' ,
'APPLY_CHAR_SP' 	=> '[color=%s]Spell Power : [/color]%s' ,
'APPLY_CHAR_ACRIT' 	=> '[color=%s]Arcane Crit : [/color]%s %%',
'APPLY_CHAR_FCRIT' 	=> '[color=%s]Fire Crit : [/color]%s %%',
'APPLY_CHAR_FROST' 	=> '[color=%s]Frost Crit : [/color]%s %%',
'APPLY_CHAR_SPHIT' 	=> '[color=%s]Spell Hit : [/color]%s %%', 
'APPLY_CHAR_SPHAS' 	=> '[color=%s]Spell Haste : [/color]%s' , 
'APPLY_CHAR_HCRIT' 	=> '[color=%s]Holy Crit : [/color]%s %%',
'APPLY_CHAR_SHCRIT' => '[color=%s]Shadow Crit : [/color]%s %%',
'APPLY_CHAR_MREG' 	=> '[color=%s]Mana Regen (Casting) : [/color]%s ',

'APPLY_CHAR_RANGEDPS' 	=> '[color=%s]DPS : [/color]%s',
'APPLY_CHAR_RANGEDAP' 	=> '[color=%s]Ranged Attackpower : [/color]%s',
'APPLY_CHAR_RANGEDCRIT' => '[color=%s]Ranged Crit : [/color]%s %%',
'APPLY_CHAR_RANGEHIT' 	=> '[color=%s]Ranged Hit : [/color]%s %%',
'APPLY_CHAR_RANGEHAS' 	=> '[color=%s]Ranged Haste : [/color]%s %%',

'APPLY_CHAR_MELEEDPS' 	=> '[color=%s]DPS Main/Off-Hand : [/color]%s %%',
'APPLY_CHAR_MELEEAP' 	=> '[color=%s]Melee Attackpower : [/color]%s',
'APPLY_CHAR_MELEECRIT' 	=> '[color=%s]Melee Crit : [/color]%s %%',
'APPLY_CHAR_MELEEHIT' 	=> '[color=%s]Melee Hit : [/color]%s %%',
'APPLY_CHAR_MELEEHAS' 	=> '[color=%s]Melee Haste : [/color]%s %%',
'APPLY_CHAR_EXPERTISE' 	=> '[color=%s]Expertise : [/color]%s %%',

'APPLY_CHAR_PALHO' 		=> '[color=%s][u]Holy[/u][/color]',
'APPLY_CHAR_PALRE' 		=> '[color=%s][u]Retribution[/u][/color]',
'APPLY_CHAR_PALPR' 		=> '[color=%s][u]Protection[/u][/color]',

'APPLY_CHAR_WARRARM' 	=> '[color=%s][u]Arms/Fury[/u][/color]',
'APPLY_CHAR_WARRPRO' 	=> '[color=%s][u]Protection[/u][/color]',
'APPLY_CHAR_HP' 		=> '[color=%s]Health : [/color]%s',
'APPLY_CHAR_ARMOR' 		=> '[color=%s]Armor : [/color]%s',
'APPLY_CHAR_DEF' 		=> '[color=%s]Defense : [/color]%s',
'APPLY_CHAR_DODGE' 		=> '[color=%s]Dodge : [/color]%s %%',
'APPLY_CHAR_PARRY' 		=> '[color=%s]Parry : [/color]%s %%',
'APPLY_CHAR_BLOCK' 		=> '[color=%s]Block : [/color]%s %%',

'APPLY_CHAR_DRUFER' 	=> '[color=%s][u]Feral[/u][/color]',
'APPLY_CHAR_RESTO' 		=> '[color=%s][u]Balance/Restoration[/u][/color]', 
'APPLY_CHAR_NATCRIT' 	=> '[color=%s]Nature Crit : [/color]%s %%',

'APPLY_CHAR_SHAEN' 		=> '[color=%s][u]Enhancement[/u][/color]',
'APPLY_CHAR_SHAEL' 		=> '[color=%s][u]Elemental[/u][/color]',
'APPLY_CHAR_SHARE' 		=> '[color=%s][u]Restoration[/u][/color]', 

'APPLY_CHAR_URL' => '[color=%s][/color][url=%s]WoW Armory Link[/url]', 

));

?>
