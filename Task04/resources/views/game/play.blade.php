@extends('layout')

@section('title', 'Играем - Арифметическая прогрессия')

@section('content')
<header>
    <h1>🎮 Игра в процессе</h1>
    <p class="subtitle">Игрок: <strong>{{ $game->player_name }}</strong></p>
</header>

@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('wrong'))
    <div class="alert alert-error">{{ session('wrong') }}</div>
@endif

<div class="step-info">
    <strong>Попытка {{ $stepNumber }} из 3</strong>
</div>

<p style="text-align: center; font-size: 0.95em; color: #666; margin-bottom: 20px;">
    Найдите пропущенное число в последовательности:
</p>

<div class="progression">
    {{ $game->shown_progression }}
</div>

<form action="{{ route('game.step', $game->id) }}" method="POST">
    @csrf
    <div>
        <input
            type="number"
            name="answer"
            placeholder="Введите число"
            required
            autofocus
        >
        @error('answer')
            <span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>
        @enderror
    </div>

    <div class="btn-group">
        <button type="submit" class="btn btn-primary">✓ Проверить ответ</button>
        <a href="{{ route('game.index') }}" class="btn btn-secondary" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">← Вернуться</a>
    </div>
</form>

@if($game->steps->count() > 0)
    <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #eee;">
        <h3 style="color: #333; margin-bottom: 15px;">Предыдущие попытки:</h3>
        @foreach($game->steps as $step)
            <div style="padding: 10px; background: {{ $step->is_correct ? '#d4edda' : '#f8d7da' }}; border-radius: 5px; margin-bottom: 10px;">
                <strong>Попытка {{ $step->step_number }}:</strong> {{ $step->answer }}
                <span style="margin-left: 20px; font-weight: bold;">{{ $step->is_correct ? '✓ Верно!' : '✗ Неправильно' }}</span>
            </div>
        @endforeach
    </div>
@endif
@endsection
