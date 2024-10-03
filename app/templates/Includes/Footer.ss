<!-- footer -->
    <div class="footer wow fadeInUp">
        <div class="container-fluid">
            <div class="brand">Annie Phemour</div>
            <div class="breif">
                <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo ullam aliquam sapiente, iusto perspiciatis dolorem sit exercitationem, voluptate ea aut officiis laboriosam sunt voluptatum impedit fugit animi! Labore, ab qui?</p> -->
                <form action="$Link('subscribe')" method="post" class="mb-3">
                    <h5>Subscribe to our newsletter</h5>
                    <p>Monthly digest of what's new and exciting from us.</p>
                    <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                      <label for="newsletter1" class="visually-hidden">Email address</label>
                      <input id="newsletter1" name="Email" type="text" class="form-control" placeholder="Email address">
                      <button class="btn btn-primary" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
            <div class="socials">
                <a href="https://www.facebook.com/anniephemour"><i class="bi fs-4 bi-facebook"></i></a>
                <a href="https://www.instagram.com/annie_phemour"><i class="bi fs-4 bi-instagram"></i></a>
                <a href="#!"><i class="bi fs-4 bi-twitter-x"></i></a>
                <a href="http://tiktok.com/@AnniePhemourTheAuthor"><i class="bi fs-4 bi-tiktok"></i></a>
            </div>
            <div class="links">
                <a href="$BaseHref">Home</a>
                <a href="$BaseHref#about">About</a>
                <a href="$BaseHref/books">Books</a>
                <a href="$BaseHref/contact-us">Contact Us</a>
            </div>
            <hr>
            <div class="copyright">
                <p>Designed and Maintained by Lucid North Technologies</p>
                <p>Copyright &copy;<span id="year">
                    <script>
                      document.getElementById('year').appendChild(document.createTextNode(new Date().getFullYear()))
                    </script>
                  </span> - All Rights Reserved.</p>
              </div>
        </div>
    </div>
    <!-- footer -->