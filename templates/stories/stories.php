<section id="stories">
    <?php foreach($stories as $story)
    { ?>
        <div class="story" id=<?=htmlspecialchars($story['ID'])?>>
            <?php $points = get_personal_story_votes($story['ID'], $_SESSION['username']);
                $paths = get_vote_path($points);
                $like_path = $paths[0];
                $dislike_path = $paths[1];
            ?>

            <img src=<?php echo $like_path ?> alt="Like Button"/>
            <p> <?=$story['points']?> </p>
            <img src=<?php echo $dislike_path ?> alt="Dislike Button" />
            <a href=<?= "../post/post.php?post=" . $story['ID']?>> <?=htmlspecialchars($story['title'])?> </a> <!-- Change href's to post -->
            <img src=<?php if($story['picture'] == null) {echo '../assets/no_image.png';}
                else echo htmlspecialchars($story['picture']);?>
                alt="Post's minimized image or logo" />
            <img src="../assets/comment.png" alt="Comment Symbol"/>
            <p> <?=$story['comment_number']?> </p>
            <img src="../assets/op.png" alt="OP Icon"/>
            <a href=<?="../profile/profile_posts.php?user=" . $story['username']?>> <?=$story['username']?> </a> 
            <img src="../assets/channel.png" alt="Channel Icon"/>
            <a href=<?="../channels/channel.php?channel=" . htmlspecialchars($story['channel_name'])?>> 
                <?=htmlspecialchars($story['channel_name'])?> </a>
        </div>
        <?php
    } ?>
</section>