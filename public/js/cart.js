(function() {

    // Get The Quantity Dropdown Element
    const dropdowns = document.querySelectorAll('.quantity select');

    Array.from(dropdowns).forEach(element => {
        element.addEventListener('change', function() {
            let rowId = this.getAttribute('data-rowId'),
                quantity = this.getAttribute('data-quantity'), // The Quantity Of The Product "The Stock Quantity"
                name = this.getAttribute('data-name'); // The Name Of The Product

            axios.patch(`/cart/${rowId}`, {
                    'qty': this.value, // The Quantity Of The Producted Select By Customer"The Quantity Of The Product That User has been ordered"
                    'quantity': quantity, // The Quantity Of The Product "The Stock Quantity"
                    'name': name
                })
                .then(response => location.reload())
                .catch(error => location.reload())
        });
    });
})();