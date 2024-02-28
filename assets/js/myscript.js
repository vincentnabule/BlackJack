var gamesPlayed = 0;
var drawGames = 0;
var winner = null;
var gameOver = false;
var userWins = 0;
var dealerWins = 0;

var userJack = Number($("#userjack").text());
var dealerJack = Number($("#dealerjack").text());

// audio
var audioSuccess = document.createElement('audio');
audioSuccess.setAttribute('src', 'sound/success.mp3')

// clicking on start game
function startGame() {
    $(".playing").removeAttr("hidden");
    $(".notPlaying").attr("hidden", true);

    drawCard();
}

// new game
function newGame() {
    if (gameOver) {
        audioSuccess.play();
        gameOver = false;
        gamesPlayed++;
        console.log("All games: " + gamesPlayed);

        controlBtns(false);
        $('#hit').removeAttr('disabled', true)
        $("#drawAgain").attr("hidden", true);
        $('#cardFace').attr("hidden", true);

        drawCard();
    }

}

// 1st draw for both dealer and player(2 cards each)
function drawCard() {
    $.ajax({
        url: "cards.php",
        method: "POST",
        dataType: "json",
        data: {
            firstDraw: 1,
        },
        success: function (response) {
            setTimeout(doWhat(response), 2000);
        },
    });
}

// 2nd draw player hitting.
function drawExtra() {
    audioSuccess.play();
    var draw = $(".json").text();
    $.ajax({
        url: "cards.php",
        method: "POST",
        dataType: "json",
        data: {
            drawExtraCards: draw,
        },
        success: function (data) {
            setTimeout(doWhat(data), 2000);
        },
    });

}

//user standing
function showResults() {
    changeCard();

    $("#DScore").removeAttr("hidden");
    $("#hit").attr("disabled", true);

    var d_score = Number($("#DScore").text());
    var u_score = Number($("#UScore").text());

    // dealer score < 17 must hit
    if (d_score <= 17) {
        setTimeout(dealerDraw(), 2000);
    } else {
        revealScores(u_score, d_score);
    }
}

// dealer hitting
function dealerDraw() {
    audioSuccess.play();
    var draw = $(".json").text();
    $.ajax({
        url: "cards.php",
        method: "POST",
        dataType: "json",
        data: {
            dealerExtraCards: draw,
        },
        success: function (data) {
            doWhat(data);
            setTimeout(showResults(), 2000);
        },
    });
}

// unkown function
function doWhat(response) {
    var data = JSON.parse(response);
    var userScore = data["userScores"];
    var dealerScore = data["dealerScores"];
    var userDeck = data["userDeck"];
    var dealerDeck = data["dealerDeck"];
    var userPics = data["userPic"];
    var dealerPics = data["dealerPic"];
    var userSize = userDeck.length;
    var dealerSize = dealerDeck.length;

    var htmloutput = cardsLayout(userPics, userSize, userScore, dealerPics, dealerSize, dealerScore, response);
    $("#dataHere").empty();
    $("#dataHere").append(htmloutput);
}

// cards layout
function cardsLayout(user_pics, u_size, user_score, dealer_pics, d_size, dealer_score, data) {
    if ((u_burst(user_score, dealer_score))) {
        console.log(u_burst(user_score, dealer_score));
    } else {
        console.log('game on');
    }

    var htmldt = "";
    htmldt += '<section class="d-md-flex justify-content-around p-3">';
    htmldt += '<section class="player">';
    htmldt += '<div class="cards_section d-flex">';
    for (var c = u_size - 1; c > -1; c--) {
        htmldt += '<div class="u_card_' + u_size + "" + (u_size - c) + '">';
        htmldt += '<div class="cards card shadow p-1 rounded">';
        htmldt += '<img src="assets/images/cards/' + user_pics[c] + '.png" alt="' + user_pics[c] + '" id="card_' + c + '">';
        htmldt += '</div>';
        htmldt += '</div>';
    }
    htmldt += '</div>';
    htmldt += '<div class="h4 text-center text-info mt-2" id="UScore">' + user_score + '</div>';
    htmldt += '</section>';

    htmldt += '<section class="dealer">';
    htmldt += '<div class="cards_section d-flex">';
    for (var d = d_size - 1; d > 0; d--) {
        htmldt += '<div class="u_card_' + d_size + "" + (d_size - d) + '">';
        htmldt += '<div class="cards card shadow p-1 rounded">';
        htmldt += '<img src="assets/images/cards/' + dealer_pics[d] + '.png" alt="' + dealer_pics[d] + '">';
        htmldt += "</div>";
        htmldt += "</div>";
    }
    htmldt += '<div class="u_card_' + d_size + "" + d_size + '">';
    htmldt += '<div class="cards card shadow p-1 rounded">';
    htmldt += '<div class="my_cards">';
    htmldt += '    <img src="assets/images/Back/card-blue.jpg" alt="sp" id="cardBack">';
    htmldt += '    <img src="assets/images/cards/' + dealer_pics[0] + '.png" alt="' + dealer_pics[0] + '" id="cardFace" hidden>';
    htmldt += '</div>';
    htmldt += '</div>';
    htmldt += '</div>';
    htmldt += '</div>';
    htmldt += '<div class="h4 text-center text-info mt-2" id="DScore" hidden>' + dealer_score + "</div>";
    htmldt += '</section>';
    htmldt += '</section>';
    htmldt += '<div class="json" hidden>' + data + "</div>";

    setTimeout(cardsFadeIn(u_size), 2000);
    return htmldt;
}

// Scores
function u_burst(u, d) { // user bursts and 21
    if (!(gameOver)) {
        if (u == 21) {
            // player wins  by blackjack
            winner = "player";
            // userWins += 1;
            userJack++;
            gameOver = true;

            showModal(u, d, winner);
        } else if (u > 21) {
            // player lose
            winner = "dealer";
            dealerWins += 1;
            gameOver = true;

            showModal(u, d, winner);
            play
        }
    }
    return gameOver;
}

// comparing after hitting stand
function revealScores(u, d) {
    if (d == 21) {
        // dealer wins blackjack
        winner = "dealer";
        // dealerWins++;
        dealerJack++;

    } else if (d > 21 || u > d) {
        // player win
        winner = "player";
        userWins++;
    } else if (d > u) {
        winner = "dealer";
        dealerWins++;
    }
    else if (d == u) {
        drawGames++;
        winner = "draw";
    }

    gameOver = true;
    showModal(u, d, winner);

    return gameOver;
}

// modal score
function showModal(user, dealer, war) {
    changeCard();
    $("#modalBtn").click();
    $(".US").text(user);
    $(".DS").text(dealer);

    if (war === "player") {
        $("#gWinner").html("Hurraaay <br> You Won");
        $("#gWinner").addClass("text-info");
    } else if (war === "dealer") {
        $("#gWinner").html("Unfortunately <br>You Lost");
        $("#gWinner").addClass("text-danger");
    } else {
        $("#gWinner").text("Draw");
    }

    controlBtns(true);
    $("#drawAgain").removeAttr("hidden");
    $("#DScore").attr("hidden", false);

    //update table
    $('#userwins').text(userWins);
    $('#dealerwins').text(dealerWins);
    $('#userjack').text(userJack);
    $('#dealerjack').text(dealerJack);
    $('.gMatch').text(drawGames);

    console.log("User wins: " + userWins);
    console.log("Dealer wins: " + dealerWins);
}

// ctl btn
function controlBtns(a) {
    $("#hit").attr("hidden", a);
    $("#stand").attr("hidden", a);
    $("#split").attr("hidden", a);
}

// switching
function changeCard() {
    $('#cardBack').fadeOut(2000);
    $('#cardFace').fadeIn(2000)
    $('#cardFace').removeAttr('hidden');
}

// cards fade in
function cardsFadeIn(sz) {
    for (var x = sz - 1; x > -1; x--) {
        $('#card' + x).fadeIn(2000);
    }
}