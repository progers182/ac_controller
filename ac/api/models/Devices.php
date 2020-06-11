<?php

require_once 'DbConn.php';

class Devices extends DbConn {
    private $internal_id;
    private $ip_address;
    private $username;
    private $is_blocked;

    public function read() {
        $query =  'SELECT COUNT(*) FROM `device_ids`;';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query =  'SELECT COUNT(*) FROM `device_ids`;';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    public function create($data) {
        $stmt = $this->read_single();

        $num = $stmt->fetch(PDO::FETCH_NUM)[0] + 1;

        $query = 'INSERT INTO `device_ids`
        SET  internal_id = :internal_id, ip_address = INET_ATON(:ip_address), username = :username, is_blocked = :is_blocked
            ';

        $stmt = $this->conn->prepare($query);

        // clean
        $this->internal_id = $num;
        $this->ip_address = htmlspecialchars(strip_tags($data->ip_address));
        $this->username = htmlspecialchars(strip_tags($data->username));
        $this->is_blocked = htmlspecialchars(strip_tags($data->is_blocked));

        // bind
        $stmt->execute([
            ':internal_id' => $this->internal_id,
            ':ip_address' => $this->ip_address,
            ':username' => $this->username,
            ':is_blocked' => $this->is_blocked
        ]);
        return true;
    }
}
