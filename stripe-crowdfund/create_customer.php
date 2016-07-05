<?php
    require('functions.php');
    

    echo '<pre>';
//print_r($_POST); die;
/*<pre>Array
(
    [street] => Street 1
    [city] => noida
    [state] => uttar pradesh
    [zip] => 201301
    [email] => sean@sparxitsolutions.com
    [cardholdername] => Sean Rock
    [cardnumber] => 4111111111111111
    [exp_month] => 10
    [exp_year] => 2016
    [cvv] => 456
)
*/

    $card = array(  "card" => array( 
                                "number"    => $_POST['cardnumber'],
                                "exp_month" => $_POST['exp_month'],
                                "exp_year"  => $_POST['exp_year'],
                                "cvc"       => $_POST['cvv'] ) );
     

    // 1. Create a customer object
    $customer_id = create_a_customer(get_source($card), $_POST);

    
    // 2. Create a card object & attach to a customer.    
    $card = create_card_object($customer_id, get_source($card));
    
    //print_r($card);

    // 3. Get customer list.
    //$customer_list = get_customer_list();

    //delete_customer($customer_id);
    
    echo '</pre>';
    
    $amount = 1000;
    
    mysql_query("INSERT INTO cards SET amount='".$amount."', customer_id='".$card['customer']."', card_id='".$card['id']."'");
    
    
    
//    while($obj = mysql_fetch_object($query)){
//        
//    }
?>
<html>
    <body>
        <h2>List of customers with card details</h2>
        <table width="100%" border="1" cellpadding="2">
            <thead>
                <tr><td>Sr.</td><td>Customer ID</td><td>Card ID</td><td>Has been charged</td><td>Charge ID</td></tr>
            </thead>
            <tbody>
                <?php
                    $query = mysql_query("SELECT * FROM cards WHERE 1");    
                    $i = 1;
                    while($obj = mysql_fetch_object($query) ){
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $obj->customer_id; ?></td>
                            <td><?php echo $obj->card_id; ?></td>
                            <td><?php echo $obj->has_been_charged; ?></td>
                            <td><?php echo $obj->charge_id; ?></td>
                        </tr>    
                        <?php
                    }              
                ?>
            </tbody>
        </table>
    </body>
</html>