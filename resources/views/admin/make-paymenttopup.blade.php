<html>

<body>
    Redirecting For Payment...
    <br>
    Please do not Close this Window or press Back Button
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        let stripe = Stripe('{{env("STRIPE_KEY")}}');
        let userId = '{{$userId}}';
        let paymentID = '{{$paymentID}}';
        let data = {
            user_id: userId,
            payment_id: paymentID,
            _token: '{{csrf_token()}}',
        };
        fetch('{{route("create-payment-session-topup")}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                    //'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: JSON.stringify(data)
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(session) {
                return stripe.redirectToCheckout({
                    sessionId: session.id
                });
            })
            .then(function(result) {
                // If `redirectToCheckout` fails due to a browser or network
                // error, you should display the localized error message to your
                // customer using `error.message`.
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
    </script>

</body>

</html>