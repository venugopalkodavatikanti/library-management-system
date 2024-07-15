<?php
include "header-section.php";


?>

<?php if (!isset($_SESSION['user_id'])) {
    header('location:user-login.php');
}

$stmt = $db_connection_object->prepare("SELECT b.book_id, b.title, b.author, b.publisher, b.isbn, b.price, b.publication_year, 
cat.category_name, b.image, COUNT(bc.copy_id) AS available_copies 
FROM book b 
JOIN book_copy bc ON b.book_id = bc.book_id 
JOIN book_status bs ON bc.current_status_id = bs.status_id JOIN book_category cat ON b.category_id = cat.category_id 
WHERE bs.status = 'available' and b.book_id=? GROUP BY b.book_id HAVING COUNT(bc.copy_id) > 0");
$stmt->bind_param("s",$_GET["book_id"]);
$stmt->execute();
$selected_book = $stmt->get_result();



?>

<div style="">
    <div class="container">
        <div class=" mt-1">
        <div class="page-heading mt-4">
                    <center>
                        <h2 class="text-light">Book Details</h2>
                    </center>
                </div>


        </div>
        <div class="row my-5">
            <?php if (mysqli_num_rows($selected_book) > 0) {

                while ($book = mysqli_fetch_assoc($selected_book)) {

            ?>
                    <div class="col-sm-12">
                        <div class="card text-dark shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="card-body">
                                <center>
                                    <img src="<?php echo $book["image"] ?>" height="700px" alt="" />
                                </center>
                                <hr>

                                <h4 class="text-dark"><i></i> <?php echo $book["title"] ?></h4><br />

                                <h6 class="text-dark"><i>Author - </i> <?php echo $book["author"] ?></h6>
                                <hr />
                                <h6 class="text-dark"><i>Publisher - </i> <?php echo $book["publisher"] ?></h6>
                                <hr />
                                <h6 class="text-dark"><i>ISBN - </i> <?php echo $book["isbn"] ?></h6>
                                <hr />
                                <h6 class="text-dark"><i>Year of publication - </i> <?php echo $book["publication_year"] ?></h6>
                                <hr />
                                <b class="text-dark"><i>$</i> <?php echo $book["price"] ?>/-</b>
                                <hr />
                                
                                <b class="text-dark"><i>Genre - </i> <?php echo $book["category_name"] ?></b>
                                <hr />
                                
                                <b class="text-dark"><i>Total available copies - </i>Only <?php echo $book["available_copies"] ?> copies</b>
                            </div>
                        </div>
                    </div>
                    
            <?php }
            } ?>
        </div>
    </div>
</div>

<?php include "bottom-bar.php" ?>