
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
    <!-- datatable -->
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.css" rel="stylesheet"> 
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>
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

    <?php }?>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h2>Invoice List</h2>
            <a href="<?php echo url('Invoice/create')?>" class="btn btn-primary btn-sm">Add</a>
        </div>
            <table class="table table-bordered" id="invoiceTable">
            </table>
    </div>

    <script>
        var baseurl = '<?php echo BASE_URL ?>';
        var invoiceTable ='';
    
        $(document).ready(function() {            
            invoiceTable = $("#invoiceTable").DataTable({
                ajax:{
                    url: baseurl+'Invoice/getInvoices', // Construct the URL
                    type:'POST',
                    data:function(d){
                        d.action = "get_invoices";
                        d.customer_id = $("customer_id").val();
                    },
                },
                columns:[
                    {data:"id", title:"ID"},
                    {data:"date", title:"date"},
                    {data:"customer_name", title:"Customer Name"},
                    {data:"billing_address", title:"Billing Address"},
                    {data:"delivery_address", title:"Delivery Address"},
                    {data:"gross_amount_total", title:"Gross Amount Total"},
                    {data:"discount_amount_total", title:"Discount Amount Total"},
                    {data:"tax_amount_total", title:"Tax Amount Total"},
                    {data:"net_amount_total", title:"Net Amount Total"},
                    {data:"transporter_name", title:"Transporter Name"},
                    {
                        data:null, 
                        title:"Action", 
                        render:function(data, type, row, meta){
                            // console.log(data, type, row, meta);
                            let btn = '<div class="btn-group"><button class="btn btn-sm btn-warning edit" data-id ="'+row.id+'">Edit</button>';
                            btn += '<button class="btn btn-sm btn-danger delete">delete</button></div>';  
                            return btn;                           
                        } 
                    },
                
                ],
                createdRow:function(row, data, dataIndex){
                    $(row).find('.edit').on('click',function(){
                        editInvoice(data.id);
                        window.location = baseurl+'Invoice/edit/'+data.id;
                    });
                }         
                
            });
        });
    // $(invoiceTable).on('click','.edit',function(){
    //     editInvoice($(this).data.id);
    // });    

    function deleteInvoice(id){
        console.log("delete invoice"+id);
    }
    function editInvoice(id){
        console.log("edit invoice"+id);

    }

    </script>
</body>
</html>
