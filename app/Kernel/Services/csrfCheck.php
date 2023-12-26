<?php

function checkToken($inputToken)
{
    if($inputToken && hash_equals($inputToken, $_SESSION['TOKEN'])){
        return true;
    }
    return false;
}