<?php namespace Adamgoose\PrismicIo\Fragments\Blocks;

use stdClass;

class Paragraph implements BlockInterface {

  protected $type;
  protected $value;

  /**
   * Create new HeadingBlock
   *
   * @param  stdClass $block
   * @return void
   */
  public function __construct(stdClass $block)
  {
    $this->type = $block->type;
    $this->value = $block->text;
  }

  /**
   * Parse the block to a string
   *
   * @return string
   */
  public function toString()
  {
    return $this->value;
  }

  /**
   * Parse the block to HTML
   *
   * @return string
   */
  public function toHtml()
  {
    $tag = "p";
    $html = "<$tag>";
    $html .= $this->value;
    $html .= "</$tag>";

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