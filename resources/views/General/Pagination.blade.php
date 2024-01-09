@include('Layouts.BaseCssLink')
@include('Layouts.BaseJsLink')

@yield('BaseCssLink')

<!-- Pagination #01 -->
@if ($result->lastPage() > 1)
    <nav aria-label="Page Navigation">
        <ul class="list-inline text-center">
            <li class="list-inline-item {{ ($result->currentPage() == 1) ? ' u-pagination-v1__item--disabled' : '' }} g-my-5">
                <a class="u-pagination-v1__item u-pagination-v1-1 g-pa-12-21"
                   href="{{ $result->url(1) }}" aria-label="Previous">
                    <span aria-hidden="true">
                      <i class="fa fa-angle-double-left"></i>
                    </span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="list-inline-item {{ ($result->currentPage() == 1) ? ' u-pagination-v1__item--disabled' : '' }} g-my-5">
                <a class="u-pagination-v1__item u-pagination-v1-1 g-pa-12-21"
                   href="{{ $result->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">
                      <i class="fa fa-angle-left"></i>
                    </span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            @for ($i = 1; $i <= $result->lastPage(); $i++)
                <li class="list-inline-item hidden-sm-down ">
                    <a class="u-pagination-v1__item u-pagination-v1-1 g-pa-12-19 {{ ($result->currentPage() == $i) ? ' u-pagination-v1-1--active' : '' }} g-my-5"
                       href="{{ $result->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="list-inline-item {{ ($result->currentPage() == $result->lastPage()) ? ' u-pagination-v1__item--disabled' : '' }} g-my-5">
                <a class="u-pagination-v1__item u-pagination-v1-1 g-pa-12-21" href="{{ $result->nextPageUrl() }}"
                   aria-label="Next">
                    <span aria-hidden="true">
                       <i class="fa fa-angle-right"></i>
                    </span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            <li class="list-inline-item {{ ($result->currentPage() == $result->lastPage()) ? ' u-pagination-v1__item--disabled' : '' }} g-my-5">
                <span style="display: none">{{ $lastPage = $result->lastPage() }}</span>
                <a class="u-pagination-v1__item u-pagination-v1-1 g-pa-12-21" href="{{ $result->url($lastPage) }}"
                   aria-label="Next">
                    <span aria-hidden="true">
                       <i class="fa fa-angle-double-right"></i>
                    </span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            <br>
            <li class="list-inline-item g-my-5">
                <span style="direction: rtl" class="u-pagination-v1__item-info g-pa-12-19">صفحه {{ $result->currentPage() }} از {{ $result->lastPage() }}</span>
            </li>
        </ul>
    </nav>
@endif
<!-- End Pagination #01 -->
@yield('JavaScriptLinks')
