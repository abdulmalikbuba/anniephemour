<!-- welcome -->
<div class="welcome" style="background-image: url($BannerImage.URL);">
    <div class="container">
        <div class="content overlay">
            <div class="wrapper">
                <h1 class="mb-4 wow zoomIn" data-wow-delay="0.1s">Welcome to <br> <span>Annie Phemour</span></h1>
                <p class="wow fadeInUp" data-wow-delay="0.2s">$WelcomeContent</p>
                <a href="#login" data-bs-toggle="modal" class="btn btn-lg btn-warning rounded-0 wow fadeInUp" data-wow-delay="0.4s">Get Started</a>
            </div>
        </div>
    </div>
</div>
<!-- welcome -->

<!-- about -->
<div class="about" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="image wow zoomIn" data-wow-delay="0.1s">
                    <img src="$resourceURL('app/images/beautiful-black-businesswoman-using-tablet.jpg')" alt="">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="about-content">
                    <div class="heading">
                        <h5 class="wow fadeInDown" data-wow-delay="0.2s">About</h5>
                        <h2 class="wow fadeInUp" data-wow-delay="0.3s">Annie Phemour</h2>
                    </div>
                    <div class="description mt-3 wow fadeInUp" data-wow-delay="0.4s">
                        <p>$AboutContent</p>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- about -->

<!-- books -->
<div class="books">
    <div class="container">
        <div class="heading">
            <h3 class="wow zoomIn" data-wow-delay="0.1s">$BookTitle</h3>
            <p class="wow fadeInUp" data-wow-delay="0.2s">$BookSubTitle</p>
        </div>
        
        <div class="row">
            <% loop $FeaturedBooks %>
                <div class="col-lg-4 col-md-6">
                    <div class="book-single wow fadeInUp" data-wow-delay="0.3s">
                        <a href="#!" data-bs-toggle="modal" data-bs-target="#exampleModal{$ID}">
                            <% if $BookImage %>
                                <div class="image">
                                    <img src="$BookImage.URL" alt="">
                                </div>
                            <% end_if %>
                            <div class="description">
                                <small>
                                    $Description.LimitWordCount(14,'...')
                                </small>
                            </div>
                        </a>
                    </div>

                    <div class="modal fade" id="exampleModal{$ID}" tabindex="-1" aria-labelledby="exampleModalLabel{$ID}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-warning-subtle justify-content-center">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel{$ID}">$Title</h1>
                                    <%-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --%>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <div class="image">
                                                    <% if $BookImage %>
                                                        <img src="$BookImage.URL" alt="">
                                                    <% else %>
                                                        <img src="$resourceURL('app/images/The Slut.jpg')" alt="">
                                                    <% end_if %>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="des">
                                                    <h4></h4>
                                                    <p>$Description</p>
                                                    <h5 class="price">GHC $Price</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <% if $Price %>
                                <div class="modal-footer">
                                    <form action="cart/addToCart" method="POST">
                                        <input type="hidden" name="BookID" value="$ID">
                                        <button type="submit" class="btn btn-warning">Add to Cart<i class="bi ms-2 bi-cart-fill"></i></button>
                                    </form>
                                    <%-- <a href="#!" class="btn btn-warning">Buy Now</a> --%>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                                <% end_if %>
                            </div>
                        </div>
                    </div>
                </div>
            <% end_loop %>
        </div>

        <% if $FeaturedBooks %>
        <div class="see-more wow zoomIn" data-wow-delay="0.6s">
            <a href="books/" class="btn btn-warning rounded-0">More Books</a>
        </div>
        <% end_if %>
    </div>
</div>
<!-- books -->

<!-- newsletter -->
<div class="newsletter">

</div>
<!-- newsletter -->