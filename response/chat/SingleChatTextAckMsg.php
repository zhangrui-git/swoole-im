<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/im.git/
 */

namespace response\chat;


use packages\WebSocketResponse;

class SingleChatTextAckMsg extends WebSocketResponse
{
    protected int $version = 1;

    protected string $service = 'chat';

    protected string $module = 'SingleChatText';
}