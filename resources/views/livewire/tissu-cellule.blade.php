<div>
    {{-- <input type="text" wire:model.debounce.300ms="search" placeholder="Search..." /> --}}
    <div>
        <h1>{{ $message }}</h1>
    </div>
    @if (isset($results))
        <ul>
            @foreach ($results as $result)
                <li>{{ $result->designation }}</li> <!-- Adjust to your column -->
            @endforeach
        </ul>
    @endif
</div>
