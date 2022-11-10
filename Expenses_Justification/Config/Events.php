<?php

namespace Expenses_Justification\Config;

use CodeIgniter\Events\Events;

Events::on('pre_system', function () {
    helper("exjus_general");
});