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
class Wso2App {
  /*
   * var status;
   */

  public $status;

  /*
   * var list;
   */
  public $list;

  /**
   * Return List of Applcations.
   * @param type $accessToken
   */
  public function __construct($accessToken) {

    $client = new Client([
      'base_uri' => 'https://54.172.206.43/api/am/store/v0.10/',
      'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $accessToken
      ],
      'verify' => false]);
    $response = $client->request('GET', 'applications');
    $statusCode = $response->getStatusCode();
    $this->status = $statusCode;
    if ($statusCode == 200) {
      $body = $response->getBody();
      $stringBody = (string) $body;
      $apps = json_decode($stringBody, true);
      $this->list = $apps['list'];
    }
  }

  public function ApplicationDetails($accessToken, $appId) {
    try {
      $client = new Client([
        'base_uri' => 'https://54.172.206.43/api/am/store/v0.10/',
        'headers' => [
          'Content-Type' => 'application/json',
          'Authorization' => "Bearer " . $accessToken,
        ],
        'verify' => false]);
      $response = $client->request('GET', 'applications/' . $appId);
      $status = $response->getStatusCode();
      if ($status == 200) {
        $this->status = $status;
        $body = $response->getBody();
        $stringBody = (string) $body;
        $applicationDetails = json_decode($stringBody, true);
        return $applicationDetails;
      }
    }
    catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  /**
   * Create new Application.
   * @param type $accessToken
   * @param type $data
   * @return type
   */
  public function CreateNewApplication($accessToken, $data) {
    try {
      $client = new Client([
        'base_uri' => 'https://54.172.206.43/api/am/store/v0.10/',
        'headers' => [
          'Content-Type' => 'application/json',
          'Authorization' => "Bearer " . $accessToken,
        ],
        'verify' => false]);
      $response = $client->request('POST', 'applications', [
        'json' => $data
      ]);
      $status = $response->getStatusCode();
      if ($status == 201) {
        $this->status = $status;

        return $data['name'] . "Application create successfully.";
      }
    }
    catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  public function ApplicationNewSubscriptionApi($accessToken, $data) {
    try {
      $client = new Client([
        'base_uri' => 'https://54.172.206.43/api/am/store/v0.10/',
        'headers' => [
          'Content-Type' => 'application/json',
          'Authorization' => "Bearer " . $accessToken,
        ],
        'verify' => false]);
      $response = $client->request('POST', 'subscriptions', [
        'json' => $data
      ]);
      $status = $response->getStatusCode();
      if ($status == 201) {
        $this->status = $status;
        return "Application Subscribe to API successfully.";
      }
    }
    catch (Exception $e) {
      echo $e->getMessage();
    }
  }

}
