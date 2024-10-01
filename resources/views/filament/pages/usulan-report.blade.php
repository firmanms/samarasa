<x-filament-panels::page>

<form wire:submit.prevent="submit">
    {{ $this->form }}
<br>
    <x-filament::button type="submit" class="mt-4">
        Download Laporan
    </x-filament::button>
</form>

</x-filament-panels::page>
