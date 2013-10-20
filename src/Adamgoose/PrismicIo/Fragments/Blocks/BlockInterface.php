<?php namespace Adamgoose\PrismicIo\Fragments\Blocks;

interface BlockInterface {

  /**
   * Parse the block to a string
   *
   * @return string
   */
  public function toString();

  /**
   * Parse the block to HTML
   *
   * @return string
   */
  public function toHtml();

  /**
   * Handle dynamic string typecasting
   *
   * @return string
   */
  public function __toString();

}