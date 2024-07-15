<?php
include "header-section.php";


?>

<?php if (!isset($_SESSION['user_id'])) {
    header('location:user-login.php');
}

$stmt = $db_connection_object->prepare("SELECT t.transaction_id, b.book_id, b.title, t.borrow_date, t.return_date , t.copy_id
FROM book b JOIN book_copy bc ON b.book_id = bc.book_id 
JOIN book_status bs ON bc.current_status_id = bs.status_id 
JOIN book_category cat ON b.category_id = cat.category_id 
JOIN transaction t ON bc.copy_id = t.copy_id WHERE t.user_id = ? AND t.return_date IS NULL GROUP BY b.book_id");
$stmt->bind_param("s",  $_SESSION['user_id']);
$stmt->execute();
$all_requests = $stmt->get_result();

if (isset($_GET["return_book"])) {
    $stmt = $db_connection_object->prepare("update transaction set return_date=CURRENT_DATE, fine_amount = CASE 
        WHEN DATEDIFF(CURRENT_DATE, borrow_date) > 7 THEN (DATEDIFF(CURRENT_DATE, borrow_date) - 7) * 5
        ELSE 0
    END where transaction_id=?");
    $stmt->bind_param("s",  $_GET["transaction_id"]);
      $stmt->execute();
  

    $stmt = $db_connection_object->prepare("update book_copy SET current_status_id = (select status_id from book_status where status='available') where copy_id=? ");
    $stmt->bind_param("s",  $_GET["book_copy_id"]);
      $stmt->execute();

    header('location:borrowed-books.php?returned_book=success');
}


?>

<div style="">
    <div class="container">
        <div class=" mt-1">
            <div class="page-heading mt-4">
                <center>
                    <h2 class="text-light">Borrowed Books</h2>
                </center>
            </div>

            <?php if (isset($_GET["returned_book"])) {
                if ($_GET["returned_book"] == "success") { ?>
                    <div class="alert alert-success" role="alert">
                        Book has been returned successfully
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <?php } 
            }
            ?>


        </div>
        <div class="row my-5">

            <div class="col">
                <div class="card text-dark shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="card-body">
                        <?php if (mysqli_num_rows($all_requests) > 0) { ?>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Book ID</th>
                                        <th scope="col">Book title</th>
                                        <th scope="col">Borrow date</th>
                                        <th scope="col">Return date</th>
                                        <th scope="col">Action</th>


                                    </tr>
                                </thead>
                                <tbody>


                                    <?php while ($request = mysqli_fetch_assoc($all_requests)) { ?>
                                        <tr>
                                            <th scope="row"><?php echo $request["book_id"] ?></th>
                                            <td><?php echo $request["title"] ?></td>
                               
                                            <td><?php echo $request["borrow_date"] ?></td>
                                            <td><?php if ($request["return_date"] == "") {
                                                  echo  "On or before ".date('Y-m-d', strtotime($request["borrow_date"] . ' +7 days'));
                                                } else { 
                                                    echo $request["borrow_date"];
                                                 } ?></td>
                                                 <?php
$days_diff = (strtotime(date('Y-m-d')) - strtotime($request["borrow_date"] )) / (60 * 60 * 24);
$fine = ($days_diff > 7) ? ($days_diff - 7) * 5 : 0;

                                                 ?>
                                            <td><a class="btn btn-purple" href="borrowed-books.php?return_book=true&transaction_id=<?php echo $request["transaction_id"] ?>&book_copy_id=<?php echo $request["copy_id"] ?>"><?php echo ($fine!=0)?"Pay $".$fine." & ":"" ?>Return book</a></td>



                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table><?php
                                } ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include "bottom-bar.php" ?>