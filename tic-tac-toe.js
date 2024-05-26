$(document).ready(function() {
    let board = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ];
    let currentPlayer = 'X';
    const statusDisplay = $('#status');
    let isOnline = false;

    $('#modeModal').modal({backdrop: 'static', keyboard: false});

    $('#offlineMode').on('click', function() {
        isOnline = false;
        $('#modeModal').modal('hide');
        statusDisplay.text(`Player ${currentPlayer}'s turn`);
    });

    $('#onlineMode').on('click', function() {
        isOnline = true;
        $('#modeModal').modal('hide');
        statusDisplay.text(`Player ${currentPlayer}'s turn`);
        // Initialize online game setup here
    });

    function checkWinner() {
        // Check rows
        for (let i = 0; i < 3; i++) {
            if (board[i][0] && board[i][0] === board[i][1] && board[i][0] === board[i][2]) {
                return board[i][0];
            }
        }
        // Check columns
        for (let i = 0; i < 3; i++) {
            if (board[0][i] && board[0][i] === board[1][i] && board[0][i] === board[2][i]) {
                return board[0][i];
            }
        }
        // Check diagonals
        if (board[0][0] && board[0][0] === board[1][1] && board[0][0] === board[2][2]) {
            return board[0][0];
        }
        if (board[0][2] && board[0][2] === board[1][1] && board[0][2] === board[2][0]) {
            return board[0][2];
        }
        return null;
    }

    function isBoardFull() {
        for (let i = 0; i < 3; i++) {
            for (let j = 0; j < 3; j++) {
                if (board[i][j] === '') {
                    return false;
                }
            }
        }
        return true;
    }

    function handleCellClick() {
        const row = $(this).data('row');
        const col = $(this).data('col');

        if (board[row][col] === '') {
            board[row][col] = currentPlayer;
            $(this).text(currentPlayer);

            const winner = checkWinner();
            if (winner) {
                statusDisplay.text(`Player ${winner} wins!`);
                $('.cell').off('click');
            } else if (isBoardFull()) {
                statusDisplay.text('It\'s a draw!');
            } else {
                currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
                statusDisplay.text(`Player ${currentPlayer}'s turn`);
            }
        }
    }

    function resetGame() {
        for (let i = 0; i < 3; i++) {
            for (let j = 0; j < 3; j++) {
                board[i][j] = '';
            }
        }
        $('.cell').text('').on('click', handleCellClick);
        currentPlayer = 'X';
        statusDisplay.text(`Player ${currentPlayer}'s turn`);
    }

    $('.cell').on('click', handleCellClick);
    $('#reset').on('click', resetGame);
});
