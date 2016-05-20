
<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <meta charset="UTF-8" />
    <script src="https://cdn.worldpay.com/v1/worldpay.js"></script>        

    <script type='text/javascript'>
    window.onload = function() {
      Worldpay.useTemplateForm({
        'clientKey':'T_C_26641604-f3d2-4420-b81c-ddc22c7514e4',
        'form':'paymentForm',
        'paymentSection':'paymentSection',
        'display':'modal',
        'callback': function(obj) {
          if (obj && obj.token) {
            var _el = document.createElement('input');
            _el.value = obj.token;
            _el.type = 'hidden';
            _el.name = 'token';
            document.getElementById('paymentForm').appendChild(_el);
            document.getElementById('paymentForm').submit();
          }
        }
      });
    }
    </script>
  </head>
  <body>
    <form action="complete.php" id="paymentForm" method="post">
      <!-- all other fields you want to collect, e.g. name and shipping address -->
      <div id='paymentSection'></div>
      <div>
        <input type="submit" value="Place Order" onclick="Worldpay.submitTemplateForm()" />
      </div>
    </form>
  </body> 
</html> 
 
