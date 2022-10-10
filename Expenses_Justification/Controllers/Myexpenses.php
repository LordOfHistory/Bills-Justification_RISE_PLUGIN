<?php

namespace Expenses_Justification\Controllers;

use App\Controllers\Security_Controller;

class Myexpenses extends Security_Controller {

    protected $Prueba_model;

    function __construct() {
        parent::__construct();
    }

    function index() {
        return $this->template->rander('Expenses_Justification\Views\prueba\index');
    }
}
