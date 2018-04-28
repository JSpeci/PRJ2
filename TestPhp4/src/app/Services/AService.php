<?php

namespace App\Services;

use \Interop\Container\ContainerInterface as ContainerInterface;

/**
 * Description of AService
 *
 * @author King
 */
abstract class AService {
    
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    
    protected abstract function assemblyDTO($body);
}
