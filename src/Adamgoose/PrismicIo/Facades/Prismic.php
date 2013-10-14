<?php namespace Adamgoose\PrismicIo\Facades;

use Illuminate\Support\Facades\Facade;

class Prismic extends Facade {

  protected static function getFacadeAccessor() { return 'prismic'; }

}