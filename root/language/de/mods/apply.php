<?php
/**
* language file Application form German
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
'APPLY_INSTALL_MOD' =>  'Bewerbungs Mod Version %s erfolgreich installiert. ',
'APPLY_UNINSTALL_MOD' =>  'Bewerbungs Mod Version %s erfolgreich deinstalliert. ',
'APPLY_UPD_MOD' =>  'Bewerbungs Mod erfolgreich zu Version %s aktualisiert',
'UMIL_CACHECLEARED' => 'Template, Theme, Imageset Caches geleert', 

/***** Questionnaire ******/
'APPLY_MENU' => 'Bewerbungen',
'APPLY_TITLE' => 'Bewerbungs-Formular',
'APPLY_INFO' => 'Willkommen und schön, dass du dich entschieden hast bei uns ein neues zu Hause für deinen Charakter zu suchen. 
Um uns mit deiner Bewerbung zu untersützen, beantworte bitte die unten aufgeführten Fragen. Gib deinen Charakternamen exakt so an, wie er im Armory angezeigt wird.  ',
'APPLY_PUBLICQUESTION' => 'Öffentliche Bewerbung ?', 
'APPLY_REQUIRED'  => 'Du musst alle Pflichtfelder ausfüllen. ', 
'MANDATORY'	=> 'Pflichtfeld',	
'APPLY_REALM' => 'Server (leer für ',
'APPLY_REALM1' => 'Server : ',
'APPLY_NAME' => ' Character Name: ',
'APPLY_QUESTION'  => 'Frage ',
'APPLY_ANSWER'  => 'Antwort ',
'APPLY_LEVEL'  => 'Level (1-80): ',
'APPLY_CLASS'  => 'Klasse: ',
'APPLY_TALENT'  => 'Talente: ',
'APPLY_PROFF'  =>  'Berufe: ',

// classes for simplerecruit
'SR_DK' => 'Todesritter', 
'SR_DRUID' => 'Druide', 
'SR_HUNTER' => 'Jäger', 
'SR_MAGE' => 'Magier', 
'SR_PALADIN' => 'Paladin', 
'SR_PRIEST' => 'Priester', 
'SR_ROGUE' => 'Schurke', 
'SR_SHAMAN'=> 'Schamane',
'SR_WARLOCK'=> 'Hexenmeister',
'SR_WARRIOR'=> 'Krieger',

/***** ACP Privacy settings *****/
'APPLY_ACP_PRISETTING'		=> 'Privatsphäre Einstellung',
'APPLY_ACP_FORUM_PUB'		=> 'Bewerbungs Forum (öffentlich) ',
'APPLY_ACP_FORUM_PRI'		=> 'Bewerbungs Forum (privat) ',
'APPLY_ACP_FORUM_PRI_EXPLAIN'	=> 'Setze die Gruppenberechtigung für das Forum für Gäste/Bewerber auf: <br />"Post"->"Kann neue Beiträge schreiben"->"Ja",<br/> "Kann Forum lesen" -> "Nein" ',
'APPLY_ACP_FORUM_PREF'		=> 'Nutzer Einstellung (privat oder öffentlich) ',
'APPLY_ACP_FORUM_PREF_EXPLAIN'		=> 'entscheidet in welches Forum die Bewerbung geschrieben wird.',
'APPLY_ACP_FORUM_CHOICE' =>  'Erlaube dem Nutzer die private Auswahl ?',
'APPLY_ACP_FORUM_CHOICE_EXPLAIN' =>  'Wenn deine Gilde keine privaten Bewerbungen erlaubt, setze diese Option auf "Nein"',
'APPLY_ACP_PUBLIC'			=> 'öffentlich',
'APPLY_ACP_PRIVATE'			=> 'privat',
'APPLY_ACP_GUESTPOST' 		=> 'Können Gäste schreiben? :',
'APPLY_ACP_GUESTPOST_EXPLAIN' 	=> 'Wenn die Option aktiviert ist, vergiss nicht die Option "Aktiviere visuelle Bestätigung für Gast Postings:" auf "Ja" zu setzen.' ,  

/***** ACP Privacy settings *****/
'APPLY_ACP_CHARNAME' 		=> 'Charakter Name',
'APPLY_ACP_ARMSETTING'		=> 'Armory Einstellung',
'APPLY_ACP_SIMPLERECRUIT'   => 'einfache Bewerbung oder mit Armory Prüfung', 
'APPLY_ACP_SIMPLERECRUIT_EXPLAIN'   => 'Armory Prüfung ermittelt will fetch character information from Blizzard. Simplerecruit will not check the Armory. Use this for other games than Wow', 
'APPLY_ACP_ARMORYONLINENAME' => 'Character name to check the Armory connection ',
'APPLY_ACP_ARMORYONLINENAME_EXPLAIN' => 'Put here the name of a random character to test the Armory connection. This char will be checked when Apply loads and Simplerecruit will be activated when Armory is down.', 

'APPLY_ACP_REALM' 			=> 'Realm',
'APPLY_ACP_REGION' 			=> 'Region',
'APPLY_ACP_APPTEMPLATEUPD'	=> 'Update Application template', 

/***** ACP template settings *****/
'ACP_DKP_APPLY_EXPLAIN'  => 'Hier kannst du alle Einstellungen zum Bewerbungsformular vornehmen.',
'APPLY_ACP_APPTEMPLATENEW'  => 'Bewerbungsvorlage neue Frage', 
'APPLY_CHGMAND' 			=> 'Ändere bestehende Fragen hier. ',
'APPLY_CHGMAND_EXPLAIN' 	=> 'Ändere die Pflichtprüfung, Reihenfolge, Frage und Art der Eingabe. Grenze verschiedene Optionen durch Komma "," ohne Leerzeichen voneinander ab. Die ersten beiden Fragen sind reserviert.',
'APPLY_ACP_NEWQUESTION' 	=> 'Trage hier neue Fragen ein.',
'APPLY_ACP_NEWQUESTION_EXPLAIN' => 'Prüfe ob Pflichtfeld, gib die Ordnungszahl, Frage und Eingabeart an. Grenze verschiedene Optionen durch Komma "," ohne Leerzeichen voneinander ab.', 
'APPLY_ACP_INPUTBOX' 		=> 'Eingabefeld',	
'APPLY_ACP_TXTBOX' 			=> 'Textbox', 
'APPLY_ACP_SELECTBOX' 		=> 'Auswahlbox',
'APPLY_ACP_RADIOBOX' 		=> 'Optionsfeld (radiobutton)',
'APPLY_ACP_CHECKBOX' 		=> 'Kontrollkästchen (checkbox)',

//warnings
'APPLY_ACP_RETURN' 			=> '<h3>Zurück zum Bewerbungskonfiguration.</h3>',
'APPLY_ACP_REALMBLANKWARN' 	=> 'Server Feld kann nicht leer sein.', 
'APPLY_ACP_SETTINGSAVED' 	=> 'Bewerbungsformular allgemeine Einstellungen gespeichert',
//upd
'APPLY_ACP_ORDQU_NOTEMPTY' 	=> 'Ordnungszahl und/oder Frage kann nicht leer sein.',
'APPLY_ACP_ORDQU_NUMB' 		=> 'Ordnungszahl kann nur eine Zahl größer 2 sein.',
'APPLY_ACP_ORDQU_NUMBRES' 	=> 'Reserviert! Ordnungszahl kann nicht 1 oder 2 sein.', 
'APPLY_ACP_TWOREALM' 		=> 'Du kannst keine 2 Server oder Charakternamen einrichten.', 
'APPLY_ACP_QUESTUPD' 		=> 'Bewerbungsfragen aktualisiert',
//addnew
'APPLY_ACP_ORDQUEST' 		=> 'You need to fill out order, question and options before adding.',
'APPLY_ACP_QUESTNOTADD' 	=> 'ERROR : New question not saved !', 
'APPLY_ACP_QUESTNADD' 		=> 'New question Saved !',   
'APPLY_ACP_EXPLAINOPTIONS' 	=> 'Seperate Options with a comma "," with no spaces.',  


/** posting template **/

'APPLY_CHAR_NAME' 	=> '[color=#105289][b]Character Name : [/b][/color]%s',
'APPLY_CHAR_LEVEL' 	=> '[color=#105289]Character Level : [/color]%s',  
'APPLY_CHAR_CLASS' 	=> '[color=#105289]Character Klasse : [/color]%s' ,
'APPLY_CHAR_PROFF' 	=> '[color=#105289][u]Berufe :[/u][/color]
%s',
'APPLY_CHAR_BUILD' 	=> '[color=#105289][u]Talent Verteilungen : [/u][/color]%s',

'APPLY_CHAR_MANA' 	=> '[color=#105289]Mana : [/color]%s' ,
'APPLY_CHAR_SP' 	=> '[color=#105289]Zaubermacht : [/color]%s' ,
'APPLY_CHAR_ACRIT' 	=> '[color=#105289]Arkan Krit : [/color]%s %%',
'APPLY_CHAR_FCRIT' 	=> '[color=#105289]Feuer Krit : [/color]%s %%',
'APPLY_CHAR_FROST' 	=> '[color=#105289]Frost Krit : [/color]%s %%',
'APPLY_CHAR_SPHIT' 	=> '[color=#105289]Trefferwertung : [/color]%s %%', 
'APPLY_CHAR_SPHAS' 	=> '[color=#105289]Tempo : [/color]%s' , 
'APPLY_CHAR_HCRIT' 	=> '[color=#105289]Heilig Krit : [/color]%s %%',
'APPLY_CHAR_SHCRIT' => '[color=#105289]Schatten Krit : [/color]%s %%',
'APPLY_CHAR_MREG' 	=> '[color=#105289]Mana Regeneration (zaubernd) : [/color]%s ',

'APPLY_CHAR_RANGEDPS' 	=> '[color=#105289]DPS : [/color]%s',
'APPLY_CHAR_RANGEDAP' 	=> '[color=#105289]Distanz Angriffskraft : [/color]%s',
'APPLY_CHAR_RANGEDCRIT' => '[color=#105289]Distanz Krit : [/color]%s %%',
'APPLY_CHAR_RANGEHIT' 	=> '[color=#105289]Trefferwertung : [/color]%s %%',
'APPLY_CHAR_RANGEHAS' 	=> '[color=#105289]Tempo : [/color]%s %%',

'APPLY_CHAR_MELEEDPS' 	=> '[color=#105289]DPS Haupt/Neben-Hand : [/color]%s %%',
'APPLY_CHAR_MELEEAP' 	=> '[color=#105289]Nahkampf Angriffskraft : [/color]%s',
'APPLY_CHAR_MELEECRIT' 	=> '[color=#105289]Nahkampf Crit : [/color]%s %%',
'APPLY_CHAR_MELEEHIT' 	=> '[color=#105289]Nahkampf Hit : [/color]%s %%',
'APPLY_CHAR_MELEEHAS' 	=> '[color=#105289]Tempo : [/color]%s %%',
'APPLY_CHAR_EXPERTISE' 	=> '[color=#105289]Waffenkunde : [/color]%s %%',

'APPLY_CHAR_PALHO' 		=> '[color=#105289][u]Heilig[/u][/color]',
'APPLY_CHAR_PALRE' 		=> '[color=#105289][u]Vergeltung[/u][/color]',
'APPLY_CHAR_PALPR' 		=> '[color=#105289][u]Schutz[/u][/color]',

'APPLY_CHAR_WARRARM' 	=> '[color=#105289][u]Waffen/Furor[/u][/color]',
'APPLY_CHAR_WARRPRO' 	=> '[color=#105289][u]Schutz[/u][/color]',
'APPLY_CHAR_HP' 		=> '[color=#105289]Leben : [/color]%s',
'APPLY_CHAR_ARMOR' 		=> '[color=#105289]Rüstung : [/color]%s',
'APPLY_CHAR_DEF' 		=> '[color=#105289]Verteidigung : [/color]%s',
'APPLY_CHAR_DODGE' 		=> '[color=#105289]Ausweichen : [/color]%s %%',
'APPLY_CHAR_PARRY' 		=> '[color=#105289]Parrieren : [/color]%s %%',
'APPLY_CHAR_BLOCK' 		=> '[color=#105289]Blocken : [/color]%s %%',

'APPLY_CHAR_DRUFER' 	=> '[color=#105289][u]Wilder Kampf[/u][/color]',
'APPLY_CHAR_RESTO' 		=> '[color=#105289][u]Gleichgewicht/Wiederherstellung[/u][/color]', 
'APPLY_CHAR_NATCRIT' 	=> '[color=#105289]Natur Krit : [/color]%s %%',

'APPLY_CHAR_SHAEN' 		=> '[color=#105289][u]Verstärkung[/u][/color]',
'APPLY_CHAR_SHAEL' 		=> '[color=#105289][u]Elementar[/u][/color]',
'APPLY_CHAR_SHARE' 		=> '[color=#105289][u]Wiederherstellung[/u][/color]', 

'APPLY_CHAR_URL' => '[color=#105289][/color][url=%s]WoW Armory Link[/url]', 

));

?>
