<?php
namespace NeoP\Http\Server\Message;


class DownloadFile
{

    /**
     * filename is absolute pathname
     * @var string
     */
    protected $filename = "";

    /**
     * offset
     * @var bigint(int64)
     */
    protected $offset;

    /**
     * size
     * @var bigint(int64)
     */
    protected $size;

    function __construct(string $filename, int $offset = 0, int $size = 0)
    {
        $this->filename = $filename;
        $this->offset = $offset;
        $this->size = $size;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getOffset(): string
    {
        return $this->offset;
    }

    public function getSize(): string
    {
        return $this->size;
    }
}