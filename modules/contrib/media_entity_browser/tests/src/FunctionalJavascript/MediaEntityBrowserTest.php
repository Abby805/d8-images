<?php

namespace Drupal\Tests\media_entity_browser\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\JavascriptTestBase;
use Drupal\media\Entity\Media;
use Drupal\media\Entity\MediaType;
use Drupal\Tests\media\Functional\MediaFunctionalTestCreateMediaTypeTrait;

/**
 * A test for the media entity browser.
 *
 * @group media_entity_browser
 */
class MediaEntityBrowserTest extends JavascriptTestBase {

  use MediaFunctionalTestCreateMediaTypeTrait;
  /**
   * Modules to install.
   *
   * @var array
   */
  public static $modules = [
    'media',
    'entity_browser',
    'media_entity_browser',
    'video_embed_media',
    'ctools',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->drupalLogin($this->drupalCreateUser(array_keys($this->container->get('user.permissions')->getPermissions())));
    $this->createMediaType([
      'label' => 'Video',
      'bundle' => 'video',
    ], 'video_embed_field');

    Media::create([
      'bundle' => 'video',
      'field_media_video_embed_field' => [['value' => 'https://www.youtube.com/watch?v=XgYu7-DQjDQ']],
    ])->save();
  }

  /**
   * Test the media entity browser.
   */
  public function testMediaBrowser() {
    $this->drupalGet('entity-browser/iframe/media_entity_browser');

    $this->assertSession()->elementExists('css', '.view-media-entity-browser');
    $this->assertSession()->elementExists('css', '.image-style-media-entity-browser-thumbnail');

    $this->assertSession()->elementNotExists('css', '.views-row.checked');
    $this->getSession()->getPage()->find('css', '.views-row')->press();
    $this->assertSession()->elementExists('css', '.views-row.checked');

    $this->assertSession()->buttonExists('Select entities');
  }

}
