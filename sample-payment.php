<html>
    <!-- Sample Page which has a button saying Pay Now, which leads to PayHere services and gets back the sttaus of the payment and stores in the mysql database -->
    <head>
        <title>PayHere Sample</title>
    </head>

    <body>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
<button type="submit" id="payhere-payment" >PayHere Pay</button>
<script>
    // Payment completed. It can be a successful failure.
    payhere.onCompleted = function onCompleted(orderId) {
        console.log("Payment completed. OrderID:" + orderId);
        // Note: validate the payment and show success or failure page to the customer
    };

    // Payment window closed
    payhere.onDismissed = function onDismissed() {
        // Note: Prompt user to pay again or show an error page
        console.log("Payment dismissed");
    };

    // Error occurred
    payhere.onError = function onError(error) {
        // Note: show an error page
        console.log("Error:"  + error);
    };
    var merchant_id = "1221879";    

    // Put the payment variables here
    var payment = {
        "sandbox": true,
        "merchant_id": merchant_id,    // Replace your Merchant ID
        "return_url": undefined,     // Important
        "cancel_url": undefined,     // Important
        "notify_url": "http://sample.com/notify",
        "order_id": "ItemNo12345",
        "items": "Door bell wireles",
        "amount": "1000.00",
        "currency": "LKR",
        "hash": "F626F1B3D79BD77A3C965646CD9ECC8E", // *Replace with generated hash retrieved from backend
        "first_name": "Saman",
        "last_name": "Perera",
        "email": "samanp@gmail.com",
        "phone": "0771234567",
        "address": "No.1, Galle Road",
        "city": "Colombo",
        "country": "Sri Lanka",
        "delivery_address": "No. 46, Galle road, Kalutara South",
        "delivery_city": "Kalutara",
        "delivery_country": "Sri Lanka",
        "custom_1": "",
        "custom_2": ""
    };

    // Show the payhere.js popup, when "PayHere Pay" is clicked
    document.getElementById('payhere-payment').onclick = function (e) {
        payhere.startPayment(payment);
    };
</script>



    </body>




</html>


