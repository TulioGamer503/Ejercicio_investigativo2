<?php

use React\EventLoop\Loop;
use React\MySQL\Factory;

$loop = Loop::get();
$factory = new Factory();
$connection = $factory->createLazyConnection('root:password@localhost/crud');

return $connection;
