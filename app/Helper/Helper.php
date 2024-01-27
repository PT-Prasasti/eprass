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

    public static function timeago($datetime) {
        $now = new \DateTime();
        $ago = new \DateTime($datetime);
        $interval = $now->diff($ago);
    
        if ($interval->y > 0 || $interval->m > 1) {
            return $ago->format('d F Y H:i');
        } elseif ($interval->m > 0) {
            return $interval->format('%m month'.($interval->m > 1 ? 's' : '').' ago');
        } elseif ($interval->d > 0) {
            return $interval->format('%d day'.($interval->d > 1 ? 's' : '').' ago');
        } elseif ($interval->h > 0) {
            return $interval->format('%h hour'.($interval->h > 1 ? 's' : '').' ago');
        } elseif ($interval->i > 0) {
            return $interval->format('%i minute'.($interval->i > 1 ? 's' : '').' ago');
        } else {
            return 'Just now';
        }
    }
}