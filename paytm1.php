Here is a sample code for Paytm integration in PHP:


<?php

// array for final token
$finalToken = array();

// array for post data
$postData = array();

// API configuration
$api_config = array(
    'mid' => "YOUR_MID_HERE",
    'key' => "YOUR_KEY_HERE",
    'website' => "WEBSITE_NAME_HERE"
);

// transaction data
$transactionData = array(
    'order_id' => "ORDER_ID_HERE",
    'amount' => "AMOUNT_HERE"
);

// post data
$postData['MID'] = $api_config['mid'];
$postData['WEBSITE'] = $api_config['website'];
$postData['ORDER_ID'] = $transactionData['order_id'];
$postData['CUST_ID'] = "CUSTOMER_ID_HERE";
$postData['TXN_AMOUNT'] = $transactionData['amount'];
$postData['CHANNEL_ID'] = "WEB";
$postData['INDUSTRY_TYPE_ID'] = "RETAIL";

// generating hash
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
$hashVarsSeq = explode('|', $hashSequence);
$hash_string = '';
foreach($hashVarsSeq as $hash_var) {
    $hash_string .= isset($postData[$hash_var]) ? $postData[$hash_var] : '';
    $hash_string .= '|';
}
$hash_string .= $api_config['key'];
$hash = strtolower(hash('sha512', $hash_string));

// adding additional parameters
$postData['HASH'] = $hash;
$postData['MOBILE_NO'] = "CUSTOMER_MOBILE_NO_HERE";
$postData['EMAIL'] = "CUSTOMER_EMAIL_HERE";
$postData['VERIFIED_BY'] = "EMAIL";
$postData['IS_USER_VERIFIED'] = "YES";

// final token
$finalToken = $postData;

// initiating the payment
$payment_url = "PAYMENT_URL_HERE";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $payment_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $finalToken);
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

// verifying the payment response
$response_data = json_decode($response);
if($response_data->STATUS == "TXN_SUCCESS") {
    // Payment successful
    // your action here
}
else {
    // Payment failed
    // your action here
}

?>
