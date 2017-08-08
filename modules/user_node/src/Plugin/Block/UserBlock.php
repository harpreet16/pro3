<?php
/**
 * @file
 * Contains \Drupal\first_module\Plugin\Block\HelloBlock.
 */
 
namespace Drupal\user_node\Plugin\Block;
use Drupal\Core\Block\BlockBase;
 
/**
 * Provides a 'Hello' Block
 *
 * @Block(
 *   id = "user_block",
 *   admin_label = @Translation("User block"),
 * )
 */
class UserBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    // return array(
    //   '#markup' => $this->t('Hello, World!'),
    // );
    return array(
    '#title' => 'Registration Closed',
    '#description' => 'Registration is closed from 12:00 am to 6:00am',
    '#theme' => 'my_userblock',
  );
  }
 
}