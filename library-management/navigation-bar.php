<nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand mr-5" href="index.php">Student Library</a>
            <button class="navbar-toggler navbar-mobile-button" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="	fa fa-angle-down"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])) {
                    ?>

                        
                        <?php if (isset($_SESSION["role"])) {
                            if ($_SESSION["role"] == "Student") { ?>
                                <li class="nav-item  ">
                                    <a class="nav-link" href="book-request.php">My Requests </a>
                                </li>
                                <li class="nav-item  ">
                                    <a class="nav-link" href="borrowed-books.php">Borrowed books</a>
                                </li>
                        <?php  }

                 } ?>
                        <?php if (isset($_SESSION["role"])) {
                            if ($_SESSION["role"] == "Librarian" || $_SESSION["role"] == "Admin") { ?>

                                
                                <li class="nav-item  ">
                                    <a class="nav-link" href="issue-book.php">Approve Requests <i class="fa fa-clock-o"></i></a>
                                </li>

                              
                                <?php 
                          }
                        } ?>
                        <li class="nav-item  ">
                            <a class="nav-link" href="book-listing.php">Available books <i class="fa fa-list"></i></a>
                        </li>
                    <?php
                    } ?>

                    <li class="nav-item  ">
                        <a class="nav-link" href="about-us.php">About us <i class="fa fa-info-circle"></i></a>
                    </li>
                    <li class="nav-item  ">
                        <a class="nav-link" href="contact-us.php">Contact us <i class="fa fa-phone"></i></a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION["username"] ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                
                                <a class="nav-link text-dark" href="user-logout.php?logout=true">Logout <i class="fa fa-sign-out"></i></a>
                            </div>
                        </li>
                    <?php
                    } else { ?>
                        <li class="nav-item ">
                            <a class="nav-link" href="user-login.php">Login <i class="fa fa-user-circle"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="user-registration.php">Register <i class="fa fa-plus"></i></a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
        </div>

    </nav>