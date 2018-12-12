<section id="stories"> <!-- Get with php from DB, change href's accordingly -->
    <?php foreach($stories as $story)
    { ?>
        <div class="story" id=<?=$story['ID']?>>
            <?php $points = get_personal_story_votes($story['ID'], 'Des_locado'); //Mudar para user
                $paths = get_vote_path($points);
                $like_path = $paths[0];
                $dislike_path = $paths[1];
            ?>

            <img src=<?php echo $like_path ?> alt="Like Button"/>
            <p> <?=$story['points']?> </p>
            <img src=<?php echo $dislike_path ?> alt="Dislike Button" />
            <a href="../post/post.php"> <?=$story['title']?> </a> <!-- Change href's to post -->
            <a href="front_page.html"> <img src=<?php if($story['picture' == null]) echo '../assets/no_image.png'?>
                alt="Post's minimized image or logo" /> </a> <!-- Change href's to post   -->
            <img src="../assets/comment.png" alt="Comment Symbol"/> <!-- Change href's to post -->
            <p> <?=$story['comment_number']?> </p>
            <img src="../assets/op.png" alt="OP Icon"/>
            <a href="front_page.html"> <?=$story['username']?> </a> <!-- Change href's to OP's profile -->
            <img src="../assets/channel.png" alt="Channel Icon"/>
            <a href="front_page.html"> <?=$story['channel_name']?> </a> <!-- Change href's to channel -->
        </div>
        <?php
    } ?>
</section>