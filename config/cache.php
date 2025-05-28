<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Predis\Client;

class Cache {
    private $redis;

    public function __construct() {
        $this->redis = new Client([
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
        ]);
    }

    public function set($key, $value, $expiration = 600) {
        $this->redis->set($key, $value);
        $this->redis->expire($key, $expiration);
    }

    public function get($key) {
        return $this->redis->get($key);
    }

}