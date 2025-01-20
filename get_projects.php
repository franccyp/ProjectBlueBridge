<?php

include "project.php";
include "config.php";

class ProjectManager {
    function get_method_url($url){

        // Get cURL resource
        $curl = curl_init();

        //loading api token
        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'method: GET';
        $headr[] = api_token;

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'project blue'
        ));

        curl_setopt($curl, CURLOPT_HTTPHEADER,$headr);

        // Send the request & save response to $resp
        $resp = curl_exec($curl);

        if ($resp === false)
        {
            // throw new Exception('Curl error: ' . curl_error($crl));
            print_r('Curl error: ' . curl_error($curl));
        }
        // Close request to clear up some resources
        curl_close($curl);
        return $resp; //print_r($resp);
    }

    function all_projects (){
        return $this->get_method_url(project_url);
    }

    function get_project_by_id($project_id){
        $new_curl_filter_url = project_url . "/" . urlencode($project_id);
        $response = $this->get_method_url($new_curl_filter_url);
        // print($response);
        return json_decode($response, true);
    }

    function get_project_filter_name($name_project){
        $encode_filter_name = urlencode($name_project);
        $new_curl_filter_url = project_url ."?name=" .$encode_filter_name;
        print($new_curl_filter_url);
        return $this->get_method_url($new_curl_filter_url);
    }

}


?>
