@extends('layout')

@section('title', 'Арифметическая прогрессия - Главная')

@section('content')
<header>
    <h1>🎮 Арифметическая прогрессия</h1>
    <p class="subtitle">Угадайте пропущенное число в последовательности</p>
</header>

<div style="text-align: center; margin-bottom: 30px;">
    <a href="{{ route('game.create') }}" class="btn btn-primary" style="font-size: 1.2em; padding: 15px 40px;">
        ➕ Начать новую игру
    </a>
</div>

@if($games->count() > 0)
    <h2 style="margin-top: 40px; color: #333; margin-bottom: 20px;">Последние игры</h2>
    <div class="game-list">
        @foreach($games as $game)
            <div class="game-item">
                <div class="game-item-header">
                    <div>
                        <div class="player-name">👤 {{ $game->player_name }}</div>
                        <div class="game-date">{{ $game->started_at->format('d.m.Y H:i') }}</div>
                    </div>
                    <span class="status status-{{ $game->status }}">
                        @if($game->status === 'won')
                            ✓ Победа
                        @elseif($game->status === 'lost')
                            ✗ Проигрыш
                        @else
                            ⏳ В процессе
                        @endif
                    </span>
                </div>
                <a href="{{ route('game.show', $game->id) }}" class="btn btn-secondary btn-view">Подробнее</a>
            </div>
        @endforeach
    </div>

    @if($games->hasPages())
        <div class="pagination">
            {{ $games->links() }}
        </div>
    @endif
@else
    <div style="text-align: center; padding: 40px; color: #999;">
        <p style="font-size: 1.1em;">Пока нет сыгранных игр</p>
        <p style="margin-top: 10px;">Начните первую игру прямо сейчас!</p>
    </div>
@endif
@endsection
