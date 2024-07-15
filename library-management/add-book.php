<?php
include "header-section.php";

if (isset($_POST["add-book"])) {
    $stmt = $db_connection_object->prepare("insert into book(title, author, publisher, isbn, price, publication_year, image, category_id) values(?,?, ?,?,?,?,?,?)");
    $stmt->bind_param("ssssssss", $_POST["title"], $_POST["author"], $_POST["publisher"], $_POST["isbn"], $_POST["price"], $_POST["publication_year"], $_POST["image"], $_POST["category_id"]);
    $stmt->execute();

    $inserted_book_id = $db_connection_object->insert_id;

    $available_copies = $_POST["available_copies"];
    while ($available_copies > 0) {
        $stmt = $db_connection_object->prepare("insert into book_copy(book_id, current_status_id) values(?,(select status_id from book_status where status='available'))");
        $stmt->bind_param("s", $inserted_book_id);
        $stmt->execute();
        $available_copies--;
    }

    header('location:book-listing.php?added_book=success');
}

$stmt = $db_connection_object->prepare("select category_id, category_name from book_category");
$stmt->execute();
$book_categories = $stmt->get_result();


?>

<div class="container">
    <div class="page-heading mt-4">
        <center>
            <h2 class="text-light">Add New Book</h2>
        </center>
    </div>
    <div class="row my-5">
        <div class="col-sm-8 col-md-6 offset-sm-2 offset-md-3">

            <div class="card">
                <div class="card-body">
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title" required />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Author</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="author" required />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Publisher</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="publisher" required />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">ISBN</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="isbn" required />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Book price </label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">$</div>
                                </div>
                                <input type="text" class="form-control" id="inlineFormInputGroupUsername" name="price">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Year of publication</label>
                            <input type="number" min="1900" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="publication_year" required />
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Total Availabile Copies</label>
                            <input type="number" min="1" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="available_copies" required />

                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Book Genre</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="category_id" required>
                                <?php if (mysqli_num_rows($book_categories) > 0) {
                                    while ($book_category = mysqli_fetch_assoc($book_categories)) { ?>
                                        <option value="<?php echo $book_category["category_id"] ?>"><?php echo $book_category["category_name"] ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Book image url</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" name="image" required>
                        </div>
                        <br>
                        <center>
                            <button type="submit" class="btn btn-purple" name="add-book"><b>Add</b></button>
                        </center>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include "bottom-bar.php" ?>