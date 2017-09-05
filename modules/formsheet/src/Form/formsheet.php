<?php

namespace Drupal\formsheet\Form;

require_once '/var/www/html/pro3/libraries/google-api-php-client-2.2.0/vendor/autoload.php';


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;



class formsheet extends FormBase {

  public function getFormId() {
    return 'my_test_formint_id';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    kint($form);
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
    );  

    $form['email'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email'),
    );
    $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Submit',
  ); 

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {      


        define('APPLICATION_NAME', 'Google Sheets API PHP Quickstart');
        define('CREDENTIALS_PATH', __DIR__. '/sheets.googleapis.com-php-formint.json');
        define('CLIENT_SECRET_PATH', __DIR__. '/client_secret.json');
        // If modifying these scopes, delete your previously saved credentials
        // at ~/.credentials/sheets.googleapis.com-php-quickstart.json
        define('SCOPES', implode(' ', array(
          Google_Service_Sheets::SPREADSHEETS)
        ));



        /**
         * Returns an authorized API client.
         * @return Google_Client the authorized client object
         */
        function getClient() {
          $client = new Google_Client();
          $client->setApplicationName(APPLICATION_NAME);
          $client->setScopes(SCOPES);
          $client->setAuthConfig(CLIENT_SECRET_PATH);
          $client->setAccessType('offline');

          // Load previously authorized credentials from a file.
          $credentialsPath = CREDENTIALS_PATH;
          if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
          } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
                if(get1('code')){
                $authCode=get1('code');
                  }
                else{
                  header('Location:'.$authUrl);
                }
            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                    // Store the credentials to disk.
                    if(!file_exists(dirname($credentialsPath))) {
                      mkdir(dirname($credentialsPath), 0700, true);
                    }
                    file_put_contents($credentialsPath, json_encode($accessToken));
                    printf("Credentials saved to %s\n", $credentialsPath);
          }
          $client->setAccessToken($accessToken);

          // Refresh the token if it's expired.
          if ($client->isAccessTokenExpired()) {
            $accessToken=$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
          }
          return $client;
          // print_r($client);
        }

        /**
         * Expands the home directory alias '~' to the full path.
         * @param string $path the path to expand.
         * @return string the expanded path.
         */


        // Get the API client and construct the service object.
        $client = getClient();
        // print_r($client);
        $service = new Google_Service_Sheets($client);
        // print_r($service);

        // ($service);
        // Prints the names and majors of students in a sample spreadsheet:
        // https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
        $spreadsheetId = '1857HFmVbdE-xAwvYSuR04nHh1kPMeR-GvFM0_frOiOA';
        $range = 'Sheet1!A1:E1';
        $values = array(
            array(
                "harpreet","har16aug@gmail.com","test","hello"
            ),
        );
        $body = new Google_Service_Sheets_ValueRange(array(
          'values' => $values
        ));
        $params = array(
          'valueInputOption' => 'RAW'
        );
        $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);


        function get1($key, $default=NULL) {
            return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
        }
    }


}
?>