<div class="col-lg-3 acc-side-bar">
    <div class="d-flex profile mb-4">
        <i class="bi fs-3 me-3 bi-person-workspace"></i>
        <div>
            <div class="name">$CurrentUser.FirstName $CurrentUser.Surname</div>
            <div class="email">$CurrentUser.Email</div>
        </div>
    </div>
    <hr>
    <div class="flex-column">
        <a class="nav-link mb-3" href="account"><i class="bi fs-5 me-2 bi-person-fill-gear"></i>Accout Details</a>
        <a class="nav-link mb-3" href="account/orders"><i class="bi fs-5 me-2 bi-clipboard-check"></i>Order History</a>
        <a class="nav-link" href="$Link('logout')"><i class="bi fs-5 me-2 bi-box-arrow-right"></i>Sign-Out</a>
    </div>
</div>
<div class="col-lg-3 acc-dropd">
    <div class="dropdown-start">
        <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi fs-5 me-2 text-white bi-list"></i>Dashboard Navigation
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="account"><i class="bi fs-5 me-2 bi-person-fill-gear"></i>Accout Details</a></li>
            <li><a class="dropdown-item" href="account/orders"><i class="bi fs-5 me-2 bi-clipboard-check"></i>Order History</a></li>
            <li><a class="dropdown-item" href="$Link('logout')"><i class="bi fs-5 me-2 bi-box-arrow-right"></i>Sign-Out</a></li>
        </ul>
    </div>
</div>