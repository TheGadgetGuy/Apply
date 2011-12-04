<?php
/**
* language file Wow Application form French
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
'APPLY_INSTALL_MOD' =>  'Mod de Recrutement Version %s a été installé avec succes. ',
'APPLY_UNINSTALL_MOD' =>  'Mod de Recrutement Version %s a été déinstallé avec succès. ',
'APPLY_UPD_MOD' =>  'Mod de Recrutement actualisé à la version %s ',
'UMIL_CACHECLEARED' => 'La Cache Template, Theme, et Imageset sont vidées', 

/***** Questionnaire ******/
'APPLY_MENU' => 'Candidatures',
'APPLY_TITLE' => 'Formulaire de recrutement',
'APPLY_INFO' => 'Bienvenu à et merci de ton intérêt porté à notre Guilde. Afin de nous aider à mieux évaluer ta candidature, merci de remplir ce petit formulaire. Entre le nom de caractère exactement comme renseigné dans l’Armurerie.  ',
'APPLY_PUBLICQUESTION' => 'Candidature publique ?', 
'APPLY_REQUIRED'  => 'Les champs marqués ’*’ ne sont pas optionnels. ', 
'MANDATORY'	=> '*',	
'APPLY_REALM' => 'Serveur (vide pour ',
'APPLY_REALM1' => 'Serveur : ',
'APPLY_NAME' => ' Nom de caractère: ',
'APPLY_QUESTION'  => 'Question ',
'APPLY_ANSWER'  => 'Réponse ',
'APPLY_LEVEL'  => 'Niveau: ',
'APPLY_CLASS'  => 'Classe: ',
'APPLY_RACE'  => 'Race: ',
'APPLY_TALENT'  => 'Talents: ',
'APPLY_PROFF'  =>  'Proffessions: ',

/***** ACP Privacy settings *****/
'APPLY_ACP_PRISETTING'		=> 'Règlages vie privée',
'APPLY_ACP_FORUM_PUB'		=> 'Forum de recrutement (public) ',
'APPLY_ACP_FORUM_PRI'		=> 'Forum de recrutement (privé) ',
'APPLY_ACP_FORUM_PRI_EXPLAIN'	=> 'Configure les droits d’accès de groupe pour le Forum pour les Visiteurs anonymes et utilisateurs insccrits: <br />"Post"->"Peut écrire"->"Oui",<br/> "Peut lire" -> "Non" ',
'APPLY_ACP_FORUM_PREF'		=> 'Permisssions d’utilisateurs (Privé ou public) ',
'APPLY_ACP_FORUM_PREF_EXPLAIN'		=> 'décide dans quel forum la candidature sera écrite.',
'APPLY_ACP_FORUM_CHOICE' =>  'Permettre l’utilisateur le choix d’une candidature privée ?',
'APPLY_ACP_FORUM_CHOICE_EXPLAIN' =>  'Si ta guilde ne permet pas de candidatures privées, choisis "Non"',
'APPLY_ACP_PUBLIC'			=> 'public',
'APPLY_ACP_PRIVATE'			=> 'privé',
'APPLY_ACP_GUESTPOST' 		=> 'Permettre les invités de poster ? :',
'APPLY_ACP_GUESTPOST_EXPLAIN' 	=> 'Si cette option est activée, n’oublies pas l’option "Activer la confirmation Anti-spam  pour invités" à "oui".' ,  

/***** ACP Armory settings *****/
'APPLY_ACP_TEMPLATESETTING'	=> 'Règlages gabarit',
'APPLY_WELCOME'				=> 'Message d’acceuil',
'APPLY_WELCOME_EXPLAIN'		=> 'bbcodes sont supportés.',
'APPLY_ACP_CHARNAME' 		=> 'Nom de Caractère',
'APPLY_ACP_REALM' 		=> 'Royaume',
'APPLY_ACP_REGION' 		=> 'Region',
'APPLY_ACP_APPTEMPLATEUPD'	=> 'Mise à jour du modèle', 
/***** ACP template settings *****
'ACP_APPLY_MANDATORY'  		=> 'Obligatoire',
'ACP_APPLY_HEADER'  		=> 'Entête',
'ACP_APPLY_EXPLAIN'  		=> 'Explanation',
'ACP_APPLY_CONTENTS'  		=> 'Contenu',
'ACP_DKP_APPLY_EXPLAIN'  => 'Ici tu peux saisir toutes les configurations du formulaire de recrutement.',
'APPLY_ACP_APPTEMPLATENEW'  => 'Nouvelle question', 
'APPLY_CHGMAND' 			=> 'Autres questions existantes ici. ',
'APPLY_CHGMAND_EXPLAIN' 	=> 'Change le flag d’obligation, la séquence, la question et la métode de saisie. le séparateur des options est une virgule "," sans espace. Les permières 2 questions sont réservés.',
'APPLY_ACP_NEWQUESTION' 	=> 'Saisis les nouvelles questions ici.',
'APPLY_ACP_NEWQUESTION_EXPLAIN' => 'Controle si obligatoire, entre la sequence, la question et la métode de saisie. le séparateur des options est une virgule "," sans espace. ', 
'APPLY_ACP_INPUTBOX' 		=> 'champ de saisie',	
'APPLY_ACP_TXTBOX' 			=> 'Texte', 
'APPLY_ACP_SELECTBOX' 		=> 'Choix',
'APPLY_ACP_RADIOBOX' 		=> 'Option radio',
'APPLY_ACP_CHECKBOX' 		=> 'checkbox',

//warnings
'APPLY_ACP_RETURN' 		=> '<h3>Retour au formulaire de recrutement</h3>',
'APPLY_ACP_REALMBLANKWARN' 	=> 'Le champ Serveur le peut être vide.', 
'APPLY_ACP_SETTINGSAVED' 	=> 'Règlages enregistrées',
'APPLY_NO_GUILD'		=> 'Pas de Guilde trouvé.', 
//upd
'APPLY_ACP_TWOREALM' 		=> 'Seulement un nom de caractère est permis.', 
'APPLY_ACP_QUESTUPD' 		=> 'questions de formulaire enregistrées',
//addnew
'APPLY_ACP_ORDQUEST' 		=> 'tu dois remplir l’ordre, la question et les options avant d’ajouter.',
'APPLY_ACP_QUESTNOTADD' 	=> 'Erreur: nouvelle question n’a pas été sauvegardée !', 
'APPLY_ACP_QUESTNADD' 		=> 'Nouvelle question sauvegardée !',   
'APPLY_ACP_EXPLAINOPTIONS' 	=> 'Sépare les options avec une virgule "," sans espaces.',  

/** ACP settings for posting template **/
'APPLY_COLORSETTINGS' 		=> 'Règlages Couleurs',
'APPLY_POST_ANSWERCOLOR' 	=> 'Couleur Réponses',
'APPLY_POST_QUESTIONCOLOR' 	=> 'Couleur Questions',
'APPLY_FORMCOLOR'		=> 'Couleur Questions du Formulaire',
'APPLY_POSTCOLOR'		=> 'Couleurs formulaire et messages de recrutement',
'APPLY_POSTCOLOR_EXPLAIN' 	=> 'Couleur des textes utilisées dans le formulaire et dans les messages. Donc si vous utilisez un style sombre, vous pourrez choisir une couleur qui contraste.',

/** posting template **/
'APPLY_CHAR_OVERVIEW' 		=> 'Application',
'APPLY_CHAR_MOTIVATION' 	=> 'Motivation',
'APPLY_CHAR_NAME' 	=> '[color=%s][b]Nom de Caractère : [/b][/color]%s',
'APPLY_CHAR_LEVEL' 	=> '[color=%s]Niveau : [/color]%s',  
'APPLY_CHAR_CLASS' 	=> '[color=%s]Classe: [/color]%s' ,
'APPLY_CHAR_PROFF' 	=> '[color=%s][u]Proffessions :[/u][/color]
%s',
'APPLY_CHAR_BUILD' 	=> '[color=%s][u]Spécialisation de talents : [/u][/color]%s',
'APPLY_CHAR_URL' => '[color=%s][/color][url=%s]Lien Armurerie[/url]', 
'ERROR_NAME'  =>  'Erreur : Nom doit être alphabetique (a-zA-ZàäåâÅÂçÇéèëêïÏîÎæŒæÆÅóòÓÒöÖôÔøØüÜ sont permis). ',
'APPLY_REQUIRED_LEVEL'  => 'Niveau obligatoire',  
'APPLY_REQUIRED_NAME'	=> 'Nom obligatoire.', 
'RETURN_APPLY'  =>  'Retourne au formulaire.',
));

?>
