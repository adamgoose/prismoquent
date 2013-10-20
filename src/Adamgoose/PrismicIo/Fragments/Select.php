<?php namespace Adamgoose\PrismicIo\Fragments;

use stdClass;
use Adamgoose\PrismicIo\Api;

class Select implements FragmentInterface {

  protected $type = 'Select';
  protected $value;

  /**
   * Create new Select Fragment
   *
   * @param  stdClass $fragment
   * @param  Api      $api
   * @return void
   */
  public function __construct(stdClass $fragment, Api $api)
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