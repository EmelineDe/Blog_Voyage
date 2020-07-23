<?php


function getExtrait($db)
{


    $sql = 'select * from articles join pays on articles.idpay = pays.idpay';
    $res = $db->prepare($sql);
    $res->execute();

    return ($res->fetchAll(PDO::FETCH_ASSOC));
}

function getArticles($db)
{
    $sql = 'select * from articles join pays on articles.idpay = pays.idpay order by articles.idpay asc';

    $res = $db->query($sql);

    return ($res->fetchAll(PDO::FETCH_ASSOC));
}


function getArticleById($db, $idart)
{
    $sql = 'select * from articles join pays on articles.idpay = pays.idpay where articles.idarticle = :id';
    $res = $db->prepare($sql);
    $res->bindParam(':id', $idart, PDO::PARAM_INT);
    $res->execute();
    return ($res->fetch(PDO::FETCH_ASSOC));
}

function getusers($db, $id)
{

    $sql = 'SELECT idusers FROM users WHERE idusers = :id';
    $res = $db->prepare($sql);
    $res->bindParam(':id', $id, PDO::PARAM_INT);
    $res->execute();
    return $res->fetch();
}

function getCommentsbyid($db, $id)
{

    $sql = 'SELECT * from commentaires 
            join users on commentaires.idusers = users.idusers 
            join articles on commentaires.idarticle = articles.idarticle 
            where articles.idarticle = :id 
            order by idcommentaire asc';

    $res = $db->prepare($sql);
    $res->bindParam(':id', $id, PDO::PARAM_INT);
    $res->execute();
    return ($res->fetchAll(PDO::FETCH_ASSOC));
}

function getGestionComments($db)
{

    $sql = 'SELECT * from commentaires
            join users on commentaires.idusers = users.idusers 
            join articles on commentaires.idarticle = articles.idarticle 
            join pays on articles.idpay = pays.idpay WHERE commentaires.valided = 0
            order by idcommentaire asc';

    $res = $db->prepare($sql);
    $res->execute();
    return ($res->fetchAll(PDO::FETCH_ASSOC));
}

function getImage($db)
{

    $sql = 'SELECT 
                articles.idarticle,
                articles.imageName,
                articles.idpay,
                pays.nom_fr_fr 
            FROM 
                articles JOIN pays ON articles.idpay = pays.idpay 
            WHERE 
                articles.idpay is not null 
            order by pays.nom_fr_fr asc';

    $res = $db->prepare($sql);
    $res->execute();
    return ($res->fetchAll(PDO::FETCH_ASSOC));
}

function search($db, $mot)
{
    $sql = "SELECT articles.idarticles as id, articles.titre as titre, 
    articles.contenu, pays.nom_fr_fr as namecountry FROM article
     WHERE articles.idarticle = pays.idpay AND articles.titre LIKE :mot 
    OR articles.contenu LIKE :mot ORpays.nom_fr_fr LIKE :mot";

    $stmp = $db->prepare($sql);
    $stmp->bindValue(":mot", '%' . $mot . '%');
    $stmp->execute();
}
