@if($enabled)
    <div id="{{ $nameFieldName }}_wrap" @if($withCsp) @cspNonce @endif style="display: none" aria-hidden="true">
        <input id="{{ $nameFieldName }}"
               name="{{ $nameFieldName }}"
               type="text"
               value=""
               @if ($livewireModel ?? false) wire:model.defer="{{ $livewireModel }}.{{ $unrandomizedNameFieldName }}" @endif
               autocomplete="nope"
               tabindex="-1">
        <input name="{{ $validFromFieldName }}"
               type="text"
               value="{{ $encryptedValidFrom }}"
               @if ($livewireModel ?? false) wire:model.defer="{{ $livewireModel }}.{{ $validFromFieldName }}" @endif
               autocomplete="off"
               tabindex="-1">
    </div>
@endif
