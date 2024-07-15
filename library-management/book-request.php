<?php
include "header-section.php";


?>

<?php if (!isset($_SESSION['user_id'])) {
    header('location:user-login.php');
}

$stmt = $db_connection_object->prepare("SELECT br.request_id, br.student_id, u.name as student_name, b.title, br.request_status, 
br.request_date, nu.name as approved_by from borrow_request br
inner join user u on br.student_id = u.user_id
left join user nu on nu.user_id = br.approved_by
inner join book b on br.book_id = b.book_id
where br.student_id = ?
");
$stmt->bind_param("s",  $_SESSION['user_id']);
$stmt->execute();
$all_requests = $stmt->get_result();


?>

<div style="">
    <div class="container">
        <div class=" mt-1">
            <div class="page-heading mt-4">
                <center>
                    <h2 class="text-light">Request Summary</h2>
                </center>
            </div>

            <?php if (isset($_GET["borrow_request"])) {
                if ($_GET["borrow_request"] == "success") { ?>
                    <div class="alert alert-success" role="alert">
                        Request has been raised successfully
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <?php } else { ?>
                    <div class="alert alert-danger" role="alert">
                        Request is already raised for this book.
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
                                        <th scope="col">Approved by</th>
                               
                                       
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
                                            <td><?php echo $request["approved_by"] ?></td>
                                            
                                        
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