<?php

namespace Drupal\d8_testable_code_example;

use Drupal\node\NodeInterface;

/**
 * Interface NodeTitleGeneratorInterface.
 *
 * @package Drupal\d8_testable_code_example
 */
interface NodeTitleGeneratorInterface {

  /**
   * Generate and update the title of the given node depending on the bundle
   * as follows:
   * - Basic pages: "Page: @title"
   * - Articles: "Awesome article by @author".
   *
   * @param \Drupal\node\NodeInterface $node.
   */
  public function generateTitle(NodeInterface $node);

}
