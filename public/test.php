<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Тест ошибок";
throw new Exception("Тестовая ошибка");
