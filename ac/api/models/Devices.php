<?php

require_once 'DbConn.php';

class Devices extends DbConn {
    private $internal_id;
    private $ip_address;
    private $username;
    private $is_blocked;

    public function read() {
    }

    private function getNewId() {
        $query = 'SELECT COUNT(*) FROM `device_ids`;';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() { // cou
        $query = 'SELECT COUNT(*) FROM `device_ids`;';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create($data) {
        $config = parse_ini_file("../config/config.ini");

        // return id password wasn't passed or if it is incorrect
        if (! isset($data->password) || ($data->password !== $config["auth_pwd"])) {
            return false;
        }

        $stmt = $this->getNewId();

        $num = $stmt->fetch(PDO::FETCH_NUM)[0] + 1;

        $query = 'INSERT IGNORE INTO `device_ids`
        SET internal_id = :internal_id, ip_address = INET_ATON(:ip_address), username = :username, is_blocked = :is_blocked
            ';

        $stmt = $this->conn->prepare($query);

        // clean
        $this->internal_id = $num;
        $this->ip_address = htmlspecialchars(strip_tags($data->ip_address));
        $this->username = htmlspecialchars(strip_tags($data->username));
        $this->is_blocked = 0;

        // bind
        $stmt->execute([
            ':internal_id' => $this->internal_id,
            ':ip_address' => $this->ip_address,
            ':username' => $this->username,
            ':is_blocked' => $this->is_blocked
        ]);
        return true;
    }

    public function get_device($addr, $fields = []) {
        $query = 'SELECT * FROM `device_ids`
        WHERE ip_address = INET_ATON(:ip_address)
            ';

        $stmt = $this->conn->prepare($query);
        $this->ip_address = htmlspecialchars(strip_tags($addr));
        $stmt->execute([
            ':ip_address' => $this->ip_address
        ]);
        $data = [];
        // require is_blocked in $fields
        if (!in_array("is_blocked", $fields)) {
            $fields[] = "is_blocked";
        }

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach ($fields as $field) {
                $data[$field] = $row[$field];
            }
        }

        if ($data["is_blocked"] == 1) {
            return ["error" => "You are not allowed to access this service"];
        }
        else return $data;
    }
}


