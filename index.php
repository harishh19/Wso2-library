<?php

/*
 * @file
 */
require 'vendor/autoload.php';



/*
 * Get wso2 api list from wso2 server.
 *  - API List : Create class called Wso2Api used to retirve apps list array.
 *  - When Using in another module/file. load the class file and guzzle autoload
 *    to perform the operation with class "Wso2Api" as shown below.
 *  - API Details : Create function called "ApiDetails" for retrive the details
 *    of particular API passing "ApiId" as a parameter.
 */

/*
require __DIR__ . '/controller/Wso2Api.php';
// Fetch List of all APIs.
$api = new Wso2Api();

// Fetch API details passing API ID as param.
$apiId = "7c0c22f3-59c0-4a2e-b464-d743836b8752";
$apiDetails = $api->ApiDetails($apiId);


print"<pre>";
print_r($apiDetails);
print"</pre>";

die();
 
 */



/*
 * Client registration and access token for OAuth2.0scopes.
 *  - First step before using apim:scope for operating any api with
 *    OAuth2.0Scope. User have registered on wso2 server called client-register.
 *    Created class "Wso2OAuth2scope" with __construct function to register
 *    with the client. It returns ClientId and ClientSecret. As of now I have
 *    saved clientId and ClientSecret in $_SESSION(alternatively you can save
 *    anywhere in your system while using this class. $_SESSION is not
 *    preferable).
 *  - And another function "OAuthScopeAccessToken" at class "Wso2OAuth2scope".
 *    to get the access token for apim:scope to retrieve apps list, create apps,
 *    subscription etc..
 *  - When Using in another module/file. load the class file and guzzle autoload
 *    to perform the operation with class "Wso2OAuth2scope" as shown below. 
 */


require __DIR__ . '/controller/Wso2OAuthScope.php';
require __DIR__ . '/controller/Wso2App.php';

$wso2Scope = new Wso2OAuth2scope();
// Retireve the access token for apim:subscribe.
$scope = $wso2Scope->OAuthScopeAccessToken($_SESSION['clientId'], $_SESSION['clientSecret'], 'apim:subscribe');
$scopeDecode = json_decode($scope);
$accessToken = $scopeDecode->access_token;

// Fetch the list of Applications. Params : access_token.
$application = new Wso2App($accessToken);

// Fetch Application Deatils using Application Id.
// As of now using direct static applicationId,
$appId = "ad8d65ab-61e0-48ec-ae29-e31fe3d7ba0f";
$applicationDetails = $application->ApplicationDetails($accessToken, $appId);

print"<pre>";
print_r($applicationDetails);
print"</pre>";
Die();



/*
 * Create an new application. params : access_token on apim:subscribe and
 * data required for api call as shown below.
 */
/* $data = [
  "throttlingTier" => "Unlimited",
  "description" => "sample app description",
  "name" => "sampleapp",
  "callbackUrl" => "http://my.server.com/callback"
  ];
  $newApplication = $application->CreateNewApplication($accessToken, $data);
 */

/*
 * Application new subscription with API. params : access_token apim:subscirbe
 * and required param $data shown below.
 */
/*
$data = [
  "tier" => "Gold",
  "apiIdentifier" => "7c0c22f3-59c0-4a2e-b464-d743836b8752",
  "applicationId" => "ad8d65ab-61e0-48ec-ae29-e31fe3d7ba0f"
];
$AppSubscribeApi = $application->ApplicationNewSubscriptionApi($accessToken, $data);
*/
//
//print"<pre>";
//print_r($AppSubscribeApi);
//print"</pre>";
//
//
//die();
//
