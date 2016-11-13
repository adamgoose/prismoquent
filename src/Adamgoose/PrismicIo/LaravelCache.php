<?php
/**
 * Created by IntelliJ IDEA.
 * User: Raymond Médédé KPATCHAA
 * Date: 13/11/2016
 * Time: 00:26
 */

namespace Adamgoose\PrismicIo;

use Prismic\Cache\CacheInterface;
use Illuminate\Support\Facades\Cache;

/**
 * An implementation of a Prismic Api cache build on top of the
 * default Laravel cache. The Laravel cache can be configured
 * in 'app/config/cache.php'.
 */
class LaravelCache implements CacheInterface
{
    public function get($key)
    {
        return Cache::get($key);
    }

    public function set($key, $value, $ttl = 0)
    {
        return Cache::put($key, $value, $ttl);
    }

    public function delete($key)
    {
        return Cache::forget($key);
    }

    public function clear()
    {
        return Cache::flush();
    }

    public function has($key)
    {
        return Cache::has($key);
    }
}

