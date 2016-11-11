<?php

namespace Drupal\d8_testable_code_example;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\node\NodeInterface;

/**
 * Class NodeTitleGenerator.
 *
 * @package Drupal\d8_testable_code_example
 */
class NodeTitleGenerator implements NodeTitleGeneratorInterface {

  /**
   * Generate and update the title of the given node depending on the bundle
   * as follows:
   * - Basic pages: "Page: @title"
   * - Articles: "Awesome article by @author".
   *
   * @param \Drupal\node\NodeInterface $node .
   */
  public function generateTitle(NodeInterface $node) {
    switch ($node->bundle()) {
      case 'page':
        $title = $this->generate_page_title($node);
        break;
      case 'article':
        $title = $this->generate_article_title($node);
        break;
      default:
        $title = $node->getTitle();
        break;
    }

    return (string)$title;
  }

  /**
   * Set the title "Page: @title" to the given Node.
   * @param \Drupal\node\NodeInterface $node
   */
  private function generate_page_title($node) {
   return new FormattableMarkup('Page: @title', ['@title' => $node->getTitle()]);
  }

  /**
   * Set the title "Awesome article by @author" to the given Node.
   * @param \Drupal\node\NodeInterface $node
   */
  private function generate_article_title($node) {
    $author_name = $node->getOwner()->getAccountName();
    return new FormattableMarkup('Awesome article by @author', ['@author' => $author_name]);
  }
}
