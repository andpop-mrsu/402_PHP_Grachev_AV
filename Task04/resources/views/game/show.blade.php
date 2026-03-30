@extends('layout')

@section('title', 'Результаты - Арифметическая прогрессия')

@section('content')
<header>
    <h1>@if($game->status === 'won') 🎉 Поздравляем! @else 😢 Игра завершена @endif</h1>
    <p class="subtitle">Игрок: <strong>{{ $game->player_name }}</strong></p>
</header>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

<div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
    <div style="text-align: center; margin-bottom: 20px;">
        @if($game->status === 'won')
            <h2 style="color: #28a745; font-size: 1.8em;">✓ ВЫ ВЫИГРАЛИ!</h2>
        @else
            <h2 style="color: #dc3545; font-size: 1.8em;">✗ ВЫ ПРОИГРАЛИ</h2>
        @endif
    </div>

    <div style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
        <p style="color: #666; margin-bottom: 10px;"><strong>Последовательность:</strong></p>
        <div class="progression" style="border-color: #999;">
            {{ $game->full_progression }}
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px;">
        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center; border: 1px solid #ddd;">
            <p style="color: #666; font-size: 0.9em;">Пропущенное число:</p>
            <p style="font-size: 1.8em; font-weight: bold; color: #667eea;">{{ $game->missing_value }}</p>
        </div>
        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center; border: 1px solid #ddd;">
            <p style="color: #666; font-size: 0.9em;">Попыток использовано:</p>
            <p style="font-size: 1.8em; font-weight: bold; color: #ff6b6b;">{{ count($steps) }} / 3</p>
        </div>
    </div>
</div>

@if(count($steps) > 0)
    <h3 style="color: #333; margin-bottom: 15px;">История попыток:</h3>
    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 30px;">
        @foreach($steps as $step)
            <div style="padding: 12px; background: white; border-left: 4px solid {{ $step->is_correct ? '#28a745' : '#dc3545' }}; margin-bottom: 10px; border-radius: 5px;">
                <strong>Попытка {{ $step->step_number }}:</strong> 
                <span style="font-size: 1.1em; font-weight: bold;">{{ $step->answer }}</span>
                <span style="margin-left: 20px;">
                    @if($step->is_correct)
                        <span style="color: #28a745;">✓ Правильно!</span>
                    @else
                        <span style="color: #dc3545;">✗ Неправильно</span>
                    @endif
                </span>
            </div>
        @endforeach
    </div>
@endif

<div class="btn-group">
    <a href="{{ route('game.create') }}" class="btn btn-primary">➕ Новая игра</a>
    <a href="{{ route('game.index') }}" class="btn btn-secondary">🏠 Главная</a>
</div>
@endsection
