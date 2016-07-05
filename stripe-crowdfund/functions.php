<?php
    require('vendor/autoload.php');    
    require('db_connection.php');
    
    \Stripe\Stripe::setApiKey("<xxxx Stripe API KEY xxxx>");
    
    
    /**
     * Create a token
     * 
     * @return string
     */
    function get_source($card) 
    {
        $result = \Stripe\Token::create($card);

        return $result['id'];
    }

    
    /**
     * Create a new customer.
     * 
     * @param array $source
     * 
     * @return string
     */
    function create_a_customer($source, $info) 
    {
        $result = \Stripe\Customer::create(array(
            "description" => $info['cardholdername'].' for '.$info['email'], 
            "source" => $source));
        $new_customer = $result->__toArray(true);
        return $new_customer['id'];
    }

    
    /**
     * Create a new card object for new customer.
     * 
     * @param string $customer_id
     * @return array
     */
    function create_card_object($customer_id, $source) 
    {
        $customer = \Stripe\Customer::retrieve($customer_id);
        $card = $customer->sources->create(array("source" => $source));
        return $card->__toArray(true);
    }
    
    
    /**
     * Get list of all customers
     * 
     * @return array
     */
    function get_customer_list() 
    {
        $result = \Stripe\Customer::all(array("limit" => 100));
        //print_r($result->__toJSON());
        return $result->__toArray(true);
    }
    
    
    /**
     * Create a charge to charge a credit card.
     * 
     * @param int $amount
     * @param string $currency [ Optional ]
     * 
     * @return array
     */
    function create_a_charge($customer_id, $amount, $currency = "usd") 
    {
        $result = \Stripe\Charge::create(array(
            "amount" => $amount,
            "currency" => $currency,
            "customer" => $customer_id,
            "description" => "Charge for sean@example.com"
        ));
        
        return $result->__toArray(true);
    }

    
    /**
     * Get list of charges you’ve previously created.
     * 
     * @return array
     */
    function get_charges_list() 
    {
        $result = \Stripe\Charge::all(array("limit" => 100));
        //print_r($result->__toJSON());
        return $result->__toArray(true);
    }
    
    
    /**
     * Delete a customer.
     * 
     * @return array
     */
    function delete_customer($customer_id) 
    {
        $cu = \Stripe\Customer::retrieve($customer_id);
        $cu->delete();
    }
    
    
    /**
     * Delete a card.
     * 
     * @return array
     */
    function delete_card($customer_id, $card_id) 
    {
        $customer = \Stripe\Customer::retrieve($customer_id);
        $customer->sources->retrieve($card_id)->delete();
    }

?>
