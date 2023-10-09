<?php 
ini_set('memory_limit', '-1');
header('Content-Type: text/html; charset=UTF-8');
include('../config.php');

if (!isset($_SERVER['argv']) || count($_SERVER['argv']) == 0) exit();

$args = $_SERVER['argv'];
$str_ctrl = !empty($args[1]) ? $args[1]:"";
$echo_result = (!empty($args[2]) && $args[2]==true) ? true:false;

if("3roUApgZbigh" != $str_ctrl) exit("- Permission denied.\n\r");


$db = new PDO('mysql:dbname='.$DBName.';host='.$DBHost, $DBUser, $DBPass);

$file = file_get_contents2("https://www.marocannonces.com/flux/xml/okjob.xml");

function utf8_for_xml($string)
{
	return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
}

$file = utf8_for_xml($file);

$flux = new SimpleXMLElement($file);

//	$flux = simplexml_load_file($file, null, LIBXML_NOCDATA);

// instancier la classe d'insertion
$cls = new insertAds($db);
// ajouter les jobs

foreach ($flux as $element) {
	$cls->insert($element);
}

echo "### Terminer ###";

function file_get_contents2($url) {
	$ch = curl_init($url);
   
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
   
	$contents = curl_exec($ch);
	curl_close($ch);
   
	return $contents;
   }

/**
 * Create Ads
 * @author IKAN
 *
 */
class insertAds {

	protected $vars;
	protected $db;

	protected $root;
	protected $regions;
	protected $categories;

	public function __construct(&$db){
		$this->db = $db;
		$this->root_path = dirname(__FILE__)."/..";
		include $this->root_path."/locations/locations_array.php";
		$this->regions = $loc;
		
		include $this->root_path."/categories/categories_array_en.php";
		$this->categories = $l;
		// var_dump($this->categories);die;
	}

	protected function vformat($vars2)
	{
		// convertir les données xml en un tableau
		$vars =  array();

		foreach($vars2 as $k => $v)
		{
			if($k != "extra_fields")
				$vars["{$k}"] = urldecode("{$v}");
			elseif($k == "extra_fields")
			{
				foreach($v as $k1=>$v1)
				{
					$vars["{$k}"]["{$k1}"] = urldecode("{$v1}");
				}
			}
		}
		$this->vars = $vars;
		//var_dump($this->vars);die;
	}

	public function insert($vars)
	{
		// formatter les données
		$this->vformat($vars);
		
		// insert employers
		if(!$this->insert_employer())
		{
			return "Erreur insertion employer";
		}

		// TODO upload images

		// TODO niveau d'etude

		// insert jobs
		if(!$this->insert_job())
		{
			return "Erreur insertion Job";
		}
	}


	protected function insert_employer()
	{
		
		$res = $this->db->query("SELECT count(*) FROM `jobsportal_employers` WHERE username = '".$this->vars["email"]."'"); //
				
		if($res->fetchColumn() > 0) return true;
		
		if(isset($this->vars["extra_fields"]) && !empty($this->vars["extra_fields"]["raison-sociale"]))
			$company = $this->vars["extra_fields"]["raison-sociale"];
		else
			$company = $this->vars["name"];
		
		$sql = "INSERT INTO `jobsportal_employers` (`id`, `username`, `company`, `company_description`, `contact_person`, `address`, `phone`, `fax`, `website`, `password`, `active`, `code`, `language`, `logo`, `credits`, `employer_fields`, `newsletter`, `resumes`, `video_id`, `registered_on`, `show_information`, `box_1`, `box_2`, `box_3`, `box_4`, `box_5`, `box_6`, `type`, `new_subscription`, `subscription_code`, `subscription`, `date`, `location`, `latitude`, `longitude`) VALUES
				(NULL, '".$this->vars["email"]."', '".$company."', '', '".$this->vars["name"]."', '".$this->getRegion($this->vars["state"])."', '".$this->vars["phone"]."', '', '', 'ok201602', 1, '', 'fr', '".$this->vars["thumbnail"]."', 0, 'a:0:{}', 1, 0, NULL, NULL, 1, 'jobs#add#1', 'jobs#my#2', 'application_management#list#3', 'home#received#4', 'profile#edit#5', 'profile#logo#6', 'Basic', NULL, NULL, 0, '".$this->vars["date"]."', '".$this->getRegion($this->vars["state"])."', NULL, NULL);";

		$r = $this->db->prepare($sql)->execute();

		if(!$r)
		{
			echo "<p>Erreur employers insert: ".$sql."</p>";
			return false;
		}

		return true;
	}

	protected function insert_job()
	{
		if(!empty($this->vars["extra_fields"]["domaine"]))
			$domaine = $this->vars["extra_fields"]["domaine"];
		elseif(!empty($this->vars["extra_fields"]["domain"]))
			$domaine = $this->vars["extra_fields"]["domain"];
		else
			$domaine = "Autres métiers";
			
		$tab= array("date" => $this->vars["date"],
				"employer"=> $this->vars["email"],
				"job_category" => $this->getCategory($domaine),
				"region" => $this->getRegion($this->vars["state"]),
				"title" => $this->vars["title"],
				"message" => $this->vars["description"],
				"active" => "YES",
				"featured" =>0,
				"expires" => $this->vars["date"]+5184000, // 2 mois
				"zip" => "",
				"job_type" => 1,
				"featured_expires" => 0,
				"salary" => !empty($this->vars["extra_fields"]["salaire"])? $this->vars["extra_fields"]["salaire"]:'',
				"date_available" => "",
				"more_fields" => serialize(array()),
				"applications" => 0,
				"images" => "",
				"status" => 1,
				"ref" => $this->vars["listingId"],
		);



		$param = implode(",", array_keys($tab));
		$inter = array();
		for($i=0;$i<count($tab);$i++){
			$inter[] ='?';
		}

		$values = array_values($tab);
		
		// delete jobs with same ref
		$this->db->query("delete from jobsportal_jobs WHERE ref='".$this->vars["listingId"]."'");

		$sql = "insert into jobsportal_jobs (`id`, $param) values(NULL, ".implode(',',$inter).")";
		$r = $this->db->prepare($sql)->execute($values);

		if(!$r){
			echo "erreur insertion jobs";
			return false;
		}
	}

	public function getCategory($cat)
	{
		// var_dump($this->categories);die;
		$key = array_search($cat, $this->categories);
		if(!$key) $key = $cat;
		return $key;
	}
	
	/**
	 * Recuperer l'id de la region
	 * @param unknown_type $state
	 * @return mixed
	 */
	public function getRegion($state)
	{
		$key = array_search($state, $this->regions);
		if(!$key) $key = $state;
		return $key;
	}

}

?>