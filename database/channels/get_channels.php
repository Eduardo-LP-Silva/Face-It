<?php

    function get_subscribed_channels($username)
    {
        global $db;

        $stmt = $db->prepare
        (
            'SELECT channel.channel_name as channel
            FROM channel, client_channel, client
            WHERE client.username = client_channel.client
            AND channel.channel_name = client_channel.channel
            AND client.username = ?'
        );
        $stmt->execute(array($username));

        $user_channels = $stmt->fetchAll();

        return $user_channels;
    }

    function get_channel_info($channel)
    {
        global $db;

        $stmt = $db->prepare
        (
            'SELECT channel.channel_description as channel_description, count(client_channel.client) as subscribers
            FROM channel, client_channel
            WHERE channel.channel_name = ?
            AND client_channel.channel = channel.channel_name'
        );
        $stmt->execute(array($channel));

        $channel = $stmt->fetch();

        return $channel;
    }
?>