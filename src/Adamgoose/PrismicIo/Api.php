<?php namespace Adamgoose\PrismicIo;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Client;
use stdClass;

class Api {

  protected static $client;
  protected $url;
  protected $accessToken;
  protected $data;

  /**
   * Creates new Api
   *
   * @param  stdClass $attributes
   * @return void;
   */
  public function __construct($url, $accessToken, stdClass $attributes = null)
  {
    $this->url = $url;
    $this->accessToken = $accessToken;
    $this->data = json_decode(json_encode($attributes));
  }

  /**
   * Staticlly creates new Api
   *
   * @param  string $action
   * @param  string $accessToken
   * @return Api
   */
  public static function get($api, $accessToken = null)
  {
    $url = $api . '/api' . ($accessToken ? '?access_token=' . $accessToken : '');

    $request = self::getClient()->get($url);

    $response = $request->send();

    $response = json_decode($response->getBody(true));

    if(!$response)
      throw new \RuntimeException('Unable to decode the json response');

    return new Api($api, $accessToken, $response);
  }

  /**
   * Gets all Api data
   *
   * @return stdClass
   */
  public function data()
  {
    return $this->data;
  }

  /**
   * Gets all available repository refs
   *
   * @return stdClass
   */
  public function refs()
  {
    $refs = new stdClass;
    foreach($this->data->refs as $ref) {
      $refs->{$ref->label} = $ref->ref;
      if($ref->isMasterRef)
        $refs->Master = $ref->ref;
    }

    return $refs;
  }

  /**
   * Returns master ref
   *
   * @return string
   */
  public function master()
  {
    return $this->refs()->Master;
  }

  /**
   * Returns all bookmarks
   *
   * @return stdClass
   */
  public function bookmarks()
  {
    return $this->data->bookmarks;
  }

  /**
   * Returns all collections
   *
   * @return stdClass
   */
  public function collections()
  {
    $collections = new stdClass;
    foreach($this->data->forms as $collection => $data) {
      $collections->{$collection} = new stdClass;
      $collections->{$collection}->name = isset($data->name) ? $data->name : 'Everything';
      $collections->{$collection}->query = isset($data->fields->q->default) ? $data->fields->q->default : '';
    }

    return $collections;
  }

  /**
   * Gets Guzzie client
   *
   * @return Guzzie\Http\Client
   */
  public static function getClient()
  {
    if(self::$client === null) {
      self::$client = new Client('', array(
        Client::CURL_OPTIONS => array(
          CURLOPT_CONNECTTIMEOUT  => 10,
          CURLOPT_RETURNTRANSFER  => true,
          CURLOPT_TIMEOUT         => 60,
          CURLOPT_USERAGENT       => 'prismic-php-0.1',
          CURLOPT_HTTPHEADER      => array('Accept: application/json'),
        )
      )); 
    }

    return self::$client;
  }

  /**
   * Makes Api call
   *
   * @return array
   */
  public function call($query = null, $ref = null, $endpoint = '/api/documents/search')
  {
    $requestData = array(
      'ref' => $ref ?: $this->master(),
      'access_token' => $this->accessToken,
    );
    $requestData['q'] = $query ?: null;
    $url = $this->url . $endpoint . '?' . http_build_query($requestData);

    $request = $this->getClient()->get($url);

    $response = $request->send();

    $response = @json_decode($response->getBody(true));

    if(!$response)
      throw new \ErrorException('Unable to decode json response');

    foreach($response as $result) {
      $results[$result->id] = new Document($result);
    }

    return $results;
  }

}