<?php

class LogOutController
{
    public function logOut()
    {
        $_SESSION = [];
        session_destroy();

        header('Location: /');
        exit;
    }
}
