<?php 

namespace KpTest\General;

/**
 * Database class
 */
class Database extends \MySQLi {
    private static $instance = null ;

    // DB params
    protected const HOST = Config::DB_HOST;
    protected const USER = Config::DB_USER;
    protected const PASSWORD = Config::DB_PASSWORD;
    protected const DATABASE = Config::DB_DATABASE;

    private function __construct($host, $user, $password, $database){ 
        parent::__construct($host, $user, $password, $database);

    }

    // DB Singleton
    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new self(self::HOST, self::USER, self::PASSWORD, self::DATABASE);
            if (self::$instance->connect_errno) {
                ApiResponse::displayError('DB_error');
            }
        }
        return self::$instance ;
    }

    // Prevent cloning
    public function __clone() {
        throw new Exception("Can't clone a singleton");
    }

    // Run query as prepared statement
    public function runQuery($query,$params='') {
        $stmt = self::$instance->prepare($query);

        if (!empty($params)) {
            $types='';
            if (is_array($params)) {
                foreach ($params as $param) {
                    $types.=$this->_gettype($param);
                }
            } else {
                $types.=$this->_gettype($params);
                $params = [$params];
            }

            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        return $stmt;
    }


    // Select one row from the db
    public function selectRow($query,$params='') {

        $stmt = $this->runQuery($query,$params);

        $result = $stmt->get_result();
        $final = [];
        while ($row = $result->fetch_assoc())
        {
            foreach ($row as $key => $value)
            {
                $final[$key] = $value;
            }
        }

        return $final;
    }


    // Insert row in the db and retur its ID
    public function insertRow($query,$params='') {

        $stmt = $this->runQuery($query,$params);
        return self::$instance->insert_id; ;
    }

    // Helper function for returning parameter type
    private function _gettype($var) {
        if (is_string($var)) return 's';
        if (is_float($var)) return 'd';
        if (is_int($var)) return 'i';
        return 'b';
    }

}
