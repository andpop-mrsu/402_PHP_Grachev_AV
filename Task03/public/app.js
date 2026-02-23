const API_BASE = "";

const state = {
  currentGame: null,
};

const elements = {
  newGameForm: document.getElementById("new-game-form"),
  playerName: document.getElementById("player-name"),
  currentGame: document.getElementById("current-game"),
  currentPlayer: document.getElementById("current-player"),
  currentProgression: document.getElementById("current-progression"),
  stepForm: document.getElementById("step-form"),
  answer: document.getElementById("answer"),
  stepResult: document.getElementById("step-result"),
  gamesList: document.getElementById("games-list"),
  stepsView: document.getElementById("steps-view"),
  refreshHistory: document.getElementById("refresh-history"),
  error: document.getElementById("error"),
};

async function api(path, options = {}) {
  const response = await fetch(`${API_BASE}${path}`, {
    headers: { "Content-Type": "application/json" },
    ...options,
  });

  const payload = await response.json().catch(() => ({}));
  if (!response.ok) {
    throw new Error(payload.error || `HTTP ${response.status}`);
  }

  return payload;
}

function setError(message) {
  elements.error.textContent = message || "";
}

function renderCurrentGame(game) {
  state.currentGame = game;
  elements.currentPlayer.textContent = game.player_name;
  elements.currentProgression.textContent = game.shown_progression;
  elements.stepResult.textContent = "";
  elements.currentGame.classList.remove("hidden");
}

function renderGames(games) {
  elements.gamesList.innerHTML = "";

  if (!games.length) {
    const li = document.createElement("li");
    li.textContent = "Игр пока нет";
    elements.gamesList.append(li);
    return;
  }

  games.forEach((game) => {
    const li = document.createElement("li");
    const btn = document.createElement("button");
    const status = game.status === "won" ? "победа" : "в процессе";
    btn.type = "button";
    btn.textContent = `#${game.id} | ${game.player_name} | ${game.started_at} | ${status}`;
    btn.addEventListener("click", () => loadGameSteps(game.id));
    li.append(btn);
    elements.gamesList.append(li);
  });
}

async function loadGames() {
  const data = await api("/games");
  renderGames(data.games || []);
}

async function loadGameSteps(gameId) {
  const data = await api(`/games/${gameId}`);
  const lines = [];
  lines.push(`Игра #${data.id}`);
  lines.push(`Ходы: ${data.steps.length}`);

  data.steps.forEach((step) => {
    lines.push(`- [${step.step_number}] ответ=${step.answer}, результат=${step.is_correct ? "верно" : "неверно"}, время=${step.created_at}`);
  });

  elements.stepsView.textContent = lines.join("\n");
}

elements.newGameForm.addEventListener("submit", async (event) => {
  event.preventDefault();
  setError("");

  try {
    const playerName = elements.playerName.value.trim();
    if (!playerName) {
      throw new Error("Введите имя игрока");
    }

    const data = await api("/games", {
      method: "POST",
      body: JSON.stringify({ player_name: playerName }),
    });

    const listData = await api("/games");
    renderGames(listData.games || []);
    const createdGame = (listData.games || []).find((game) => Number(game.id) === Number(data.id));
    if (createdGame) {
      renderCurrentGame(createdGame);
    }
    elements.answer.value = "";
  } catch (error) {
    setError(error.message);
  }
});

elements.stepForm.addEventListener("submit", async (event) => {
  event.preventDefault();
  setError("");

  if (!state.currentGame) {
    setError("Сначала начните игру");
    return;
  }

  try {
    const answer = elements.answer.value.trim();
    if (answer === "") {
      throw new Error("Введите ответ");
    }

    const data = await api(`/step/${state.currentGame.id}`, {
      method: "POST",
      body: JSON.stringify({ answer }),
    });

    const resultText = data.step.is_correct
      ? `Верно. Пропущенное число: ${data.game.missing_value}`
      : `Неверно. Попробуйте снова.`;

    elements.stepResult.textContent = resultText;

    state.currentGame = data.game;
    await loadGames();
    await loadGameSteps(state.currentGame.id);
    elements.answer.value = "";
  } catch (error) {
    setError(error.message);
  }
});

elements.refreshHistory.addEventListener("click", async () => {
  setError("");
  try {
    await loadGames();
  } catch (error) {
    setError(error.message);
  }
});

(async function init() {
  try {
    await loadGames();
  } catch (error) {
    setError(error.message);
  }
})();
