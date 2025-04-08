@extends('layouts.app')

@section('content')
    
    <!-- Componente Livewire -->
    @livewire('ticket-show', ['ticketId' => $ticket->id])


@endsection
