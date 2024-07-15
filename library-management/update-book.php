<?php
include "header-section.php";

if (isset($_POST["update-book"])) {
    $stmt = $db_connection_object->prepare("update book set title =? , author=?, publisher=?, isbn=?, price=?, publication_year=?, image=?, category_id=? where book_id=?");
    $stmt->bind_param("sssssssss", $_POST["title"], $_POST["author"], $_POST["publisher"], $_POST["isbn"], $_POST["price"], $_POST["publication_year"], $_POST["image"], $_POST["category_id"], $_POST["book_id"]);
    $stmt->execute();

    header('location:book-listing.php?updated_book=success');
}

if (isset($_POST["update-copy"])) {
    $stmt = $db_connection_object->prepare("update book_copy set current_status_id = ? where copy_id=?");
    $stmt->bind_param("ss", $_POST["current_status_id"], $_POST["copy_id"]);
    $stmt->execute();

    header('location:book-listing.php?updated_book=success');
}

if (isset($_GET["delete-book"])) {
    $stmt = $db_connection_object->prepare("select t.copy_id from transaction t inner join book_copy bc on t.copy_id=bc.copy_id
    inner join book b on bc.book_id = b.book_id where b.book_id=? ");
    $stmt->bind_param("s", $_GET["book_id"]);
      $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
        header('location:book-listing.php?deleted_book=fail');
    } else {
        $stmt = $db_connection_object->prepare("delete from book_copy where book_id=?");
        $stmt->bind_param("s", $_GET["book_id"]);
        $stmt->execute();
        $stmt = $db_connection_object->prepare("delete from book where book_id=?");
        $stmt->bind_param("s", $_GET["book_id"]);
        $stmt->execute();
    
        header('location:book-listing.php?deleted_book=success');
    }
    
}

$stmt = $db_connection_object->prepare("select category_id, category_name from book_category");
$stmt->execute();
$book_categories = $stmt->get_result();

$stmt = $db_connection_object->prepare("SELECT b.book_id, b.title, b.author, b.publisher, b.isbn, b.price, b.publication_year, 
cat.category_name, cat.category_id, b.image, COUNT(bc.copy_id) AS available_copies 
FROM book b 
JOIN book_copy bc ON b.book_id = bc.book_id 
JOIN book_status bs ON bc.current_status_id = bs.status_id JOIN book_category cat ON b.category_id = cat.category_id 
WHERE  b.book_id=? GROUP BY b.book_id HAVING COUNT(bc.copy_id) > 0");
$stmt->bind_param("s", $_GET["book_id"]);
$stmt->execute();
$selected_book = $stmt->get_result();

$stmt = $db_connection_object->prepare("SELECT copy_id, current_status_id, status
FROM book_copy inner join book_status on book_copy.current_status_id = book_status.status_id
WHERE book_id = ?");
$stmt->bind_param("s", $_GET["book_id"]);
$stmt->execute();
$book_copies = $stmt->get_result();



?>

<div class="container">
    <div class="page-heading mt-4">
        <center>
            <h2 class="text-light">Update Book</h2>
        </center>
    </div>
    <div class="row my-5">
        <div class="col-sm-8 col-md-6 offset-sm-2 offset-md-3">

            <div class="card">
                <div class="card-body">

                    <form action="#" method="post">
                        <?php if (mysqli_num_rows($selected_book) > 0) {
                            while ($book = mysqli_fetch_assoc($selected_book)) { ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title" value="<?php echo $book["title"] ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Author</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="author" value="<?php echo $book["author"] ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Publisher</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="publisher" value="<?php echo $book["publisher"] ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">ISBN</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="isbn" value="<?php echo $book["isbn"] ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Book price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">$</div>
                                        </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroupUsername" value="<?php echo $book["price"] ?>" name="price">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Year of publication</label>
                                    <input type="number" min="1900" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="publication_year" value="<?php echo $book["publication_year"] ?>" required />
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Book Genre</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="category_id" required>
                                        <?php if (mysqli_num_rows($book_categories) > 0) {
                                            while ($category = mysqli_fetch_assoc($book_categories)) { ?>
                                                <option value="<?php echo $category["category_id"] ?>" <?php if ($category["category_id"] == $book["category_id"]) { ?> selected<?php } ?>><?php echo $category["category_name"] ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Book Image url</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" name="image" value="<?php echo $book["image"] ?>" required>
                                </div>
                                <input type="hidden" name="book_id" value="<?php echo $book["book_id"] ?>">
                                <br>
                                <center>
                                    <button type="submit" class="btn btn-purple" name="update-book"><b>Update Book Details</b></button>
                                </center>
                    
                        <?php }
                        } ?>
                    </form>
                    

                </div></div>
                <div class="card mt-4">
                <div class="card-body">
                <center>
            <h3 class="text-dark">Update Book Copy Status</h3>
        </center>
                    <?php if (mysqli_num_rows($book_copies) > 0) { ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Book Copy ID</th>
                                    <th scope="col">Current Status</th>
                                    <th scope="col">Update Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>



                                <?php while ($book_copy = mysqli_fetch_assoc($book_copies)) {



                                    $stmt = $db_connection_object->prepare("select status_id, status from book_status");
                                    $stmt->execute();
                                    $book_statuses = $stmt->get_result();

                                ?>

                                    <tr>
                                        <th scope="row"><?php echo $book_copy["copy_id"] ?></th>
                                        <td><?php echo $book_copy["status"] ?></td>
                                        <form action="#" method="post">
                                        <td>


                                            <select class="form-control" id="exampleFormControlSelect1" name="current_status_id" required>
                                                <?php if (mysqli_num_rows($book_statuses) > 0) {
                                                    while ($book_status = mysqli_fetch_assoc($book_statuses)) { ?>
                                                        <option value="<?php echo $book_status["status_id"] ?>" <?php if ($book_status["status_id"] == $book_copy["current_status_id"]) { ?> selected<?php } ?>><?php echo $book_status["status"] ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                            <input type="hidden" name="copy_id" value="<?php echo $book_copy["copy_id"] ?>">
                                        </td>
                                        <td><button type="submit" class="btn btn-purple" name="update-copy">Update</button></td>
                                        </form>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                    <hr><hr>
                    <h6>Do you want to delete all available copies of this book?</h6>
                    <a href="update-book.php?delete-book=true&book_id=<?php echo $_GET["book_id"] ?>" class="btn btn-purple">Yes, Delete</a>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include "bottom-bar.php" ?>