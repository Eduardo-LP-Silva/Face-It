<?php

    function print_r2($val)
    {
        echo '<pre>';
        print_r($val);
        echo  '</pre>';
    }

    function get_vote_path($points)
    {
        if(!empty($points))
        {
            $points = $points[0]['points'];

            if($points == 1)
            {
                $like_path = "../assets/like_pressed.png";
                $dislike_path = "../assets/dislike.png";
            }
            else
            {
                $like_path = "../assets/like.png";
                $dislike_path = "../assets/dislike_pressed.png";
            }
        }
        else
        {
            $like_path = "../assets/like.png";
            $dislike_path = "../assets/dislike.png";
        }

        return [$like_path, $dislike_path];
    }
?>