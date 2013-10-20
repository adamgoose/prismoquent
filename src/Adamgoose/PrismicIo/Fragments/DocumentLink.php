<?php namespace Adamgoose\PrismicIo\Fragments;

use stdClass;
use Adamgoose\PrismicIo\Api;

class DocumentLink implements FragmentInterface {

  private $api;
  public $type;
  public $target;

  /**
   * Create new DocumentLink Fragment
   *
   * @param  stdClass $fragment
   * @param  Api      $api
   * @return void
   */
  public function __construct(stdClass $fragment, Api $api)
  {
    $this->api = $api;

    $this->type = $fragment->type;
    $this->target = $fragment->value->document->id;
  }

  /**
   * Retreive linked document
   *
   * @return Adamgoose\PrismicIo\Document
   */
  public function document()
  {
    return $this->api->call('[[:d = at(document.id, "'.$this->target.'")]]')[$this->target];
  }

  /**
   * Parse the fragment to a string
   *
   * @return string
   */
  public function toString()
  {
    return $this->target;
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
   * Handle dynamic attribute calls to the method
   *
   * @param  string $key
   * @return mixed
   */
  public function __get($key)
  {
    // check for local attribute
    if(property_exists($this, $key))
      return $this->{$key};
    else
      return $this->document()->{$key};
  }
}