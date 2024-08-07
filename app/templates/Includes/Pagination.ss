<% if $MoreThanOnePage %>
<nav aria-label="Page navigation example" class="py-3  wow zoomIn" data-wow-delay="0.3s">
  <ul class="pagination justify-content-center">
    <% if $NotFirstPage %>
    <li class="page-item">
      <a class="page-link" href="$PrevLink" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <% end_if %>

    <% loop $PaginationSummary %>
    <% if $Link %>
    <li class="page-item">
      <a class="page-link" href="$Link">$PageNum</a>
    </li>
    <% end_if %>
    <% end_loop %>

    <% if $NotLastPage %>
    <li class="page-item">
      <a class="page-link" href="$NextLink" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    <% end_if %>
  </ul>
</nav>
<% end_if %>