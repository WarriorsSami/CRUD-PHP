<?php

require_once ('constants.php');

// Singleton class for creating database connection
class ConnectDB {
    // Hold the class instance.
    private static $instance = null;
    private $conn;

    private $host = HOSTNAME_SQL;
    private $user = USERNAME_SQL;
    private $pass = PASSWORD_SQL;
    private $name = DATABASE_SQL;
    private $port = 3306;

    // The db connection is established in the private constructor.
    private function __construct() {
        $this->conn = new mysqli (
            $this->host,
            $this->user,
            $this->pass,
            $this->name,
            $this->port);
    }

    public static function getInstance(): ConnectDB {
        if(!self::$instance) {
            self::$instance = new ConnectDB();
        }

        return self::$instance;
    }

    public function getConnection(): mysqli {
        return $this->conn;
    }
}

$conn = (ConnectDB::getInstance())->getConnection();

if ($conn->connect_error) {
	die ("Database error:" . $conn->connect_error);
}