<!-- book page -->
<div class="book-page">

    <div class="banner">
    <div class="overlay">
        <div class="wrapper">
        <p class="wow fadeInDown">Delve into our fantastic range of books</p>
        <h2 class="wow zoomIn">Our Books</h2>
        <%-- <a href="$BaseHref" class="wow fadeInUp">Back To Home</a> --%>
        </div>
    </div>
    </div>

    <div class="container mt-5">

    <div class="row">
        <% if $getBooks %>
        <% loop $getBooks %>
        <div class="col-lg-3 col-md-6 mx-auto">
            <div class="book-single wow fadeInUp">
                <a href="#!" data-bs-toggle="modal" data-bs-target="#bookModal-$ID">
                    <% if $BookImage %>
                    <div class="image">
                        <img src="$BookImage.URL" alt="">
                    </div>
                    <% end_if %>
                    <div class="description">
                        <small>$Description.LimitWordCount(11, '...')</small>
                    </div>
                </a>
            </div>

            <div class="modal fade" id="bookModal-$ID" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Book</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                        <% if $BookImage %>
                        <div class="image">
                            <img src="$BookImage.URL" alt="">
                        </div>
                        <% end_if %>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="des">
                            <h4>$Title</h4>
                            <p>$Description</p>
                            <h5 class="price">GHC $Price</h5>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="cart/addToCart" method="POST">
                        <input type="hidden" name="BookID" value="$ID">
                        <button type="submit" class="btn btn-outline-secondary">Add to Cart <i class="bi ms-2 bi-cart-fill"></i></button>
                    </form>
                    <a href="cart/purchase" class="btn btn-warning">Buy Now</a>
                </div>
                </div>
            </div>
            </div>

        </div>
        <% end_loop %>
        <% else %>
            <div class="alert alert-warning text-center" role="alert">
            No books have been uploaded yet!
            </div>
        <% end_if %>
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