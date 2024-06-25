<?php

function updateAdminProfile($action_done, $actionAmout, $admNick, $mySql){
    //think theres also need for validation
    $updateAdminData = "UPDATE admins SET $action_done = $action_done+$actionAmout WHERE user = ?";
    $updateStmt = $mySql->prepare($updateAdminData);
    $updateStmt->bind_param('s', $admNick);
    $updateStmt->execute();
    $updateStmt->close();    
}

?>