@php
/** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */
@endphp
<div class="row align-items-center">
    <div class="col-12">
        <ul class="pagination pagination-sm m-0">
            <li class="page-item">
                @if($paginator->currentPage() != 1)
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">«</a>
                @else
                    <span class="page-link">
                        <span rel="prev">«</span>
                    </span>
                @endif
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                @php
                $halfTotalLinks = 5;
                $from = $paginator->currentPage() - $halfTotalLinks;
                $to = $paginator->currentPage() + $halfTotalLinks;
                if ($paginator->currentPage() < $halfTotalLinks) {
                    $to += $halfTotalLinks - $paginator->currentPage();
                }
                if ($paginator->lastPage() - $paginator->currentPage() < $halfTotalLinks) {
                    $from -= $halfTotalLinks - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                }
                @endphp
                @if ($from < $i && $i < $to)
                    <li class="page-item{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                        @if(($paginator->currentPage() == $i))
                            <span class="page-link">
                                <span>{{ $i }}</span>
                            </span>
                        @else
                        <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                        @endif
                    </li>
                @endif
            @endfor
            <li class="page-item">
                @if($paginator->lastPage() != $paginator->currentPage())
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">»</a>
                @else
                    <span class="page-link">
                        <span rel="prev">»</span>
                    </span>
                @endif
            </li>
        </ul>
    </div>
    <div class="col-sm-2">
        Всего записей <strong>{{ $paginator->total() }}</strong>
    </div>
</div>
