<?php
session_start();
if(empty($_SESSION['name'])) {
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');

$id = $_SESSION['id']; // Retrieve the logged-in employee ID from session

// SQL query to select attendance records for the logged-in employee
$fetch_query = mysqli_query($connection, "SELECT tbl_attendance.date, tbl_attendance.shift, tbl_attendance.check_in, tbl_attendance.message, tbl_attendance.in_status, tbl_attendance.check_out, tbl_attendance.out_status FROM tbl_attendance INNER JOIN tbl_employee ON tbl_attendance.employee_id = tbl_employee.employee_id WHERE tbl_employee.id='$id'");

?>
<div class="page-wrapper">
    <div class="content">
                <h1 class="page-title">Employee Attendance History</h1>
        <div class="table-responsive">
            <table class="datatable table table-stripped ">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Shift</th>
                        <th>Clock In</th>
                        <th>Notes</th>
                        <th>In Status</th>
                        <th>Clock Out</th>
                        <th>Out Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = mysqli_fetch_array($fetch_query)) {
                    ?>
                    <tr>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['shift']; ?></td>
                        <td><?php echo $row['check_in']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td><?php echo $row['in_status']; ?></td>
                        <td><?php echo $row['check_out']; ?></td>
                        <td><?php echo $row['out_status']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
