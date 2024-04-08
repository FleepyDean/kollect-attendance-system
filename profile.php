<?php
session_start();
if(empty($_SESSION['name']))
{
	header('location:index.php');
}
include('header.php');
include('includes/connection.php');
$id = $_SESSION['id'];
$fetch_data = mysqli_query($connection,"select * from tbl_employee where id='$id'");
$res = mysqli_fetch_array($fetch_data);
?>
        <div class="page-wrapper">
            <div class="content">
                
				<div class="row">

                       <div class="col-lg-8">
                        <div class="card-header">
                                <h4 class="page-title">Profile</h4>
                            </div>
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Employee ID</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $res['employee_id'];?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $res['first_name'];?> <?php echo $res['last_name']; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $res['emailid']; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Phone</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $res['phone']; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Gender</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $res['gender']; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Department</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $res['department']; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Shift</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $res['shift']; ?></p>
              </div>
            </div>
          </div>
        </div>
					  
				</div>
				
            </div>
            
        </div>
    
 <?php 
 include('footer.php');
?>