<?php

include "header-section.php";

?>


<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="images/slide-1.jpg" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
                <h3>WELCOME TO STUDENT LIBRARY</h3>
                <a href="book-listing.php" class="btn btn-lg btn-purple my-3">View All Books</a>
                <p>Explore, Learn, Grow: Your Gateway to Knowledge</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="images/slide-2.jpg" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
                <h3>WELCOME TO STUDENT LIBRARY</h3>
                <a href="book-listing.php" class="btn btn-lg btn-purple my-3">View All Books</a>
                <p>Explore, Learn, Grow: Your Gateway to Knowledge</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="images/slide-3.jpg" alt="Third slide">
            <div class="carousel-caption d-none d-md-block">
                <h3>WELCOME TO STUDENT LIBRARY</h3>
                <a href="book-listing.php" class="btn btn-lg btn-purple my-3">View All Books</a>
                <p>Explore, Learn, Grow: Your Gateway to Knowledge</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<?php

include "bottom-bar.php";

?>