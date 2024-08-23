<?php


function dd($bug)
{
    echo "<pre>" . print_r($bug, true) . "</pre>";
    die;
}