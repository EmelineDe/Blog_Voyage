<?php

require 'connect.php';

function footer($db)
{
    $sql = 'select imageName from articles order by idarticle asc limit 6';

    $res = $db->query($sql);

    return ($res->fetchAll(PDO::FETCH_ASSOC));
}
