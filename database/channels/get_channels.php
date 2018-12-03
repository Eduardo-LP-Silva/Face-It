<?php
    function getSubscribedChannels($username)
    {
        global $db;

        $stmt = $db->prepare
        (
            'SELECT channel_name
            FROM channel, client, client_channel
            WHERE client_channel.channel = channel_name
            and channel.client = client.username
            and client.username = ' . $username;
        );
    }
?>