<input id="busca" name="busca" type="text" class="form-control" placeholder="Pesquise" aria-label="Pesquise" wire:model="search" wire:offline.attr="disabled">
@error('search') <span class="error">{{ $message }}</span> @enderror
<div class="input-group-append">
	<button id="search" class="btn btn-outline-secondary" type="button" wire:offline.attr="disabled">Buscar</button>
</div>