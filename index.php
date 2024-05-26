<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .board {
            display: grid;
            grid-template-columns: repeat(3, 120px);
            grid-template-rows: repeat(3, 120px);
            gap: 10px;
            justify-content: center;
            margin-top: 50px;
        }
        .cell {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid #6c757d;
            font-size: 3rem;
            cursor: pointer;
            background-color: #ffffff;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .cell:hover {
            background-color: #e9ecef;
        }
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .modal-header {
            border-bottom: none;
        }
        .modal-body {
            padding: 30px;
            text-align: center;
        }
        .modal-title {
            font-weight: bold;
            color: #6c757d;
        }
        .btn-block {
            border-radius: 25px;
            padding: 10px;
            font-size: 1.2rem;
            transition: background-color 0.3s ease;
        }
        .btn-block:hover {
            background-color: #6c757d;
            color: #fff;
        }
        .status {
            margin-top: 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1 class="mb-4">Tic Tac Toe</h1>
        <div class="board" id="board">
            <div class="cell" data-row="0" data-col="0"></div>
            <div class="cell" data-row="0" data-col="1"></div>
            <div class="cell" data-row="0" data-col="2"></div>
            <div class="cell" data-row="1" data-col="0"></div>
            <div class="cell" data-row="1" data-col="1"></div>
            <div class="cell" data-row="1" data-col="2"></div>
            <div class="cell" data-row="2" data-col="0"></div>
            <div class="cell" data-row="2" data-col="1"></div>
            <div class="cell" data-row="2" data-col="2"></div>
        </div>
        <button id="reset" class="btn btn-primary mt-3">Reset Game</button>
        <p id="status" class="status mt-3"></p>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modeModal" tabindex="-1" role="dialog" aria-labelledby="modeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modeModalLabel">Choose Mode</h5>
                </div>
                <div class="modal-body">
                    <button id="offlineMode" class="btn btn-secondary btn-block mb-3">Offline Mode</button>
                    <button id="onlineMode" class="btn btn-secondary btn-block">Online Mode</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="tic-tac-toe.js"></script>
</body>
</html>
