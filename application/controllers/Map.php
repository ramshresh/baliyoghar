<?php

/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 7/13/2016
 * Time: 10:57 AM
 */
class Map extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('Home/login', 'refresh');
        }
        $this->load->model('eventmodel');
        $this->load->model('functionsmodel');
        $this->load->model('coursemodel');
        $this->load->model('personmodel');
    }


    public function loadpage($data = null, $view = 'Home', $pagetitle = 'HOME | BALIYOGHAR', $page = array('includes/Header', 'includes/Navigation')) {
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $data['pagetitle'] = $pagetitle;
        for ($i = 0; $i < count($page); $i++) {
            $this->load->View($page[$i], $data);
        }
        $this->load->View($view, $data);
        $this->load->View('includes/Footer');
    }

    public function events() {
        $this->loadpage(null, 'Map_Events', 'Events');
    }

    public function coverages() {
        $this->loadpage(null, 'Map_Coverages', 'Events');
    }

    public function getEventsGeojson(){
        $json = json_encode([
            "type" => "FeatureCollection",
            "features" => eventmodel::markers_geojson()
        ]);
        header('Content-type: application/json; charset=utf-8');
        echo $json;
    }

    public function kobo_data(){
        $username = "baliyoghar";
        $password = "b@liyoghar.nset";
        $host ='https://kc.humanitarianresponse.info/api/v1/data';
        $host ='https://kc.humanitarianresponse.info/api/v1/metadata/235034';
        $host ='https://kc.humanitarianresponse.info/api/v1/data/75980';

        $query =urlencode('{"_submission_time":{"$gte":"2016-07-13T06:42:26"}}');

        $url = $host.'?query='.$query;

        $ch = curl_init($url);
        $headers = [
        ];
        curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);

        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_MAXREDIRS,5);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response_data = curl_exec($ch);
        echo $response_data;
        if (curl_errno($ch)> 0){
            die('There was a cURL error: ' . curl_error($ch));
        } else {
//Close the handler and release resources
            curl_close($ch);
        }

        /*$process = curl_init($host);
        //curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));
        curl_setopt($process, CURLOPT_HEADER, 1);
        curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($process,CURLOPT_HEADER,[
            'Content-Language: en',
            'Content-Type: application/json',
        ]);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_POST, 1);
        //curl_setopt($process, CURLOPT_POSTFIELDS, $payloadName);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
        $return = curl_exec($process);

        curl_close($process);

        var_dump($return);*/

        /*$remote_url = 'https://kc.kobotoolbox.org/api/v1/data';

// Create a stream
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header' => "Authorization: Basic " . base64_encode("$username:$password")
            )
        );

        $context = stream_context_create($opts);

// Open the file using the HTTP headers set above
        $file = file_get_contents($remote_url, false, $context);

        print($file);*/

    }
}