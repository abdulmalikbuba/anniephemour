<!DOCTYPE html>
<html lang="en">
<head>
    <% base_tag %>
    $MetaTags(false)
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay with Paystack</title>
    <script src="https://js.paystack.co/v1/inline.js"></script>
</head>
<body>
    <% include Header %>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card border-0 shadow-5">
                <div class="card-body">
                <h2>Complete your payment</h2>
                <form id="paymentForm">
                    <input type="hidden" id="email" value="$Email">
                    <input type="hidden" id="amount" value="$Amount">
                    <input type="hidden" id="reference" value="$Reference">
                    <button type="button" class="btn btn-warning" onclick="payWithPaystack()"> Pay </button>
                </form>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function payWithPaystack() {
            var handler = PaystackPop.setup({
                key: '$PublicKey',
                email: document.getElementById('email').value,
                amount: document.getElementById('amount').value,
                currency: 'GHS',
                ref: document.getElementById('reference').value,
                channels: ['card', 'bank', 'ussd', 'qr', 'mobile_money', 'bank_transfer'],
                callback: function(response) {
                    window.location.href = '$CallbackUrl?reference=' + response.reference;
                },
                onClose: function() {
                    alert('Transaction was not completed, window closed.');
                }
            });
            handler.openIframe();
        }
    </script>
</body>
</html>
