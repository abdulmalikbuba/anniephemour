<!-- main -->
<div class="serv-page mb-5">
    <div class="banner">
    <div class="overlay">
        <div class="wrapper">
        <h2>$Title</h2>
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="$BaseHref">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">$Title</li>
            </ol>
        </nav>
        </div>
    </div>
    </div>

    <div class="container">
    <% loop $Episodes %>
    <div class="podcast-episode">
        <h3>$Title</h3>
        <p>$ReleaseDate.Nice</p>
        <p>$Description</p>
        <audio controls>
            <source src="$AudioFile.URL" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
    <% end_loop %>
    </div>

</div>
<!-- main -->