<?php 
/*
* Super Simple Shopping Cart
* 
* Copyright (c) 2008, Daniel Morante
* All rights reserved.
* Redistribution and use in source and binary forms, with or without modification, 
* are permitted provided that the following conditions are met:
* 
* 	* Redistributions of source code must retain the above copyright notice, 
*	  this list of conditions and the following disclaimer.
*   * Redistributions in binary form must reproduce the above copyright notice, 
* 	  this list of conditions and the following disclaimer in the documentation 
* 	  and/or other materials provided with the distribution.
*   * Neither the name of The Daniel Morante Company, Inc. nor the names of its contributors 
* 	  may be used to endorse or promote products derived from this software without 
* 	  specific prior written permission.
* 
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS 
* OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY 
* AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR 
* CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL 
* DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, 
* DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER 
* IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT 
* OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

Not database driven
Add products with a "Get" request "add=name&price=XX&qty"
items storred in a "SESSION" vairable by thier names, qty, and price only
Remove with a "get" request "renove=xx"
Empty with a "get" request "empty"
*/

//Start the session
session_start();

//Create 'cart' if it doesn't already exist
if (!isset($_SESSION['SHOPPING_CART'])){ $_SESSION['SHOPPING_CART'] = array(); }


//Add an item only if we have the threee required pices of information: name, price, qty
if (isset($_GET['add']) && isset($_GET['price']) && isset($_GET['qty'])){
	//Adding an Item
	//Store it in a Array
	$ITEM = array(
		//Item name		
		'name' => $_GET['add'], 
		//Item Price
		'price' => $_GET['price'], 
		//Qty wanted of item
		'qty' => $_GET['qty']		
		);

	//Add this item to the shopping cart
	$_SESSION['SHOPPING_CART'][] =  $ITEM;
	//Clear the URL variables
	header('Location: ' . $_SERVER['PHP_SELF']);
}
//Allowing the modification of individual items no longer keeps this a simple shopping cart.
//We only support emptying and removing
else if (isset($_GET['remove'])){
	//Remove the item from the cart
	unset($_SESSION['SHOPPING_CART'][$_GET['remove']]);
	//Re-organize the cart
	//array_unshift ($_SESSION['SHOPPING_CART'], array_shift ($_SESSION['SHOPPING_CART']));
	//Clear the URL variables
	header('Location: ' . $_SERVER['PHP_SELF']);

}
else if (isset($_GET['empty'])){
	//Clear Cart by destroying all the data in the session
	session_destroy();
	//Clear the URL variables
	header('Location: ' . $_SERVER['PHP_SELF']);

}
else if (isset($_POST['update'])) {
	//Updates Qty for all items
	foreach ($_POST['items_qty'] as $itemID => $qty) {
		//If the Qty is "0" remove it from the cart
		if ($qty == 0) {
			//Remove it from the cart
			unset($_SESSION['SHOPPING_CART'][$itemID]);
		}
		else if($qty >= 1) {
			//Update to the new Qty
			$_SESSION['SHOPPING_CART'][$itemID]['qty'] = $qty;
		}
	}
	//Clear the POST variables
	header('Location: ' . $_SERVER['PHP_SELF']);
} 

?>
<?php
function sendEmail($additional){		
# -=-=-=- PHP FORM VARIABLES (add as many as you would like)
$adminEmail = 'info@example.com';
$companyName = 'Unibia.net';
$purpose = 'Online Order';
$actionDone = "Placing your $purpose with $companyName";
$name = $_POST['first_name'] . ' ' . $_POST['last_name'];
$email = $_POST["email"];
$phone = $_POST['phone'];
$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
//Payment information
$card_num = $_POST['card_num'];
$name_on_card = $_POST['name_on_card'];
$card_type = $_POST['card_type'];
$exp_month = $_POST['exp_month'];
$exp_year = $_POST['exp_year'];

# -=-=-=- MIME BOUNDARY

$mime_boundary = "----BOUNDRY----".md5(time());

# -=-=-=- MAIL HEADERS

$to = $adminEmail;
$subject = $_SERVER['HTTP_HOST'] . " $purpose";

$headers = "From: $name <$email>\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";

# -=-=-=- TEXT EMAIL PART

$message = "--$mime_boundary\n";
$message .= "Content-Type: text/plain; charset=UTF-8\n";
$message .= "Content-Transfer-Encoding: 8bit\n\n";

//Summary of Information Recived
$info_recived_text = '';
$info_recived_text .= "Name: $name\n";
$info_recived_text .= "Email: $email\n";
$info_recived_text .= "Address: $address\n";
$info_recived_text .= "Address (cont): $address2\n";
$info_recived_text .= "City: $city\n";
$info_recived_text .= "State: $state\n";
$info_recived_text .= "Zip: $zip\n";
$info_recived_text .= "Home Phone: $phone\n";

//Payment Information
$payment_text = '';
$payment_text .= "Name: $name_on_card\n";
$payment_text .= "CC#: $card_num\n";
$payment_text .= "Type: $card_type\n";
$payment_text .= "Month: $exp_month\n";
$payment_text .= "Year: $exp_year\n";

$message .= strip_tags($additional) . "\n\n";
$message .= $info_recived_text . "\n\n";
$message .= $payment_text; 

# -=-=-=- HTML EMAIL PART
 
$message .= "--$mime_boundary\n";
$message .= "Content-Type: text/html; charset=UTF-8\n";
$message .= "Content-Transfer-Encoding: 8bit\n\n";

$message .= "<html>\n";
$message .= "<body style=\"font-family:Verdana, Verdana, Geneva, sans-serif; font-size:14px; color:#666666;\">\n";

//Summary of Information Recived
$info_recived_html = '';
$info_recived_html .= "<div>Name: $name</div>\n";
$info_recived_html .= "<div>Email: $email</div>\n";
$info_recived_html .= "<div>Address: $address</div>\n";
$info_recived_html .= "<div>Address (cont): $address2</div>\n";
$info_recived_html .= "<div>City: $city</div>\n";
$info_recived_html .= "<div>State: $state</div>\n";
$info_recived_html .= "<div>Zip: $zip</div>\n";
$info_recived_html .= "<div>Home Phone: $phone</div>\n";

//Payment Information
$payment_html = '';
$payment_html .= "<div>Name: $name_on_card</div>\n";
$payment_html .= "<div>CC#: $card_num</div>\n";
$payment_html .= "<div>Type: $card_type</div>\n";
$payment_html .= "<div>Month: $exp_month</div>\n";
$payment_html .= "<div>Year: $exp_year</div>\n";

$message .= $additional;
$message .= $info_recived_html;
$message .= $payment_html;
$message .= "</body>\n";
$message .= "</html>\n";

# -=-=-=- FINAL BOUNDARY

$message .= "--$mime_boundary--\n\n";

# -=-=-=- SEND MAIL

$mail_sent = @mail( $to, $subject, $message, $headers );

//*****This part gets sent to the clients*********
# -=-=-=- MAIL HEADERS

$to = "$name <$email>";
$subject = "$companyName $purpose";

$headers = "From: $companyName <$adminEmail>\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";

# -=-=-=- TEXT EMAIL PART

$message = "--$mime_boundary\n";
$message .= "Content-Type: text/plain; charset=UTF-8\n";
$message .= "Content-Transfer-Encoding: 8bit\n\n";

$message .= "Dear $name,\n";
$message .= "\n";
$message .= "Thank you for $actionDone.  ";
$message .= "This is an automated response to confirm your request.  ";
$message .= "$companyName respects your privacy, if you did not preform this request, ";
$message .= "please let us know as soon as possible.\n";
$message .= "\n";
$message .= "Below you'll find the information we recieved.  If any of it is incorrect ";
$message .= "or you'd like to add more, please do so by responding to this message. \n";
$message .= "\n";
$message .= strip_tags($additional) . "\n\n";
$message .= $info_recived_text;
$message .= "\n";
# -=-=-=- HTML EMAIL PART
 
$message .= "--$mime_boundary\n";
$message .= "Content-Type: text/html; charset=UTF-8\n";
$message .= "Content-Transfer-Encoding: 8bit\n\n";

$message .= "<html>\n";
$message .= "<body style=\"font-family:Verdana, Verdana, Geneva, sans-serif; font-size:14px; color:#666666;\">\n";
$message .= "<div>Dear $name,</div>\n";
$message .= "<p></p>\n";
$message .= "<div><p>Thank you for $actionDone.  ";
$message .= "This is an automated response to confirm your request.  ";
$message .= "$companyName respects your privacy, if you did not preform this request, ";
$message .= "please let us know as soon as possible.</p></div>\n";
$message .= "<p></p>\n";
$message .= "<div><p>Below you'll find the information we recieved.  If any of it is incorrect ";
$message .= "or you'd like to add more, please do so by responding to this message. </p></div>\n";
$message .= "<p></p>\n";
$message .= $additional;
$message .= $info_recived_html;
$message .= "<p></p>\n";
$message .= "</body>\n";
$message .= "</html>\n";

# -=-=-=- FINAL BOUNDARY

$message .= "--$mime_boundary--\n\n";

# -=-=-=- SEND MAIL

$mail_sent = @mail( $to, $subject, $message, $headers );
//echo $mail_sent ? "Mail sent" : "Mail failed";
}

if (isset($_POST['submit']) && 
	isset($_POST['email']) && 
	isset($_POST['card_num'])
	)
{		
	//Everything is good, proceed
	sendEmail($_SESSION['SHOPPING_CART_HTML']);
	$result_message = "Thank You.";
}
elseif (isset($_POST['submit'])){
	//Missing Required Information
	$result_message = "You must Provide two email addresses.";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $_SERVER['HTTP_HOST']; ?> Online Order Form</title>
<style type="text/css">
<!--
#formArea #orderForm #formColumns {
	width:650px;
	margin:auto;
}
#formArea #orderForm #formColumns #leftColumn {
	float:left;
	width:300px;
}
#orderForm {
	height:500px;
}
#formArea #orderForm #formColumns #rightColumn {
	float:right;
	width:300px;
}
#formArea #orderForm #formColumns th {
	text-align: left;
}
.copyright {
	font-size: 9pt;
}
-->
</style>
</head>

<body>
<div id="pageHeader">
  <h1><?php echo $_SERVER['HTTP_HOST']; ?> Order Form</h1>
</div>
<div id="shoppingCartDisplay">
<form action="" method="post" name="shoppingcart">
	<?php 
    //We want to include the shopping cart in the email
    ob_start();
    ?>
    <table width="500" border="1">
      <tr>
        <th scope="col">&nbsp;</th>
        <th scope="col">Item Name</th>
        <th scope="col">Unit Price</th>
        <th scope="col">Qty</th>
        <th scope="col">Cost</th>
      </tr>
    
        <?php 
        //Print all the items in the shopping cart
        foreach ($_SESSION['SHOPPING_CART'] as $itemNumber => $item) {
        ?>
        <tr id="item<?php echo $itemNumber; ?>">    
            <td><a href="?remove=<?php echo $itemNumber; ?>">remove</a></td>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo $item['price']; ?></td>
            <td><input name="items_qty[<?php echo $itemNumber; ?>]" type="text" id="item<?php echo $itemNumber; ?>_qty" value="<?php echo $item['qty']; ?>" size="2" maxlength="3" /></td>
            <td><?php echo $item['qty'] * $item['price']; ?></td>        
        </tr>
        <?php
        }
        ?>
    </table>
	<?php $_SESSION['SHOPPING_CART_HTML'] = ob_get_flush(); ?>
    <p>
      <label>
      <input type="submit" name="update" id="update" value="Update Cart" />
      </label>
    </p>
</form>
<p><a href="javascript: history.go(-1)">Keep Shopping</a> - <a href="?empty">Empty</a> Cart</p>
</div>

   
<div id="formArea">   
	<?php if (isset($result_message)) {?>
        <div><h3><?php echo $result_message; ?></h3></div>
    <? 
    } 
    else {
    ?>
    <div id="orderForm">
        <form action="" method="post" name="orderform">
            <div id="formColumns">
                <div id="leftColumn">
                    <table width="100%"  border="0" cellpadding="5" cellspacing="0">
                        <tr>
                            <th>Account Information</th>
                        </tr>
                        <tr height="21">
                            <td height="32"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Name [First] [Last]*</font></td>
                        </tr>
                        <tr height="21">
                            <td height="21"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><input name="first_name" type="text" class="inputtext" value="" size="15"><input name="last_name" type="text" class="inputtext" value="" size="15" />
                            </font></td>
                            </tr>                                               
                        <tr>
                            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email Address*</font></td>
                        </tr>
                        <tr>
                            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><input name="email" type="text" class="inputtext" value="" size="20">
                            </font></td>
                        </tr>
                        <tr>
                            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Home Phone*</font></td>
                        </tr>
                        <tr>
                            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><input name="phone" type="text" class="inputtext" id="phone" value="" size="20">
                            </font></td>
                        </tr>											
                        <tr>
                            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Billing Address*</font></td>
                        </tr>
                        <tr>
                            <td><input name="address" type="text" class="inputtext" value="" size="20"></td>
                        </tr>
                        <tr>
                            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Billing Address (cont)</font></td>
                        </tr>
                        <tr>
                            <td><input name="address2" type="text" class="inputtext" value="" size="20"></td>
                        </tr>
                        <tr>
                            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">City* &nbsp;State* </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Zip code*</font></td>
                        </tr>
                        <tr>
                            <td><input name="city" type="text" class="inputtext" value="" size="15" />
                            <input name="state" type="text" class="inputtext" value="" size="2" maxlength="2" />
                            <input name="zip" type="text" class="inputtext" id="zip" value="" size="10" /></td>
                        </tr>											
                    </table>
                </div>
                <div id="rightColumn">
                    <table width="100%" height="50%"  border="0" cellpadding="3" cellspacing="0">
                        <tr valign="middle">
                            <th>Payment</th>
                        </tr>									
                        <tr>
                            <td align="left">
                                <div align="left">
                                    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Name as appears on card:&nbsp;&nbsp;</font></div>												</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">
                                    <input name="name_on_card" type="text" id="name_on_card" value="" class="inputtext"></div>												</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">
                                    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Card Type :&nbsp;&nbsp;</font></div>												</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">
                                    <select name="card_type" class="inputtext">
                                        <option value="VISA">Visa</option>
                                        <option value="MASTERCARD">Master Card</option>
                                        <option value="AMEX">American Express</option>
                                        <option value="DISCOVER">Discover</option>
                                    </select></div>												</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">
                                    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Card Number : </font></div>												</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">
                                    <input name="card_num" type="text" class="inputtext"></div>												</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">
                                    <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> Exp. Date :&nbsp;&nbsp;</font></div>												</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">
                                    <select name="exp_month">
                                        <option value=""></option>
                                        <option value=1>1</option>
                                        <option value=2>2</option>
                                        <option value=3>3</option>
                                        <option value=4>4</option>
                                        <option value=5>5</option>
                                        <option value=6>6</option>
                                        <option value=7>7</option>
                                        <option value=8>8</option>
                                        <option value=9>9</option>
                                        <option value=10>10</option>
                                        <option value=11>11</option>
                                        <option value=12>12</option>
                                    </select><select name="exp_year">
                                        <option value=""></option>
                                        <option value=2001>2001</option>
                                        <option value=2002>2002</option>
                                        <option value=2003>2003</option>
                                        <option value=2004>2004</option>
                                        <option value=2005>2005</option>
                                        <option value=2006>2006</option>
                                        <option value=2007>2007</option>
                                        <option value=2008>2008</option>
                                        <option value=2009>2009</option>
                                        <option value=2010>2010</option>
                                        <option value=2011>2011</option>
                                        <option value=2012>2012</option>
                                        <option value=2013>2013</option>
                                        <option value=2014>2014</option>
                                    </select></div>												</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="center">
                                    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></div>												</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">
                                    <input name="submit" type="submit" id="submit" value="Submit"></div>												</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">														</div>												</td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>
   <?php } ?>
</div>
<div align="center" class="copyright"><a href="http://www.unibia.com/unibianet/node/24" target="_blank">Super Simple Shopping Cart</a><br />
&copy;2008 By Daniel Morante- <a href="http://www.unibia.net" target="_blank">http://www.unibia.net</a></div>
</body>
</html>