<?php
namespace App\Helper;

class Helper
{
    public static function randomstring($length = 5)
    {
        
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$randomIndex];
        }
    
        return $randomString;
    }
}