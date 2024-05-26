$(document).ready(function() {
    let board = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ];
    let currentPlayer = 'X';
    let currentName = 'X';
    const statusDisplay = $('#status');
    let isOnline = false;
    let ajaxInProgress  = false;
    let playerx = "";
    let playero = "";
    let playerxBGcolor = '#7fffd4';
    let playeroBGcolor = '#90ee90';

    $('#modeModal').modal({ backdrop: 'static', keyboard: false });

    $('#offlineMode').on('click', function() {
        isOnline = false;
        $('#modeModal').modal('hide');
        setPlayerName();
        statusDisplay.text(`Player ${currentName}'s turn`);
        setBGcolor(currentPlayer);
    });

    $('#onlineMode').on('click', function() {
        isOnline = true;
        $('#modeModal').modal('hide');
        // Initialize online game setup here
        loadOnlineGameState();
        setPlayerName();
        setBGcolor(currentPlayer);
        statusDisplay.text(`Player ${currentName}'s turn`);
    });

    function loadOnlineGameState() {
        
        if(!ajaxInProgress){
            ajaxInProgress = true;
            
            $.ajax({
                url: 'load_game_state.php',
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        board = response.board;
                        // currentPlayer = response.currentPlayer;
                        setCurrentPlayerId(response.currentPlayer);

                        renderBoard();
                        statusDisplay.text(`Player ${currentName}'s turn`);
                    } else {
                        alert('Failed to load game state.');
                    }
                },
                error: function() {
                    alert('Error communicating with server. Please try again.');
                },
                complete: function() {
                    ajaxInProgress = false; // Set flag to false when request completes
                }
            });
        }
    }

    function renderBoard() {
        for (let i = 0; i < 3; i++) {
            for (let j = 0; j < 3; j++) {
                $(`.cell[data-row=${i}][data-col=${j}]`).text(board[i][j]);
            }
        }
    }

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

        if (isOnline) {
            // Send move to backend
            
            if(!ajaxInProgress){
                ajaxInProgress = true;
                $.ajax({
                    url: 'make_move.php',
                    type: 'POST',
                    data: {
                        row: row,
                        col: col,
                        currentPlayer: currentPlayer
                    },
                    success: function(response) {
                        if (response.success) {
                            board[row][col] = currentPlayer;
                            $(`.cell[data-row=${row}][data-col=${col}]`).text(currentPlayer);

                            const winner = response.status;
                            if (winner) {

                                let theWinnerName = getWinnerName(winner);
                                let winner_text = `${theWinnerName} is the ultimate champion.`;
                                statusDisplay.text(winner_text);
                                $('.cell').off('click');
                            } else if (isBoardFull()) {
                                statusDisplay.text('It\'s a draw!');
                            } else {
                                // currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
                                setCurrentPlayerId(currentPlayer === 'X' ? 'O' : 'X');
                                statusDisplay.text(`Player ${currentName}'s turn`);
                            }
                        } else {
                            alert('Invalid move, please try again.');
                        }
                    },
                    error: function() {
                        alert('Error communicating with server. Please try again.');
                    },
                    complete: function() {
                        ajaxInProgress = false; // Set flag to false when request completes
                          
                    }
                });
            }
        } else {
            if (board[row][col] === '') {
                board[row][col] = currentPlayer;
                $(this).text(currentPlayer);

                const winner = checkWinner();
                console.log(winner);
                if (winner) {
                    // statusDisplay.text(`Player ${winner} wins!`);
                    let theWinnerName = getWinnerName(winner);
                    let winner_text = `${theWinnerName} is the ultimate champion.`;
                    statusDisplay.text(winner_text);
                    $('.cell').off('click');
                } else if (isBoardFull()) {
                    statusDisplay.text('It\'s a draw!');
                } else {
                    // currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
                    setCurrentPlayerId(currentPlayer === 'X' ? 'O' : 'X');
                    statusDisplay.text(`Player ${currentName}'s turn`);
                }

                
        
            }
        }

    }

    function resetGame() {
        if (isOnline) {
            // Send reset request to backend
            if(!ajaxInProgress){
                ajaxInProgress = true;
                $.ajax({
                    url: 'reset_game.php',
                    type: 'POST',
                    success: function(response) {
                        if (response.success) {
                            board = [
                                ['', '', ''],
                                ['', '', ''],
                                ['', '', '']
                            ];
                            renderBoard();
                            $('.cell').on('click', handleCellClick);
                            currentPlayer = 'X';
                            setCurrentPlayerId('X');
                            statusDisplay.text(`Player ${currentName}'s turn`);
                        } else {
                            alert('Error resetting game: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error communicating with server. Please try again.');
                    },
                    complete: function() {
                        ajaxInProgress = false; // Set flag to false when request completes
                    }
                });
            }
        } else {
            for (let i = 0; i < 3; i++) {
                for (let j = 0; j < 3; j++) {
                    board[i][j] = '';
                }
            }
            renderBoard();
            $('.cell').on('click', handleCellClick);
            // currentPlayer = 'X';
            setCurrentPlayerId('X');
            statusDisplay.text(`Player ${currentName}'s turn`);
        }
    }

    function setPlayerName(){
        playerx = $('#playerx').val().length > 0 ? $('#playerx').val() : $('#playerx').data('default');
        $('#playerx').val(playerx);

        playero = $('#playero').val().length > 0 ? $('#playero').val() : $('#playero').data('default');
        $('#playero').val(playero);

        // currentName = currentPlayer === 'X' ? playerx : playero;
    }

    function setCurrentPlayerId(defaultId = 'X'){
        currentPlayer = defaultId;
        currentName = currentPlayer === 'X' ? playerx : playero;
        setBGcolor(defaultId);
    }

    function getWinnerName(defaultId = 'X'){
        let newWinnerName = defaultId === 'X' ? playerx : playero;
        setBGcolor(defaultId);
        return newWinnerName;
    }

    function setBGcolor(defaultId = 'X'){
        bgColor = defaultId === 'X' ? playerxBGcolor : playeroBGcolor;
        $('body').css('background-color', bgColor)                
    }



    $('.cell').on('click', handleCellClick);
    $('#reset').on('click', resetGame);
});
