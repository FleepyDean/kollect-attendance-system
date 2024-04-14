<?php
session_start();
error_reporting(0);
if(empty($_SESSION['name']))
{
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');
$id = $_SESSION['id'];
$fetch_query = mysqli_query($connection, "select shift from tbl_employee where id='$id'");
$shift = mysqli_fetch_array($fetch_query);

$fetch_emp = mysqli_query($connection, "select * from tbl_employee where id='$id'");
$emp = mysqli_fetch_array($fetch_emp);
$empid = $emp['employee_id'];
$dept = $emp['department'];

$curr_date = date('Y-m-d');
date_default_timezone_set('Asia/Kuala_Lumpur');
$time = date('Y-m-d H:i:s');
$intime = "";
$outtime = "";
$checkout_status='';
$shifttime = $shift['shift']; 
$shifttime = substr($shifttime, 0,8);
if(time()>strtotime($shifttime))
{
  $intime = "Late";
}
else
{
  $intime = "On Time";
} 

$outtimeshift = $shift['shift'];
$outtimeshift = substr($outtimeshift, -8);

if(time()>strtotime($outtimeshift))
{
  $outtime = "Over Time";
}
else
{
  $outtime = "Early";
}


    if(isset($_REQUEST['turn-it']))
    {
      $shift = $shift['shift'];
      $department = $dept;
      $location = $_REQUEST['location'];
      $msg = $_REQUEST['msg'];
      $emp_id = $empid;
      $date = $curr_date;
      $check_in = $time;
      $in_status = $intime;
      

      
      $insert_query = mysqli_query($connection, "insert into tbl_attendance set employee_id='$emp_id', department='$department', shift='$shift', location='$location', message='$msg', date='$date',  check_in='$check_in', in_status='$in_status'");

      if($insert_query) {
        $check_in_query = mysqli_query($connection, "select check_in from tbl_attendance where employee_id='$empid' and date='$curr_date'");
        $check_in_row = mysqli_fetch_array($check_in_query);
        $check_in_time = $check_in_row['check_in'];
    
        $message = "Successfully clocked in at $check_in_time";
      } else {
        $message = "Clock in failed";
      }
    }
?>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4 ">
                        <h4 class="page-title">Employee Attendance Form</h4>
                         
                    </div>
                    
                </div>
                <div class="row">
                  <?php
                   $date = date('Y-m-d');
                   $fetch_attend = mysqli_query($connection,"select employee_id from tbl_attendance where date='$date' and employee_id='$empid'");
                  $row = mysqli_num_rows($fetch_attend);
                  if($row==0){
                   ?>
                    <div class="col-lg-8 offset-lg-2">
                       <form method="post">
                            <div class="row">
                              <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Shift <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="shift" value="<?php echo $shift['shift']; ?>" disabled>
                                          
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Location <span class="text-danger">*</span></label>
                                        <select class="select" name="location" required>
                                            <option value="">Select</option>
                                            <?php
                                             $fetch_query = mysqli_query($connection, "select location from tbl_location");
                                                while($loc = mysqli_fetch_array($fetch_query)){ 
                                            ?>
                                            <option value="<?php echo $loc['location']; ?>"><?php echo $loc['location']; ?></option>
                                            <?php } ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Message </label>
                                        <textarea class="form-control" name="msg"></textarea>  
                                          
                                    </div>
                                </div>
                               
                    </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn" name="turn-it"><img src="assets/img/login.png" width="40"> Clock In</button>
                            </div>
                        </form>
                    </div>
                  <?php } else {
                    
                    $fetch_checkin = mysqli_query($connection,"select date from tbl_attendance where check_out='00:00:00' and employee_id='$empid'");
                    $rows = mysqli_num_rows($fetch_checkin);
                    $check_in_time = $checkin_row['check_in'];

                    if($rows>0){
                    $data = mysqli_fetch_array($fetch_checkin);
                    $chekdate = $data['date'];
                    }
                    if(isset($_REQUEST['check-out'])) {
                      $check_out = $time;
                      $insert_query = mysqli_query($connection, "update tbl_attendance set check_out='$check_out', out_status='$outtime' where employee_id='$empid' and date='$chekdate'");
                      $checkout_status = 0;
                  
                      if($insert_query) {
                        $check_out_query = mysqli_query($connection, "select check_out from tbl_attendance where employee_id='$empid' and date='$curr_date'");
                        $check_out_row = mysqli_fetch_array($check_out_query);
                        $check_out_time = $check_out_row['check_out'];
                    
                        $message = "Successfully clocked out at $check_out_time";
                      } else {
                        $message = "Clock out failed";
                      }
                  }
                    ?>
                    
                   <div class="col-lg-12 offset-lg-2">
                       <div class="row">
                              <div class="col-sm-6">
                              <h3><center><?php echo isset($message) ? $message : $message; ?><center></h3>
                    <form method="post">
                     <div class="m-t-20 text-center">
                      <?php
                      $curr_date = date('Y-m-d');
                      $fetch_checkout = mysqli_query($connection,"select out_status from tbl_attendance where date='$curr_date' and employee_id='$empid'");
                      $check_out_time = $checkout_row['check_out'];
                      $result = mysqli_fetch_array($fetch_checkout);
                      $result = $result['out_status'];
                      if($result=='' || $checkout_status==1){
                      ?>
                                <button class="btn btn-primary submit-btn" name="check-out" onclick="return confirmDelete()"><img src="assets/img/clock.png" width="40">  Clock Out</button>
                      <?php  } else{?>
                        <button disabled class="btn btn-primary submit-btn" name="check-out" onclick="return confirmDelete()"><img src="assets/img/clock.png" width="40">  Done!</button>
                        <h5>See you tomorrow!</h5>
                      <?php } ?>
                              
                            </div>
                          </form>
                          </div>
                        </div>
                      </div>
                   
                  <?php } ?>

                </div>
            </div>
		</div>
    
<?php
    include('footer.php');
?>
<script>
function confirmDelete(){
    return confirm('Are you sure want to check out now?');
}
</script>