<!-- main -->
<div class="serv-page mb-5">
    <div class="banner">
        <div class="overlay">
            <div class="wrapper">
                <h2 class="wow fadeInDown">Book Club</h2>
                <nav class="wow fadeInUp" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="$BaseHref">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">$BookClubDetail.Title</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container mt-5 ">
        <div class="row">
        <% with $BookClubDetail %>
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="book-club-card-det wow fadeInUp">
                    
                    <% if $Flyer %>
                        <img src="$Flyer.URL" class="detail-image" alt="...">
                    <% end_if %>
                    <h3 class="mt-4 text-uppercase">$Title</h3>
                    <p class="text-secondary"><i class="bi me-2 bi-calendar-week"></i>$Date.Nice</p>
                    <p class="text mt-4">$Description</p>   
                    <div class="row mb-5"> 
                        <% if $Pictures %>
                            <% loop $Pictures %>
                            <div class="col-lg-4">
                                <% if $Image %>
                                    <div class="event-picture">
                                        <img src="$Image.URL" alt="Event Picture" />
                                    </div>
                                <% end_if %>
                            </div>
                            <% end_loop %>
                        <% end_if %>
                    </div>
                    
                    <a href="javascript: history.go(-1)" ><i class="bi me-2 bi-arrow-bar-left"></i>Back</a>
                  </div>
            </div>
        <% end_with %>
        </div>
    </div>

</div>
<!-- main -->