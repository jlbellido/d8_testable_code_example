<?php

namespace Drupal\d8_testable_code_example;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\node\NodeInterface;

/**
 * Class NodeTitleGenerator.
 *
 * @package Drupal\d8_testable_code_example
 */
class NodeTitleGenerator implements NodeTitleGeneratorInterface {

  /**
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $language_manager;

  public function __construct(LanguageManagerInterface $language_manager) {
    /**
     * Instead of usinf the language_manager service as: \Drupal::service('language_manager')
     * We inject it and from now we can use it as : $this->language_manager...
     */
    $this->language_manager = $language_manager;
  }

  /**
   * Generate and update the title of the given node depending on the bundle
   * as follows:
   * - Basic pages: "Page: @title"
   * - Articles: "Awesome article by @author".
   *
   * @param \Drupal\node\NodeInterface $node .
   * @return string
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
