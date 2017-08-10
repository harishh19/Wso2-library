<?php

/**
 * @file
 * Base class for Management API classes. Handles a bit of the APIClient
 * invocation, which makes the actual HTTP calls.
 *
 * @author HarishBompally
 */
use GuzzleHttp\Client;

/**
 * Wso2Api class for API object classes. Handles some of the wso2 apis,
 * which makes the actual HTTP calls.
 *
 * @author djohnson
 */
class Wso2Api {
  /*
   * var status;
   */

  public $status;

  /*
   * var list;
   */
  public $list;

  /*
   * Client retrieve the WSO2 APIs list.
   */

  public function __construct() {
    $client = new Client(['base_uri' => 'https://54.172.206.43/api/am/store/v0.10/', 'verify' => false]);
    $api = $client->get('apis');
    $statusCode = $api->getStatusCode();
    $this->status = $statusCode;

    if ($statusCode == 200) {
      $body = $api->getBody();
      $stringBody = (string) $body;
      $apis = json_decode($stringBody, true);
      $this->list = $apis['list'];
    }
  }

  /**
   * Return API details.
   * @param type $apiId
   */
  public function ApiDetails($apiId) {
    try {
      $client = new Client(['base_uri' => 'https://54.172.206.43/api/am/store/v0.10/', 'verify' => false]);
      $api = $client->get('apis/' . $apiId);
      $statusCode = $api->getStatusCode();
      $this->status = $statusCode;
      
      if ($statusCode == 200) {
        $body = $api->getBody();
        $stringBody = (string) $body;
        $apiDetails = json_decode($stringBody, true);
        return $apiDetails;
      }
    }
    catch (Exception $exc) {
      echo $exc->getMessage();
    }
  }

}
