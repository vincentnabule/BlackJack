<?php include_once 'this/header.php' ?>

<main>
    <!-- blank screen -->
    <section class="notPlaying container">
        <section class="d-flex justify-content-center">
            <div class="cards card shadow p-1 rounded">
                <img src="assets/images/cards/heart3.png" alt="sp" id="img1">
            </div>
            <div class="cards card shadow p-1 rounded">
                <img src="assets/images/cards/spade10.png" alt="sp">
            </div>
            <div class="cards card shadow p-1 rounded">
                <img src="assets/images/cards/heart1.png" alt="sp">
            </div>
            <div class="cards card shadow p-1 rounded">
                <img src="assets/images/cards/clubsq.png" alt="sp">
            </div>
            <div class="cards card shadow p-1 rounded">
                <img src="assets/images/cards/diamondk.png" alt="sp">
            </div>
        </section>
        <section class="d-flex justify-content-center">
            <div class="cards card shadow p-1 rounded">
                <img src="assets/images/cards/clubsj.png" alt="sp">
            </div>
            <div class="cards card shadow p-1 rounded">
                <img src="assets/images/cards/diamond1.png" alt="sp">
            </div>
            <div class="cards card shadow p-1 rounded">
                <img src="assets/images/cards/spadeq.png" alt="sp">
            </div>
            <div class="cards card shadow p-1 rounded">
                <img src="assets/images/cards/heartk.png" alt="sp">
            </div>
        </section>

        <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-primary btn-md w-50" onclick="startGame();">Start Game</button>
        </div>
    </section>

    <!-- Jack -->
    <section class="main_section playing" hidden>
        <!-- Scores -->
        <section class="scores mx-auto container">
            <table class="table table-bordered text-center h6">
                <thead>
                    <th class="col">You</th>
                    <th class="col">Dealer</th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="row row-cols-2">
                                <div class="col">Black Jack: </div>
                                <div class="col text-primary fw-bold" id="userjack"> 0 </div>
                            </div>
                            <div class="row row-cols-2">
                                <div class="col">Wins: </div>
                                <div class="col text-primary fw-bold" id="userwins"> 0 </div>
                            </div>
                            <div class="row row-cols-2">
                                <div class="col">Draws: </div>
                                <div class="col text-primary fw-bold gMatch"> 0 </div>
                            </div>
                        </td>
                        <td>
                            <div class="row row-cols-2">
                                <div class="col">Black Jack: </div>
                                <div class="col text-danger fw-bold" id="dealerjack"> 0 </div>
                            </div>
                            <div class="row row-cols-2">
                                <div class="col">Wins: </div>
                                <div class="col text-danger fw-bold" id="dealerwins"> 0 </div>
                            </div>
                            <div class="row row-cols-2">
                                <div class="col">Draws: </div>
                                <div class="col text-danger fw-bold gMatch"> 0 </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Actions -->
        <section class="card" id="dataHere"></section>

        <!-- modal alerts -->
        <div class="w-100 mx-auto modal fade mt-5" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="h1 text-center">Game Over</div>
                        <div class="h2 text-center" id="gWinner">You Won</div>

                        <table class="table table-bordered text-center mb-5">
                            <thead>
                                <th class="col">You</th>
                                <th class="col">Dealer</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="US">21</td>
                                    <td class="DS">19</td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- <div class="d-flex justify-content-center mt-5 mb-1">
                            <button class="btn btn-primary w-75" onclick="newGame()" data-bs-dismiss="modal" aria-label="Close"> Play Again </button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-success d-none" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modalBtn">Add Tip</button>

        <!-- controls -->
        <section class="shadow-lg action_section d-flex justify-content-around p-3 mb-sm-5">
            <button class="btn btn-sm btn-primary btn_size shadow-lg" onclick="drawExtra()" id="hit">Hit</button>
            <button class="btn btn-sm btn-success btn_size" onclick="showResults()" id="stand">Stand</button>
            <button class="btn btn-sm btn-danger btn_size" onclick="newGame()" id="drawAgain" hidden>Draw</button>
            <button class="btn btn-sm btn-info btn_size" id="split" disabled>Split</button>
        </section>
    </section>
</main>

<?php include_once 'this/footer.php' ?>