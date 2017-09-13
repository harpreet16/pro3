<?php
/**
 * @file
 * Contains \Drupal\sheet_integration\Controller.
 */

namespace Drupal\sheet_integration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class Display.
 *
 * @package Drupal\my_custom\Controller
 */
class Display extends ControllerBase {

  /**
   * showdata.
   *
   * @return string
   *   Return Table format data.
   */
  public function showdata() {
    

// you can write your own query to fetch the data I have given my example.

    $result = \Drupal::database()->select('sheet_integration', 'n')
            ->fields('n', array('cid', 'sheet_id'))
            ->execute()->fetchAllAssoc('cid');
// Create the row element.
    $rows = array();
    foreach ($result as $row => $content) {
      $delete = Url::fromUserInput('/admin/config/sheetintegration.com/delete/'.$content->cid);
      $edit   = Url::fromUserInput('/admin/config/sheetintegration.com/edit');
      $rows[] = array(
        'data' => array($content->cid, $content->sheet_id,\Drupal::l('Edit', $edit),\Drupal::l('Delete', $delete),));
    }
// Create the header.
    $header = array('Contact_Form_Id', 'Google_Sheet_Id' , 'Edit','Delete');
    $output = array(
      '#theme' => 'table',    // Here you can write #type also instead of #theme.
      '#header' => $header,
      '#rows' => $rows
    );
    return $output;
  }
}