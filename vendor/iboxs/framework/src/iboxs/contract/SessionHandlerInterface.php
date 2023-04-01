<?php
// +----------------------------------------------------------------------
// | iboxsPHP [ WE CAN DO IT JUST iboxs ]
// +----------------------------------------------------------------------
// | Copyright (c) 2023 http://lyweb.com.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: itlattice <notice@itgz8.com>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace iboxs\contract;

/**
 * Session驱动接口
 */
interface SessionHandlerInterface
{
    public function read(string $sessionId): string;
    public function delete(string $sessionId): bool;
    public function write(string $sessionId, string $data): bool;
}
