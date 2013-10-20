<?php namespace Adamgoose\PrismicIo\Fragments;

use stdClass;

class Select implements FragmentInterface {

  protected $type = 'Select';
  protected $value;

  public function __construct(stdClass $fragment)
  {
    $this->value = $fragment->value;
  }

  /**
   * Parse the fragment to a string
   *
   * @return string
   */
  public function toString()
  {
    return $this->value;
  }

  /**
   * Parse the fragment to HTML
   *
   * @return string
   */
  public function toHtml()
  {
    return $this->toString();
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