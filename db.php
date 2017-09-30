<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 11:18 AM
 */
    $DB_hostname = "smashdb.kaffine.tech";
    $DB_username = "smash_reg_user";
    $DB_password = fgets(fopen($_SERVER['DOCUMENT_ROOT'] .'/thing', 'r'));
    $DB_databasename = "smashdb";
?>