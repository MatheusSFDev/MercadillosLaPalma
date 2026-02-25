@extends('layouts.app')

@section('content')
    <livewire:public.stall-list :fleaMarketId="$fleaMarketId" />
@endsection