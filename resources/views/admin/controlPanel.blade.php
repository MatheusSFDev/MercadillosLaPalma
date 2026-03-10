@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    @livewire('admin.market-manager', ['selectedFleaMarketId' => $fleaMarket->id, 'tab' => session('tab', 'stalls')])
</div>
@endsection