@props(['items' => []])

@if (count($items) > 0)
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent mb-0">
            @foreach ($items as $index => $item)
                @php
                    $isLast = $index === count($items) - 1;
                    $label = is_array($item) ? $item[0] : $item;
                    $url = is_array($item) && isset($item[1]) ? $item[1] : '#';
                @endphp

                <li class="breadcrumb-item {{ $isLast ? 'active' : '' }}" {{ $isLast ? 'aria-current=page' : '' }}>
                    @if ($isLast)
                        <span class="text-light">{{ $label }}</span>
                    @else
                        <a href="{{ $url }}" class="text-decoration-none text-primary">
                            {{ $label }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
<style>
    .breadcrumb a:hover {
        text-decoration: underline;
    }
</style>
