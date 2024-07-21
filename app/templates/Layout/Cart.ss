<!-- book page -->
<div class="book-page">

    <div class="banner">
    <div class="overlay">
        <div class="wrapper">
        <h2 class="wow zoomIn">Your Shopping Cart</h2>
        <%-- <a href="$BaseHref" class="wow fadeInUp">Back To Home</a> --%>
        </div>
    </div>
    </div>

    <div class="container my-5">
    <!-- table -->
      <table class="table cart-table table-hover caption-top">
      <caption>My Cart</caption>
        <thead>
          <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col">Book Title</th>
            <th scope="col">Price</th>
            <th scope="col" class="text-center">Quantity</th>
            <th scope="col" class="text-center">Total Amount</th>
            <th scope="col" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
        <% if $Cart.CartItems %>
        <% loop $Cart.CartItems %>
          <tr>
            <td class="text-center"><img src="$Book.BookImage.URL" alt=""></td>
            <td>$Book.Title</td>
            <td>GHC $Book.Price</td>
            <td class="text-center">
              <form action="cart/updateQuantity" method="post" class="quantity-form">
                  <input type="hidden" name="CartItemID" value="$ID">
                  <div class="input-group">
                      <button type="button" class="btn btn-outline-secondary decrement-btn">-</button>
                      <input type="number" name="Quantity" value="$Quantity" min="1" max="10" class="form-control quantity-input">
                      <button type="button" class="btn btn-outline-secondary increment-btn">+</button>
                  </div>
              </form>
          </td>


            <td class="text-center">$TotalPrice</td>
            <td class="text-center">
              <button type="button" class="btn remove-btn" data-bs-toggle="modal" data-bs-target="#confirmationModal-$ID">
                <i class="bi fs-4 text-danger bi-x-square"></i>
              </button>

              <!-- Modal -->
              <div class="modal fade" id="confirmationModal-$ID" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Confirm Removal</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              Are you sure you want to remove this item from your cart?
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                              <form id="removeFromCartForm" action="cart/removeFromCart" method="post">
                                  <input type="hidden" name="CartItemID" value="$ID">
                                  <button type="submit" class="btn btn-danger">Remove</button>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
            </td>
          </tr>
        <% end_loop %>
          <tr>
            <td colspan="5" class="">Total</td>
            <td class="text-center">GHC $Cart.Total</td>
          </tr>
          <% else %>
          <tr>
            <td colspan="6" class="text-center">No items in cart!</td>
          </tr>
          <% end_if %>
        </tbody>
      </table>

      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="books" class="btn btn-outline-secondary me-md-2">Continue Shopping</a>
        <% if $Cart.CartItems %>
            <a href="cart/purchase" class="btn btn-warning">Proceed To Payment</a>
        <% end_if %>
      </div>

    </div>
</div>
<!-- book page -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap Toasts
        const toastElementList = [].slice.call(document.querySelectorAll('.toast'));
        const toastList = toastElementList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl, { delay: 5000 });
        });
        toastList.forEach(toast => toast.show());

        // Handle quantity forms
        const quantityForms = document.querySelectorAll('.quantity-form');

        quantityForms.forEach(form => {
            const quantityInput = form.querySelector('.quantity-input');
            const decrementBtn = form.querySelector('.decrement-btn');
            const incrementBtn = form.querySelector('.increment-btn');

            decrementBtn.addEventListener('click', function() {
                if (parseInt(quantityInput.value) > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                    updateCartItem(form);
                }
            });

            incrementBtn.addEventListener('click', function() {
                if (parseInt(quantityInput.value) < 10) { // Assuming max quantity is 10
                    quantityInput.value = parseInt(quantityInput.value) + 1;
                    updateCartItem(form);
                }
            });

            quantityInput.addEventListener('change', function() {
                if (parseInt(quantityInput.value) < 1) {
                    quantityInput.value = 1;
                } else if (parseInt(quantityInput.value) > 10) {
                    quantityInput.value = 10;
                }
                updateCartItem(form);
            });
        });

        function updateCartItem(form) {
            const formData = new FormData(form);
            fetch('cart/updateQuantity', {
                method: 'POST',
                body: formData
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            }).then(data => {
                console.log('Quantity updated successfully', data);
                // Optionally update UI or show success message
            }).catch(error => {
                console.error('Error updating quantity', error);
                // Handle error: show a message, revert input value, etc.
            });
        }
    });
</script>
