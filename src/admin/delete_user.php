<?php
/**
 * Created by PhpStorm.
 * User: Habibzadeh
 * Date: 01/05/2015
 * Time: 11:41 AM
 */
$minUserLevel = 3;
$cfgProgDir = '../security/';
include($cfgProgDir . "secure.php");
include('ManageUserDatabase.php');
require('EntryCheck.php');
$TITLE = 'Delete User Account.';
include_once(INC_PATH.'header.php');
if(isset($_SERVER['REQUEST_METHOD'])){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];
        $checks = new EntryCheck();
        if(!($checks->CheckEmail($email))){ ?>
            <script>ShowAlert('#FormAlert');</script>
        <?php }
        else{
            if($conn=new ManageUserDatabase()){
                if(($record_id = $conn->CheckForExistingUser($email)) > 0){ ?>
                    <script>
                        if(confirm("Are you sure ?")){
                            <?php if($conn->DeleteUser($record_id)){?>
                                    ShowAlert('#FormInfo');
                                <?php }else{ ?>
                                    ShowAlert('#DatabaseError');
                                <?php } ?>
                        }
                        else{
                            ShowAlert('#Canceled');
                        }
                    </script>
                <?php }else{ ?>
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
                        <div class="col-md-3">
                            <label for="email">Email Address : </label>
                        </div>
                        <div class="col-md-8">
                            <input name="email" type="email" size="50" value="">
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
                            <span class="alert-info" id="FormInfo">Account has been removed.</span>
                            <span class="alert-info" id="Canceled">Operation canceled.</span>
                            <span class="alert-danger" id="DatabaseError">Unable to complete your request.</span>
                            <span class="alert-danger" id="NotFound">User not found!</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include_once(INC_PATH.'footer.php'); ?>