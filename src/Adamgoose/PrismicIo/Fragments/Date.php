<?php namespace Adamgoose\PrismicIo\Fragments;

use stdClass;
use Carbon\Carbon;
use Adamgoose\PrismicIo\Api;

class Date implements FragmentInterface {

  public $type;
  public $epoch;
  public $carbon;

  /**
   * Create new Date Fragment
   *
   * @param  stdClass $fragment
   * @param  Api      $api
   * @return void
   */
  public function __construct(stdClass $fragment, Api $api)
  {
    $this->type = $fragment->type;
    $this->epoch = strtotime($fragment->value);
    $this->carbon = new Carbon($fragment->value);
  }

  /**
   * Parse the fragment to a string
   *
   * @return string
   */
  public function toString()
  {
    return (string)$this->carbon;
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

  /**
   * Handle dynamic calls to the object (via Carbon\Carbon)
   *
   * @param  string $method
   * @param  array  $attributes
   * @return mixed
   */
  public function __call($method, $attributes)
  {
    return call_user_func_array(array($this->carbon, $method), $attributes);
  }

}