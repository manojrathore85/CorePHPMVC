<?php
namespace App\Services; 
use PDO;
use PDOException;
use RuntimeException; 
class DB{
    private static $connection = null;
    private static $dbhost = 'localhost';
    private static $dbname = 'jwt';
    private static $dbuser = 'shubham';
    private static $dbpassword = 'Shubh@11';
    
    private function __construct()
    {
         
    }
    public static function connect(){
        $dsn = "mysql:host=". self::$dbhost .";dbname=".self::$dbname.";charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];        
        try {
            if (self::$connection === null) {
                self::$connection = new PDO($dsn, self::$dbuser, self::$dbpassword, $options);
            }
            return self::$connection;
        } catch (PDOException $e) {
            throw new RuntimeException($e->getMessage(), (int)$e->getCode());
        }
    }
}
?>