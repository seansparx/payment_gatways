<?php 
    require('functions.php'); 
    //echo '<pre>';
//    $customer_list = get_customer_list();
//        
//    foreach($customer_list['data'] as $customer){
//                delete_customer($customer['id']); 
//    }
//    die;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Secure Payment Form</title>
        <link rel="stylesheet" href="css/bootstrap-min.css">
        <link rel="stylesheet" href="css/bootstrap-formhelpers-min.css" media="screen">
        <link rel="stylesheet" href="css/bootstrapValidator-min.css"/>
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" />
        <link rel="stylesheet" href="css/bootstrap-side-notes.css" />
        <style type="text/css">
            .col-centered {
                display:inline-block;
                float:none;
                text-align:left;
                margin-right:-4px;
            }
            .row-centered {
                margin-left: 9px;
                margin-right: 9px;
            }
        </style>
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="js/bootstrap-min.js"></script>
        <script src="js/bootstrap-formhelpers-min.js"></script>
        <script type="text/javascript" src="js/bootstrapValidator-min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                
                $("#charge_payment").click(function(){

                        $("#charge_payment").attr('disabled', true);
                        $("#charge_payment").html('please wait..');
                        
                        $.post('charge.php',{ }, function(msg){
                            $("#charge_payment").html('Charge payments');
                            $("#charge_payment").attr('disabled', false);
                            window.location.reload();
                        });
                });
                
                
                $('#payment-form').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    submitHandler: function (validator, form, submitButton) {
                        $("#make_payment").attr('disabled', true);
                        $("#make_payment").html('please wait..');
                        // createToken returns immediately - the supplied callback submits the form if there are no errors
                        var param = $('#payment-form').serialize();
                        $.post('create_customer.php', param, function(msg){
                            $("#make_payment").html('Make Payment');
                            $("#make_payment").attr('disabled', false);
                            window.location.reload();
                        });
                        return false; // submit from callback
                    },
                    fields: {
                        street: {
                            validators: {
                                notEmpty: {
                                    message: 'The street is required and cannot be empty'
                                },
                                stringLength: {
                                    min: 6,
                                    max: 96,
                                    message: 'The street must be more than 6 and less than 96 characters long'
                                }
                            }
                        },
                        city: {
                            validators: {
                                notEmpty: {
                                    message: 'The city is required and cannot be empty'
                                }
                            }
                        },
                        zip: {
                            validators: {
                                notEmpty: {
                                    message: 'The zip is required and cannot be empty'
                                },
                                stringLength: {
                                    min: 3,
                                    max: 9,
                                    message: 'The zip must be more than 3 and less than 9 characters long'
                                }
                            }
                        },
                        email: {
                            validators: {
                                notEmpty: {
                                    message: 'The email address is required and can\'t be empty'
                                },
                                emailAddress: {
                                    message: 'The input is not a valid email address'
                                },
                                stringLength: {
                                    min: 6,
                                    max: 65,
                                    message: 'The email must be more than 6 and less than 65 characters long'
                                }
                            }
                        },
                        cardholdername: {
                            validators: {
                                notEmpty: {
                                    message: 'The card holder name is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 6,
                                    max: 70,
                                    message: 'The card holder name must be more than 6 and less than 70 characters long'
                                }
                            }
                        },
                        cardnumber: {
                            selector: '#cardnumber',
                            validators: {
                                notEmpty: {
                                    message: 'The credit card number is required and can\'t be empty'
                                },
                                creditCard: {
                                    message: 'The credit card number is invalid'
                                },
                            }
                        },
                        expMonth: {
                            selector: '[data-stripe="exp-month"]',
                            validators: {
                                notEmpty: {
                                    message: 'The expiration month is required'
                                },
                                digits: {
                                    message: 'The expiration month can contain digits only'
                                },
                                callback: {
                                    message: 'Expired',
                                    callback: function (value, validator) {
                                        value = parseInt(value, 10);
                                        var year = validator.getFieldElements('expYear').val(),
                                                currentMonth = new Date().getMonth() + 1,
                                                currentYear = new Date().getFullYear();
                                        if (value < 0 || value > 12) {
                                            return false;
                                        }
                                        if (year == '') {
                                            return true;
                                        }
                                        year = parseInt(year, 10);
                                        if (year > currentYear || (year == currentYear && value > currentMonth)) {
                                            validator.updateStatus('expYear', 'VALID');
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }
                                }
                            }
                        },
                        expYear: {
                            selector: '[data-stripe="exp-year"]',
                            validators: {
                                notEmpty: {
                                    message: 'The expiration year is required'
                                },
                                digits: {
                                    message: 'The expiration year can contain digits only'
                                },
                                callback: {
                                    message: 'Expired',
                                    callback: function (value, validator) {
                                        value = parseInt(value, 10);
                                        var month = validator.getFieldElements('expMonth').val(),
                                                currentMonth = new Date().getMonth() + 1,
                                                currentYear = new Date().getFullYear();
                                        if (value < currentYear || value > currentYear + 100) {
                                            return false;
                                        }
                                        if (month == '') {
                                            return false;
                                        }
                                        month = parseInt(month, 10);
                                        if (value > currentYear || (value == currentYear && month > currentMonth)) {
                                            validator.updateStatus('expMonth', 'VALID');
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }
                                }
                            }
                        },
                        cvv: {
                            selector: '#cvv',
                            validators: {
                                notEmpty: {
                                    message: 'The cvv is required and can\'t be empty'
                                },
                                cvv: {
                                    message: 'The value is not a valid CVV',
                                    creditCardField: 'cardnumber'
                                }
                            }
                        },
                    }
                });
            });
        </script>
    </head>
    <body>
        <form action="create_customer.php" method="POST" id="payment-form" class="form-horizontal">
            <div class="row row-centered">
                <div class="col-md-4 col-md-offset-4">
                    <div class="page-header">
                        <h2 class="gdfg">Secure Payment Form</h2>
                    </div>
                    <noscript>
                    <div class="bs-callout bs-callout-danger">
                        <h4>JavaScript is not enabled!</h4>
                        <p>This payment form requires your browser to have JavaScript enabled. Please activate JavaScript and reload this page. Check <a href="http://enable-javascript.com" target="_blank">enable-javascript.com</a> for more informations.</p>
                    </div>
                    </noscript>

                    <div class="alert alert-danger" id="a_x200" style="display: none;"> <strong>Error!</strong> <span class="payment-errors"></span> </div>
                    <span class="payment-success">
                        <?= $success ?>
                        <?= $error ?>
                    </span>
                    <fieldset>

                        <!-- Form Name -->
                        <legend>Billing Details</legend>

                        <!-- Street -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="textinput">Street</label>
                            <div class="col-sm-6">
                                <input type="text" value="Street 1" name="street" placeholder="Street" class="address form-control">
                            </div>
                        </div>

                        <!-- City -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="textinput">City</label>
                            <div class="col-sm-6">
                                <input type="text" name="city" value="noida" placeholder="City" class="city form-control">
                            </div>
                        </div>

                        <!-- State -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="textinput">State</label>
                            <div class="col-sm-6">
                                <input type="text" name="state" value="uttar pradesh" maxlength="65" placeholder="State" class="state form-control">
                            </div>
                        </div>

                        <!-- Postcal Code -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="textinput">Postal Code</label>
                            <div class="col-sm-6">
                                <input type="text" name="zip" value="201301" maxlength="9" placeholder="Postal Code" class="zip form-control">
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="textinput">Country</label>
                            <div class="col-sm-6"> 
                                <!--input type="text" name="country" placeholder="Country" class="country form-control"-->
                                <div class="country bfh-selectbox bfh-countries" name="country" placeholder="Select Country" data-flags="true" data-filter="true"> </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="textinput">Email</label>
                            <div class="col-sm-6">
                                <input type="text" name="email" maxlength="65" value="sean@sparxitsolutions.com" placeholder="Email" class="email form-control">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Card Details</legend>

                        <!-- Card Holder Name -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label"  for="textinput">Card Holder's Name</label>
                            <div class="col-sm-6">
                                <input type="text" name="cardholdername" maxlength="70" value="Sean Rock" placeholder="Card Holder Name" class="card-holder-name form-control">
                            </div>
                        </div>

                        <!-- Card Number -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="textinput">Card Number</label>
                            <div class="col-sm-6">
                                <input type="text" id="cardnumber" maxlength="19" name="cardnumber" value="4111111111111111" placeholder="Card Number" class="card-number form-control">
                            </div>
                        </div>

                        <!-- Expiry-->
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="textinput">Card Expiry Date</label>
                            <div class="col-sm-6">
                                <div class="form-inline">
                                    <select name="exp_month" data-stripe="exp-month" class="card-expiry-month stripe-sensitive required form-control">
                                        <option value="01" selected="selected">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option selected="selected" value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                    <span> / </span>
                                    <select name="exp_year" data-stripe="exp-year" class="card-expiry-year stripe-sensitive required form-control">
                                    </select>
                                    <script type="text/javascript">
                                        var select = $(".card-expiry-year"),
                                                year = new Date().getFullYear();

                                        for (var i = 0; i < 12; i++) {
                                            select.append($("<option value='" + (i + year) + "' " + (i === 0 ? "selected" : "") + ">" + (i + year) + "</option>"))
                                        }
                                    </script> 
                                </div>
                            </div>
                        </div>

                        <!-- CVV -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="textinput">CVV/CVV2</label>
                            <div class="col-sm-3">
                                <input type="text" id="cvv" name="cvv" value="456" placeholder="CVV" maxlength="4" class="card-cvc form-control">
                            </div>
                        </div>
                        

                        <!-- Important notice -->
                        <div class="form-group">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Important notice</h3>
                                </div>
                                <div class="panel-body">
                                    <p>Your card will be charged 10 $; after submit.</p>
                                    <p>Your account statement will show the following booking text:
                                        XXXXXXX </p>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="control-group">
                                <div class="controls">
                                    <center>
                                        <button id="make_payment" class="btn btn-success" type="submit">Make Payment</button>
                                    </center>
                                </div>
                            </div>
                    </fieldset>
        </form>
        <div class="col-md-12">
                <h2>List of customer payments :</h2>
                <table width="100%" border="1" cellpadding="2">
                    <thead>
                        <tr><td>Sr.</td><td>Customer ID</td><td>Amount</td><td>Has been charged</td><td>Charge ID</td></tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = mysql_query("SELECT * FROM cards WHERE has_been_deleted=0");    
                            $i = 1;
                            while($obj = mysql_fetch_object($query) ){
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $obj->customer_id; ?></td>
                                        <td><?php echo $obj->amount/100; ?>$</td>
                                        <td><?php echo $obj->has_been_charged; ?></td>
                                        <td><?php echo $obj->charge_id; ?></td>
                                    </tr>    
                                    <?php
                                }               
                        ?>
                    </tbody>
                </table>
                <br/>
                <div class="control-group">
                                <div class="controls">
                                    <center>
                                        <button id="charge_payment" class="btn btn-success" type="button">Charge payments</button>
                                    </center>
                                </div>
                            </div>
                <br/><br/>
            </div>
    </body>
</html>
