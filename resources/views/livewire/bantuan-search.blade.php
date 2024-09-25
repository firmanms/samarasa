<div>
    <input type="text" wire:model="search" placeholder="Search...">
    <p>Current Search: {{ $search }}</p>

    @if(!empty($results))
        <ul>
            @foreach($results as $result)
                <li>{{ $result->id }}</li>
            @endforeach
        </ul>
    @else
        <p>No results found.</p>
    @endif
</div>
