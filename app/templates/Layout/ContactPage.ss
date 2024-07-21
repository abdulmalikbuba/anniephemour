<!-- contact -->
<div class="contact-page mb-5">
    <div class="banner">
    <div class="overlay">
        <div class="wrapper">
        <h2 class="wow zoomIn">Contact Us</h2>
        <%-- <a href="$BaseHref" class="wow fadeInUp">Back To Home</a> --%>
        </div>
    </div>
    </div>

    <div class="container my-5 ">
    <div class="heading wow zoomIn">
        <h5>Get in Touch</h5>
        <p>We'd love to hear from you! Whether you have questions, suggestions, or just want to share your love for books, our team is here to connect with you.</p>
    </div>
    <div class="row">
        <div class="col-lg-6 wow fadeInUp">
        <h5>Contact Us</h5>
        <p>Feel free to reach out through any of the following methods:</p>
        <div class="info">
            <div class="d-flex">
            <div class="icon me-3">
                <i class="bi fs-2 bi-telephone-forward"></i>
            </div> 
            <div>Phone <br> <span>$SiteConfig.PhoneNumber</span></div>
            </div>
            <div class="d-flex mt-3">
            <div class="icon me-3">
                <i class="bi fs-2 bi-envelope-at"></i>
            </div> 
            <div>Email <br> <span>$SiteConfig.EmailAddress</span></div>
            </div>
        </div>
        <div class="social-media mt-4">
            <h5>Stay Connected</h5>
            <small>Follow us on social media to get the latest updates, recommendations, and more.</small>
            <div class="mt-2">
            <a href="https://www.facebook.com/anniephemour" target="_blank" class="btn btn-outline-warning me-1"><i class="bi fs-5 bi-facebook"></i></a>
            <a href="https://www.instagram.com/annie_phemour" target="_blank" class="btn btn-outline-warning me-1"><i class="bi fs-5 bi-instagram"></i></a>
            <a href="#!" target="_blank" class="btn btn-outline-warning me-1"><i class="bi fs-5 bi-twitter-x"></i></a>
            <a href="http://tiktok.com/@AnniePhemourTheAuthor" target="_blank" class="btn btn-outline-warning"><i class="bi fs-5 bi-tiktok"></i></a>
            </div>

        </div>
        </div>
        <div class="col-lg-6">
            $ContactForm
        </div>
    </div>
    </div>
</div>

 <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const toastElementList = [].slice.call(document.querySelectorAll('.toast'))
            const toastList = toastElementList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl, { delay: 5000 });
            });
            toastList.forEach(toast => toast.show());
        });
    </script>
<!-- contact -->
