@extends('layouts.app')

@section('title', 'Home')

@section('content')
  <style>
    /* Estilos para la sección principal */
    .hero-home {
      background-color: #efe300; 
      min-height: 100vh;         
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .hero-home img {
      margin-bottom: 20px;
      height: 100px;
    }
    .hero-home h1 {
      font-size: 3rem;
      text-align: center;
      color: #202617;
    }
  </style>

  <!-- Sección principal con logo y título -->
  <div class="hero-home">
    <img src="{{ asset('img/logo_negro.png') }}" alt="Logo">
    <h1>Bienvenido a Lujo Network</h1>
  </div>

  <!-- Componente Livewire: Formulario flotante -->
  @livewire('home-ticket-form')
@endsection




