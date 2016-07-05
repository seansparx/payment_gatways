<?php
    require('functions.php');
    
    $query = mysql_query("SELECT * FROM cards WHERE has_been_charged=0 AND charge_id=''");
    
    while($obj = mysql_fetch_object($query)) {
        // Charge a cutomer.
        $charge = create_a_charge($obj->customer_id, $obj->amount, "usd");
        mysql_query("UPDATE cards SET charge_id='".$charge['id']."', has_been_charged=1 WHERE customer_id='".$obj->customer_id."' AND card_id='".$obj->card_id."'");

        // Delete cutomer/card object.
        delete_card($obj->customer_id, $obj->card_id);            
        delete_customer($obj->customer_id); 
        mysql_query("UPDATE cards SET has_been_deleted=1 WHERE customer_id='".$obj->customer_id."' AND card_id='".$obj->card_id."'");
    }
        
    $charges_list = get_charges_list();

?>
<html>
    <body>
        <h2>List of customer charges</h2>
        <table width="100%" border="1" cellpadding="2">
            <thead>
                <tr><td>Sr.</td><td>Charge ID</td><td>Amount</td><td>Currency</td><td>Description</td></tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                    if(count($charges_list['data']) > 0) {
                        foreach($charges_list['data'] as $customer){
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $customer['id']; ?></td>
                                <td><?php echo $customer['amount']; ?></td>
                                <td><?php echo $customer['currency']; ?></td>
                                <td><?php echo $customer['description']; ?></td>
                            </tr>    
                            <?php
                        }
                    }
                    else{
                        ?>
                        <tr><td>No customer found.</td></tr>    
                        <?php
                    }                
                ?>
            </tbody>
        </table>
    </body>
</html>
