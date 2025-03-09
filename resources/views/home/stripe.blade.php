<!DOCTYPE html>
<html>
<head>
    <title>Laravel Ecommerce Payment System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script> <!-- Load Stripe.js v3 -->
    <style>
        .StripeElement {
            background-color: white;
            height: 40px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error {
            display: none;
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Laravel Ecommerce Payment System</h1>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table">
                    <h3 class="panel-title">Payment Details</h3>
                    <h4>You need to pay ${{ $value }}</h4>
                </div>
                <div class="panel-body">
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
                    <form id="payment-form" action="{{ route('stripe.post', $value) }}" method="post">
                        @csrf
                        <div class='form-group required'>
                            <label class='control-label'>Name on Card</label>
                            <input class='form-control' id="card-holder-name" type='text' required>
                        </div>

                        <!-- Stripe Card Element -->
                        <div class='form-group required'>
                            <label class='control-label'>Card Details</label>
                            <div id="card-element" class="StripeElement"></div>
                        </div>

                        <div class="error" id="card-errors"></div>

                        <div class="row">
                            <div class="col-xs-12">
                                <button id="submit-button" class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>
                            </div>
                        </div>

                        <!-- Hidden Input for Stripe Token -->
                        <input type="hidden" id="stripeToken" name="stripeToken">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var stripe = Stripe("{{ env('STRIPE_KEY') }}"); // Get Stripe publishable key from env
    var elements = stripe.elements();

    // Create Card Element
    var card = elements.create("card", {
        hidePostalCode: true
    });
    card.mount("#card-element");

    var form = document.getElementById("payment-form");
    var submitButton = document.getElementById("submit-button");
    var errorDiv = document.getElementById("card-errors");

    form.addEventListener("submit", async function(event) {
        event.preventDefault();
        submitButton.disabled = true; // Disable button to prevent multiple submissions

        const { token, error } = await stripe.createToken(card);

        if (error) {
            errorDiv.textContent = error.message;
            errorDiv.style.display = "block";
            submitButton.disabled = false;
        } else {
            document.getElementById("stripeToken").value = token.id;
            form.submit(); // Submit form to backend
        }
    });
});
</script>
</body>
</html>
