<!-- book page -->
<div class="book-page">

    <div class="banner">
    <div class="overlay">
        <div class="wrapper">
        <h2 class="wow zoomIn">$BannerTitle</h2>
        <%-- <a href="$BaseHref" class="wow fadeInUp">Back To Home</a> --%>
        </div>
    </div>
    </div>

    <div class="container my-5">

        <div class="row">
            <% include AccountSideNav %>
            <div class="col-lg-9">
                <div class="header">
                    <h5>$PageTitle</h5>
                </div>
                <div class="content acc-con">
                    <div class="table-responsive">
                        <table class="table table cart-table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Product</th>
                                    <th scope="col" >Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            
                            <tbody class="table-group-divider align-middle">
                                <% if $Orders.exists() %> <!-- Check if there are any orders -->
                                    <% loop $Orders %>
                                        <tr>
                                            <!-- Order ID -->
                                            <td>#{$ID}</td>

                                            <!-- Order Items -->
                                            <td>
                                                <% loop $OrderItems %>
                                                    {$Book.Title} ({$Quantity})<br />
                                                <% end_loop %>
                                            </td>

                                            <!-- Date Created -->
                                            <td>$Created.Date</td>


                                            <!-- Order Status (Wrapped in a styled div) -->
                                            <td class="text-center">
                                                <% if $Status=="Pending" %>
                                                    <div class="bg-warning-subtle p-1 text-warning rounded">{$Status}</div>
                                                    <% else_if $Status == "Processing" %>
                                                    <div class="bg-info-subtle p-1 text-info rounded">{$Status}</div>
                                                    <% else_if $Status == "Shipped" %>
                                                    <div class="bg-primary-subtle p-1 text-primary rounded">{$Status}</div>
                                                    <% else %>
                                                    <div class="bg-success-subtle p-1 text-success rounded">{$Status}</div>
                                                <% end_if %>
                                            </td>

                                            <!-- Total Price -->
                                            <td>GHC {$TotalPrice}</td>

                                            <!-- Action (Delete button) -->
                                            <td class="text-center">
                                                <form action="#!" method="POST">
                                                    <input type="hidden" name="OrderID" value="{$ID}">
                                                    <button type="submit" class="btn btn-sm">
                                                        <i class="bi fs-5 text-danger bi-x-square"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <% end_loop %>
                                <% else %>
                                    <!-- No Orders -->
                                    <tr>
                                        <td colspan="6" class="text-center text-warning">You have no orders.</td>
                                    </tr>
                                <% end_if %>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- book page -->

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const toastElementList = [].slice.call(document.querySelectorAll('.toast'))
        const toastList = toastElementList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl, { delay: 5000 });
        });
        toastList.forEach(toast => toast.show());
    });
</script>