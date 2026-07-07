<?php
?><!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Brick Pulse</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root, [data-theme="light"] {
      --font-display: 'Orbitron', 'Arial', sans-serif;
      --font-body: 'Inter', 'Arial', sans-serif;
      --text-xs: clamp(0.75rem, 0.72rem + 0.2vw, 0.875rem);
      --text-sm: clamp(0.875rem, 0.82rem + 0.3vw, 1rem);
      --text-base: clamp(1rem, 0.96rem + 0.25vw, 1.125rem);
      --text-lg: clamp(1.125rem, 1rem + 0.75vw, 1.5rem);
      --text-xl: clamp(1.5rem, 1.2rem + 1.25vw, 2.1rem);
      --text-2xl: clamp(2rem, 1.3rem + 2vw, 3rem);
      --space-1: 0.25rem; --space-2: 0.5rem; --space-3: 0.75rem; --space-4: 1rem;
      --space-5: 1.25rem; --space-6: 1.5rem; --space-8: 2rem; --space-10: 2.5rem;
      --space-12: 3rem; --space-16: 4rem;
      --color-bg: #f4f2ee;
      --color-surface: #fbfaf7;
      --color-surface-2: #f0ece7;
      --color-border: rgba(40,37,29,.12);
      --color-text: #231f18;
      --color-text-muted: #6b685f;
      --color-text-inverse: #faf7f1;
      --color-primary: #0d6867;
      --color-primary-hover: #0a5050;
      --color-danger: #a13851;
      --color-gold: #d29a17;
      --shadow-sm: 0 2px 8px rgba(29,20,10,.06);
      --shadow-md: 0 12px 30px rgba(29,20,10,.10);
      --radius-md: 0.75rem;
      --radius-lg: 1rem;
      --radius-full: 9999px;
      --transition-interactive: 180ms cubic-bezier(0.16, 1, 0.3, 1);
      --hero-glow: radial-gradient(circle at top, rgba(13,104,103,.18), transparent 45%);
    }
    [data-theme="dark"] {
      --color-bg: #151412;
      --color-surface: #1d1b18;
      --color-surface-2: #26231f;
      --color-border: rgba(255,255,255,.12);
      --color-text: #e6e1d9;
      --color-text-muted: #a7a097;
      --color-text-inverse: #171512;
      --color-primary: #66a7a7;
      --color-primary-hover: #8ebbbb;
      --color-danger: #e26d8b;
      --color-gold: #efbf56;
      --shadow-sm: 0 2px 10px rgba(0,0,0,.22);
      --shadow-md: 0 12px 30px rgba(0,0,0,.35);
      --hero-glow: radial-gradient(circle at top, rgba(102,167,167,.20), transparent 45%);
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { color-scheme: light dark; }
    body {
      min-height: 100dvh;
      background: var(--hero-glow), var(--color-bg);
      color: var(--color-text);
      font-family: var(--font-body);
      line-height: 1.5;
    }
    button, input { font: inherit; }
    a, button, input { transition: background var(--transition-interactive), color var(--transition-interactive), border-color var(--transition-interactive), transform var(--transition-interactive), box-shadow var(--transition-interactive); }
    .page { max-width: 1200px; margin: 0 auto; padding: var(--space-6) var(--space-4) var(--space-10); }
    .skip-link { position: absolute; left: -999px; top: 0; background: var(--color-primary); color: var(--color-text-inverse); padding: var(--space-2) var(--space-3); border-radius: var(--radius-md); }
    .skip-link:focus { left: var(--space-4); top: var(--space-4); }
    header {
      display: flex; justify-content: space-between; align-items: center; gap: var(--space-4);
      margin-bottom: var(--space-6);
    }
    .brand { display: flex; align-items: center; gap: var(--space-3); }
    .brand-mark { width: 42px; height: 42px; color: var(--color-primary); }
    .brand-name { font-family: var(--font-display); font-size: var(--text-lg); letter-spacing: .08em; text-transform: uppercase; }
    .theme-toggle, .btn {
      border: 1px solid var(--color-border); background: var(--color-surface); color: var(--color-text);
      border-radius: var(--radius-full); min-height: 44px; padding: 0 var(--space-4); cursor: pointer; box-shadow: var(--shadow-sm);
    }
    .theme-toggle:hover, .btn:hover { transform: translateY(-1px); }
    .hero {
      display: grid; grid-template-columns: 1.2fr .8fr; gap: var(--space-6); align-items: stretch; margin-bottom: var(--space-6);
    }
    .card {
      background: color-mix(in srgb, var(--color-surface) 88%, transparent);
      border: 1px solid var(--color-border);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-md);
      padding: var(--space-5);
      backdrop-filter: blur(12px);
    }
    .hero-copy h1 { font-family: var(--font-display); font-size: var(--text-2xl); line-height: 1.03; letter-spacing: .04em; text-transform: uppercase; margin-bottom: var(--space-4); }
    .hero-copy p { color: var(--color-text-muted); font-size: var(--text-base); max-width: 58ch; }
    .pill-row { display: flex; flex-wrap: wrap; gap: var(--space-2); margin-top: var(--space-4); }
    .pill { border-radius: var(--radius-full); padding: .5rem .8rem; background: var(--color-surface-2); color: var(--color-text-muted); font-size: var(--text-xs); text-transform: uppercase; letter-spacing: .08em; }
    .stats { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: var(--space-3); }
    .stat { padding: var(--space-4); border-radius: var(--radius-md); background: var(--color-surface-2); border: 1px solid var(--color-border); }
    .stat-label { color: var(--color-text-muted); font-size: var(--text-xs); text-transform: uppercase; letter-spacing: .08em; }
    .stat-value { font-size: var(--text-xl); font-weight: 700; font-variant-numeric: tabular-nums; margin-top: var(--space-1); }
    main { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(300px, .7fr); gap: var(--space-6); align-items: start; }
    .game-shell { padding: var(--space-4); }
    .canvas-wrap { position: relative; border-radius: var(--radius-lg); overflow: hidden; background: #111; border: 1px solid var(--color-border); }
    canvas { display: block; width: 100%; height: auto; aspect-ratio: 16 / 10; background: linear-gradient(180deg, #111a1c 0%, #0c1114 100%); }
    .hud { display: flex; flex-wrap: wrap; gap: var(--space-3); margin-top: var(--space-4); }
    .hud-item { flex: 1 1 140px; background: var(--color-surface-2); border: 1px solid var(--color-border); border-radius: var(--radius-md); padding: var(--space-3); }
    .hud-item strong { display: block; font-size: var(--text-xs); letter-spacing: .08em; text-transform: uppercase; color: var(--color-text-muted); margin-bottom: .2rem; }
    .hud-item span { font-size: var(--text-lg); font-weight: 700; font-variant-numeric: tabular-nums; }
    .control-row { display: flex; flex-wrap: wrap; gap: var(--space-3); margin-top: var(--space-4); }
    .btn-primary { background: var(--color-primary); color: var(--color-text-inverse); border-color: transparent; }
    .btn-primary:hover { background: var(--color-primary-hover); }
    .btn-danger { background: transparent; color: var(--color-danger); }
    .side-panel h2 { font-size: var(--text-lg); margin-bottom: var(--space-3); }
    .stack { display: grid; gap: var(--space-4); }
    .leaderboard-list { list-style: none; display: grid; gap: var(--space-2); }
    .leaderboard-list li { display: grid; grid-template-columns: 2rem 1fr auto; gap: var(--space-3); align-items: center; padding: .8rem .9rem; background: var(--color-surface-2); border: 1px solid var(--color-border); border-radius: var(--radius-md); }
    .leaderboard-list .rank { font-family: var(--font-display); color: var(--color-gold); }
    .form-grid { display: grid; gap: var(--space-3); }
    label { display: grid; gap: .45rem; font-size: var(--text-sm); }
    input[type="text"] { min-height: 44px; border-radius: var(--radius-md); border: 1px solid var(--color-border); background: var(--color-surface-2); color: var(--color-text); padding: 0 .9rem; }
    .note { color: var(--color-text-muted); font-size: var(--text-sm); }
    .overlay {
      position: absolute; inset: 0; display: grid; place-items: center; padding: var(--space-4);
      background: linear-gradient(rgba(9,12,14,.2), rgba(9,12,14,.72));
    }
    .overlay-panel {
      width: min(92%, 420px); background: rgba(15,18,20,.85); color: #f7f6f2; border: 1px solid rgba(255,255,255,.12);
      border-radius: var(--radius-lg); padding: var(--space-5); text-align: center; backdrop-filter: blur(10px);
    }
    .overlay-panel h2 { font-family: var(--font-display); font-size: var(--text-xl); margin-bottom: var(--space-3); letter-spacing: .08em; text-transform: uppercase; }
    .overlay-panel p { color: rgba(247,246,242,.8); margin-bottom: var(--space-4); }
    .touch-controls { display: none; grid-template-columns: 1fr 1fr; gap: var(--space-3); margin-top: var(--space-4); }
    .touch-btn { min-height: 54px; border-radius: var(--radius-md); border: 1px solid var(--color-border); background: var(--color-surface-2); }
    footer { margin-top: var(--space-6); color: var(--color-text-muted); font-size: var(--text-sm); }
    @media (max-width: 900px) {
      .hero, main { grid-template-columns: 1fr; }
    }
    @media (max-width: 680px) {
      .stats { grid-template-columns: 1fr; }
      .touch-controls { display: grid; }
      .page { padding-inline: var(--space-3); }
      .hero-copy h1 { max-width: 12ch; }
    }
  </style>
</head>
<body>
  <a class="skip-link" href="#game">跳到遊戲</a>
  <div class="page">
    <header>
      <div class="brand" aria-label="Brick Pulse logo">
        <svg class="brand-mark" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Brick Pulse logo">
          <rect x="8" y="12" width="48" height="12" rx="4" stroke="currentColor" stroke-width="4"/>
          <rect x="18" y="30" width="28" height="12" rx="6" fill="currentColor"/>
          <circle cx="32" cy="50" r="6" fill="currentColor"/>
        </svg>
        <div>
          <div class="brand-name">Brick Pulse</div>
          <div class="note">PHP + Canvas 打磚塊，可直接部署到支援 PHP 的主機。</div>
        </div>
      </div>
      <button class="theme-toggle" data-theme-toggle aria-label="切換深色模式">🌙</button>
    </header>

    <section class="hero" aria-label="遊戲介紹">
      <article class="card hero-copy">
        <h1>遠端可部署的打磚塊</h1>
        <p>這個版本以前端 Canvas 執行核心遊戲，PHP 負責首頁輸出與排行榜儲存，因此放到一般 Apache + PHP 主機就能直接玩，不需要 Node.js、資料庫或額外服務。</p>
        <div class="pill-row">
          <span class="pill">Keyboard</span>
          <span class="pill">Touch</span>
          <span class="pill">PHP JSON API</span>
          <span class="pill">Responsive</span>
        </div>
      </article>
      <aside class="card">
        <div class="stats">
          <div class="stat"><div class="stat-label">最佳分數</div><div class="stat-value" id="bestScore">0</div></div>
          <div class="stat"><div class="stat-label">排行榜筆數</div><div class="stat-value" id="boardCount">0</div></div>
          <div class="stat"><div class="stat-label">難度</div><div class="stat-value">Normal</div></div>
          <div class="stat"><div class="stat-label">部署需求</div><div class="stat-value" style="font-size:var(--text-lg)">PHP 8+</div></div>
        </div>
      </aside>
    </section>

    <main id="game">
      <section class="card game-shell" aria-labelledby="gameTitle">
        <h2 id="gameTitle" style="margin-bottom: var(--space-3);">遊戲畫面</h2>
        <div class="canvas-wrap">
          <canvas id="gameCanvas" width="960" height="600" aria-label="打磚塊遊戲畫布"></canvas>
          <div class="overlay" id="gameOverlay">
            <div class="overlay-panel">
              <h2 id="overlayTitle">準備開打</h2>
              <p id="overlayText">按下開始後，用左右方向鍵或 A / D 控制板子，清空所有磚塊。</p>
              <button class="btn btn-primary" id="startButton">開始遊戲</button>
            </div>
          </div>
        </div>
        <div class="hud" aria-label="遊戲資訊">
          <div class="hud-item"><strong>分數</strong><span id="scoreValue">0</span></div>
          <div class="hud-item"><strong>生命</strong><span id="livesValue">3</span></div>
          <div class="hud-item"><strong>關卡</strong><span id="levelValue">1</span></div>
          <div class="hud-item"><strong>剩餘磚塊</strong><span id="bricksValue">0</span></div>
        </div>
        <div class="control-row">
          <button class="btn btn-primary" id="restartButton">重新開始</button>
          <button class="btn" id="pauseButton">暫停</button>
          <button class="btn btn-danger" id="clearScoresButton">清空排行榜</button>
        </div>
        <div class="touch-controls" aria-label="手機控制">
          <button class="touch-btn" id="leftBtn" aria-label="往左移動">← 左</button>
          <button class="touch-btn" id="rightBtn" aria-label="往右移動">右 →</button>
        </div>
      </section>

      <aside class="stack">
        <section class="card side-panel" aria-labelledby="leaderboardTitle">
          <h2 id="leaderboardTitle">排行榜</h2>
          <ol class="leaderboard-list" id="leaderboardList"></ol>
          <p class="note">最高保留前 10 名，資料儲存在伺服器的 JSON 檔案。</p>
        </section>

        <section class="card side-panel" aria-labelledby="saveTitle">
          <h2 id="saveTitle">送出分數</h2>
          <form id="scoreForm" class="form-grid">
            <label>
              玩家名稱
              <input type="text" id="playerName" name="name" maxlength="20" placeholder="輸入你的名字" required>
            </label>
            <button class="btn btn-primary" type="submit">儲存目前分數</button>
          </form>
          <p class="note" id="formMessage">遊戲結束後也可以手動送出分數。</p>
        </section>

        <section class="card side-panel" aria-labelledby="deployTitle">
          <h2 id="deployTitle">部署方式</h2>
          <div class="note" style="display:grid;gap:.55rem;">
            <p>1. 把整個資料夾上傳到支援 PHP 的主機。</p>
            <p>2. 確認 <code>data/</code> 目錄可寫入。</p>
            <p>3. 用瀏覽器開啟 <code>index.php</code> 即可遊玩。</p>
          </div>
        </section>
      </aside>
    </main>

    <footer>建議環境：Apache 或 Nginx + PHP。遊戲邏輯在瀏覽器運行，PHP 只處理頁面與排行榜儲存。</footer>
  </div>

  <script>
    (() => {
      const themeToggle = document.querySelector('[data-theme-toggle]');
      const root = document.documentElement;
      let theme = matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      const updateTheme = () => {
        root.setAttribute('data-theme', theme);
        themeToggle.textContent = theme === 'dark' ? '☀️' : '🌙';
        themeToggle.setAttribute('aria-label', theme === 'dark' ? '切換亮色模式' : '切換深色模式');
      };
      updateTheme();
      themeToggle.addEventListener('click', () => { theme = theme === 'dark' ? 'light' : 'dark'; updateTheme(); });

      const canvas = document.getElementById('gameCanvas');
      const ctx = canvas.getContext('2d');
      const overlay = document.getElementById('gameOverlay');
      const overlayTitle = document.getElementById('overlayTitle');
      const overlayText = document.getElementById('overlayText');
      const scoreValue = document.getElementById('scoreValue');
      const livesValue = document.getElementById('livesValue');
      const levelValue = document.getElementById('levelValue');
      const bricksValue = document.getElementById('bricksValue');
      const bestScore = document.getElementById('bestScore');
      const boardCount = document.getElementById('boardCount');
      const leaderboardList = document.getElementById('leaderboardList');
      const form = document.getElementById('scoreForm');
      const playerNameInput = document.getElementById('playerName');
      const formMessage = document.getElementById('formMessage');
      const startButton = document.getElementById('startButton');
      const restartButton = document.getElementById('restartButton');
      const pauseButton = document.getElementById('pauseButton');
      const clearScoresButton = document.getElementById('clearScoresButton');
      const leftBtn = document.getElementById('leftBtn');
      const rightBtn = document.getElementById('rightBtn');

      const state = {
        running: false,
        paused: false,
        gameOver: false,
        level: 1,
        score: 0,
        lives: 3,
        maxLives: 3,
        paddle: { width: 150, height: 16, x: 405, speed: 9, dx: 0 },
        ball: { x: 480, y: 430, radius: 10, dx: 4.2, dy: -4.2, speedCap: 8.4 },
        rows: 5,
        cols: 9,
        brickWidth: 88,
        brickHeight: 24,
        brickPadding: 12,
        brickOffsetTop: 70,
        brickOffsetLeft: 42,
        bricks: [],
        animationId: null,
        canSubmit: false,
      };

      const api = {
        async getScores() {
          const res = await fetch('score.php');
          return res.json();
        },
        async postScore(name, score) {
          const res = await fetch('score.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, score })
          });
          return res.json();
        },
        async clearScores() {
          const res = await fetch('score.php?action=clear', { method: 'POST' });
          return res.json();
        }
      };

      function buildBricks() {
        state.bricks = [];
        for (let c = 0; c < state.cols; c++) {
          state.bricks[c] = [];
          for (let r = 0; r < state.rows; r++) {
            state.bricks[c][r] = { x: 0, y: 0, status: 1, hp: (r % 2 === 0 ? 1 : 2) };
          }
        }
      }

      function resetBallAndPaddle() {
        state.paddle.x = (canvas.width - state.paddle.width) / 2;
        state.paddle.dx = 0;
        state.ball.x = canvas.width / 2;
        state.ball.y = canvas.height - 120;
        const direction = Math.random() > 0.5 ? 1 : -1;
        state.ball.dx = 4.2 * direction;
        state.ball.dy = -4.2;
      }

      function resetGame() {
        state.running = false;
        state.paused = false;
        state.gameOver = false;
        state.level = 1;
        state.score = 0;
        state.lives = state.maxLives;
        state.rows = 5;
        state.paddle.width = 150;
        buildBricks();
        resetBallAndPaddle();
        state.canSubmit = false;
        pauseButton.textContent = '暫停';
        showOverlay('準備開打', '按下開始後，用左右方向鍵或 A / D 控制板子，清空所有磚塊。', '開始遊戲');
        renderHud();
        draw();
      }

      function showOverlay(title, text, buttonText = '開始遊戲') {
        overlay.hidden = false;
        overlayTitle.textContent = title;
        overlayText.textContent = text;
        startButton.textContent = buttonText;
      }

      function hideOverlay() { overlay.hidden = true; }

      function renderHud() {
        scoreValue.textContent = state.score;
        livesValue.textContent = state.lives;
        levelValue.textContent = state.level;
        bricksValue.textContent = countBricks();
      }

      function countBricks() {
        let count = 0;
        state.bricks.forEach(col => col.forEach(brick => { if (brick.status > 0) count++; }));
        return count;
      }

      function drawRoundedRect(x, y, w, h, r, fillStyle) {
        ctx.beginPath();
        ctx.moveTo(x + r, y);
        ctx.arcTo(x + w, y, x + w, y + h, r);
        ctx.arcTo(x + w, y + h, x, y + h, r);
        ctx.arcTo(x, y + h, x, y, r);
        ctx.arcTo(x, y, x + w, y, r);
        ctx.closePath();
        ctx.fillStyle = fillStyle;
        ctx.fill();
      }

      function drawBackground() {
        const grad = ctx.createLinearGradient(0, 0, 0, canvas.height);
        grad.addColorStop(0, '#16242b');
        grad.addColorStop(1, '#0d1117');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        for (let i = 0; i < 20; i++) {
          ctx.fillStyle = `rgba(102, 167, 167, ${0.02 + (i % 5) * 0.01})`;
          ctx.beginPath();
          ctx.arc(40 + i * 48, 70 + (i % 4) * 40, 2 + (i % 3), 0, Math.PI * 2);
          ctx.fill();
        }
      }

      function drawBricks() {
        for (let c = 0; c < state.cols; c++) {
          for (let r = 0; r < state.rows; r++) {
            const brick = state.bricks[c][r];
            if (brick.status <= 0) continue;
            const brickX = c * (state.brickWidth + state.brickPadding) + state.brickOffsetLeft;
            const brickY = r * (state.brickHeight + state.brickPadding) + state.brickOffsetTop;
            brick.x = brickX;
            brick.y = brickY;
            const color = brick.hp === 2 ? '#efbf56' : ['#66a7a7', '#84c4c4', '#9cd7d7', '#c4eeee', '#ddf8f8'][r % 5];
            drawRoundedRect(brickX, brickY, state.brickWidth, state.brickHeight, 8, color);
          }
        }
      }

      function drawPaddle() {
        drawRoundedRect(state.paddle.x, canvas.height - 48, state.paddle.width, state.paddle.height, 10, '#f5f0e8');
      }

      function drawBall() {
        ctx.beginPath();
        const glow = ctx.createRadialGradient(state.ball.x - 2, state.ball.y - 2, 2, state.ball.x, state.ball.y, state.ball.radius * 1.8);
        glow.addColorStop(0, '#fff4d8');
        glow.addColorStop(1, '#efbf56');
        ctx.fillStyle = glow;
        ctx.arc(state.ball.x, state.ball.y, state.ball.radius, 0, Math.PI * 2);
        ctx.fill();
      }

      function drawFrame() {
        ctx.strokeStyle = 'rgba(255,255,255,.1)';
        ctx.lineWidth = 2;
        ctx.strokeRect(16, 16, canvas.width - 32, canvas.height - 32);
      }

      function collisionDetection() {
        for (let c = 0; c < state.cols; c++) {
          for (let r = 0; r < state.rows; r++) {
            const brick = state.bricks[c][r];
            if (brick.status <= 0) continue;
            if (
              state.ball.x > brick.x &&
              state.ball.x < brick.x + state.brickWidth &&
              state.ball.y > brick.y &&
              state.ball.y < brick.y + state.brickHeight
            ) {
              state.ball.dy = -state.ball.dy;
              brick.hp -= 1;
              if (brick.hp <= 0) {
                brick.status = 0;
                state.score += 10;
              } else {
                state.score += 4;
              }
              if (countBricks() === 0) levelUp();
            }
          }
        }
      }

      function levelUp() {
        state.level += 1;
        state.rows = Math.min(7, state.rows + 1);
        state.paddle.width = Math.max(96, state.paddle.width - 10);
        state.ball.dx *= 1.05;
        state.ball.dy *= 1.05;
        buildBricks();
        resetBallAndPaddle();
        renderHud();
        showOverlay(`關卡 ${state.level}`, '磚塊變多、板子變短，準備迎接下一輪。', '繼續');
        state.running = false;
      }

      function loseLife() {
        state.lives -= 1;
        if (state.lives <= 0) {
          endGame();
          return;
        }
        state.running = false;
        resetBallAndPaddle();
        renderHud();
        showOverlay('失去一命', '調整位置後再試一次。', '回到遊戲');
      }

      function endGame() {
        state.running = false;
        state.gameOver = true;
        state.canSubmit = true;
        showOverlay('遊戲結束', `本次得分 ${state.score} 分，輸入名字後可送出排行榜。`, '再玩一次');
      }

      function clampBallSpeed() {
        state.ball.dx = Math.max(-state.ball.speedCap, Math.min(state.ball.speedCap, state.ball.dx));
        state.ball.dy = Math.max(-state.ball.speedCap, Math.min(state.ball.speedCap, state.ball.dy));
      }

      function update() {
        if (!state.running || state.paused) return;

        state.paddle.x += state.paddle.dx;
        if (state.paddle.x < 24) state.paddle.x = 24;
        if (state.paddle.x + state.paddle.width > canvas.width - 24) state.paddle.x = canvas.width - 24 - state.paddle.width;

        state.ball.x += state.ball.dx;
        state.ball.y += state.ball.dy;

        if (state.ball.x + state.ball.radius > canvas.width - 18 || state.ball.x - state.ball.radius < 18) {
          state.ball.dx = -state.ball.dx;
        }
        if (state.ball.y - state.ball.radius < 18) {
          state.ball.dy = -state.ball.dy;
        }

        const paddleTop = canvas.height - 48;
        if (
          state.ball.y + state.ball.radius >= paddleTop &&
          state.ball.x > state.paddle.x &&
          state.ball.x < state.paddle.x + state.paddle.width &&
          state.ball.dy > 0
        ) {
          const hit = (state.ball.x - (state.paddle.x + state.paddle.width / 2)) / (state.paddle.width / 2);
          state.ball.dx = hit * 6.2;
          state.ball.dy = -Math.abs(state.ball.dy) - 0.08;
          clampBallSpeed();
        }

        if (state.ball.y - state.ball.radius > canvas.height) {
          loseLife();
        }

        collisionDetection();
        renderHud();
      }

      function draw() {
        drawBackground();
        drawFrame();
        drawBricks();
        drawPaddle();
        drawBall();
      }

      function loop() {
        update();
        draw();
        state.animationId = requestAnimationFrame(loop);
      }

      function setMove(direction, active) {
        if (!active) {
          if ((direction === 'left' && state.paddle.dx < 0) || (direction === 'right' && state.paddle.dx > 0)) state.paddle.dx = 0;
          return;
        }
        state.paddle.dx = direction === 'left' ? -state.paddle.speed : state.paddle.speed;
      }

      document.addEventListener('keydown', (e) => {
        if (['ArrowLeft', 'a', 'A'].includes(e.key)) setMove('left', true);
        if (['ArrowRight', 'd', 'D'].includes(e.key)) setMove('right', true);
        if (e.key === ' ') {
          e.preventDefault();
          if (!state.running && !state.gameOver) startGameplay();
          else togglePause();
        }
      });
      document.addEventListener('keyup', (e) => {
        if (['ArrowLeft', 'a', 'A'].includes(e.key)) setMove('left', false);
        if (['ArrowRight', 'd', 'D'].includes(e.key)) setMove('right', false);
      });

      [['pointerdown','pointerup'], ['touchstart','touchend']].forEach(([start,end]) => {
        leftBtn.addEventListener(start, (e) => { e.preventDefault(); setMove('left', true); });
        leftBtn.addEventListener(end, (e) => { e.preventDefault(); setMove('left', false); });
        rightBtn.addEventListener(start, (e) => { e.preventDefault(); setMove('right', true); });
        rightBtn.addEventListener(end, (e) => { e.preventDefault(); setMove('right', false); });
      });

      function startGameplay() {
        if (state.gameOver) resetGame();
        hideOverlay();
        state.running = true;
        state.paused = false;
        pauseButton.textContent = '暫停';
      }

      function togglePause() {
        if (!state.running && !state.paused) return;
        state.paused = !state.paused;
        pauseButton.textContent = state.paused ? '繼續' : '暫停';
        if (state.paused) showOverlay('已暫停', '按下繼續回到遊戲。', '繼續');
        else hideOverlay();
      }

      startButton.addEventListener('click', startGameplay);
      restartButton.addEventListener('click', () => { resetGame(); startGameplay(); });
      pauseButton.addEventListener('click', togglePause);

      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const name = playerNameInput.value.trim();
        if (!name) {
          formMessage.textContent = '請先輸入玩家名稱。';
          return;
        }
        try {
          const result = await api.postScore(name, state.score);
          formMessage.textContent = result.message || '分數已送出。';
          await loadScores();
          state.canSubmit = false;
        } catch {
          formMessage.textContent = '送出失敗，請確認主機允許 PHP 寫入 data 資料夾。';
        }
      });

      clearScoresButton.addEventListener('click', async () => {
        try {
          const result = await api.clearScores();
          formMessage.textContent = result.message || '排行榜已清空。';
          await loadScores();
        } catch {
          formMessage.textContent = '清空失敗。';
        }
      });

      async function loadScores() {
        try {
          const data = await api.getScores();
          leaderboardList.innerHTML = '';
          const scores = Array.isArray(data.scores) ? data.scores : [];
          boardCount.textContent = scores.length;
          bestScore.textContent = scores.length ? scores[0].score : 0;
          if (!scores.length) {
            leaderboardList.innerHTML = '<li><span class="rank">—</span><span>尚無紀錄</span><strong>0</strong></li>';
            return;
          }
          scores.forEach((entry, index) => {
            const li = document.createElement('li');
            li.innerHTML = `<span class="rank">${index + 1}</span><span>${escapeHtml(entry.name)}<br><small class="note">${escapeHtml(entry.time)}</small></span><strong>${entry.score}</strong>`;
            leaderboardList.appendChild(li);
          });
        } catch {
          leaderboardList.innerHTML = '<li><span class="rank">!</span><span>無法讀取排行榜</span><strong>--</strong></li>';
        }
      }

      function escapeHtml(text) {
        return String(text).replace(/[&<>"']/g, (char) => ({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' }[char]));
      }

      resetGame();
      loadScores();
      loop();
    })();
  </script>
</body>
</html>
