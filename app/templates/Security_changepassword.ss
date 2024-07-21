<!DOCTYPE html>
<html lang="$ContentLocale">

<head>
    <% base_tag %>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    $MetaTags(false)
    <title>$SiteConfig.Title &raquo; <% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %></title>
    <link rel="stylesheet" href="$resourceURL('app/css/style.css')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-warning-subtle py-3 ">

    <!-- change password -->
    <div class="login-section wow zoomIn ">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-7 col-sm-12 mx-auto">
                    <div class="head mb-3 g-2">
                        <h4>Change your password</h4>
                        <small>You can change your password below.</small>
                    </div>
                    $Form
                </div>
            </div>
        </div>
    </div>
    <!-- change password end -->

</body>


    <script src="$resourceURL('app/javascript/script.js')"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://kit.fontawesome.com/d086f209ed.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>
