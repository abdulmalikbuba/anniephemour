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
                    <ul class="nav nav-underline" id="myTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="pill" href="#profile">Profile Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="pill" href="#password">Password</a>
                        </li>
                    </ul>

                    <div class="tab-content account-tab-content mt-3">
                        <div class="tab-pane container active" id="profile">
                            <div class="col-lg-12">
                            <% with $CurrentUser %>
                                <form class="row g-3" action="account/updateProfile" method="post">
                                    <div class="col-md-6">
                                        <label for="inputFirstName" class="form-label">First Name</label>
                                        <input type="text" value="$FirstName" name="FirstName" class="form-control" id="inputFirstName" placeholder="Enter your first name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputSurname" class="form-label">Last Name</label>
                                        <input type="text" value="$Surname" name="Surname" class="form-control" id="inputSurname" placeholder="Enter your surname">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputEmail4" class="form-label">Email</label>
                                        <input type="email" value="$Email" name="Email" class="form-control" id="inputEmail4" placeholder="Enter your email" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputPhoneNumber" class="form-label">Phone Number</label>
                                        <input type="tel" value="$PhoneNumber" name="PhoneNumber" class="form-control" id="inputPhoneNumber" placeholder="Enter your phone number">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="inputAddress" class="form-label">Address</label>
                                        <input type="text" value="$Address" name="Address" class="form-control" id="inputAddress" placeholder="Enter your address">
                                    </div>
                                    
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            <% end_with %>

                            </div>
                        </div>

                        <div class="tab-pane container" id="password">
                            <div class="col-lg-12">
                                <form class="row g-3" action="account/changePassword" method="post">
                                    <div class="col-md-12">
                                        <label for="inputPassword4" class="form-label">Current Password</label>
                                        <input type="password" name="CurrentPassword" class="form-control" id="inputPassword4">
                                        </div>
                                        <div class="col-md-12">
                                        <label for="inputPassword4" class="form-label">New Password</label>
                                        <input type="password" name="NewPassword" class="form-control" id="inputPassword4">
                                        </div>
                                        <div class="col-md-12">
                                        <label for="inputPassword4" class="form-label">Confirm Password</label>
                                        <input type="password" name="ConfirmPassword" class="form-control" id="inputPassword4">
                                        </div>
                                    
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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