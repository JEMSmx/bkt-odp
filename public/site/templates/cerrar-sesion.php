<?php

if($user->isLoggedin()) {
  $session->logout();
}

$session->redirect('/iniciar-sesion');
