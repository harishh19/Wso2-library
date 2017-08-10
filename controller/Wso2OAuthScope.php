<?php

/**
 * @file
 * Base class for Management API classes. Handles a bit of the APIClient
 * invocation, which makes the actual HTTP calls.
 *
 * @author HarishBompally
 */
//require_once '../../vendor/autoload.php';

use GuzzleHttp\Client;

/**
 * Wso2Api class for API object classes. Handles some of the wso2 apis,
 * which makes the actual HTTP calls.
 *
 * @author djohnson
 */
class Wso2OAuth2scope {
  /*
   * var status;
   */

  public $status;

  /*
   * var clientId;
   */
  public $clientId;

  /*
   * var clientSecret;
   */
  public $clientSecret;
  
  /*
   * var Access Token;
   */
  protected $acces_token;

  /*
   * Client registration for ClientID and Client Secret token.
   */

  public function __construct() {
    session_start();
    if (empty($_SESSION['clientId']) && empty($_SESSION['clientSecret'])) {
      try {
        $user = "admin";
        $pass = "admin";
        $auth_encode = base64_encode($user . ':' . $pass);
        $authorization = 'Basic ' . $auth_encode;
        $client = new Client([
          'base_uri' => 'https://54.172.206.43/client-registration/v0.10/',
          'headers' => [
            'Authorization' => $authorization,
            'Content-Type' => 'application/json',
          ],
          'verify' => false]);
        $response = $client->request('POST', 'register', [
          'json' => [
            "callbackUrl" => "www.google.lk",
            "clientName" => "rest_api_store126",
            "tokenScope" => "Production",
            "owner" => "admin",
            "grantType" => "password refresh_token",
            "saasApp" => true
          ]
        ]);
        $status = $response->getStatusCode();
        $this->status = $status;
        if ($status == 201) {
          $body = $response->getBody();
          $stringBody = (string) $body;
          $bodyDecode = json_decode($stringBody);
          $this->clientId = $bodyDecode->clientId;
          $this->clientSecret = $bodyDecode->clientSecret;
          $_SESSION['clientId'] = $this->clientId;
          $_SESSION['clientSecret'] = $this->clientSecret;
        }
      }
      catch (Exception $e) {
        echo $e->getMessage();
      }
    }
    else {
      echo 'ClientId and ClientSecret already set for this Client. Save under $_SESSION.';
    }
  }

  public function OAuthScopeAccessToken($clientId, $clientSecret, $scope) {
    $data = array(
      'grant_type' => "password",
      'username' => "admin",
      'password' => "admin",
      'scope' => $scope,
      'client_id' => $clientId,
      'client_secret' => $clientSecret,
    );
    $client = new Client([
      'base_uri' => 'https://54.172.206.43/oauth2/',
      'headers' => [
        'Content-Type' => 'application/x-www-form-urlencoded',
      ],
      'verify' => false]);
    $response = $client->request('POST', 'token', ['body' => http_build_query($data)]);
    return (string) $response->getBody();
  }

}
