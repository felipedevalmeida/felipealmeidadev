<?php
require 'config.php';

log_activity("Usuário deslogado");
session_destroy();
redirect('login.php');