<?php
namespace App\Controller;

use App\Services\DBFunctions;

class DropdownController extends DBFunctions{

    private static $customers = null;
    private static $transporters = null;
    private static $items = null;


    public static function customers(){
        //this way we are serve the customer on all the form centrally and avoid multiple query call when new customer add from a form it will be avilable on all other form without query 
        if (self::$customers === null) {
            self::$customers = self::get_dropdown("SELECT id, name AS text FROM accounts_master WHERE group_id = 5");
        }
        return self::getResponse(self::$customers);
    }
    public static function transporters(){
        if(self::$transporters){
            self::$transporters = self::get_dropdown("SELECT id, name AS text FROM accounts_master WHERE group_id = 6");
        }
        return self::getResponse(self::$transporters);
    }
    public static function items(){
        if (self::$items === null) {
            self::$items = self::get_dropdown("SELECT id, name AS text FROM item_master");
        }
        return self::getResponse(self::$items);
    }

    public static function get_dropdown($query){
        //to manage get access parent class method selectQuery here created instance of self 
        $instance = new self();
        try {               
            return  $instance->selectQuery($query);
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function toJson(){
        return json_encode($this);
    }
    private static function getResponse($data) {
        if (is_ajax()) {
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        } else {
            return $data;
        }
    }
    // Static method to reset (or update) the dropdown data
    public static function refreshCustomers() {
        self::$customers = self::get_dropdown( "SELECT id, name AS text FROM accounts_master WHERE group_id = 5");
    }
    public static function refreshTransporters () {
        self::$transporters = self::selectQuery("SELECT id, name AS text accounts_master WHERE group_id = 6");
    }
    public static function refreshItems() {
        self::$items = self::selectQuery("SELECT id, name AS text FROM items_master");
    }
}?>