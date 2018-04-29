<?php

use App\Controllers\HomeController;
use App\Controllers\UzivatelController;
use App\Controllers\DochazkaController;
use App\Controllers\OthersController;
use App\Controllers\AutoController;
use App\Controllers\ObjednavkaController;
use App\Controllers\LogStavuController;

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
    $this->map(['PUT', 'PATCH'], '/{id}', UzivatelController::class . ':updateUzivatel');
    $this->delete('/{id}', UzivatelController::class . ':deleteUzivatel');
});

$app->group('/Dochazka', function() {
    $this->get('/{id}', DochazkaController::class . ':getDochazkaDetailById');
    $this->get('', DochazkaController::class . ':getAllDochazka');
    $this->post('', DochazkaController::class . ':saveNewDochazka');
    $this->map(['PUT', 'PATCH'], '/{id}', DochazkaController::class . ':updateDochazka');
    $this->delete('/{id}', DochazkaController::class . ':deleteDochazka');
});

$app->group('/TypPraceUzivatele', function() {
    $this->get('', OthersController::class . ':getAllTypPRaceUzivatele');
});

$app->group('/StavUzivatele', function() {
    $this->get('', OthersController::class . ':getAllStavUzivatele');
});

$app->group('/RoleUzivatele', function() {
    $this->get('', OthersController::class . ':getAllRoleUzivatele');
});

$app->group('/StavObjednavky', function() {
    $this->get('', OthersController::class . ':getAllStavObjednavky');
});

$app->group('/Auto', function() {
    $this->get('/{id}', AutoController::class . ':getAutoDetailById');
    $this->get('', AutoController::class . ':getAllAuto');
    $this->post('', AutoController::class . ':saveNewAuto');
    $this->map(['PUT', 'PATCH'], '/{id}', AutoController::class . ':updateAuto');
    $this->delete('/{id}', AutoController::class . ':deleteAuto');
});

$app->group('/Objednavka', function() {
    $this->get('/{id}', ObjednavkaController::class . ':getObjednavkaDetailById');
    $this->get('', ObjednavkaController::class . ':getAllObjednavka');
    $this->post('', ObjednavkaController::class . ':saveNewObjednavka');
    $this->map(['PUT', 'PATCH'], '/{id}', ObjednavkaController::class . ':updateObjednavka');
    $this->delete('/{id}', ObjednavkaController::class . ':deleteObjednavka');
});

$app->group('/LogStavu', function() {
    $this->get('/{id}', LogStavuController::class . ':getLogStavuDetailById');
    $this->get('', LogStavuController::class . ':getAllLogStavu');
    $this->post('', LogStavuController::class . ':saveNewLogStavu');
});