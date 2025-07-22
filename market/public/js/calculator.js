$(document).ready(function () {
    $(document).on('keyup mouseup', '.quantity', function () {
        let currentElement = $(this),
            parentElement = $(this).closest('tr'),
            totalPrice = 0;

        axios
            .post(
                '/api/products/calculate',
                {
                    'product_id': parentElement.data('id'),
                    'quantity': currentElement.val(),
                },
                {
                    headers: {
                        Authorization: `Bearer supersecretmarkettoken`,
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
            })
            .catch(function (error) {
                alert('Something went wrong.');
            });
    });
});
