<?php
    function restrict_role($role) {
        if($_SESSION['user_role'] != $role) {
            return False;
        }
        return True;
    }
?>