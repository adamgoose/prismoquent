<?php namespace Adamgoose\PrismicIo;

use stdClass;
use Carbon\Carbon;

class Document {

  protected $api;
  protected $metadata;
  protected $data;

  /**
   * Parse a new document's data
   *
   * @param  stdClass $data
   * @return void
   */
  public function __construct(stdClass $data, Api $api)
  {
    $this->api = $api;

    $this->metadata = $data;
    $this->data = $this->metadata->data->{$this->metadata->type};
  }

  public function fragments()
  {
    $fragments = array();
    foreach($this->data as $key => $fragment)
      $fragments[$name] = $this->fragment($name);

    return $fragments;
  }

  /**
   * Get fragment object
   *
   * @param  string $key
   * @return instance of Adamgoose\PrismicIo\Fragments\FragmentInterface
   */
  public function fragment($key)
  {
    $fragment = $this->data->{$key};
    $type = 'Adamgoose\PrismicIo\Fragments\\'.$this->getFragmentType($fragment);
    return new $type($fragment, $this->api);
  }

  public function getFragmentType(stdClass $fragment)
  {
    switch($fragment->type) {
      case 'Link.web':
        return 'WebLink';
        break;
      case 'Link.document':
        return 'DocumentLink';
      default:
        return $fragment->type;
        break;
    }
  }

  /**
   * Handle dynamic attribute calls to the document
   *
   * @param  string $key
   * @return mixed
   */
  public function __get($key)
  {
    if(property_exists($this->metadata, $key))
      return $this->metadata->{$key};
    elseif(property_exists($this->data, $key))
      return $this->fragment($key);
    else
      throw new \ErrorException('Property not found');
  }

  /**
   * Handle dynamic string typecasting
   *
   * @return string
   */
  public function __toString()
  {
    return json_encode($this->fragments());
  }

}