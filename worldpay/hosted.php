<html>
<head>
	<title>HTML Redirect Example 0.1</title>
	<meta http-equiv="Content-Type" content="text/html">
	<meta name="description" content="Junior HTML Example 0.1">
	<meta name="keywords" content="html">
	<style type="text/css">td {text-align:"left"; vertical-align:"middle"; font-family:"arial"; color:"black"} h1,h2,h3,h4,h5,h6,h7 {text-align:"center"; vertical-align:"middle"; font-family:"arial"; color:"black"}</style>
</head>

<body>
<form action="https://secure-test.worldpay.com/wcc/purchase" name="BuyForm" method="POST">
<input type="hidden" name="instId"  value="211616"><!-- The "instId" value "211616" should be replaced with the Merchant's own installation Id -->
<input type="hidden" name="cartId" value="abc123"><!-- This is a unique identifier for merchants use. Example: PRODUCT123 -->
<input type="hidden" name="currency" value="GBP"><!-- Choose appropriate currency that you would like to use -->
<input type="hidden" name="amount"  value="0">
<input type="hidden" name="desc" value="">
<input type="hidden" name="testMode" value="100">

<script language=JavaScript>
function calc(productNo)
{
	if (productNo==1)
	{
		document.BuyForm.amount.value = 5.00;
		document.BuyForm.desc.value = "Product 1";
	}
	else if (productNo==2)
	{
		document.BuyForm.amount.value = 10.00;
		document.BuyForm.desc.value = "Product 2";
	}
	else if (productNo==3)
	{
		document.BuyForm.amount.value = 15.00;
		document.BuyForm.desc.value = "Product 3";
	}
}

</script>

<h1>Wordpay Example</h1>

<table align="center" cellpadding="3" border="2">
<tr>
	<td>Product 1</td>
	<td> Price: &pound;5.00</td>
	<td><input type="image" src="buy_button.jpg" alt="Buy button" onClick="calc(1)"></td>
</tr>
<tr>
	<td>Product 2</td>
	<td>Price: &pound;10.00</td>
	<td><input type="image" src="buy_button.jpg" alt="Buy button" onClick="calc(2)"></td>
</tr>

<tr>
	<td>Product 3</td>
	<td>Price: &pound;15.00</td>
	<td><input type="image" src="buy_button.jpg" alt="Buy button" onClick="calc(3)"></td>
</tr>
</table>

</form>
</body>
</html>
