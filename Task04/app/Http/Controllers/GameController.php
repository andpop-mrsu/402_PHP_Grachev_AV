<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GameController extends Controller
{
    public function index(): View
    {
        $games = Game::latest()->paginate(10);
        return view('game.index', compact('games'));
    }

    public function show(Game $game): View
    {
        $steps = $game->steps()->orderBy('step_number')->get();
        return view('game.show', compact('game', 'steps'));
    }

    public function create(): View
    {
        return view('game.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'player_name' => 'required|string|max:255',
        ]);

        $game = Game::createNewGame($validated['player_name']);

        return redirect()->route('game.play', $game->id);
    }

    public function play(Game $game): View|RedirectResponse
    {
        if ($game->status !== 'in_progress') {
            return redirect()->route('game.show', $game->id);
        }

        $stepNumber = $game->steps()->count() + 1;
        return view('game.play', compact('game', 'stepNumber'));
    }

    public function makeStep(Request $request, Game $game): RedirectResponse
    {
        if ($game->status !== 'in_progress') {
            return redirect()->route('game.show', $game->id);
        }

        $validated = $request->validate([
            'answer' => 'required|integer',
        ]);

        $stepNumber = $game->steps()->count() + 1;
        $isCorrect = (int) $validated['answer'] === $game->missing_value;

        Step::create([
            'game_id'     => $game->id,
            'step_number' => $stepNumber,
            'answer'      => $validated['answer'],
            'is_correct'  => $isCorrect,
        ]);

        if ($isCorrect) {
            $game->update(['status' => 'won', 'finished_at' => now()]);
            return redirect()->route('game.show', $game->id)
                ->with('success', 'Поздравляем! Вы угадали!');
        }

        if ($stepNumber >= 3) {
            $game->update(['status' => 'lost', 'finished_at' => now()]);
            return redirect()->route('game.show', $game->id)
                ->with('error', 'Игра окончена. Правильный ответ: ' . $game->missing_value);
        }

        return redirect()->route('game.play', $game->id)
            ->with('wrong', 'Неверно! Попробуйте ещё раз.');
    }
}
