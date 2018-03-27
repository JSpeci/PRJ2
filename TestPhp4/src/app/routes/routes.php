<?php

use App\Controllers\HomeController;
use App\Controllers\UzivatelController;

/*
  require '../app/controllers/ApiController.php';

  require '../app/controllers/HomeController.php';


  /*
  require '../app/controllers/UzivatelController.php'; */

$app->get('/', HomeController::class . ':home');

$app->group('/Uzivatele', function() {
    $this->get('/{id}', UzivatelController::class . ':getUserDetailById');
    $this->get('', UzivatelController::class . ':uzivatele');
    $this->post('', UzivatelController::class . ':saveNewUser');
    $this->map(['PUT','PATCH'], '/{id}', UzivatelController::class . ':updateUser');
    
    $this->delete('/{id}', UzivatelController::class . ':deleteUser');
    
});

