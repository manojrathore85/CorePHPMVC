<?php
namespace App\Controller;   

use \App\Model\InvoiceModel;
use \App\Controller\DropdownController;
class InvoiceController{
    public $invoiceModel;
    public function __construct()
    {   
        $this->invoiceModel = new InvoiceModel();
    }
    public function index(){  
        $invoiceData = $this->invoiceModel->getAll();
        view('InvoiceList',$invoiceData);

    }
    public function create(){

        $customers = DropdownController::customers();
        $transporters = DropdownController::transporters();
        $items = DropdownController::items();            
        view('InvoiceForm');            
        
    }   
    public function save($id = false){
        //echo "<pre>"; print_r($_REQUEST); echo "</pre>";exit;

        $invoiceData = [
            'date' => $_POST['date'],
            'customer_id' => $_POST['customer_id'],
            'billing_address' => $_POST['billing_address'],
            'delivery_address' => $_POST['delivery_address'],
            'transporter_id' => $_POST['transporter_id'],
            'gross_amount_total' => 0,
            'discount_amount_total' => 0,
            'tax_amount_total' => 0,
            'net_amount_total' => 0
        ];
        //echo "<pre>"; print_r($invoiceData); echo "</pre>";exit;
        $invoiceItems = [];
        foreach ($_POST['items'] as $item) {
            $invoiceItemid = $item['id'] ?? 0;
            $item_id = $item['item_id'];
            $qty = floatval($item['qty'] ?? 0);
            $rate = floatval($item['rate'] ?? 0);
            $discount_rate = floatval($item['discount_rate'] ?? 0);
            $tax_rate = floatval($item['tax_rate'] ?? 0);

            //echo "<pre>"; print_r($item); echo "</pre>";
            $grossAmount = $qty * $rate;
            $discountAmount = ($grossAmount * $discount_rate) / 100;
            $taxAmount = ($grossAmount - $discountAmount) * ($tax_rate / 100);
            $netAmount = $grossAmount - $discountAmount + $taxAmount;

            $invoiceItems[] = [
                'id' => $invoiceItemid,
                'item_id' => $item_id,
                'qty' => $qty,
                'rate' => $rate,
                'gross_amount' => $grossAmount,
                'tax_rate' => $tax_rate,
                'tax_amount' => $taxAmount,
                'discount_rate' => $discount_rate,
                'discount_amount' => $discountAmount,
                'net_amount' => $netAmount
            ];

            $invoiceData['gross_amount_total'] += $grossAmount;
            $invoiceData['discount_amount_total'] += $discountAmount;
            $invoiceData['tax_amount_total'] += $taxAmount;
            $invoiceData['net_amount_total'] += $netAmount;
        }

        $result = $this->invoiceModel->saveRecord($invoiceData, $invoiceItems, $id);

        if (is_array($result)) {
            // Handle validation errors
            $_SESSION['error'] = $result;
            redirect('Invoice/index');
            exit;
        } else {
            // Redirect or show success message
            echo $_SESSION['msg'] = $result;
            redirect('Invoice/index');
            exit;
        }
    }
    public function edit(int $id) {
        if (!empty($id)) {
            $customers = DropdownController::customers();
            $transporters = DropdownController::transporters();
            $items = DropdownController::items();
            $data = $this->invoiceModel->get($id);
            if (!empty($data)) {
                view('InvoiceForm', compact('customers', 'transporters', 'items', 'data'));
            } else {
                redirectBack();
            }
        }
    }
    
    public function delete(){

    }
    public function getInvoices(){
        $keys = ['customer_id', 'billing_address'];

            $conditions = array_filter($_POST, function ($key) use ($keys) {
                return in_array($key, $keys);
            }, ARRAY_FILTER_USE_KEY);
            $data = $this->invoiceModel->getAll();            
            //echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
            if ($data) {
                echo json_encode(['data'=> $data]);
            } else {
                echo json_encode([
                    'data' => '',
                    'status' => false,
                ]);
            }
    }
}?>