<?php

use App\Controllers\HomeController;
use App\Controllers\UzivatelController;
use App\Controllers\DochazkaController;

/*
  require '../app/controllers/ApiController.php';

  require '../app/controllers/HomeController.php';


  /*
  require '../app/controllers/UzivatelController.php'; */

$app->get('/', HomeController::class . ':home');

$app->group('/Uzivatele', function() {
    $this->get('/{id}', UzivatelController::class . ':getUzivatelDetailById');
    $this->get('', UzivatelController::class . ':getAllUzivatel');
    $this->post('', UzivatelController::class . ':saveNewUzivatel');
    $this->map(['PUT','PATCH'], '/{id}', UzivatelController::class . ':updateUzivatel');
    
    $this->delete('/{id}', UzivatelController::class . ':deleteUzivatel');
    
});

$app->group('/Dochazka', function() {
    $this->get('/{id}', DochazkaController::class . ':getDochazkaDetailById');
    $this->get('', DochazkaController::class . ':getAllDochazka');
    $this->post('', DochazkaController::class . ':saveNewDochazka');
    $this->map(['PUT','PATCH'], '/{id}', DochazkaController::class . ':updateDochazka');
    
    $this->delete('/{id}', DochazkaController::class . ':deleteDochazka');
    
});

