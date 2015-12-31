<?php
/**
 * Created by PhpStorm.
 * User: Habibzadeh
 * Date: 12/27/2014
 * Time: 02:40 PM
 */
$cfgProgDir = 'security/';
include($cfgProgDir . "secure.php");
define('ABS_PATH',dirname(__FILE__).'/inc/');
require_once(ABS_PATH.'header.php');
?>
<div id="Wrapper" class="container">
    <div class="row">
        <div class="col-md-4">
            <div id="SideBar">
                <div id="SideBarHead">
                    <span>Account : </span>
                    <span><strong><?php echo $login ?></strong></span>
                </div>
                <div id="Management">
                    <span class="MenuTitle">Email Management</span>
                    <ul class="SideBarMenu">
                        <li><a href="<?php echo SERVER_NAME ?>/admin/list.php" target="RightPanel">List Accounts</a></li>
                        <li><a href="<?php echo SERVER_NAME ?>/admin/new.php" target="RightPanel">New Account</a></li>
                        <li><a href="<?php echo SERVER_NAME ?>/admin/delete.php" target="RightPanel">Delete Account</a></li>
                        <li><a href="<?php echo SERVER_NAME ?>/admin/password.php" target="RightPanel">Change Password</a></li>
                    </ul>
                </div>
                <div id="Administrator">
                    <span class="MenuTitle">User Management</span>
                    <ul class="SideBarMenu">
                        <li><a href="<?php echo SERVER_NAME ?>/admin/list_user.php" target="RightPanel">List Users</a></li>
                        <li><a href="<?php echo SERVER_NAME ?>/admin/new_user.php" target="RightPanel">New User</a></li>
                        <li><a href="<?php echo SERVER_NAME ?>/admin/delete_user.php" target="RightPanel">Delete User</a></li>
                        <li><a href="<?php echo SERVER_NAME ?>/admin/password_user.php" target="RightPanel">Edit User</a></li>
                    </ul>
                </div>
                <div id="Logout">
                    <a id="LogoutLink" href="<?php echo SERVER_NAME ?>/logout.php">Logout</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <iframe name="RightPanel" class="Frames"></iframe>
        </div>
    </div>
</div>
<?php require_once(ABS_PATH.'footer.php'); ?>