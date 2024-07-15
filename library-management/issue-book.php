<?php
include "header-section.php";


?>

<?php if (!isset($_SESSION['user_id'])) {
    header('location:user-login.php');
}

$stmt = $db_connection_object->prepare("SELECT br.request_id, br.book_id, br.student_id, u.name as student_name, b.title, br.request_status, 
br.request_date, nu.name as approved_by from borrow_request br
inner join user u on br.student_id = u.user_id
left join user nu on nu.user_id = br.approved_by
inner join book b on br.book_id = b.book_id
where br.request_status = 'requested'
");

$stmt->execute();
$all_requests = $stmt->get_result();
if (isset($_GET["approve_request"])) {
    $stmt = $db_connection_object->prepare("SELECT bc.copy_id 
    FROM book_copy bc 
    JOIN book_status bs ON bc.current_status_id = bs.status_id 
    WHERE bs.status = 'available' AND bc.book_id = ? 
    ORDER BY bc.copy_id 
    LIMIT 1");
    $stmt->bind_param("s",  $_GET["book_id"]);
    $stmt->execute();
    $stmt->bind_result($copy_id);
    $stmt->fetch();
    $stmt->close();

    if ($copy_id) {

        $stmt = $db_connection_object->prepare("UPDATE book_copy 
            SET current_status_id = (select status_id from book_status where status='borrowed')  
            WHERE copy_id = ?");
        $stmt->bind_param("s",  $copy_id);
        $stmt->execute();
        $stmt = $db_connection_object->prepare("insert into transaction(user_id, copy_id, borrow_date) values(?,?, CURRENT_DATE)");
        $stmt->bind_param("ss",  $_GET['student_id'],$copy_id);
        $stmt->execute();
        $stmt = $db_connection_object->prepare("update borrow_request set request_status='approved', approved_by=? where request_id=?");
        $stmt->bind_param("ss",  $_SESSION['user_id'], $_GET['request_id']);
        $stmt->execute();
        header('location:issue-book.php?approved_request=success');
    } else {
        header('location:issue-book.php?approved_request=fail');
    }
}

?>

<div style="">
    <div class="container">
        <div class=" mt-1">
            <div class="page-heading mt-4">
                <center>
                    <h2 class="text-light">Approve Request</h2>
                </center>
            </div>

            <?php if (isset($_GET["approved_request"])) {
                if ($_GET["approved_request"] == "success") { ?>
                    <div class="alert alert-success" role="alert">
                        Request has been approved successfully
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <?php } else { ?>
                    <div class="alert alert-danger" role="alert">
                        Currently none of the book copy is available
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
                                        <th scope="col">Request ID</th>
                                        <th scope="col">Student ID</th>
                                        <th scope="col">Student name</th>
                                        <th scope="col">Book title</th>
                                        <th scope="col">Request status</th>
                                        <th scope="col">Request date</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody>


                                    <?php while ($request = mysqli_fetch_assoc($all_requests)) { ?>
                                        <tr>
                                            <th scope="row"><?php echo $request["request_id"] ?></th>
                                            <td><?php echo $request["student_id"] ?></td>
                                            <td><?php echo $request["student_name"] ?></td>
                                            <td><?php echo $request["title"] ?></td>
                                            <td><?php echo $request["request_status"] ?></td>
                                            <td><?php echo $request["request_date"] ?></td>
                                            <td><a class="btn btn-purple" href="issue-book.php?approve_request=true&student_id=<?php echo $request["student_id"] ?>&book_id=<?php echo $request["book_id"] ?>&request_id=<?php echo $request["request_id"] ?>">Approve</a></td>

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