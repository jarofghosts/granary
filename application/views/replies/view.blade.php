<?php

function buildTree($parent_object)
{

    $start_display = true;

    foreach ($parent_object->replies as $reply) {
        if ($start_display) {
            echo '<div>';
            $start_display = false;
        }
        echo View::make('replies.single_view')->with('reply', $reply);
        if ($reply->replies) {
            buildTree($reply);
        }
    }
    echo '</div>';

}
?>

<?php 
buildTree($post);
?>

