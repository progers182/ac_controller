<?php

class Database
{
    private $environment = '';
    private $conn;

    private $TABLES = [
        1 => 'arduino_state',
        2 => 'commands',
        3 => 'device_ids',
        4 => 'state_ids'
    ];

    private $host ='';
    private $db_name ='';
    private $user ='';
    private $pwd ='';

    public function connect()
    {
        $this->setEnvironmentVars();

        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->user, $this->pwd);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }

    /**
     * determines current environment and uses corresponding database connection
     *
     */
    private function setEnvironmentVars() {
        // import config.ini
        $config = parse_ini_file("config.ini");
        // get current domain
        $this->environment = strval($_SERVER['SERVER_NAME']);

        // set vars
        if (strpos($this->environment, 'phrogers') !== false) {
            $this->host = $config['host_prod'];
            $this->db_name = $config['db_name_prod'];
            $this->user = $config['user_prod'];
            $this->pwd = $config['pwd_prod'];
        }

        else {
            $this->host = $config['host_local'];
            $this->db_name = $config['db_name_local'];
            $this->user = $config['user_local'];
            $this->pwd = $config['pwd_local'];
        }
    }

    public function getTableName($id) {
        if (isset($this->TABLES[$id])) {
            return $this->TABLES[$id];
        }
        return '';
    }
}