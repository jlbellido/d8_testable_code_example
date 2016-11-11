<?php

namespace Drupal\Tests\d8_testable_code_example\Unit;

use Drupal\d8_testable_code_example\NodeTitleGenerator;
use Drupal\Tests\UnitTestCase;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;

/**
 * @coversDefaultClass \Drupal\node\PageCache\DenyNodePreview
 * @group node
 */
class NodeTitleGenerateUnitTest extends UnitTestCase {

  /**
   * @var \Drupal\d8_testable_code_example\NodeTitleGenerator
   */
  protected $node_title_generator;

  protected function setUp() {
    $this->node_title_generator = new NodeTitleGenerator();
  }

  public function testGeneratePageTitleTest() {
    // Mock a user entity:
    $mock_user = $this->prophesize(User::class);
    $mock_user->getAccountName()->willReturn('example username');

    // Mock the node entity:
    $mock_node = $this->prophesize(Node::class);
    $mock_node->getTitle()->willReturn('Title example');
    $mock_node->bundle()->willReturn('page');
    $mock_node->getOwner()->willReturn($mock_user->reveal());

    $page_node = $mock_node->reveal();
    $generated_title = $this->node_title_generator->generateTitle($page_node);
    $this->assertEquals('Page: Title example', $generated_title);

    $mock_node->bundle()->willReturn('article');
    $article_node = $mock_node->reveal();
    $generated_title = $this->node_title_generator->generateTitle($article_node);
    $this->assertEquals('Awesome article by example username', $generated_title);
  }

}
