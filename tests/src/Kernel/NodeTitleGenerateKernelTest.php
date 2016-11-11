<?php
namespace Drupal\Tests\d8_testable_code_example\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\user\Entity\User;
use Drupal\node\Entity\Node;

/**
 * Test for testing the NodeTitleGeneration functionality.
 *
 * @group d8_testable_code_example
 */
class NodeTitleGenerateKernelTest extends KernelTestBase {

  protected $user;
  /**
   * {@inheritdoc}
   */
  public static $modules = ['node', 'd8_testable_code_example', 'user', 'system'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->installEntitySchema('node');
    $this->installEntitySchema('user');
    $this->installSchema('system', 'sequences');
  }

  /**
   * Test the title generation for Pages.
   */
  function testGeneratePageTitle() {
    $default_title = 'Title example';
    $page_node = Node::create([
      'type' => 'page',
      'title' => $default_title,
    ]);
    $page_node->save();

    // Check the title generation:
    $this->assertEquals('Page: Title example', $page_node->getTitle());
  }

  /**
   * Test the title generation for Articles.
   */
  function testGenerateArticleTitle() {
    $author = User::create([
      'name' => 'user example name',
      'status' => 1,
    ]);
    $author->save();

    $default_title = 'Title example';
    $page_node = Node::create([
      'type' => 'article',
      'uid' => $author->id(),
      'title' => $default_title,
    ]);
    $page_node->save();

    // Check the title generation:
    $this->assertEquals('Awesome article by user example name', $page_node->getTitle());
  }
}
