<?php

function getAd()
{
    $pdo = pdoSqlConnect();
    $query = "select adsId,
       adsMainImg,
       adsUrl
from Ads
order by rand() limit 1;";

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function isValidUser($id, $pw){
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(SELECT * FROM User WHERE userId= ? AND userPw = ?) AS exist;";


    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([$id, $pw]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st=null;$pdo = null;

    return intval($res[0]["exist"]);

}

function isExistPhone($phone){
    $pdo = pdoSqlConnect();
    $query = "SELECT exists(select userId from User where phone = ?) as exist;";

    $st = $pdo->prepare($query);
    $st->execute([$phone]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st=null;$pdo = null;

    return intval($res[0]["exist"]);
}

function isExistEmail($phone){
    $pdo = pdoSqlConnect();
    $query = "SELECT exists(select userId from User where email = ?) as exist;";

    $st = $pdo->prepare($query);
    $st->execute([$phone]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st=null;$pdo = null;

    return intval($res[0]["exist"]);
}

function isValidAdsId($id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(SELECT * FROM Ads WHERE adsId = ?) AS exist;";


    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([$id]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return intval($res[0]["exist"]);
}

function isValidUsersId($id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(SELECT * FROM User WHERE userId = ?) AS exist;";


    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([$id]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;
    return intval($res[0]["exist"]);

}

function isValidEmailUser($email, $password)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT password FROM User WHERE email = ?;";


    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([$email]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return password_verify($password, $res[0]["password"]);

}

function getIdFromEmailPw($email)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT userId FROM User WHERE email = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$email]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return intval($res[0]["userId"]);
}

function isValidPhoneUser($phone, $password)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT password FROM User WHERE phone = ?;";


    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([$phone]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;
    return password_verify($password, $res[0]["password"]);

}

function getIdFromPhonePw($phone)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT userId FROM User WHERE phone = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$phone]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;
    return intval($res[0]["userId"]);
}
// CREATE
//    function addMaintenance($message){
//        $pdo = pdoSqlConnect();
//        $query = "INSERT INTO MAINTENANCE (MESSAGE) VALUES (?);";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message]);
//
//        $st = null;
//        $pdo = null;
//
//    }


// UPDATE
//    function updateMaintenanceStatus($message, $status, $no){
//        $pdo = pdoSqlConnect();
//        $query = "UPDATE MAINTENANCE
//                        SET MESSAGE = ?,
//                            STATUS  = ?
//                        WHERE NO = ?";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message, $status, $no]);
//        $st = null;
//        $pdo = null;
//    }

// RETURN BOOLEAN
//    function isRedundantEmail($email){
//        $pdo = pdoSqlConnect();
//        $query = "SELECT EXISTS(SELECT * FROM USER_TB WHERE EMAIL= ?) AS exist;";
//
//
//        $st = $pdo->prepare($query);
//        //    $st->execute([$param,$param]);
//        $st->execute([$email]);
//        $st->setFetchMode(PDO::FETCH_ASSOC);
//        $res = $st->fetchAll();
//
//        $st=null;$pdo = null;
//
//        return intval($res[0]["exist"]);
//
//    }
