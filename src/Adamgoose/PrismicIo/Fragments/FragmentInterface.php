<?php namespace Adamgoose\PrismicIo\Fragments;

use stdClass;
use Adamgoose\PrismicIo\Api;

interface FragmentInterface {

  /**
   * Creates new fragment object
   *
   * @param  stdClass $fragment
   * @param  Api      $api
   * @return void
   */
  public function __construct(stdClass $fragment, Api $api);

  /**
   * Parse the fragment to a string
   *
   * @return string
   */
  public function toString();

  /**
   * Parse the fragment to HTML
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