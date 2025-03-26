<?php
require_once __DIR__ . '/../models/Course.php';

$courses = Course::getAll();
include __DIR__ . '/../views/courses/list.php';
?>