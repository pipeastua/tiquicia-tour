<?php
require_once __DIR__ . '/../Models/Activity.php';
class ActivityController
{
    public function index()
    {
        $activities = Activity::getAll();
        include __DIR__ . '/../Views/activities/index.php';
    }
}
