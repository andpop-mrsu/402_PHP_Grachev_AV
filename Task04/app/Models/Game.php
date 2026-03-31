<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $table = 'games';

    protected $fillable = [
        'player_name',
        'finished_at',
        'shown_progression',
        'full_progression',
        'missing_index',
        'missing_value',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'missing_index' => 'integer',
        'missing_value' => 'integer',
    ];

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }

    public static function createNewGame(string $playerName): self
    {
        $progression = self::generateProgression();

        return self::create([
            'player_name' => $playerName,
            'shown_progression' => $progression['shown'],
            'full_progression' => $progression['full'],
            'missing_index' => $progression['missing_index'],
            'missing_value' => $progression['missing_value'],
            'status' => 'in_progress',
        ]);
    }

    private static function generateProgression(): array
    {
        $length = 10;
        $start = random_int(1, 20);
        $step = random_int(1, 10);
        $progression = [];

        for ($i = 0; $i < $length; $i++) {
            $progression[] = $start + $step * $i;
        }

        $missingIndex = random_int(0, $length - 1);
        $missingValue = $progression[$missingIndex];

        $shown = $progression;
        $shown[$missingIndex] = '..';

        return [
            'shown' => implode(' ', $shown),
            'full' => implode(' ', $progression),
            'missing_index' => $missingIndex,
            'missing_value' => $missingValue,
        ];
    }
}
