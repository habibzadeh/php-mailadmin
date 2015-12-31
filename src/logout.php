<?php
    $logout = true;
    $cfgProgDir = 'security/';
    include($cfgProgDir . "secure.php");
    define('ABS_PATH',dirname(__FILE__).'/inc/');
    require_once(ABS_PATH.'header.php');
?>
<div class="container SpacingTop">
    <div class="row SpacingTop">
        <div class="col-md-12 center-block text-center SpacingTop">
            <P><IMG SRC="security/images/logo.png"  ALT="Palizafzar"></P>
            <p><a href="/">Home</a></p>
            <div id="logout">You have been logged out.</div>
        </div>
    </div>
</div>
<?php require_once(ABS_PATH.'footer.php');?>