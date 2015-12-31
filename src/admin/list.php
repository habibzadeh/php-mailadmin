<?php
/**
 * Created by PhpStorm.
 * User: Habibzadeh
 * Date: 01/05/2015
 * Time: 11:40 AM
 */
$minUserLevel = 1;
$cfgProgDir = '../security/';
include($cfgProgDir . "secure.php");
include('ManageDatabase.php');
$TITLE = 'Email Accounts List.';
include_once(INC_PATH.'header.php');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="AccountList">
                <table class="EmailList">
                    <thead>
                        <tr>
                            <td>Id</td>
                            <td>Email</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($conn = new ManageDatabase()){
                            $query_result = $conn->MySql->query($conn->GetQueryString('emails'));
                            if($query_result){
                                while($row = $query_result->fetch_row()){
                                    echo '<tr>';
                                    echo '<td>'.$row[0].'</td>';
                                    echo '<td>'.$row[1].'</td>';
                                    echo '</tr>';
                                }
                                $query_result->close();
                            }
                            $conn->Close();
                            unset($conn);
                        }
                        else{
                            echo '<tr>';
                            echo '<td>'.'Database Error!'.'</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once(INC_PATH.'footer.php'); ?>