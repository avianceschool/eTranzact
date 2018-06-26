<?php session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Making Payment via eTranzact</title>
</head>
<body topmargin="0" leftmargin="0" >
<?php
//Generate your own unique transId per transaction.
$transId = rand(100000000,99999999999);
//if ($transId==null) $transId="";
$terminalId = "xxxxxxxxxx";
//if ($terminalId == null) $terminalId = "0000000001";
$success = $HTTP_POST_VARS["SUCCESS"];
$amount = $_REQUEST["TOTAL"];
if ($amount == null) $amount = 1000;
//session_register("TOTAL");
//echo "Amount Charged: ".$amount;
$descr = $_REQUEST["DESCRIPTION"];
if ($descr == null) $descr = "";
$responseurl="http://domainname.com/product.php";
$secret_key="xxxxxxxxxxxx";
$str=$success.$amount.$terminalid.$transid.$responseurl.$secret_key;
$checksum=md5($str);
//echo "Requesting Transaction ID . . .  ";
if ($success == null){ //or success = "" for php
	echo "<form method='POST' action='https://www.etranzact.net/WebConnectPlus/caller.jsp'>";	
	echo "<input type='hidden' name='TERMINAL_ID' value='".$terminalId."'>";
	echo "<input type='hidden' name = 'TRANSACTION_ID' value='".$transId."'>";
	echo "<input type='hidden' name = 'AMOUNT' value='".$amount."'>";
	echo "<input type='hidden' name = 'DESCRIPTION' value='".$descr."'>";
	echo "<input type='hidden' name = 'EMAIL' value='info@domainname.com'>";
	echo "<input type='hidden' name = 'CURRENCY_CODE' value='USD'>";
	echo "<input type='hidden' name ='ECHODATA' value='<customerinfo><firstname></firstname><lastname></lastname><phoneno></phoneno><email></email><address></address><city></city><state></state><zipcode></zipcode><postalcode></postcode><country></country><otherdetails></otherdetails></customerinfo>'>";
	echo "<input type='hidden' name = 'RESPONSE_URL' value='http://domainname.com/eresponse.php'>";
	echo "<input type='hidden' name = 'CHECKSUM' value='".$checksum."'>"; 
	echo "<input type='hidden' name = 'LOGO_URL' value='http://domainname.com/images/logo.png'>";
	echo "</form>";
	echo "<script language='javascript'>";
	echo "var form = document.forms[0];";
	echo "form.submit()</script>";
}else if ($success == "0"){
	//deal with successful transaction
	echo "Transaction Successfull";
	session_register("transId");
	

// ********************Custom INVOICE CODE--**************

// ********************Custom INVOICE CODE--**************


}else	//Deal with Timeout Here, Transaction ID no more valid
	echo "Error while requesting for transaction authorisation, Transaction ID no more valid ";
?>
</body>
</html>
