<?php
/**
 * Created by PhpStorm.
 * User: Habibzadeh
 * Date: 01/05/2015
 * Time: 11:40 AM
 */
$minUserLevel = 3;
$cfgProgDir = '../security/';
include($cfgProgDir . "secure.php");
include('ManageUserDatabase.php');
require('EntryCheck.php');
$TITLE = 'Edit User';
include_once(INC_PATH.'header.php');
if(isset($_SERVER['REQUEST_METHOD'])){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $re_password = $_POST['re_password'];
        $level = $_POST['level'];
        $checks = new EntryCheck();
        if(!($checks->CheckEmail($email)) || !($checks->CheckForSamePassword($password,$re_password)) || !($checks->CheckUserAccessLevel($level))){
        ?>
            <script>ShowAlert('#FormAlert');</script>
        <?php
        }
        else{
            if($conn=new ManageUserDatabase()){
                $record_id = $conn->CheckForExistingUser($email);
                if($record_id > 0){
                    if($conn->UpdateUser($record_id,$password,$level)){
                    ?>
                        <script>ShowAlert('#FormInfo');</script>
                    <?php
                    }else{
                    ?>
                        <script>ShowAlert('#UnSuccess');</script>
                    <?php
                    }
                }
                else{ ?>
                    <script>ShowAlert('#NotFound');</script>
                <?php }
                $conn->Close();
                unset($conn);
            }
        }
    }
}
?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 Window ResetRight ResetLeft">
                <h5 class="FormTitle"><?php echo $TITLE; ?></h5>
                <form class="NewAccount" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
                    <div class="row SpacingBottom">
                        <div class="col-md-4">
                            <label for="email">Email Address : </label>
                        </div>
                        <div class="col-md-8">
                            <input name="email" type="email" size="50" value="">
                        </div>
                    </div>
                    <div class="row SpacingBottom">
                        <div class="col-md-4">
                            <label for="level">User Access Level : </label>
                        </div>
                        <div class="col-md-8">
                            <input name="level" type="number" size="3" value="1">
                        </div>
                    </div>
                    <div class="row SpacingBottom">
                        <div class="col-md-4">
                            <label for="password">New Password : </label>
                        </div>
                        <div class="col-md-8">
                            <input name="password" type="password" size="20" value="">
                        </div>
                    </div>
                    <div class="row SpacingBottom">
                        <div class="col-md-4">
                            <label for="re_password">Confirm New Password : </label>
                        </div>
                        <div class="col-md-8">
                            <input name="re_password" type="password" size="20" value="">
                        </div>
                    </div>
                    <div class="row SpacingTop">
                        <div class="col-md-12 center-block text-center">
                            <input name="submit" value="submit" type="submit">
                        </div>
                    </div>
                    <div class="row SpacingTop">
                        <div class="col-md-12 center-block text-center">
                            <span class="alert-danger" id="FormAlert">Please correct information and resubmit the form.</span>
                            <span class="alert-info" id="FormInfo">Password has been changed.</span>
                            <span class="alert-danger" id="DatabaseError">Database unreachable.</span>
                            <span class="alert-danger" id="NotFound">Email Address not found!</span>
                            <span class="alert-danger" id="UnSuccess">Unable to change password!</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include_once(INC_PATH.'footer.php'); ?>