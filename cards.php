<?php
if (isset($_POST['firstDraw'])) {
    $draw1 = 2;
    // getting deck
    $deck = generateDeck();

    // user draw
    $user_cards = drawCards($deck, $draw1);
    $user_pic = showCards($user_cards);

    // dealer draw
    $dealer_cards = drawCards($deck, $draw1);
    $dealer_pic = showCards($dealer_cards);

    // selected cards
    $selected = array_merge($user_cards, $dealer_cards);

    // cards in deck
    $freeDeck = array_values(array_diff($deck, $selected));

    // userTotal
    $user = cardsTotal($user_cards, 0);

    // userTotal
    $dealer = cardsTotal($dealer_cards, 0);

    // json data
    $updates = [
        "userScores" => $user,
        "dealerScores" => $dealer,
        "cards" => 48,
        "userDeck" => $user_cards,
        "dealerDeck" => $dealer_cards,
        "userPic" => $user_pic,
        "dealerPic" => $dealer_pic,
        "currentDeck" => $freeDeck
    ];

    $data = json_encode($updates);
    echo json_encode($data);
}elseif (isset($_POST['drawExtraCards'])) { //Player drawing extra cards
    $data = json_decode($_POST['drawExtraCards']);
    $currentDeck = $data->currentDeck;
    $userDeck = $data->userDeck;
    $dealerDeck = $data->dealerDeck;
    $cardsRemaining = $data->cards;
    $draw2 = 1;

    for ($i = 0; $i < 1; $i++) {
        $ucard = rand(0, $cardsRemaining - 1);
        $num = intval($ucard);
        array_push($userDeck, $currentDeck[$num]);
        unset($currentDeck->$num);

        $cardsRemaining--;
    }
    // card pic
    $user_pic = showCards($userDeck);
    $dealer_pic = showCards($dealerDeck);

    // selected cards
    $selected = array_merge($userDeck, $dealerDeck);

    // cards in deck
    $freeDeck = array_values(array_diff($currentDeck, $selected));

    // userTotal
    $user = cardsTotal($userDeck, 0);

    // dealerTotal
    $dealer = cardsTotal($dealerDeck, 0);

    // json data
    $updates = [
        "userScores" => $user,
        "dealerScores" => $dealer,
        "cards" => $cardsRemaining,
        "userDeck" => $userDeck,
        "dealerDeck" => $dealerDeck,
        "userPic" => $user_pic,
        "dealerPic" => $dealer_pic,
        "currentDeck" => $freeDeck
    ];

    $data = json_encode($updates);
    echo json_encode($data);
}elseif (isset($_POST['dealerExtraCards'])) { //Dealer drawing extra cards
    $data = json_decode($_POST['dealerExtraCards']);
    $currentDeck = $data->currentDeck;
    $userDeck = $data->userDeck;
    $dealerDeck = $data->dealerDeck;
    $cardsRemaining = $data->cards;
    $draw2 = 1;

    for ($i = 0; $i < 1; $i++) {
        $dcard = rand(0, $cardsRemaining - 1);
        $num = intval($dcard);
        array_push($dealerDeck, $currentDeck[$num]);
        unset($currentDeck->$num);

        $cardsRemaining--;
    }
    // card pic
    $user_pic = showCards($userDeck);
    $dealer_pic = showCards($dealerDeck);

    // selected cards
    $selected = array_merge($userDeck, $dealerDeck);

    // cards in deck
    $freeDeck = array_values(array_diff($currentDeck, $selected));

    // userTotal
    $user = cardsTotal($userDeck, 0);

    // dealerTotal
    $dealer = cardsTotal($dealerDeck, 0);

    // json data
    $updates = [
        "userScores" => $user,
        "dealerScores" => $dealer,
        "cards" => $cardsRemaining,
        "userDeck" => $userDeck,
        "dealerDeck" => $dealerDeck,
        "userPic" => $user_pic,
        "dealerPic" => $dealer_pic,
        "currentDeck" => $freeDeck
    ];

    $data = json_encode($updates);
    echo json_encode($data);
}

// functions
// generating deck
function generateDeck()
{
    $all_cards = [];
    $suites = ['spade', 'diamond', 'clubs', 'heart'];
    for ($f = 0; $f < 4; $f++) {
        for ($v = 1; $v < 14; $v++) {
            if ($v <= 10) {
                $val = $v;
            } else {
                if ($v == 11) {
                    $val = 'j';
                } elseif ($v == 12) {
                    $val = 'q';
                } elseif ($v == 13) {
                    $val = 'k';
                }
            }

            $card = $suites[$f] . '_' . $val;
            array_push($all_cards, $card);
        }
    }
    return $all_cards;
}

// Draw first cards(2 user & 2 dealer)
function drawCards($all, $no)
{
    $own = [];
    for ($i = 0; $i < $no; $i++) {
        $lim = count($all);
        $card = rand(0, $lim - 1);
        $temp = $all;

        array_push($own, $temp[$card]);
        unset($temp[$card]);

        $all = array_values($temp);
    }

    return $own;
}

// scores count 
function cardsTotal($deck, $total)
{
    for ($k = 0; $k < sizeof($deck); $k++) {
        $tt = explode('_', $deck[$k]);
        if ($tt[1] == 'j' || $tt[1] == 'q' || $tt[1] == 'k') {
            $value = 10;
        } elseif ($tt[1] == 1) {
            // needs work
            $value = 1;
        } else {
            $value = intval($tt[1]);
        }
        $total += $value;
    }

    return $total;
}

// cards image
function showCards($d)
{
    $dt = [];
    for ($x = 0; $x < sizeof($d); $x++) {
        $img = explode('_', $d[$x]);
        $pic = $img[0] . '' . $img[1];

        array_push($dt, $pic);
    }

    return $dt;
}