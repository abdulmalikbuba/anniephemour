<!DOCTYPE html>
<html lang="en">
<head>
    <% base_tag %>
    $MetaTags(false)
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="$resourceURL('app/images/bookfavicon.png')">
    <title>$SiteConfig.Title | <% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %></title>
    <script src="https://js.paystack.co/v1/inline.js"></script>
</head>
<body>
    <% include Header %>

    <!-- Display session messages -->
    $SessionMessage

    <!-- Login Modal -->
    <div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning-subtle">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Sign In</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <% if $CurrentUser %>
                        <div class="text-center">
                            <p class="">You're logged in as $CurrentUser.FirstName $CurrentUser.Surname</p>
                            <a href="account" class="">View Profile</a>
                            <hr>
                            <p class="">Do you wish to logout?</p>
                            <a href="$Link('logout')" class="btn btn-secondary">Logout</a>
                        </div>
                    <% else %>
                        <form method="POST" action="$Link('login')">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" name="Email" aria-describedby="emailHelp" required>
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember-me">
                                <label class="form-check-label" for="exampleCheck1">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-warning">Submit</button>
                        </form>
                    

                    <%-- <div class="login-option text-center">
                        <p>Or</p>
                        <div class="d-grid gap-2 col-10 mx-auto">
                            <a href="$Link('GoogleAuthController/login')" class="btn btn-outline-secondary"><i class="bi bi-google me-2"></i>Continue with Google</a>
                            <a href="#!" class="btn btn-primary"><i class="bi bi-facebook me-2"></i>Continue with Facebook</a>
                        </div>
                    </div> --%>

                    <div class="sign-up text-center pt-3">
                        <p>Don't have an account?</p>
                        <a href="#signup" data-bs-toggle="modal">Sign Up</a>
                    </div>
                    <% end_if %>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="signup" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning-subtle">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Sign Up</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="$Link('doSignUp')">
                        <div class="mb-3">
                            <label for="exampleInputName1" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="exampleInputName1" name="Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" name="Email" aria-describedby="emailHelp" required>
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPhoneNumber" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="exampleInputPhoneNumber" name="PhoneNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword2" name="confirmPassword" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Submit</button>
                    </form>

                    <div class="sign-up text-center pt-3">
                        <p>Don't have an account?</p>
                        <a href="#login" data-bs-toggle="modal">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    $Layout

    <% include Footer %>

     <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastElementList = [].slice.call(document.querySelectorAll('.toast'))
            const toastList = toastElementList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl, { delay: 5000 });
            });
            toastList.forEach(function(toast) {
                toast.show();
                // Hide the toast after 5 seconds
                setTimeout(function() {
                    toast.hide();
                }, 5000);
            });

            function payWithPaystack() {
                var handler = PaystackPop.setup({
                    key: '$PublicKey',
                    email: document.getElementById('email').value,
                    amount: document.getElementById('amount').value,
                    currency: 'GHS',
                    ref: document.getElementById('reference').value,
                    channels: ['card', 'bank', 'ussd', 'qr', 'mobile_money', 'bank_transfer'],
                    callback: function(response) {
                        window.location.href = '$CallbackUrl?reference=' + response.reference;
                    },
                    onClose: function() {
                        alert('Transaction was not completed, window closed.');
                    }
                });
                handler.openIframe();
            }

            // Attach payWithPaystack function to the Pay Now button in the modal
            document.querySelector('#paymentForm button').addEventListener('click', payWithPaystack);

        });
    </script>
</body>
</html>