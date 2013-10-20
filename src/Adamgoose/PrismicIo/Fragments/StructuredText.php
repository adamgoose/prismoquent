<?php namespace Adamgoose\PrismicIo\Fragments;

use stdClass;
use Adamgoose\PrismicIo\Api;

class StructuredText implements FragmentInterface {

  public $type = 'StructuredText';
  public $blocks;

  /**
   * Create new StructuredText Fragment
   *
   * @param  stdClass $fragment
   * @return void
   */
  public function __construct(stdClass $fragment, Api $api)
  {
    foreach($fragment->value as $block) {
      $type = 'Adamgoose\PrismicIo\Fragments\Blocks\\' . $this->getBlockType($block);
      $this->blocks[] = new $type($block);
    }
  }

  public function getBlockType(stdClass $block)
  {
    switch($block->type) {
      case 'heading1':
        return 'Heading';
        break;
      default:
        return ucfirst($block->type);
        break;
    }
  }

  /**
   * Get all blocks in the fragment
   *
   * @return array
   */
  public function blocks()
  {
    return $this->blocks;
  }

  /**
   * Parse the fragment to a string
   *
   * @return string
   */
  public function toString()
  {
    $string = '';
    foreach($this->blocks as $block)
      $string .= $block->toString();

    return $string;
  }

  /**
   * Parse the fragment to HTML
   *
   * @return string
   */
  public function toHtml()
  {
    $html = '';
    foreach($this->blocks as $block)
      $html .= $block->toHtml();

    return $html;
  }

  /**
   * Handle dynamic string typecasting
   *
   * @return string
   */
  public function __toString()
  {
    return $this->toString();
  }

}