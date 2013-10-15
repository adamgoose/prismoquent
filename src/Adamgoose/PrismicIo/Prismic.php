<?php namespace Adamgoose\PrismicIo;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class Prismic {

  protected $api;
  protected $ref;
  protected $forms;
  protected $collection;
  protected $mask;
  protected $query;

  public function __construct()
  {
    $this->api = \Prismic\Api::get('https://' . Config::get('prismic-io::id') . '.prismic.io/api', Config::get('prismic-io::token'));
    $this->ref = $this->api->master()->ref;
    $this->forms = $this->api->forms();
  }

  /**
   * Defines the context reference ID
   *
   * @param $ref string
   * @return $this
   */
  public function ref($ref)
  {
    $this->ref = $ref;

    return $this;
  }

  /**
   * Defines the context collection name
   *
   * @param $collection string
   * @return $this
   */
  public function collection($collection)
  {
    $this->collection = $collection;

    return $this;
  }

  /**
   * Defines the context mask name
   *
   * @param $mask string
   * @return $this
   */
  public function mask($mask)
  {
    $this->mask = $mask;

    return $this;
  }

  /**
   * Defines the context tags
   *
   * @param $tags array
   * @return $this
   */
  public function tags(array $tags)
  {
    $this->tags = $tags;

    return $this;
  }

  /**
   * Defines the context custom query
   *
   * @param $query string
   * @return $this
   */
  public function query($query)
  {
    $this->query = $query;

    return $this;
  }

  /**
   * Executes the context API call
   *
   * @return array of \Prismic\Document
   */
  public function get()
  {
    if(isset($this->collection)) {
      $ctx = $this->forms->{$this->collection};
    } else {
      $ctx = $this->forms->everything;
    }

    $ctx = $ctx->ref($this->ref);

    if(isset($this->mask)) {
      $ctx = $ctx->query('[[:d = at(document.type, "' . $this->mask . '")]]');
    }

    if(isset($this->tags)) {
      $ctx = $ctx->query('[[:d = any(document.tags, ["' . implode('","', $this->tags) . '"])]]');
    }

    if(isset($this->query)) {
      $ctx = $ctx->query($this->query);
    }

    return $ctx->submit();
  }

  /**
   * Gets a document by its ID
   *
   * @param $id string
   * @return \Prismic\Document
   */
  public function getId($id)
  {
    $ctx = $this->forms->everything->ref($this->ref)->query('[[:d = at(document.id, "' . $id . '")]]');
    return $ctx->submit()[0];
  }

  /**
   * Executes the context API call and sorts the results
   *
   * @param $dateField string
   * @param $dir string
   * @return array of \Prismic\Document
   */
  public function getBy($dateField, $dir = 'asc')
  {
    $results = array();
    foreach($this->get() as $document)
    {
      $results[$document->getDate($document->type.".".$dateField)->asEpoch()] = $document;
    }

    if($dir == 'asc')
      ksort($results);
    else
      krsort($results);

    return $results;
  }

  /**
   * Executes the context API call and returns the slug-matched document
   *
   * @param $slug string
   * @return \Prismic\Document
   */
  public function getSlug($slug)
  {
    if(Cache::has('prismic-'.$slug)) {
      return $this->getId(Cache::get('prismic-'.$slug));
    }

    foreach($this->get() as $document)
      if($document->slug() == $slug) {
        Cache::put('prismic-'.$slug, $document->id, 99);
        return $document;
      }

    App::abort(404);
  }

}