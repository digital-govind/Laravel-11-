<?php

function getRedisKey(string $type, string $key)
{
    switch ($type) {
        case 'auth':
            return 'auth:' . $key;
            break;
        case 'user':
            return 'user:' . $key;
            break;
        // case 'feed:count':
        //     return 'user:feed:count:' . $key;
        //     break;
        // case 'follower:count':
        //     return 'user:follower:count:' . $key;
        //     break;
        // case 'followig:count':
        //     return 'user:following:count:' . $key;
        //     break;
        default:
            return '';
    }
}
