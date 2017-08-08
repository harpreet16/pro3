<?php
namespace Drupal\render_view\Controller;
 

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Render\Renderer;

class AlbumController extends ControllerBase {

  /**
   * @var Renderer
   */
  protected $renderer;

  public function __construct(Renderer $renderer) {
    $this->renderer = $renderer;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('renderer')
    );
  }

  public function albumSongList() {
  $content = [];
  // get renderable array for view
  $view = views_embed_view('events', 'page_1');
  // render view
  $content['#markup'] = $this->renderer->render($view);

  return $content;
}


}

?>