<!-- main -->
<div class="serv-page">
    <div class="banner">
    <div class="overlay">
        <div class="wrapper">
        <h2 class="wow fadeInDown">$Title</h2>
        <nav class="wow fadeInUp" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="$BaseHref">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">$Title</li>
            </ol>
        </nav>
        </div>
    </div>
    </div>

    <div class="container my-5">
        <div class="row">
        <%-- <% loop $BookReadingEvents %>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="book-club-card wow fadeInUp">
                    <% if $Flyer %>
                    <img src="$Flyer.URL" class="" alt="...">
                    <% end_if %>
                    <div class="card-body">
                        <h5 class="title mt-1">$Title.LimitWordCount(4, '...')</h5>
                        <p class="text">$Description.LimitWordCount(10, '...')</p>
                        <a href="$Link" class="btn btn-sm btn-warning">Read More</a>
                    </div>
                  </div>
            </div>
        <% end_loop %> --%>
        <div class="alert alert-warning text-center" role="alert">
            Sorry.. No book clubs available yet!
        </div>
        </div>

        <% with $BookReadingEvents %>
            <% include Pagination %>    
        <% end_with %>
    </div>


</div>
<!-- main -->