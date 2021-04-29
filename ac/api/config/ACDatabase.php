<?php
require_once '../../../abstract_db/Database.php';
class ACDatabase extends Database
{
    private $ini_path = '/ac/api/config/db_config.ini';
    const TABLES = [
        1 => 'arduino_state',
        2 => 'commands',
        3 => 'device_ids',
        4 => 'state_ids'
    ];

    public function getTableName($id) {
        if (isset(self::TABLES[$id])) {
            return self::TABLES[$id];
        }
        return '';
    }
}