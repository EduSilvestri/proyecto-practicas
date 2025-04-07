@extends('layouts.app')

@section('content')
    
    <!-- Componente Livewire -->
    @livewire('ticket-show', ['ticket' => $ticket])


@endsection
