@if($paginator->hasPages())
<div class="row d-flex justify-content-between bg-warning" style="list-style-type: none;">
    <div class="col bg-success">
        @if ($paginator->onFirstPage())
        Prev
        @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="next">Prev</a>
        @endif
    </div>
    @foreach ($elements as $element)
    <div class="col bg-danger">
        <div class="row justify-content-center">
            @if (is_string($element))
            <div class="mx-5">
                1
            </div>
            @endif
            @if (is_array($element))
            @foreach ($element as $page =>$url)
            @if ($page == $paginator->currentPage())
            <div class="mx-5">
                {{$page}}
            </div>
            @else
            <div class="mx-5">
                <a href="{{$url}}">
                    {{$page}}
                </a>
            </div>
            @endif
            @endforeach
            @endif
        </div>
    </div>
    @endforeach
    <div class="col bg-primary">
        @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
        @else
        Next
        @endif
    </div>
</div>
@endif