<?php

namespace Expenses_Justification\Models;

use App\Models\Crud_model;

class Expenses_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'expenses_list';
        parent::__construct($this->table);
    }

    function get_details() {
        $expenses_table = $this->db->prefixTable('expenses_list');
        $users_table = $this->db->prefixTable('users');
        $sql = "SELECT $expenses_table.*, 
        CONCAT($users_table.first_name, ' ',$users_table.last_name) AS profile_name, $users_table.image AS profile_avatar, $users_table.deleted AS deleted
        FROM $expenses_table
        LEFT JOIN $users_table ON $users_table.id = $expenses_table.profileid";
        return $this->db->query($sql);
    }
}
