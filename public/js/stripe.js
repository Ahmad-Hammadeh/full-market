// Create a Stripe client.
var stripe = Stripe(
    "pk_test_51HH7hJBYhGiuOyXnfU4T3eyfsMnrDflLEBBkBdGMcA6qWfhpFHTyZOOqS54gQsPGznzAVEmNUlrtTKet0rlavmzG00S5VlnlYF"
);

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: "#32325d",
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: "antialiased",
        fontSize: "16px",
        "::placeholder": {
            color: "#aab7c4"
        }
    },
    invalid: {
        color: "#fa755a",
        iconColor: "#fa755a"
    }
};

// Create an instance of the card Element.
var card = elements.create("card", { style: style, hidePostalCode: true });

// Add an instance of the card Element into the `card-element` <div>.
// card.mount("#card-element"); // Note: We Will Mount The Stripe Element When The User Select The Buying By The Card

// Handle real-time validation errors from the card Element.
card.on("change", function(event) {
    var displayError = document.getElementById("card-errors");
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = "";
    }
});

// Handle form submission.
var form = document.getElementById("payment-form");

form.addEventListener("submit", function(event) {

    if (form.classList.contains('credit_card')) { // Custom Check For Check If User Selected The Buying By The Card

        event.preventDefault();

        // Add Disabled Attribute To The Submit button To Prevent Repeat The Submission
        document
            .getElementById("order-finish")
            .setAttribute("disabled", "disabled");

        let data = {
            name: document.getElementById("name_on_card").value,
            address_line1: document.getElementById("address").value,
            address_city: document.getElementById("city").value,
            address_state: document.getElementById("province").value,
            address_zip: document.getElementById("postalcode").value
        };

        stripe.createToken(card, data).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById("card-errors");
                errorElement.textContent = result.error.message;

                // Remove Disabled Attribute Of The Submit button To Allow The Submission
                document.getElementById("order-finish").removeAttribute("disabled");
            } else {
                // Send the token to your server.
                stripeTokenHandler(result.token);
            }
        });
    }
});


// Submit the form with the token ID.
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById("payment-form");
    var hiddenInput = document.createElement("input");
    hiddenInput.setAttribute("type", "hidden");
    hiddenInput.setAttribute("name", "stripeToken");
    hiddenInput.setAttribute("value", token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}
