<?php

require_once '../../../abstract_db/DbConn.php';


class States extends DbConn {
    private $state;
    private $state_id;

    public function read() {
        $query = 'SELECT * FROM `state_ids`;';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function read_single() {
        // TODO: Implement read_single() method.
    }

    /**
     * state_ids table should not be changed
     *
     */
    public function create($data) {
        return false;
    }
}
