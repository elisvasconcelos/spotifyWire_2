<div wire:init="search">
	<ul>
	    @foreach($musicas as $item)
	        <li><a href='{{ $item->external_urls->spotify }}'>{{ $item->name }}</a></li>
	        <li>
	    	@foreach($item->artists as $artist)
	        	{{ $artist->name }}
			@endforeach
	        </li>
	    @endforeach
	</ul>
</div>