$(document).ready(function () {
    /**
     * AJAX post request for getting the product price calculated with potential promotion
     */
    $(document).on('click', '.quantity', function () {
        let currentElement = $(this),
            parentElement = $(this).closest('tr'),
            totalPrice = 0,
            selectedProducts = $('.selected-products'),
            itemsPerType = parentElement.find('.selected-items');

        itemsPerType.val(itemsPerType.val() + currentElement.data('name'));

        axios
            .post(
                '/api/products/calculate',
                {
                    'product_id': parentElement.data('id'),
                    'sku_string': itemsPerType.val(),
                },
                {
                    headers: {
                        Authorization: 'Bearer ' + $('meta[name="api-token"]').attr('content'),
                        'Content-Type': 'application/json',
                    }
                })
            .then(function (response) {
                parentElement
                    .find('[name="product_bundle_price"]')
                    .val(response.data.total_price);

                $('[name="product_bundle_price"]').each(function () {
                    totalPrice += parseInt($(this).val());
                });

                $('.total-price').text(totalPrice);
                selectedProducts.text(selectedProducts.text() + currentElement.data('name'));
            })
            .catch(function (error) {
                alert('Something went wrong.');
            });
    });

    /**
     * Create an order with the selected items
     */
    $(document).on('click', '#checkout', function () {
        if (confirm('Are you sure you want to place an order for these items?')) {
            let products = [];

            // Gets each row with the needed ids and quantities
            $('#products-table tr').each(function () {
                let productId = $(this).data('id'),
                    quantity = $(this).find('.quantity').val();

                if (productId && quantity > 0) {
                    products.push({
                        product_id: parseInt(productId),
                        quantity: parseInt(quantity)
                    });
                }
            });

            axios
                .post(
                    '/api/products/place-order',
                    {
                        'products': products,
                    },
                    {
                        headers: {
                            Authorization: 'Bearer ' + $('meta[name="api-token"]').attr('content'),
                            'Content-Type': 'application/json',
                        }
                    })
                .then(function (response) {
                    // Clear the prices
                    $('.quantity, [name="product_bundle_price"]').val(0);
                    $('.total-price').text(0);

                    // Refresh the page if success
                    if (response.status === 200) {
                        location.reload();
                    }
                })
                .catch(function (error) {
                    alert('Something went wrong.');
                });
        }
    });
});
