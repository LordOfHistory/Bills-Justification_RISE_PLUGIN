<?php

namespace Prueba\Controllers;

use App\Controllers\Security_Controller;

class Prueba extends Security_Controller {

    protected $Prueba_model;

    function __construct() {
        parent::__construct();
    }

    function index() {
        return $this->template->rander('Prueba\Views\prueba\index');
    }
}
