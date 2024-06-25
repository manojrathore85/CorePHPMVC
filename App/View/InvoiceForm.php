<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
</head>
<style>
    .error{
        color: red;
    }
</style>
<body>    
    <?php 
    if (isset($_SESSION['msg'])) {  ?>
        <div class="alert alert-success text-center">
            <?php 
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
            ?>
        </div>
    <?php }?>
    <?php if (isset($_SESSION['error'])) {?>
        <div class="alert alert-danger text-center">
            <?php 
                    foreach ($_SESSION['error'] as $error) {
                        echo "<p>$error</p>";
                    }
                    unset($_SESSION['error']);
            ?>
        </div>

    <?php } 
        $invoice = $data['invoice'] ?? null ;
    ?>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h2>Invoice Management</h2>
            <a href="<?php echo url('Invoice/index'); ?>" class="btn btn-primary btn-sm">List</a>
        </div>
        <form id="invoiceForm" method="post" action="<?php echo url('Invoice/save/'); echo $invoice['id'] ?? '';  ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" required value="<?=$invoice['date'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label for="customer_id">Customer:</label>
                <select class="form-control select2" id="customer_id" name="customer_id" required >
                    <option value="">Select Customer</option>
                    <?php renderOptions($customers, $invoice['customer_id']); ?>
                    <!-- Populate with PHP -->
                </select>
            </div>
            <div class="form-group">
                <label for="billing_address">Billing Address:</label>
                <textarea class="form-control" id="billing_address" name="billing_address" required><?=$invoice['billing_address'] ?? '' ?></textarea>
            </div>
            <div class="form-group">
                <label for="delivery_address">Delivery Address:</label>
                <textarea class="form-control" id="delivery_address" name="delivery_address"><?=$invoice['delivery_address'] ?? '' ?></textarea>
            </div>
            <div class="form-group">
                <label for="transporter_id">Transporter:</label>
                <select class="form-control select2" id="transporter_id" name="transporter_id" value="<?=$invoice['transporter_id'] ?? '' ?>">
                    <option value="">Select Transporter</option>
                    <!-- Populate with PHP -->
                </select>
            </div>
            <h3>Invoice Items</h3>
            <table class="table table-bordered" id="invoiceItemsTable">
                <thead>
                    <tr>
                        <th style="width:200px">Item</th>
                        <th style="width:100px;">Qty</th>
                        <th style="width:100px;">Rate</th>
                        <th style="width:100px;">Gross Amount</th>
                        <th style="width:100px;">Tax Rate (%)</th>
                        <th style="width:100px;">Tax Amount</th>
                        <th style="width:100px;">Discount Rate (%)</th>
                        <th style="width:100px;">Discount Amount</th>
                        <th style="width:100px;">Net Amount</th>
                        <th style="width:100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['items'])){
                        $i=0;
                        foreach($data['items'] as $item){?>
                            <tr class="invoice-item">
                                <td>
                                <input type="text" class="form-control invoice-item-id" name="items[<?=$i?>][id]" value="<?=$item['id'] ?>" >
                                <select class="form-control select2 item_id" name="items[<?=$i?>][item_id]" data-selected="<?=$item['item_id']?>">
                                    <?php renderOptions($items, $item['item_id']); ?>
                                <!-- Populate with PHP -->
                                </select>
                                </td>
                                <td><input type="text" class="form-control qty" name="items[<?=$i?>][qty]" value="<?=$item['qty'] ?>" ></td>
                                <td><input type="text" class="form-control rate" name="items[<?=$i?>][rate]" value="<?=$item['rate']?>" ></td>
                                <td><input type="number" class="form-control gross_amount" name="items[<?=$i?>][gross_amount]" value="<?=$item['gross_amount']?>" readonly></td>
                                <td><input type="number" class="form-control tax_rate" name="items[<?=$i?>][tax_rate]" value="<?=$item['tax_rate']?>"></td>
                                <td><input type="number" class="form-control tax_amount" name="items[<?=$i?>][tax_amount]" value="<?=$item['tax_amount']?>" readonly></td>
                                <td><input type="number" class="form-control discount_rate" name="items[<?=$i?>][discount_rate]" value="<?=$item['discount_rate']?>"></td>
                                <td><input type="number" class="form-control discount_amount" name="items[<?=$i?>][discount_amount]" value="<?=$item['discount_amount']?>" readonly></td>
                                <td><input type="number" class="form-control net_amount" name="items[<?=$i?>][net_amount]" value="<?=$item['net_amount']?>" readonly></td>
                                <td><button type="button" class="btn btn-danger remove-item">Remove</button></td>
                            </tr>
                    <?php $i++; } 
                    } else { ?>
                    <tr class="invoice-item">
                        <td>
                            <select class="form-control select2 item_id" name="items[0][item_id]">
                                <option value="">Select Item</option>
                                <!-- Populate with PHP -->
                            </select>
                        </td>
                        <td><input type="text" class="form-control qty" name="items[0][qty]" ></td>
                        <td><input type="text" class="form-control rate" name="items[0][rate]" ></td>
                        <td><input type="number" class="form-control gross_amount" name="items[0][gross_amount]" readonly></td>
                        <td><input type="number" class="form-control tax_rate" name="items[0][tax_rate]"></td>
                        <td><input type="number" class="form-control tax_amount" name="items[0][tax_amount]" readonly></td>
                        <td><input type="number" class="form-control discount_rate" name="items[0][discount_rate]"></td>
                        <td><input type="number" class="form-control discount_amount" name="items[0][discount_amount]" readonly></td>
                        <td><input type="number" class="form-control net_amount" name="items[0][net_amount]" readonly></td>
                        <td><button type="button" class="btn btn-danger remove-item">Remove</button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="addItem">Add Item</button>
            <button type="submit" class="btn btn-success">Save Invoice</button>
        </form>
    </div>

    <script>
        var BASE_URL = '<?php echo BASE_URL ?>';
        $(document).ready(function() {
            console.log(BASE_URL);
            //extend validator error msg place by default 
            $.validator.setDefaults({
                errorPlacement: function (error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('span'));
                        element.next('span').addClass('error').removeClass('valid');
                    } else {
                        error.insertAfter(element); // default
                    }
                }
            });

            // add custom method no space allowed
            $.validator.addMethod("noSpace", function(value, element) { 
                return value == '' || value.trim().length != 0;  
            }, "No space please and don't leave it empty");

            //$('.select2').select2();
            $('#customer_id').select2({
                ajax: {
                    url: BASE_URL+'Dropdown/customers/', // URL to fetch data from
                    dataType: 'json',
                    
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
            $('#transporter_id').select2({
                ajax: {
                    url: BASE_URL+'Dropdown/transporters/', // URL to fetch data from
                    dataType: 'json',                
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
            $('.item_id').select2({
                ajax: {
                    url: BASE_URL+'Dropdown/items/', // URL to fetch data from
                    dataType: 'json',                    
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true,                    
                }
            });

            function calculateAmounts() {
                $('#invoiceItemsTable .invoice-item').each(function() {
                    var qty = parseFloat($(this).find('.qty').val()) || 0;
                    var rate = parseFloat($(this).find('.rate').val()) || 0;
                    var taxRate = parseFloat($(this).find('.tax_rate').val()) || 0;
                    var discountRate = parseFloat($(this).find('.discount_rate').val()) || 0;

                    var grossAmount = qty * rate;
                    var discountAmount = grossAmount * discountRate / 100;
                    var taxAmount = (grossAmount - discountAmount) * taxRate / 100;
                    var netAmount = grossAmount - discountAmount + taxAmount;

                    $(this).find('.gross_amount').val(grossAmount.toFixed(2));
                    $(this).find('.discount_amount').val(discountAmount.toFixed(2));
                    $(this).find('.tax_amount').val(taxAmount.toFixed(2));
                    $(this).find('.net_amount').val(netAmount.toFixed(2));
                });
            }

            $('#invoiceForm').on('keyup change', '.qty, .rate, .tax_rate, .discount_rate', function() {
                calculateAmounts();
            });

            $('#addItem').click(function() {
                var index = $('#invoiceItemsTable .invoice-item').length;
                var newRow = `
                    <tr class="invoice-item">
                        <td>
                            <select class="form-control select2 item_id" name="items[${index}][item_id]">
                                <option value="">Select Item</option>
                                <!-- Populate with PHP -->
                            </select>
                        </td>
                        <td><input type="text" class="form-control qty" name="items[${index}][qty]"></td>
                        <td><input type="text" class="form-control rate" name="items[${index}][rate]"></td>
                        <td><input type="number" class="form-control gross_amount" name="items[${index}][gross_amount]" readonly></td>
                        <td><input type="number" class="form-control tax_rate" name="items[${index}][tax_rate]"></td>
                        <td><input type="number" class="form-control tax_amount" name="items[${index}][tax_amount]" readonly></td>
                        <td><input type="number" class="form-control discount_rate" name="items[${index}][discount_rate]"></td>
                        <td><input type="number" class="form-control discount_amount" name="items[${index}][discount_amount]" readonly></td>
                        <td><input type="number" class="form-control net_amount" name="items[${index}][net_amount]" readonly></td>
                        <td><button type="button" class="btn btn-danger remove-item">Remove</button></td>
                    </tr>
                `;
                $('#invoiceItemsTable tbody').append(newRow);
                $('.item_id').select2({
                ajax: {
                        url: BASE_URL+'Dropdown/items/', // URL to fetch data from
                        dataType: 'json',                        
                        delay: 250,
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        },
                        cache: true,                    
                    }
                });
            });

            $('#invoiceItemsTable').on('click', '.remove-item', function() {
                $(this).closest('tr').remove();
                calculateAmounts();
            });

            $('#invoiceForm').validate({
                rules: {
                    date:{
                        required:true,
                    
                    },
                    customer_id:{
                        required:true,
                    
                    },
                    billing_address:{
                        required:true,
                        noSpace:true,
                    }
                },
                messages: {
                    date:{
                        required:"Please select date",
                    },
                    customer_id:{
                        required:"Please select customer",                    
                    },
                    billing_address:{
                        required:"Please enter billing address",
                        noSpace:"Space only not allowed can leave empty",
                    },
                }
            });
        });

        // Define custom class based validation rules
        $.validator.addClassRules({
                item_id: {
                    required: true,
                },
                qty:{
                    required:true, 
                    number:true,               
                },
                rate:{
                    required:true,                    
                    number:true,                    
                },                
            });
        // Define custom messages for class-based rules
        $.extend($.validator.messages, {
            item_id: "Please select item.",
            qty: "Please enter a valid quantity.",
            rate: "Please enter a valid rate",            
        });    
    </script>
</body>
</html>
