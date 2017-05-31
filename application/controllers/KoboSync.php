<?php

class KoboSync extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
		echo 'Following Routes are Available: <hr><ul>
<li>kobosync/listforms</li>
</ul>';
	}

	public function listForms()
	{
		$username = "baliyoghar";
		$password = "b@liyoghar.nset";
		//$host ='https://kc.humanitarianresponse.info/api/v1/data';
		//$host ='https://kc.humanitarianresponse.info/api/v1/metadata/235034';
		//$host ='https://kc.humanitarianresponse.info/api/v1/data/75980';
		$host = 'https://kc.humanitarianresponse.info/api/v1/forms';

		$query = urlencode('{"_submission_time":{"$gte":"2016-07-13T06:42:26"}}');

		$url = $host . '?query=' . $query;

		$ch = curl_init($url);
		$headers = [
		];
		curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response_data = curl_exec($ch);

		if (curl_errno($ch) > 0) {
			die('There was a cURL error: ' . curl_error($ch));
		} else {
//Close the handler and release resources
			curl_close($ch);
		}

		$results = json_decode($response_data,TRUE);

		foreach($results as $item){
			echo 'Form Id : '.$item['formid'];echo '<br>';
			echo 'Title : '.$item['title'];echo '<br>';
			echo 'Description : '.$item['description'];echo '<br>';
			echo 'Download Url :'. 'https://kc.humanitarianresponse.info/api/v1/data'.$item['formid'];
			echo '<hr>';
		}
	}

	public function syncForm($formid)
	{
		$username = "baliyoghar";
		$password = "b@liyoghar.nset";
		//$host ='https://kc.humanitarianresponse.info/api/v1/data';
		//$host ='https://kc.humanitarianresponse.info/api/v1/metadata/235034';
		//$host ='https://kc.humanitarianresponse.info/api/v1/data/75980';
		$host = 'https://kc.humanitarianresponse.info/api/v1/data/'.$formid;

		//$query = urlencode('{"_submission_time":{"$gte":"2016-07-13T06:42:26"}}');
		//$url = $host . '?query=' . $query;
		$url = $host ;

		$ch = curl_init($url);
		$headers = [
		];
		curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response_data = curl_exec($ch);

		if (curl_errno($ch) > 0) {
			die('There was a cURL error: ' . curl_error($ch));
		} else {
//Close the handler and release resources
			curl_close($ch);
		}

		$results = json_decode($response_data,TRUE);


		/*foreach($results as $items){
			foreach($items as $key=>$value){
				if(is_array($value)){
					$value = json_encode($value);
				}
				echo $key;echo ' : ';echo $value;'<br>';
				echo '<hr>';
			}

		}*/
		echo $response_data;
	}

	public function formDef($formid)
	{
		$username = "baliyoghar";
		$password = "b@liyoghar.nset";
		//$host ='https://kc.humanitarianresponse.info/api/v1/data';
		//$host ='https://kc.humanitarianresponse.info/api/v1/metadata/235034';
		//$host ='https://kc.humanitarianresponse.info/api/v1/data/75980';
		$host = 'https://kc.humanitarianresponse.info/api/v1/forms/'.$formid.'/form.json';


		$url = $host;

		$ch = curl_init($url);
		$headers = [
		];
		curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_ENCODING ,"");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response_data = curl_exec($ch);
echo  $response_data;
		exit();
		if (curl_errno($ch) > 0) {
			die('There was a cURL error: ' . curl_error($ch));
		} else {
//Close the handler and release resources
			curl_close($ch);
		}

		$results = json_decode($response_data,TRUE);


		foreach($results as $items){
			foreach($items as $key=>$value){
				if(is_array($value)){
					$value = json_encode($value);
				}
				echo $key;echo ' : ';echo $value;'<br>';
				echo '<hr>';
			}

		}
	}
}

?>
