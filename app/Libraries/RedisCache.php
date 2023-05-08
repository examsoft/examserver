<?php

/**
 * redis使用公共类
 */

namespace App\Libraries;

use Config\Cache;

class RedisCache
{

    public static function watch($key){
        if (!$key) {
            return false;
        }

        try {
            $cache = self::initConfig();
            $cache->watch($key);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    public static function multi(){
        try {
            $cache = self::initConfig();
            $cache->multi();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function exec(){
        try {
            $cache = self::initConfig();
            $cache->exec();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    public static function setCache($key, $data, int $time = 1800)
    {
        if (!$key) {
            return false;
        }

        try {
            $cache = self::initConfig();
            $cache->setCache($key, serialize($data), $time);
            return $cache->getCache($key);
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function getCache($key)
    {
        if (!$key) {
            return false;
        }

        try {
            $cache = self::initConfig();
            $data = $cache->getCache($key);
            return !empty($data) ? unserialize($data) : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function setDataCache($key, $data, int $time = 1800)
    {
        if (!$key) {
            return false;
        }

        try {
            $cache = self::initConfig();
            $cache->save($key, serialize($data), $time);
            return $cache->get($key);
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function getDataCache($key)
    {
        if (!$key) {
            return false;
        }

        try {
            $cache = self::initConfig();
            $data = $cache->get($key);
            return !empty($data) ? unserialize($data) : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function delDataCache($key)
    {
        if (!$key) {
            return false;
        }
        try {
            $cache = self::initConfig();
            $cache->delete($key);
        } catch (\Exception $e) {
            return false;
        }

    }

    public static function lpushData($queue,$value)
    {
        if (!$queue) {
            return false;
        }

        try {
            $cache = self::initConfig();
            return $cache->lpush($queue,serialize($value));
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function rpushData($queue,$value)
    {
        if (!$queue) {
            return false;
        }

        try {
            $cache = self::initConfig();
            return $cache->rpush($queue,serialize($value));
        } catch (\Exception $e) {
            return false;
        }
    }


    public static function lpopData($queue)
    {
        if (!$queue) {
            return false;
        }

        try {
            $cache = self::initConfig();
            $data = $cache->lpop($queue);
            return !empty($data) ? unserialize($data) : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function rpopData($queue)
    {
        if (!$queue) {
            return false;
        }

        try {
            $cache = self::initConfig();
            $data = $cache->rpop($queue);
            return !empty($data) ? unserialize($data) : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 初始化配置项
     */
    private static function initConfig()
    {
        $cache = \Config\Services::cache();
        return $cache;
    }

    /**
     * 加锁
     * @param $key
     * @return bool|string
     */
    public static function setRedisLock($key, string $val, $seconds = 1)
    {
        if (!$key) {
            return false;
        }

        $cache = self::initConfig();
        return $cache->setLock($key, $val.'_lock',  array('nx', 'ex' => intval($seconds)));
    }
}
