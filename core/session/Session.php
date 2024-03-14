<?php

namespace core\session;

use Swoole\Table;

class Session
{
    protected FdTable $fd;
    protected SsidTable $ssid;
    public function __construct(int $size = 10000)
    {
        $this->fd = new FdTable($size, 1);
        $this->ssid = new SsidTable($size, 1);
    }

    public function newSession(int $fd): string
    {
        $ssid = md5(microtime().mt_rand(1000, 9999));
        $this->fd->set(strval($fd), ['ssid' => $ssid]);
        $this->ssid->set($ssid, ['fd' => $fd]);
        return $ssid;
    }

    public function delSession(int $fd): bool
    {
        $strFd = strval($fd);
        $ret = false;
        $ssid = $this->fd->get($strFd, 'ssid');
        if ($ssid) {
            $ret &= $this->ssid->del($ssid);
        }
        $ret &= $this->fd->del($strFd);
        return $ret;
    }

    /**
     * @param int $fd
     * @return bool|string
     */
    public function getSsid(int $fd)
    {
        return $this->fd->get(strval($fd), 'ssid');
    }

    /**
     * @param string $ssid
     * @return bool|int
     */
    public function getFd(string $ssid)
    {
        return $this->ssid->get($ssid, 'fd');
    }
}