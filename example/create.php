<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';
use Socket\Lxd;

$parameters = '{"name": "xenial", "source": {"type": "image", "protocol": "simplestreams", "server": "https://cloud-images.ubuntu.com/daily", "alias": "18.04"}}';

Lxd::create($parameters);