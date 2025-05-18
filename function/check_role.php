<?php

    function restrict_admin() {
        if($_SESSION['user_role'] != "admin") {
            die("You Don't Have Access To This Page");
        }
    }

    function restrict_supervisor() {
        if($_SESSION['user_role'] != "supervisor") {
            die("You Don't Have Access To This Page");
        }
    }

    function restrict_student() {
        if($_SESSION['user_role'] != "student") {
            die("You Don't Have Access To This Page");
        }
    }
?>