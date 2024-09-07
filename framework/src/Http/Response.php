<?php 
namespace followed\framed\Http;

class Response 
{
    public const HTTP_INTERNAL_SERVER_ERROR = 500;
    public const HTTP_FORBIDDEN = 403;
    public function __construct(
        private ?string $content = '',
        private int $status = 200,
        private array $headers = []
    )
    {
        http_response_code($this->status);
    }

    public function send(): void
    {
        ob_start();
        foreach($this->headers as $key => $value){
            header("$key: $value");
        }
        echo $this->content;
        ob_end_flush();
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getHeader(string $header): mixed
    {
        return $this->headers[$header];
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeader($key, $value): void
    {
        $this->headers[$key] = $value;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }


}