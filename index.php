<?php
include("config.php");
foreach (glob("assets/classes/*.php") as $filename)
{
    include $filename;
}
?>