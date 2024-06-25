<?php
namespace App\Model;

use \App\Services\DBFunctions;
use PDO;
use PDOException;
class InvoiceModel extends DBFunctions{

    public function __construct() {
        parent::__construct();
    }

    public function saveRecord($invoiceData, $invoiceItems, $id = null) {
        // Validation
        $errors = $this->validateInvoice($invoiceData, $invoiceItems);
        if (!empty($errors)) {
            return $errors;
        }
        
        if ($id) {
            // Update existing invoice
            $this->update("invoices", $invoiceData,['id'=>$id]);
            $invoiceId = $id;
            // Save invoice items
            $idWillRemain = array_column($invoiceItems, 'id');
            $idWillRemain = implode(',',$idWillRemain);

            $stmt = $this->pdo->prepare("delete from invoice_items where invoice_id = '$id' and id not in ($idWillRemain)");
            $stmt->execute();
        } else {
            // Insert new invoice
            $invoiceId = $this->insert("invoices",$invoiceData);            

        }
        foreach ($invoiceItems as $item) {
            $item['invoice_id'] = $invoiceId;
            $this->saveInvoiceItem($item);        
        }


        return "Invoice saved successfully";
    }
    public function deleteRecord($id) {
        $this->delete("invoices",['id'=> $id]);
        return "Invoice deleted successfully";
    }

    public function get($id) {
        $invoice = $this->selectSingle("invoices",'*',['id'=>$id]);
        $items = $this->select("invoice_items",'*',['invoice_id'=>$id]);
        return ['invoice' => $invoice, 'items' => $items];
    }

    public function getAll($conditions=[]) {
        return $this->selectQuery("select i.*, c.name as customer_name, t.name as transporter_name
        from invoices i 
        inner join accounts_master c on i.customer_id = c.id 
        left join accounts_master t on i.transporter_id = t.id");
        //return $this->select('invoices','*',$conditions);
    }

    private function validateInvoice($invoiceData, $invoiceItems) {
        $errors = [];

        if (empty($invoiceData['customer_id'])) {
            $errors[] = "Customer is required";
        }

        if (empty($invoiceData['billing_address'])) {
            $errors[] = "Billing address is required";
        }

        foreach ($invoiceItems as $item) {
            if (empty($item['item_id'])) {
                $errors[] = "Item is required";
            }
            if (empty($item['qty'])) {
                $errors[] = "Quantity is required";
            }
            if (empty($item['rate'])) {
                $errors[] = "Rate is required";
            }
        }

        return $errors;
    }

    private function saveInvoiceItem($item) {
        // echo "<pre>"; print_r($item); echo "</pre>";exit;
        if (isset($item['id']) && !empty($item['id'])) {
            $this->update("invoice_items",$item, ["id" => $item['id']]);
        } else {
            
            return $this->insert("invoice_items",$item);
        }
    }
    
}
?>
