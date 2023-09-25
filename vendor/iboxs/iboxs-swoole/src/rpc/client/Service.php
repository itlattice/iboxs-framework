<?php

namespace iboxs\swoole\rpc\client;

interface Service
{
    public function withContext($context): self;
}
