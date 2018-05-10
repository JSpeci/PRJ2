<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;


class HomeController extends ApiController{
        
    public function home(Request $request, Response $response, array $args) {
        // your code
        // to access items in the container... $this->container->get('');
        
        return $this->container->view->render($response, 'template.html');
    }
    
}
