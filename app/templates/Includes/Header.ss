<!-- header -->
<nav class="navbar navbar-expand-lg">
	<div class="container">
		<a class="navbar-brand" href="$BaseHref">Annie Phemour</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
		<ul class="navbar-nav ms-auto">
			<li class="nav-item">
			<a class="nav-link" href="$BaseHref">Home</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="$BaseHref#about">About Us</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="$BaseHref/books">Books</a>
			</li>
			<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				Services
			</a>
			<ul class="dropdown-menu rounded-0">
				<li><a class="dropdown-item" href="services/book-club">Book Club</a></li>
				<li><a class="dropdown-item" href="services/podcast">Podcast</a></li>
				<li><a class="dropdown-item" href="services/fanzone">Fan Zone</a></li>
				<li><a class="dropdown-item" href="services/short-stories">Short Stories</a></li>
			</ul>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="contact-us">Contact Us</a>
			</li>
			
			<% if $CurrentUser %>
				<li class="nav-item ms-5">
					<a class="btn btn-sm mb-1 position-relative" href="cart">
						<i class="bi fs-4 bi-cart-check"></i>
						<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
							$CartItemCount
							<span class="visually-hidden">cart items</span>
						</span>
					</a>
				</li>
			<% end_if %>

			<li class="nav-item">
				<% if $CurrentUser %>
					<a class="rounded-0 btn btn-sm ms-3 mb-1 user-btn" data-bs-toggle="modal" data-bs-target="#login"><i class="bi fs-4 bi-person"></i></a>
				<% else %>
					<a class="rounded-0 btn btn-warning" data-bs-toggle="modal" data-bs-target="#login">Login</a>
				<% end_if %>
			</li>
		</ul>
		</div>
	</div>
</nav>
<!-- header -->