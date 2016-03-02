<?php


//date_default_timezone_set('Asia/Yekaterinburg');
echo time_elapsed_string('2016-03-01 14:44:48');

echo date("Y-m-d H:i:s");

//echo timeAgo(strtotime('2016-03-01 13:22:35'));



function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function timeAgo($time_ago){
    $cur_time 	= time();
    $time_elapsed 	= $cur_time - $time_ago;
    $seconds 	= $time_elapsed ;
    $minutes 	= round($time_elapsed / 60 );
    $hours 		= round($time_elapsed / 3600);
    $days 		= round($time_elapsed / 86400 );
    $weeks 		= round($time_elapsed / 604800);
    $months 	= round($time_elapsed / 2600640 );
    $years 		= round($time_elapsed / 31207680 );
// Seconds
    if($seconds <= 60){
        echo "$seconds seconds ago";
    }
//Minutes
    else if($minutes <=60){
        if($minutes==1){
            echo "one minute ago";
        }
        else{
            echo "$minutes minutes ago";
        }
    }
//Hours
    else if($hours <=24){
        if($hours==1){
            echo "an hour ago";
        }else{
            echo "$hours hours ago";
        }
    }
//Days
    else if($days <= 7){
        if($days==1){
            echo "yesterday";
        }else{
            echo "$days days ago";
        }
    }
//Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            echo "a week ago";
        }else{
            echo "$weeks weeks ago";
        }
    }
//Months
    else if($months <=12){
        if($months==1){
            echo "a month ago";
        }else{
            echo "$months months ago";
        }
    }
//Years
    else{
        if($years==1){
            echo "one year ago";
        }else{
            echo "$years years ago";
        }
    }
}