<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Арифметическая прогрессия')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            padding: 40px;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }

        h1 {
            color: #333;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            font-size: 0.95em;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 1em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
            border: 2px solid #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input, textarea {
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .progression {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
            font-size: 1.3em;
            font-weight: bold;
            letter-spacing: 3px;
            border: 2px solid #667eea;
            color: #333;
        }

        .game-list {
            margin-top: 20px;
        }

        .game-item {
            padding: 15px;
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .game-item:hover {
            background: #e9ecef;
        }

        .game-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .player-name {
            font-weight: bold;
            color: #333;
        }

        .status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .status-won {
            background: #d4edda;
            color: #155724;
        }

        .status-lost {
            background: #f8d7da;
            color: #721c24;
        }

        .status-in_progress {
            background: #fff3cd;
            color: #856404;
        }

        .game-date {
            color: #666;
            font-size: 0.9em;
        }

        .btn-view {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 16px;
            font-size: 0.9em;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-group .btn {
            flex: 1;
        }

        .step-info {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .step-info strong {
            color: #667eea;
        }

        .attempt-count {
            background: #e9ecef;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
        }

        .pagination a, .pagination span {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            color: #667eea;
            text-decoration: none;
        }

        .pagination a:hover {
            background: #667eea;
            color: white;
        }

        .pagination .active {
            background: #667eea;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
