<?php

namespace GDForm\Core\Admin;

trait Listener
{

    public static function isRequest($page, $task, $method = 'GET')
    {
        return ($_SERVER['REQUEST_METHOD'] === $method && isset($_GET['page']) && $_GET['page'] === $page && isset($_GET['task']) && $_GET['task'] === $task);
    }

}