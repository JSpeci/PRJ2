<?php

namespace App\Controllers;

use \Interop\Container\ContainerInterface as ContainerInterface;



abstract class ApiController {

    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

}
