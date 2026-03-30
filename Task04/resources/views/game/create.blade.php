@extends('layout')

@section('title', 'Новая игра')

@section('content')
<header>
    <h1>Новая игра</h1>
    <p class="subtitle">Введите ваше имя для начала</p>
</header>

<form action="{{ route('game.store') }}" method="POST">
    @csrf
    <div>
        <input 
            type="text" 
            name="player_name" 
            placeholder="Введите ваше имя" 
            required 
            autofocus
            maxlength="255"
            value="{{ old('player_name') }}"
        >
        @error('player_name')
            <span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>
        @enderror
    </div>
    
    <button type="submit" class="btn btn-primary">Начать игру</button>
</form>

<div style="text-align: center; margin-top: 20px;">
    <a href="{{ route('game.index') }}" class="btn btn-secondary">← Вернуться</a>
</div>
@endsection
