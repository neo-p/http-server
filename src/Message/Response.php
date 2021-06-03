<?php

namespace NeoP\Http\Server\Message;

use NeoP\Http\Server\Exception\HttpException;
use NeoP\Http\Server\Exception\HttpExitException;
use Swoole\Http\Response as SwooleResponse;
use NeoP\Http\Message\Response as HttpMessageResponse;
use NeoP\Http\Message\Stream\Stream;
use NeoP\Http\Server\GrpcServer;
use NeoP\Http\Server\Http2Server;

class Response extends HttpMessageResponse
{
  /**
   * sent or not
   * @var boolean
   */
  protected $isSend = false;

  /**
   * files or not
   * @var boolean
   */
  protected $isDownload = false;

  /**
   * trailer
   * @var array
   */
  protected $trailer = [];

  /**
   * is sent file object.
   * @var DownloadFile
   */
  protected $downloadFile;

  function __construct(SwooleResponse $swooleResponse)
  {
    parent::__construct($swooleResponse);
  }

  public function status(?int $status = NULL, ?string $phrase = NULL)
  {
    if ($status === NULL) {
      return $this->getStatusCode();
    } else {
      $this->withStatus($status, $phrase ?? '');
      return $this;
    }
  }

  public function content(string $content)
  {
    $this->withBody(new Stream($content));
    return $this;
  }

  public function json($data)
  {
    if (is_array($data) || is_object($data)) {
      $this->withBody(new Stream((string) json_encode($data)));
      return $this;
    }
    throw new HttpException("Response to json method args is not array and object!");
  }

  public function download(string $filename, int $offset = 0, int $size = 0)
  {
    $this->isDownload = true;
    $this->downloadFile = new DownloadFile($filename, $offset, $size);
    return $this;
  }

  public function send()
  {
    if (!$this->isSend) {
      if ($this->isDownload) {
        $this->swooleResponse->sendfile($this->downloadFile->getFilename(), $this->downloadFile->getOffset(), $this->downloadFile->getSize());
      } else {
        $body = $this->getBody();
        $contents = $body->getContents();
        $this->sendHeader();
        $service = service('server.service');
        if ($service === GrpcServer::class || $service === Http2Server::class) {
          if ($service === GrpcServer::class) {
            $this->grpcHeader();
          }
          $this->sendTrailer();
        }
        $this->swooleResponse->end($contents);
      }
      $this->isSend = true;
    }
  }

  public function isSend(): bool
  {
    return $this->isSend;
  }

  public function header(string $name, $default = NUll): array
  {
    $header = $this->getHeader($name);
    if ($header === NULL) {
      return $default;
    }
    return $header;
  }

  public function headers(): array
  {
    return $this->getHeaders();
  }

  public function addHeader(string $name, $value): Response
  {
    $this->withAddedHeader($name, $value);
    return $this;
  }

  public function exitGrpc(?int $status = NULL, ?string $phrase = '')
  {
    $this->trailer['grpc-status'] = $status;
    $this->trailer['grpc-message'] = $phrase;
    $this->send();
  }

  public function exit(?int $status = NULL, ?string $phrase = '')
  {
    throw new HttpExitException($phrase, $status);
  }

  private function sendHeader()
  {
    foreach ($this->headers() as $key => $value) {
      $this->swooleResponse->header($key, $this->getHeaderLine($key));
    }
  }

  private function sendTrailer()
  {
    if (count($this->trailer) > 0) {
      $this->swooleResponse->header('te', 'trailers');
      foreach ($this->trailer as $key => $value) {
        $this->swooleResponse->trailer($key, $value);
      }
    }
  }

  public function withTrailer($key, $value)
  {
    $this->trailer[$key] = $value;
  }

  private function grpcHeader()
  {
    $this->swooleResponse->header('content-type', 'application/grpc');
    $this->swooleResponse->header('trailer', 'grpc-status, grpc-message');
    if (!isset($this->trailer['grpc-status'])) {
      $this->trailer['grpc-status'] = 0;
    }

    if (!isset($this->trailer['grpc-message'])) {
      $this->trailer['grpc-message'] = '';
    }
  }
}
