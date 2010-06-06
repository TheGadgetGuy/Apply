<?php
/**
* language file Application form English
* 
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


/** posting template **/

'APPLY_CHAR_NAME' 	=> '[color=#105289][b]Character name : [/b][/color]%s',
'APPLY_CHAR_LEVEL' 	=> '[color=#105289]Character level : [/color]%s',  
'APPLY_CHAR_CLASS' 	=> '[color=#105289]Character class : [/color]%s' ,
'APPLY_CHAR_PROFF' 	=> '[color=#105289][u]Professions :[/u][/color]
%s',
'APPLY_CHAR_BUILD' 	=> '[color=#105289][u]Talent build : [/u][/color]%s',

'APPLY_CHAR_MANA' 	=> '[color=#105289]Mana : [/color]%s' ,
'APPLY_CHAR_SP' 	=> '[color=#105289]Spell Power : [/color]%s' ,
'APPLY_CHAR_ACRIT' 	=> '[color=#105289]Arcane Crit : [/color]%s %%',
'APPLY_CHAR_FCRIT' 	=> '[color=#105289]Fire Crit : [/color]%s %%',
'APPLY_CHAR_FROST' 	=> '[color=#105289]Frost Crit : [/color]%s %%',
'APPLY_CHAR_SPHIT' 	=> '[color=#105289]Spell Hit : [/color]%s %%', 
'APPLY_CHAR_SPHAS' 	=> '[color=#105289]Spell Haste : [/color]%s' , 
'APPLY_CHAR_HCRIT' 	=> '[color=#105289]Holy Crit : [/color]%s %%',
'APPLY_CHAR_SHCRIT' => '[color=#105289]Shadow Crit : [/color]%s %%',
'APPLY_CHAR_MREG' 	=> '[color=#105289]Mana Regen (Casting) : [/color]%s ',

'APPLY_CHAR_RANGEDPS' 	=> '[color=#105289]DPS : [/color]%s',
'APPLY_CHAR_RANGEDAP' 	=> '[color=#105289]Ranged Attackpower : [/color]%s',
'APPLY_CHAR_RANGEDCRIT' => '[color=#105289]Ranged Crit : [/color]%s %%',
'APPLY_CHAR_RANGEHIT' 	=> '[color=#105289]Ranged Hit : [/color]%s %%',
'APPLY_CHAR_RANGEHAS' 	=> '[color=#105289]Ranged Haste : [/color]%s %%',

'APPLY_CHAR_MELEEDPS' 	=> '[color=#105289]DPS Main/Off-Hand : [/color]%s %%',
'APPLY_CHAR_MELEEAP' 	=> '[color=#105289]Melee Attackpower : [/color]%s',
'APPLY_CHAR_MELEECRIT' 	=> '[color=#105289]Melee Crit : [/color]%s %%',
'APPLY_CHAR_MELEEHIT' 	=> '[color=#105289]Melee Hit : [/color]%s %%',
'APPLY_CHAR_MELEEHAS' 	=> '[color=#105289]Melee Haste : [/color]%s %%',
'APPLY_CHAR_EXPERTISE' 	=> '[color=#105289]Expertise : [/color]%s %%',

'APPLY_CHAR_PALHO' 		=> '[color=#105289][u]Holy[/u][/color]',
'APPLY_CHAR_PALRE' 		=> '[color=#105289][u]Retribution[/u][/color]',
'APPLY_CHAR_PALPR' 		=> '[color=#105289][u]Protection[/u][/color]',

'APPLY_CHAR_WARRARM' 	=> '[color=#105289][u]Arms/Fury[/u][/color]',
'APPLY_CHAR_WARRPRO' 	=> '[color=#105289][u]Protection[/u][/color]',
'APPLY_CHAR_HP' 		=> '[color=#105289]Health : [/color]%s',
'APPLY_CHAR_ARMOR' 		=> '[color=#105289]Armor : [/color]%s',
'APPLY_CHAR_DEF' 		=> '[color=#105289]Defense : [/color]%s',
'APPLY_CHAR_DODGE' 		=> '[color=#105289]Dodge : [/color]%s %%',
'APPLY_CHAR_PARRY' 		=> '[color=#105289]Parry : [/color]%s %%',
'APPLY_CHAR_BLOCK' 		=> '[color=#105289]Block : [/color]%s %%',

'APPLY_CHAR_DRUFER' 	=> '[color=#105289][u]Feral[/u][/color]',
'APPLY_CHAR_RESTO' 		=> '[color=#105289][u]Balance/Restoration[/u][/color]', 
'APPLY_CHAR_NATCRIT' 	=> '[color=#105289]Nature Crit : [/color]%s %%',

'APPLY_CHAR_SHAEN' 		=> '[color=#105289][u]Enhancement[/u][/color]',
'APPLY_CHAR_SHAEL' 		=> '[color=#105289][u]Elemental[/u][/color]',
'APPLY_CHAR_SHARE' 		=> '[color=#105289][u]Restoration[/u][/color]', 

'APPLY_CHAR_URL' => '[color=#105289][/color][url=%s]WoW Armory Link[/url]', 

));

?>
