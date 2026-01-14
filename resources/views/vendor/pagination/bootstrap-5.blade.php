@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination" style="gap: 8px; margin: 0;">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border: none; border-radius: 6px; font-size: 13px; cursor: not-allowed;">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="padding: 8px 12px; background: #00d9a3; color: white; border: none; border-radius: 6px; font-size: 13px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#1aa573'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#00d9a3'; this.style.transform='translateY(0)';">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="padding: 8px 12px; background: #00d9a3; color: white; border: none; border-radius: 6px; font-size: 13px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#1aa573'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#00d9a3'; this.style.transform='translateY(0)';">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border: none; border-radius: 6px; font-size: 13px; cursor: not-allowed;">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div>
                <p class="small text-muted" style="font-size: 13px; color: #666;">
                    {!! __('Showing') !!}
                    <span class="fw-semibold" style="color: #00d9a3;">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="fw-semibold" style="color: #00d9a3;">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="fw-semibold" style="color: #00d9a3;">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <ul class="pagination" style="gap: 5px; margin: 0;">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')" style="display: none;">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item" style="display: none;">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link" style="padding: 6px 8px; font-size: 12px; border: none;">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link" style="padding: 6px 10px; background: linear-gradient(135deg, #00d9a3 0%, #1aa573 100%); color: white; border: none; border-radius: 5px; font-size: 12px; min-width: 35px; text-align: center;">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}" style="padding: 6px 10px; background: #f0fdfb; color: #00d9a3; border: 1px solid #d1fae5; border-radius: 5px; font-size: 12px; min-width: 35px; text-align: center; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#00d9a3'; this.style.color='white'; this.style.borderColor='#00d9a3'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#f0fdfb'; this.style.color='#00d9a3'; this.style.borderColor='#d1fae5'; this.style.transform='translateY(0)';">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item" style="display: none;">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')" style="display: none;">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
