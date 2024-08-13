<?php

namespace followed\framed\Http;

class HttpException extends \Exception
{
    private int $status = 400;

    public function setStatus(int $status): void {
        $this->status = $status;
    }

    public function getStatus(): int {
        return $this->status;
    }
}