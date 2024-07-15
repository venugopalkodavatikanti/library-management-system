<?php
include "header-section.php";


?>

<?php if (!isset($_SESSION['user_id'])) {
    header('location:user-login.php');
}
if ($_SESSION["role"] == "Librarian") {
    $stmt = $db_connection_object->prepare("SELECT b.book_id, b.title, b.author, b.publisher, b.isbn, b.price, b.publication_year, 
    cat.category_name, b.image, COUNT(bc.copy_id) AS available_copies 
    FROM book b 
    JOIN book_copy bc ON b.book_id = bc.book_id 
    JOIN book_status bs ON bc.current_status_id = bs.status_id JOIN book_category cat ON b.category_id = cat.category_id 
     GROUP BY b.book_id HAVING COUNT(bc.copy_id) > 0");
}
else{
    $stmt = $db_connection_object->prepare("SELECT b.book_id, b.title, b.author, b.publisher, b.isbn, b.price, b.publication_year, 
    cat.category_name, b.image, COUNT(bc.copy_id) AS available_copies 
    FROM book b 
    JOIN book_copy bc ON b.book_id = bc.book_id 
    JOIN book_status bs ON bc.current_status_id = bs.status_id JOIN book_category cat ON b.category_id = cat.category_id 
    WHERE bs.status = 'available' GROUP BY b.book_id HAVING COUNT(bc.copy_id) > 0");
}


$stmt->execute();
$available_books = $stmt->get_result();


if (isset($_GET["request_book"])) {

    $stmt = $db_connection_object->prepare("select * from borrow_request where student_id=? and book_id=?");
    $stmt->bind_param("ss",  $_SESSION['user_id'], $_GET["book_id"]);
      $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
        header('location:book-request.php?borrow_request=fail');
    } else {

    $stmt = $db_connection_object->prepare("insert into borrow_request(student_id, book_id) values(?,?)");
    $stmt->bind_param("ss",  $_SESSION['user_id'], $_GET["book_id"]);
    $stmt->execute();

    header('location:book-request.php?borrow_request=success');
    }
}


?>

<div style="">
    <div class="container">
        <div class=" mt-1">
            <div class="page-heading mt-4">
                <center>
                    <h2 class="text-light">Available Books</h2>
                </center>
            </div>
            <?php if ($_SESSION["role"] == "Librarian") { ?>
                <div class="row">
                    <a href="add-book.php" class=" btn btn-purple ml-auto">Add new book</a>
                </div>
            <?php } ?>

            <?php if (isset($_GET["added_book"])) {
                if ($_GET["added_book"] == "success") { ?>
                    <div class="alert alert-success" role="alert">
                        Book added in the inventory
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

            <?php }
            }
            ?>

            
            <?php if (isset($_GET["updated_book"])) {
                if ($_GET["updated_book"] == "success") { ?>
                    <div class="alert alert-success" role="alert">
                        Book details updated in the inventory
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

            <?php }
            }
            ?>
            <?php if (isset($_GET["deleted_book"])) {
                if ($_GET["deleted_book"] == "success") { ?>
                    <div class="alert alert-success" role="alert">
                        Book deleted from the inventory
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <?php } else { ?>
                    <div class="alert alert-danger" role="alert">
                        Book cannot be deleted from the inventory because of its transaction history
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            <?php }
            }
            ?>
        </div>
        <div class="row my-5">
            <?php if (mysqli_num_rows($available_books) > 0) {

                while ($book = mysqli_fetch_assoc($available_books)) {

            ?>
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <div class="card text-dark shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="card-body">
                                <center>
                                    <img src="<?php echo $book["image"] ?>" height="188px" alt="" />
                                </center>
                                <hr>

                                <h4 class="text-dark"><i></i> <?php echo $book["title"] ?></h4><br />

                                <h6 class="text-dark"><i>Author - </i> <?php echo $book["author"] ?></h6>
                                <hr />
                                <h6 class="text-dark"><i>Genre - </i> <?php echo $book["category_name"] ?></h6>
                                <hr />
                                <b class="text-dark"><i>$</i> <?php echo $book["price"] ?>/-</b>
                                <hr />

                                <a href="book-details.php?book_id=<?php echo $book["book_id"] ?>" class="btn btn-purple"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <?php if ($_SESSION["role"] == "Librarian") { ?>
                                    <a href="update-book.php?book_id=<?php echo $book["book_id"] ?>" class="btn btn-purple"><i class="fa fa-pencil" aria-hidden="true"></i></a>


                                <?php } ?>
                                <?php if ($_SESSION["role"] == "Student") { ?>
                                    <a href="book-listing.php?request_book=true&book_id=<?php echo $book["book_id"] ?>" class="btn btn-purple"> Raise Book Request</a>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</div>

<?php include "bottom-bar.php" ?>