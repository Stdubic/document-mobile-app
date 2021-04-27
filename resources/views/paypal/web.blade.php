<!DOCTYPE html>
<html>
<head>
    <title>Paypal payment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <style type="text/css">
        .container {
            display: flex;
            margin: 18% 4%;
            flex: 1;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.3);
            height: 100%;
            padding: 6% 0%;
        }
        .loading{
            display:none;
            z-index: 1000;
            flex:1;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: absolute;
            top:0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.7);
        }
        p {
            padding: 1px 15px;
            font-weight: 600;
            text-align: center;
            font-family: Open Sans;
            font-family: 'Open Sans', sans-serif;
            font-size: 24px;
        }
        .paypal-button {
            padding: 10px;
        }
        .upgrade-button {
            border: 1px solid silver;
            background: transparent;
            padding: 10px 24px;
            font-family: 'Open Sans', sans-serif;
            font-size: 16px;
            font-weight: 400;

        }
    </style>
</head>
<body>
<div id="loading" class="loading">
    <img src="{{ asset('img/spinner.svg') }}" />
</div>
<div id="success-message">
    <p>
    </p>
</div>
<div class="container">
    <p>Process the upgrade payment via PayPal</p>
    <p style="font-size: 16px;font-weight: normal;">Upgrade price is <b> <?= $settings->amount?> <?=$payment_currency?> </b> for <b><?= $settings->duration ?></b> months  </p>

    <?php use Illuminate\Support\Facades\Crypt; ?>
    <div id="paypal-button" class="paypal-button">
        <form action="/upgrade/{{Crypt::encrypt($jwt)}}">
            <button type="submit" class="upgrade-button" >Request an upgrade invoice</button>
        </form>
    </div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script type="text/javascript">
    const client_id =  "<?=$settings->client_id?>";
    const amount =  <?=$settings->amount?>;
    const payment_currency = "<?=$payment_currency?>";
    const jwt = "<?=$jwt?>";
    window.addEventListener("load", function() {

      /*
        paypal.Button.render(
            {
                env: "sandbox",
                client: {
                    sandbox: `${client_id}`
                },
                payment: function(data, actions) {
                    return actions.payment.create({
                        transactions: [
                            {
                                amount: {
                                    total: `${amount}`,
                                    currency: `${payment_currency}`
                                }
                            }
                        ]
                    });
                },
                onAuthorize: function(data, actions) {
                    return actions.payment.execute().then(function(payPalResp) {
                        const paymentId = payPalResp.id;
                        if (payPalResp.state === "approved") {
                            const loading = document.getElementById("loading");
                            loading.style.display = "flex";
                            var toSend = new FormData();
                            toSend.append("payment_id", paymentId);

                            var requestConfig = {
                                method: "POST",
                                headers: {
                                    Authorization: `Bearer ${jwt}`
                                },
                                body: toSend
                            };

                            fetch("/api/users/upgrade", requestConfig)
                                .then(function(response) {
                                    return response.json();
                                })
                                .then(function(response) {
                                    if (response.success) {
                                        alert("You are successfuly upgraded.");
                                    } else {
                                        alert("Error while upgrading.");
                                    }
                                    loading.style.display = "none";
                                })
                                .catch(function(error) {
                                    alert(error.message);
                                    loading.style.display = "none";
                                });
                        }
                    });
                }
            },
            "#paypal-button"
        );
        */

    });

</script>
</body>
</html>