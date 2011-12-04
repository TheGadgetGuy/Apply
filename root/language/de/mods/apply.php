<?php
/**
* language file Application form German
* @author Sheeper, Sajaki
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
'APPLY_INFO' => '[size=150]Willkommen und schön, dass du dich entschieden hast bei uns ein neues zu Hause für deinen Charakter zu suchen. 
Um uns mit deiner Bewerbung zu untersützen, beantworte bitte die unten aufgeführten Fragen. Gib deinen Charakternamen exakt so an, wie er im Armory angezeigt wird.[/size]  ',
'APPLY_PUBLICQUESTION' => 'Öffentliche Bewerbung ?', 
'APPLY_REQUIRED'  => 'Du musst alle Pflichtfelder ausfüllen. ', 
'MANDATORY'	=> 'Pflichtfeld',	
'APPLY_REALM' => 'Server (leer für ',
'APPLY_REALM1' => 'Server: ',
'APPLY_NAME' => ' Character Name: ',
'APPLY_QUESTION'  => 'Frage ',
'APPLY_ANSWER'  => 'Antwort ',
'APPLY_LEVEL'  => 'Level: ',
'APPLY_CLASS'  => 'Klasse: ',
'APPLY_RACE'  => 'Race: ',
'APPLY_TALENT'  => 'Talente: ',
'APPLY_PROFF'  =>  'Berufe: ',

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

/***** ACP Armory settings *****/
'APPLY_ACP_TEMPLATESETTING'	=> 'Formular Einstellungen',
'APPLY_WELCOME'			=> 'Einladungstext',
'APPLY_WELCOME_EXPLAIN'		=> 'bbcodes werden umgesetzt. ',
'APPLY_ACP_CHARNAME' 		=> 'Charakter Name',
'APPLY_ACP_REALM' 		=> 'Realm',
'APPLY_ACP_REGION' 			=> 'Region',
'APPLY_ACP_APPTEMPLATEUPD'	=> 'Aktualisiere Bewerbungsbogen', 

/***** ACP template settings *****/
'ACP_APPLY_MANDATORY'  		=> 'erforderlich',
'ACP_APPLY_HEADER'  		=> 'Kopfzeile',
'ACP_APPLY_EXPLAIN'  		=> 'Erklärung',
'ACP_APPLY_CONTENTS'  		=> 'Inhalt selectbox',
'ACP_DKP_APPLY_EXPLAIN'  	=> 'Hier kannst du alle Einstellungen zum Bewerbungsformular vornehmen.',
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
'APPLY_ACP_RETURN' 		=> '<h3>Zurück zur Bewerbungskonfiguration.</h3>',
'APPLY_ACP_REALMBLANKWARN' 	=> 'Server Feld darf nicht leer sein.', 
'APPLY_ACP_SETTINGSAVED' 	=> 'allgemeine Bewerbungseinstellungen gespeichert',
'APPLY_NO_GUILD'		=> 'Gilde ist erforderlich', 
//upd
'APPLY_ACP_TWOREALM' 		=> 'Du kannst keine 2 Server oder Charakternamen einrichten.', 
'APPLY_ACP_QUESTUPD' 		=> 'Bewerbungsfragen aktualisiert',
//addnew
'APPLY_ACP_ORDQUEST' 		=> 'Du musst die Reihenfolge, Fragen und Optionen ausfüllen bevor die Frage gespeichert werden darf.',
'APPLY_ACP_QUESTNOTADD' 	=> 'Fehler : Frage wurde nicht gespeichert !', 
'APPLY_ACP_QUESTNADD' 		=> 'Neue Frage wurde gespeichert !',   
'APPLY_ACP_EXPLAINOPTIONS' 	=> 'Einzelne Option begrenazt durch komma "," ohne Leerzeichen.',  

/** ACP settings for posting template **/
'APPLY_COLORSETTINGS' 		=> 'Farbinstellungen',
'APPLY_POST_ANSWERCOLOR' 	=> 'Antwortfarbe',
'APPLY_POST_QUESTIONCOLOR' 	=> 'Fragenfarbe',
'APPLY_FORMCOLOR'			=> 'Fragebogenfarbe',
'APPLY_POSTCOLOR'			=> 'Farben für Fragebogen und Bewerbungsbeitrage',
'APPLY_POSTCOLOR_EXPLAIN' 	=> 'Farben angezeigt im Fragebogen und in den Beitragen. Wenn du einen eher dunkler Style gebrauchst, kann hier eine Kontrastierende Farbe gewählt werden.',

/** posting template **/
'APPLY_CHAR_OVERVIEW' 		=> 'Charakter',
'APPLY_CHAR_MOTIVATION' 	=> 'Motivation',

'APPLY_CHAR_NAME' 	=> '[color=%s][b]Character Name : [/b][/color]%s',
'APPLY_CHAR_LEVEL' 	=> '[color=%s]Character Level : [/color]%s',  
'APPLY_CHAR_CLASS' 	=> '[color=%s]Character Klasse : [/color]%s' ,
'APPLY_CHAR_PROFF' 	=> '[color=%s][u]Berufe :[/u][/color]
%s',
'APPLY_CHAR_BUILD' 	=> '[color=%s][u]Talent Verteilungen : [/u][/color]%s',
'APPLY_CHAR_URL' => '[color=%s][/color][url=%s]WoW Armory Link[/url]', 
'APPLY_ERROR_NAME'  =>  'Fehler : Name muss alphabetisch (a-zA-ZàäåâÅÂçÇéèëêïÏîÎæŒæÆÅóòÓÒöÖôÔøØüÜ sind erlaubt). ',
'APPLY_REQUIRED_LEVEL'  => 'Level ist erforderlich. ', 
'APPLY_REQUIRED_NAME'	=> 'Name ist erforderlich. ', 

'RETURN_APPLY'  =>  'Zurück zum Fragebogen.',


));

?>
