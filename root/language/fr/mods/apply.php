<?php
/**
* language file Wow Application form French
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
'APPLY_LEVEL'  => 'Niveau (1-80): ',
'APPLY_CLASS'  => 'Classe: ',
'APPLY_TALENT'  => 'Talents: ',
'APPLY_PROFF'  =>  'Proffessions: ',

// classes for simplerecruit
'SR_DK' => 'Chevalier de la Mort', 
'SR_DRUID' => 'Druide', 
'SR_HUNTER' => 'Chasseur', 
'SR_MAGE' => 'Mage', 
'SR_PALADIN' => 'Paladin', 
'SR_PRIEST' => 'Prêtre', 
'SR_ROGUE' => 'Voleur', 
'SR_SHAMAN'=> 'Chaman',
'SR_WARLOCK'=> 'Démoniste',
'SR_WARRIOR'=> 'Guerrier',

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

/***** ACP Privacy settings *****/
'APPLY_ACP_CHARNAME' 		=> 'Nom de Caractère',
'APPLY_ACP_ARMSETTING'		=> 'Règlages Armurerie',
'APPLY_ACP_SIMPLERECRUIT'   => 'Candidature Simple ou Candidature Armurerie', 
'APPLY_ACP_SIMPLERECRUIT_EXPLAIN'   => 'La candidature Armurerie cherche d’informations chez Blizzard tandis que la candidature simple ne le fait pas.', 
'APPLY_ACP_ARMORYONLINENAME' => 'Nom de caractère Armurerie',
'APPLY_ACP_ARMORYONLINENAME_EXPLAIN' => 'Saisier le nom d’un caractère aléatoire servant à vérifier la connection à l’Armurerie. Un essai de connection à ce caractère sera effectué au chargement du formulaire et le mode Simple sera choisi lorsque ce check échoue.', 

'APPLY_ACP_REALM' 			=> 'Royaume',
'APPLY_ACP_REGION' 			=> 'Region',
'APPLY_ACP_APPTEMPLATEUPD'	=> 'Mise à jour du modèle', 

/***** ACP template settings *****/
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
'APPLY_ACP_RETURN' 			=> '<h3>Retour au formulaire de recrutement</h3>',
'APPLY_ACP_REALMBLANKWARN' 	=> 'Le champ Serveur le peut être vide.', 
'APPLY_ACP_SETTINGSAVED' 	=> 'Règlages enregistrées',
//upd
'APPLY_ACP_ORDQU_NOTEMPTY' 	=> 'Ordre ou/ou question ne peuvent être vides.',
'APPLY_ACP_ORDQU_NUMB' 		=> 'Ordre doit être plus grand que 2.',
'APPLY_ACP_ORDQU_NUMBRES' 	=> 'Réservé! Ordre ne peut être 1 ou 2.', 
'APPLY_ACP_TWOREALM' 		=> 'Seulement un nom de caractère est permis.', 
'APPLY_ACP_QUESTUPD' 		=> 'questions de formulaire enregistrées',
//addnew
'APPLY_ACP_ORDQUEST' 		=> 'tu dois remplir l’ordre, la question et les options avant d’ajouter.',
'APPLY_ACP_QUESTNOTADD' 	=> 'Erreur: nouvelle question n’a pas été sauvegardée !', 
'APPLY_ACP_QUESTNADD' 		=> 'Nouvelle question sauvegardée !',   
'APPLY_ACP_EXPLAINOPTIONS' 	=> 'Sépare les options avec une virgule "," sans espaces.',  


/** posting template **/

'APPLY_CHAR_NAME' 	=> '[color=#105289][b]Nom de Caractère : [/b][/color]%s',
'APPLY_CHAR_LEVEL' 	=> '[color=#105289]Niveau : [/color]%s',  
'APPLY_CHAR_CLASS' 	=> '[color=#105289]Classe: [/color]%s' ,
'APPLY_CHAR_PROFF' 	=> '[color=#105289][u]Proffessions :[/u][/color]
%s',
'APPLY_CHAR_BUILD' 	=> '[color=#105289][u]Spécialisation de talents : [/u][/color]%s',

'APPLY_CHAR_MANA' 	=> '[color=#105289]Mana : [/color]%s' ,
'APPLY_CHAR_SP' 	=> '[color=#105289]Bonus dégats : [/color]%s' ,
'APPLY_CHAR_ACRIT' 	=> '[color=#105289]Crit Arcane : [/color]%s %%',
'APPLY_CHAR_FCRIT' 	=> '[color=#105289]Crit Feux: [/color]%s %%',
'APPLY_CHAR_FROST' 	=> '[color=#105289]Crit Froid : [/color]%s %%',
'APPLY_CHAR_SPHIT' 	=> '[color=#105289]Sc. Toucher : [/color]%s %%', 
'APPLY_CHAR_SPHAS' 	=> '[color=#105289]Hâte : [/color]%s' , 
'APPLY_CHAR_HCRIT' 	=> '[color=#105289]Crit sacré : [/color]%s %%',
'APPLY_CHAR_SHCRIT' => '[color=#105289]Crit ombre : [/color]%s %%',
'APPLY_CHAR_MREG' 	=> '[color=#105289]Régen mana pendant incantation : [/color]%s ',

'APPLY_CHAR_RANGEDPS' 	=> '[color=#105289]DPS : [/color]%s',
'APPLY_CHAR_RANGEDAP' 	=> '[color=#105289]Dégats à distance : [/color]%s',
'APPLY_CHAR_RANGEDCRIT' => '[color=#105289]Critique : [/color]%s %%',
'APPLY_CHAR_RANGEHIT' 	=> '[color=#105289]Toucher : [/color]%s %%',
'APPLY_CHAR_RANGEHAS' 	=> '[color=#105289]Vitesse : [/color]%s %%',

'APPLY_CHAR_MELEEDPS' 	=> '[color=#105289]DPS melée : [/color]%s %%',
'APPLY_CHAR_MELEEAP' 	=> '[color=#105289]Force : [/color]%s',
'APPLY_CHAR_MELEECRIT' 	=> '[color=#105289]Critique : [/color]%s %%',
'APPLY_CHAR_MELEEHIT' 	=> '[color=#105289]toucher : [/color]%s %%',
'APPLY_CHAR_MELEEHAS' 	=> '[color=#105289]Vitesse : [/color]%s %%',
'APPLY_CHAR_EXPERTISE' 	=> '[color=#105289]pouvoirs d’armes : [/color]%s %%',

'APPLY_CHAR_PALHO' 		=> '[color=#105289][u]Sacré[/u][/color]',
'APPLY_CHAR_PALRE' 		=> '[color=#105289][u]Vindicte[/u][/color]',
'APPLY_CHAR_PALPR' 		=> '[color=#105289][u]Protection[/u][/color]',

'APPLY_CHAR_WARRARM' 	=> '[color=#105289][u]Armes/Fureur[/u][/color]',
'APPLY_CHAR_WARRPRO' 	=> '[color=#105289][u]Défense[/u][/color]',
'APPLY_CHAR_HP' 		=> '[color=#105289]Vie : [/color]%s',
'APPLY_CHAR_ARMOR' 		=> '[color=#105289]Armure : [/color]%s',
'APPLY_CHAR_DEF' 		=> '[color=#105289]Défense : [/color]%s',
'APPLY_CHAR_DODGE' 		=> '[color=#105289]Esquisse : [/color]%s %%',
'APPLY_CHAR_PARRY' 		=> '[color=#105289]Parade : [/color]%s %%',
'APPLY_CHAR_BLOCK' 		=> '[color=#105289]Blocage : [/color]%s %%',

'APPLY_CHAR_DRUFER' 	=> '[color=#105289][u]Combat farouche[/u][/color]',
'APPLY_CHAR_RESTO' 		=> '[color=#105289][u]Equilibre/Restauration[/u][/color]', 
'APPLY_CHAR_NATCRIT' 	=> '[color=#105289]Crit naturel: [/color]%s %%',

'APPLY_CHAR_SHAEN' 		=> '[color=#105289][u]Amélioration[/u][/color]',
'APPLY_CHAR_SHAEL' 		=> '[color=#105289][u]Elementaire[/u][/color]',
'APPLY_CHAR_SHARE' 		=> '[color=#105289][u]Restauration[/u][/color]', 

'APPLY_CHAR_URL' => '[color=#105289][/color][url=%s]Lien Armurerie[/url]', 

));

?>
