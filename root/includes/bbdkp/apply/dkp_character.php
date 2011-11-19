<?php
/**
* bbdkp Apply core class
*
* @package bbDkp.includes
* @version $Id$
* @copyright (c) 2010 bbDkp <http://code.google.com/p/bbdkp/>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @author Kapli, Malfate, Sajaki, Blazeflack, Twizted, Ethereal
*
*
**/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * This class describes an applicant
 */
class dkp_character
{
	// character definition
	public $name ='';
	public $realm = '';
	public $ModelViewURL;
	public $url;
	public $feedurl; 
	public $level ='';
	public $class = 0;
	public $talents ='';
	public $race ='';
	
	public $talent1name ='';
	public $talent1 ='';
	public $talent2name ='';
	public $talent2 ='';
	public $professions ='';
	public $classid = 0;
	public $genderid = 0;
	public $raceid = 0;
	public $faction = 0;
	public $guild = ''; 

	public $spellpower = 0; 
	public $spellhit = 0; 
	public $firecrit = 0;
	public $frostcrit = 0; 
	public $arcanecrit = 0; 
	public $holycrit = 0; 
	public $shadowcrit = 0; 
	public $naturecrit = 0; 
	public $mrcast = 0; 
	public $spellhaste = 0; 
	
	public $hp = 0; 
	public $mana = 0; 
	public $rap = 0; 
	public $rcr = 0; 
	public $rhr = 0;  
	public $rdps = 0; 
	public $rspeed = 0; 
	public $map = 0; 
	public $mcr = 0;
	public $mhr = 0; 
	public $mhdps = 0; 
	public $ohdps = 0; 
	public $mspeed = 0; 
	
	public $expertise = 0; 
	public $armor = 0; 
	public $defense = 0; 
	public $dodge = 0; 
	public $parry = 0; 
	public $block = 0;  

	public $glyphminor;
	public $glyphmajor;
	public $item = array();
	public $achievements;
	public $gear = array();
	public $ilvl = array();
	public $gems1 = array();
	public $gems2 = array();
	public $gems3 = array();
	public $ench = array();
	public $gearNameLink = array();
	
	public $modeltemplate; 

	
	//constructor
	public function character()
	{
				
	}
	
	/**
 	 * function to get applicant from armory - returns character object or false
	 * 
	 * @access public
	 * @return boolean or object
	 * 
	 */
	public function GetChar1($name, $realm)
	{
		global $db, $user, $config;
		
		if (strlen($name) == 0 || strlen($realm) == 0 )
		{
			return false;
		}
		
		$this->name = $name; 
		
		$base_url = ($config['bbdkp_apply_region'] == "US") ? "http://www.wowarmory.com" : "http://eu.wowarmory.com"; 
		$charurl   = $base_url . "/character-sheet.xml?r=" . $realm . "&n=" . $name;
		$this->url = $base_url . "/character-sheet.xml?r=" . urlencode($realm) . "&n=" . urlencode($name);
		$this->realm = str_replace(" ", "_", $realm);
		
		//calling static bbdkp urlreader function. 
		$xml_data = bbDkp_Admin::read_php ( $this->url,false,false );
		
		if (empty($xml_data))
		{
    	    return false;
		}
		else
		{
		    $xml = simplexml_load_string($xml_data);
		    if (!isset($xml->characterInfo->character['name']))
		    {
        	    return false;
		    }
		}
		
		if($this->_Getchar2($xml) == true)
		{
			// get post content
			$this->modeltemplate = $this->_getFormattedPost();
			return true;
		}
		else 
		{
			return false;
		}
		
	}
	
	/**
	 * internal function to fill character object
	 * 
	 */
	private function _Getchar2($xml) 
	{
		
		global $phpbb_root_path, $phpEx, $config;  
		
		$skills = $xml->xpath('characterInfo/characterTab/professions/skill');
		if (!empty($skills)) 
		{
			$this->professions = '';
			foreach ($skills as $k => $v) 
			{
			    $skills[$k] = $v->attributes();
				$this->professions .='<img src="'.$phpbb_root_path.'images/apply_icon/Trade_'.$skills[$k]['name'] . '.jpg" width="20" height="20" alt="'.$skills[$k]['name'] . '">  [color='. $config['bbdkp_apply_pacolor'] . '] '.$skills[$k]['name'] . ' (' . $skills[$k]['value'] . '/'. $skills[$k]['max'] . ')[/color] '.'<br/>';
			}
		}	
		else 
		{
			$this->professions .=" NONE";
	
		}
				
		$talent = $xml->xpath('characterInfo/characterTab/talentSpecs/talentSpec');
		foreach ($talent as $k => $v)
		{
		    $talent[$k] = $v->attributes();
            if ($talent[$k]['active']=="1") 
            {
            	$this->talent1name = (string) $talent[$k]['prim'];
			    $this->talent1 =  ' (' . $talent[$k]['treeOne'] . "/" . $talent[$k]['treeTwo'] . "/" . $talent[$k]['treeThree'].")";
			    
            }
            else
            {
			    $this->talent2name = (string) $talent[$k]['prim'];
			    $this->talent2 = ' (' . $talent[$k]['treeOne'] . "/" . $talent[$k]['treeTwo'] . "/" . $talent[$k]['treeThree'].")";
            }
		}
		$this->talents = (string) $this->talent1 . '  ' . $this->talent2;
		$this->name = (string)  ucfirst(strtolower($this->name));
		$this->level = (int)  $xml->characterInfo->character['level'];
		$this->class = (string) $xml->characterInfo->character['class'];
		$this->classid = (int) $xml->characterInfo->character['classId'];
		$this->genderid = (int) $xml->characterInfo->character['genderId'];
		$this->race = (string) $xml->characterInfo->character['race'];
		$this->raceid = (int) $xml->characterInfo->character['raceId'];
		$this->faction = (string) $xml->characterInfo->character['faction'];
		
		$this->spellpower = (float) $xml->characterInfo->characterTab->spell->bonusHealing['value'];
		$this->spellhit = (float)$xml->characterInfo->characterTab->spell->hitRating['increasedHitPercent'];
		$this->firecrit = (float)  $xml->characterInfo->characterTab->spell->critChance->fire['percent'];
		$this->frostcrit = (float) $xml->characterInfo->characterTab->spell->critChance->frost['percent'];
		$this->arcanecrit = (float) $xml->characterInfo->characterTab->spell->critChance->arcane['percent'];
		$this->holycrit = (float) $xml->characterInfo->characterTab->spell->critChance->holy['percent'];
		$this->shadowcrit = (float) $xml->characterInfo->characterTab->spell->critChance->shadow['percent'];
		$this->naturecrit = (float) $xml->characterInfo->characterTab->spell->critChance->nature['percent'];
		$this->mrcast = (float) $xml->characterInfo->characterTab->spell->manaRegen['casting'];
		$this->spellhaste = (float) $xml->characterInfo->characterTab->spell->hasteRating['hastePercent'];		
		$this->hp = (int) $xml->characterInfo->characterTab->characterBars->health['effective'];
		$this->mana = (int) $xml->characterInfo->characterTab->characterBars->secondBar['effective'];
		$this->rap = (float) $xml->characterInfo->characterTab->ranged->power['effective'];
		$this->rcr = (float) $xml->characterInfo->characterTab->ranged->critChance['percent'];
		$this->rhr = (float) $xml->characterInfo->characterTab->ranged->hitRating['increasedHitPercent'];
		$this->rdps = (float) $xml->characterInfo->characterTab->ranged->damage['dps'];
		$this->rspeed = (float) $xml->characterInfo->characterTab->ranged->speed['hastePercent'];
		$this->map = (int) $xml->characterInfo->characterTab->melee->power['effective'];
		$this->mcr = (float) $xml->characterInfo->characterTab->melee->critChance['percent'];
		$this->mhr = (float) $xml->characterInfo->characterTab->melee->hitRating['increasedHitPercent'];
		$this->mhdps = (float) $xml->characterInfo->characterTab->melee->mainHandDamage['dps'];
		$this->ohdps = (float) $xml->characterInfo->characterTab->melee->offHandDamage['dps'];
		$this->mspeed = (float) $xml->characterInfo->characterTab->melee->mainHandSpeed['hastePercent'];
		$this->expertise = (float) $xml->characterInfo->characterTab->melee->expertise['percent'];
		$this->armor = (int) $xml->characterInfo->characterTab->defenses->armor['effective'];
		$this->defense = (float) $xml->characterInfo->characterTab->defenses->defense['value'] + $xml->characterInfo->characterTab->defenses->defense['plusDefense'];
		$this->dodge = (float) $xml->characterInfo->characterTab->defenses->dodge['percent'];
		$this->parry = (float) $xml->characterInfo->characterTab->defenses->parry['percent'];
		$this->block = (float) $xml->characterInfo->characterTab->defenses->block['percent'];

		//glyphs 
		$glyphs = $xml->characterInfo->characterTab->glyphs;
		$this->glyphmajor = '';
		$this->glyphminor = '';
		foreach ($glyphs->glyph as $key)
		{
			if(@$key->attributes()->type[0] == "major")
			{
				$this->glyphmajor .= (string) @$key->attributes()->name[0];
			}
			elseif (@$key->attributes()->type[0] == "minor")
			{
				$this->glyphminor .= (string) @$key->attributes()->name[0];
			}
		}
		
		// Gem/item information, and item name display. (Icon or name only)
		// Thanks Ethereal for finding Info for Gear List Tab
		$item = $xml->xpath('characterInfo/characterTab/items/item');
		foreach ($item as $k => $v)
		{
			$item[$k]= $v->attributes();
			
			$gearslot = $item[$k]['slot'];
			$gearslot = intval($gearslot);
	
			unset ($gearench);		
			// is item enchanted ?
			if (!empty($item[$k]['permanentEnchantItemId'])) 
			{
				$this->ench[$gearslot] = (string) $item[$k]['permanentEnchantItemId'];
			}
			else
			{
				$this->ench[$gearslot] = '';
			}

			// is item gemmed ?
			unset ($gemall);
			$geargem1 = (string) $item[$k]['gem0Id'];
			$geargem2 = (string) $item[$k]['gem1Id'];
			$geargem3 = (string) $item[$k]['gem2Id'];
			$this->gems[$gearslot] = ''; 
			if ($geargem1!="0") 
			{
				$this->gems[$gearslot] .= $geargem1;
			}
			if ($geargem2!="0") 
			{
				$this->gems[$gearslot] .= $geargem2;
			}
			if ($geargem3!="0") 
			{
				$this->gems[$gearslot] .= $geargem3;
			}

			//Icon link using bbcodes --> icon type set in html
			$this->gear[$gearslot] = (string) $item[$k]['id'];
			
			//Item name only(no icon) using bbcodes
			$this->gearNameLink[$gearslot] = (string)  $item[$k]['id'];
			
			$this->ilvl[$gearslot] = (string) $item[$k]['level'];

		}
		
		return true; 
	}
	
	/**
	 * this function prepares the post contents, using object data
	 * table html gets passed back to main apply function
	 *  
	 */
	private function _getFormattedPost()
	{
		global $common, $user, $phpbb_root_path, $config;
		
		// get the posting templates
		$opendir = @opendir($phpbb_root_path . 'includes/bbdkp/apply/patterns/'); 
		while (($file = readdir($opendir)) !== false )
		{
			if (substr($file, strpos($file, '.') + 1) == 'html')
			{
				$filename = (strpos($file, 'php') !== false) ? str_replace('.php', '', $file) : str_replace('.html', '', $file);
				$filecontents[$filename] = @file_get_contents($phpbb_root_path . 'includes/bbdkp/apply/patterns/' . $file);
			}
		}
		
		// get main div				
		$innerdiv = $filecontents['innerdiv'];
		
		// replace placeholders with content	
		$innerdiv = str_replace('{CANDIDATE}', $this->name , $innerdiv);
		$innerdiv = str_replace('{REALM}', (string) $this->realm , $innerdiv);
		$innerdiv = str_replace('{REGION}', $config['bbdkp_apply_region'] , $innerdiv);
	 	
		//get left td classpanes
		switch ($this->class)
		{
			case 'Mage':
				$leftpane = $filecontents['class_mage'];
				$leftpane = str_replace('{APPLY_CHAR_MANA}'  , sprintf( $user->lang['APPLY_CHAR_MANA'], $config['bbdkp_apply_pqcolor'],  '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mana . '[/color]'  ), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_ACRIT}' , sprintf( $user->lang['APPLY_CHAR_ACRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->arcanecrit . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_FCRIT}' , sprintf( $user->lang['APPLY_CHAR_FCRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->firecrit. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_FROST}' , sprintf( $user->lang['APPLY_CHAR_FROST'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->frostcrit. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SP}' 	 , sprintf( $user->lang['APPLY_CHAR_SP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellpower. '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_SPHIT}' , sprintf( $user->lang['APPLY_CHAR_SPHIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellhit. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SPHAS}' , sprintf( $user->lang['APPLY_CHAR_SPHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellhaste. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_HCRIT}' , sprintf( $user->lang['APPLY_CHAR_HCRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->holycrit. '[/color]'), $leftpane); 
				
				break;
			case 'Priest':
				$leftpane = $filecontents['class_priest'];
				$leftpane = str_replace('{APPLY_CHAR_MANA}'  , sprintf( $user->lang['APPLY_CHAR_MANA'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mana. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SP}' 	 , sprintf( $user->lang['APPLY_CHAR_SP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellpower. '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_SPHIT}' , sprintf( $user->lang['APPLY_CHAR_SPHIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellhit. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SPHAS}' , sprintf( $user->lang['APPLY_CHAR_SPHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellhaste. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_HCRIT}' , sprintf( $user->lang['APPLY_CHAR_HCRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->holycrit. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SHCRIT}' , sprintf( $user->lang['APPLY_CHAR_SHCRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->shadowcrit. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MREG}' , sprintf( $user->lang['APPLY_CHAR_MREG'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mrcast. '[/color]'), $leftpane); 
				break;

			case 'Warlock':
				$leftpane = $filecontents['class_warlock'];
				$leftpane = str_replace('{APPLY_CHAR_FCRIT}' , sprintf( $user->lang['APPLY_CHAR_FCRIT'],$config['bbdkp_apply_pqcolor'],  '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->firecrit. '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_MANA}'  , sprintf( $user->lang['APPLY_CHAR_MANA'],$config['bbdkp_apply_pqcolor'],  '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mana. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SP}' 	 , sprintf( $user->lang['APPLY_CHAR_SP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellpower. '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_SPHIT}' , sprintf( $user->lang['APPLY_CHAR_SPHIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellhit. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SPHAS}' , sprintf( $user->lang['APPLY_CHAR_SPHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellhaste. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_HCRIT}' , sprintf( $user->lang['APPLY_CHAR_HCRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->holycrit. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SHCRIT}' , sprintf( $user->lang['APPLY_CHAR_SHCRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->shadowcrit. '[/color]'), $leftpane); 
				
				break;
			case 'Hunter':
				$leftpane = $filecontents['class_hunter'];
				$leftpane = str_replace('{APPLY_CHAR_RANGEDPS}' , sprintf( $user->lang['APPLY_CHAR_RANGEDPS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->rdps. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_RANGEDAP}' , sprintf( $user->lang['APPLY_CHAR_RANGEDAP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->rap. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_RANGEDCRIT}' , sprintf( $user->lang['APPLY_CHAR_RANGEDCRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->rcr. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_RANGEHIT}' , sprintf( $user->lang['APPLY_CHAR_RANGEHIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->rhr. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_RANGEHAS}' , sprintf( $user->lang['APPLY_CHAR_RANGEHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->rspeed. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEHIT}' , sprintf( $user->lang['APPLY_CHAR_MELEEHIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mhr. '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_MELEEDPS}' , sprintf( $user->lang['APPLY_CHAR_MELEEDPS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mhdps), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEAP}' , sprintf( $user->lang['APPLY_CHAR_MELEEAP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->map . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEECRIT}' , sprintf( $user->lang['APPLY_CHAR_MELEECRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mcr . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEHAS}' , sprintf( $user->lang['APPLY_CHAR_MELEEHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mspeed . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_EXPERTISE}' , sprintf( $user->lang['APPLY_CHAR_EXPERTISE'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->expertise . '[/color]'), $leftpane); 
				break;
			case 'Rogue':
				$leftpane = $filecontents['class_rogue'];
				
				$leftpane = str_replace('{APPLY_CHAR_MELEEDPS}' , sprintf( $user->lang['APPLY_CHAR_MELEEDPS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mhdps . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEAP}' , sprintf( $user->lang['APPLY_CHAR_MELEEAP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->map . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEECRIT}' , sprintf( $user->lang['APPLY_CHAR_MELEECRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mcr . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEHIT}' , sprintf( $user->lang['APPLY_CHAR_MELEEHIT'], $config['bbdkp_apply_pqcolor'],'[color='. $config['bbdkp_apply_pacolor'] . ']' .  $this->mhr . '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_MELEEHAS}' , sprintf( $user->lang['APPLY_CHAR_MELEEHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mspeed . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_EXPERTISE}' , sprintf( $user->lang['APPLY_CHAR_EXPERTISE'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->expertise . '[/color]'), $leftpane); 
				break;
			case 'Warrior':
				$leftpane = $filecontents['class_warrior'];
				$leftpane = str_replace('{APPLY_CHAR_WARRARM}' , sprintf( $user->lang['APPLY_CHAR_WARRARM'],$config['bbdkp_apply_pqcolor']), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_WARRPRO}' , sprintf($user->lang['APPLY_CHAR_WARRPRO'], $config['bbdkp_apply_pqcolor']), $leftpane); 
				
				
				$leftpane = str_replace('{APPLY_CHAR_ARMOR}' , sprintf( $user->lang['APPLY_CHAR_ARMOR'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->armor . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_DEF}' , sprintf( $user->lang['APPLY_CHAR_DEF'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->defense . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_DODGE}' , sprintf( $user->lang['APPLY_CHAR_DODGE'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->dodge  . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_PARRY}' , sprintf( $user->lang['APPLY_CHAR_PARRY'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->parry . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_BLOCK}' , sprintf( $user->lang['APPLY_CHAR_BLOCK'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->block . '[/color]'), $leftpane); 
								
				$leftpane = str_replace('{APPLY_CHAR_MELEEDPS}' , sprintf( $user->lang['APPLY_CHAR_MELEEDPS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mhdps . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEAP}' , sprintf( $user->lang['APPLY_CHAR_MELEEAP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->map . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEHIT}' , sprintf( $user->lang['APPLY_CHAR_MELEEHIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mhr . '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_MELEECRIT}' , sprintf( $user->lang['APPLY_CHAR_MELEECRIT'],$config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mcr . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEHAS}' , sprintf( $user->lang['APPLY_CHAR_MELEEHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mspeed . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_EXPERTISE}' , sprintf( $user->lang['APPLY_CHAR_EXPERTISE'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->expertise . '[/color]'), $leftpane); 
								
				break;
			case 'Paladin':
				$leftpane = $filecontents['class_paladin'];    
				$leftpane = str_replace('{APPLY_CHAR_PALHO}' , sprintf($user->lang['APPLY_CHAR_PALHO'], $config['bbdkp_apply_pqcolor']), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_PALRE}' , sprintf($user->lang['APPLY_CHAR_PALRE'],$config['bbdkp_apply_pqcolor']), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_PALPR}' , sprintf($user->lang['APPLY_CHAR_PALPR'],$config['bbdkp_apply_pqcolor']), $leftpane); 
				
				
				$leftpane = str_replace('{APPLY_CHAR_ARMOR}' , sprintf( $user->lang['APPLY_CHAR_ARMOR'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->armor . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_DEF}' , sprintf( $user->lang['APPLY_CHAR_DEF'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->defense . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_DODGE}' , sprintf( $user->lang['APPLY_CHAR_DODGE'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->dodge . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_PARRY}' , sprintf( $user->lang['APPLY_CHAR_PARRY'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->parry . '[/color]') , $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_BLOCK}' , sprintf( $user->lang['APPLY_CHAR_BLOCK'],$config['bbdkp_apply_pqcolor'],  '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->block . '[/color]'), $leftpane); 

				$leftpane = str_replace('{APPLY_CHAR_MELEEDPS}' , sprintf( $user->lang['APPLY_CHAR_MELEEDPS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mhdps . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEAP}' , sprintf( $user->lang['APPLY_CHAR_MELEEAP'],$config['bbdkp_apply_pqcolor'],  '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->map . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEECRIT}' , sprintf( $user->lang['APPLY_CHAR_MELEECRIT'],$config['bbdkp_apply_pqcolor'],  '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mcr . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEHIT}' , sprintf( $user->lang['APPLY_CHAR_MELEEHIT'],$config['bbdkp_apply_pqcolor'],  '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mhr . '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_MELEEHAS}' , sprintf( $user->lang['APPLY_CHAR_MELEEHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mspeed . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_EXPERTISE}' , sprintf( $user->lang['APPLY_CHAR_EXPERTISE'], $config['bbdkp_apply_pqcolor'],'[color='. $config['bbdkp_apply_pacolor'] . ']' .  $this->expertise . '[/color]'), $leftpane); 

				$leftpane = str_replace('{APPLY_CHAR_MANA}'  , sprintf( $user->lang['APPLY_CHAR_MANA'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mana . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SP}' 	 , sprintf( $user->lang['APPLY_CHAR_SP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellpower . '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_SPHIT}' , sprintf( $user->lang['APPLY_CHAR_SPHIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellhit . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SPHAS}' , sprintf( $user->lang['APPLY_CHAR_SPHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellhaste . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_HCRIT}' , sprintf( $user->lang['APPLY_CHAR_HCRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->holycrit . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MREG}' , sprintf( $user->lang['APPLY_CHAR_MREG'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mrcast . '[/color]'), $leftpane); 				
				
				break;
			case 'Druid':
				$leftpane = $filecontents['class_druid'];
				$leftpane = str_replace('{APPLY_CHAR_DRUFER}' , sprintf( $user->lang['APPLY_CHAR_DRUFER'], $config['bbdkp_apply_pqcolor']) , $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_RESTO}' , sprintf( $user->lang['APPLY_CHAR_RESTO'], $config['bbdkp_apply_pqcolor']) , $leftpane); 

				
				$leftpane = str_replace('{APPLY_CHAR_ARMOR}' , sprintf( $user->lang['APPLY_CHAR_ARMOR'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->armor . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_DEF}' , sprintf( $user->lang['APPLY_CHAR_DEF'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->defense . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_DODGE}' , sprintf( $user->lang['APPLY_CHAR_DODGE'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->dodge . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEHIT}' , sprintf( $user->lang['APPLY_CHAR_MELEEHIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mhr . '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_MELEEDPS}' , sprintf( $user->lang['APPLY_CHAR_MELEEDPS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mhdps . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEAP}' , sprintf( $user->lang['APPLY_CHAR_MELEEAP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->map . '[/color]') , $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEECRIT}' , sprintf( $user->lang['APPLY_CHAR_MELEECRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mcr . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEHAS}' , sprintf( $user->lang['APPLY_CHAR_MELEEHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mspeed . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_EXPERTISE}' , sprintf( $user->lang['APPLY_CHAR_EXPERTISE'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->expertise . '[/color]'), $leftpane); 
				
				$leftpane = str_replace('{APPLY_CHAR_SP}' 	 , sprintf( $user->lang['APPLY_CHAR_SP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellpower . '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_MANA}'  , sprintf( $user->lang['APPLY_CHAR_MANA'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mana . '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_NATCRIT}' , sprintf( $user->lang['APPLY_CHAR_NATCRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->naturecrit. '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_SPHIT}' , sprintf( $user->lang['APPLY_CHAR_SPHIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellhit. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SPHAS}' , sprintf( $user->lang['APPLY_CHAR_SPHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellhaste. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MREG}' , sprintf( $user->lang['APPLY_CHAR_MREG'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mrcast. '[/color]'), $leftpane); 
				
				break;
			case 'Shaman':
				$leftpane = $filecontents['class_shaman'];
				$leftpane = str_replace('{APPLY_CHAR_SHAEN}' , sprintf( $user->lang['APPLY_CHAR_SHAEN'], $config['bbdkp_apply_pqcolor']), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SHAEL}' , sprintf( $user->lang['APPLY_CHAR_SHAEL'], $config['bbdkp_apply_pqcolor']), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SHARE}' , sprintf( $user->lang['APPLY_CHAR_SHARE'], $config['bbdkp_apply_pqcolor']), $leftpane); 
				
				$leftpane = str_replace('{APPLY_CHAR_MELEEDPS}' , sprintf( $user->lang['APPLY_CHAR_MELEEDPS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mhdps. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEAP}' , sprintf( $user->lang['APPLY_CHAR_MELEEAP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->map. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEECRIT}' , sprintf( $user->lang['APPLY_CHAR_MELEECRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mcr. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEHAS}' , sprintf( $user->lang['APPLY_CHAR_MELEEHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mspeed. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_EXPERTISE}' , sprintf( $user->lang['APPLY_CHAR_EXPERTISE'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->expertise. '[/color]'), $leftpane); 
				
				$leftpane = str_replace('{APPLY_CHAR_SP}' 	 , sprintf( $user->lang['APPLY_CHAR_SP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellpower. '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_MANA}'  , sprintf( $user->lang['APPLY_CHAR_MANA'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' .  $this->mana. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_NATCRIT}' , sprintf( $user->lang['APPLY_CHAR_NATCRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->naturecrit. '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_FCRIT}' , sprintf( $user->lang['APPLY_CHAR_FCRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->firecrit. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SPHIT}' , sprintf( $user->lang['APPLY_CHAR_SPHIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellhit. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_SPHAS}' , sprintf( $user->lang['APPLY_CHAR_SPHAS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->spellhaste. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MREG}' , sprintf( $user->lang['APPLY_CHAR_MREG'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mrcast. '[/color]'), $leftpane); 
								
				break;
			 default:
			 	$leftpane = $filecontents['class_dk'];
				
				$leftpane = str_replace('{APPLY_CHAR_ARMOR}' , sprintf( $user->lang['APPLY_CHAR_ARMOR'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->armor. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_DEF}' , sprintf( $user->lang['APPLY_CHAR_DEF'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->defense. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_DODGE}' , sprintf( $user->lang['APPLY_CHAR_DODGE'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->dodge. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEHIT}' , sprintf( $user->lang['APPLY_CHAR_MELEEHIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mhr. '[/color]'), $leftpane);
				$leftpane = str_replace('{APPLY_CHAR_MELEEDPS}' , sprintf( $user->lang['APPLY_CHAR_MELEEDPS'],$config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' .  $this->mhdps. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEAP}' , sprintf( $user->lang['APPLY_CHAR_MELEEAP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' .  $this->map. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEECRIT}' , sprintf( $user->lang['APPLY_CHAR_MELEECRIT'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mcr. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_MELEEHAS}' , sprintf( $user->lang['APPLY_CHAR_MELEEHAS'], $config['bbdkp_apply_pqcolor'],  '[color='. $config['bbdkp_apply_pacolor'] . ']' . $this->mspeed. '[/color]'), $leftpane); 
				$leftpane = str_replace('{APPLY_CHAR_EXPERTISE}' , sprintf( $user->lang['APPLY_CHAR_EXPERTISE'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' .  $this->expertise. '[/color]'), $leftpane); 
							 	
				break;
		}
		$leftpane = str_replace('{APPLY_CHAR_HP}' , sprintf( $user->lang['APPLY_CHAR_HP'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' .  $this->hp. '[/color]'), $leftpane); 
		$leftpane = str_replace('{APPLY_CHAR_LEVEL}'  , sprintf( $user->lang['APPLY_CHAR_LEVEL'],$config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' .  $this->level. '[/color]'),  $leftpane);
		$leftpane = str_replace('{APPLY_CHAR_NAME}'  , sprintf( $user->lang['APPLY_CHAR_NAME'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' .  $this->name. '[/color]'),  $leftpane); 
		$leftpane = str_replace('{APPLY_CHAR_CLASS}' , sprintf( $user->lang['APPLY_CHAR_CLASS'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' .  $this->class. '[/color]'), $leftpane); 
		$leftpane = str_replace('{APPLY_CHAR_PROFF}' , sprintf( $user->lang['APPLY_CHAR_PROFF'], $config['bbdkp_apply_pqcolor'],  $this->professions), $leftpane); 
		$leftpane = str_replace('{APPLY_CHAR_BUILD}' , sprintf( $user->lang['APPLY_CHAR_BUILD'], $config['bbdkp_apply_pqcolor'], '[color='. $config['bbdkp_apply_pacolor'] . ']' .  $this->talents. '[/color]'), $leftpane); 
		
		//place left td in main div
		$innerdiv = str_replace('{CLASSTD}', $leftpane , $innerdiv);

		//return innerdiv to apply.php for insertion in post
		return $innerdiv; 		
		
	}

}


class applycore
{
	//public vars
	public $armoryonline;
	
	public function applycore()
	{
		$this->armoryonline = $this->_armorycheck();
	}
	
	/**
	 * 
	* function to check if Armory is online 
	* if we get an armory xml for the charactercheckname in apply setting then we assume the armory works 
    * 
    * @return boolean
    * @access private
	**/
	private function _armorycheck()
	{
		
		global $db, $config;
		
		$realm = $config['bbdkp_apply_realm']; 
		$base_url = ($config['bbdkp_apply_region'] == "US") ? "http://www.wowarmory.com" : "http://eu.wowarmory.com"; 
		$name = $config['bbdkp_apply_charconnectcheck'];	
		$url = $base_url . "/character-sheet.xml?r=" . $realm . "&n=" . $name;
		
		$xml_data = bbDkp_Admin::read_php ( $url,false,false );
		
		if (empty($xml_data))
		{
    	    return false;
		}
		else
		{
		    $xml = simplexml_load_string($xml_data);
		    if (isset($xml->characterInfo->character['name']))
		    {
        	    return true;
		    }
		    else
		    {
        	    return false;
		    }
		}
			
	}
	
	
	
}

?>