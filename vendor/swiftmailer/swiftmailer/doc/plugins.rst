<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Provides the base functionality for an InputStream supporting filters.
 *
 * @author Chris Corbyn
 */
abstract class Swift_ByteStream_AbstractFilterableInputStream implements Swift_InputByteStream, Swift_Filterable
{
    /**
     * Write sequence.
     */
    protected $sequence = 0;

    /**
     * StreamFilters.
     *
     * @var Swift_StreamFilter[]
     */
    private $filters = [];

    /**
     * A buffer for writing.
     */
    private $writeBuffer = '';

    /**
     * Bound streams.
     *
     * @var Swift_InputByteStream[]
     */
    private $mirrors = [];

    /**
     * Commit the given bytes to the storage medium immediately.
     *
     * @param string $bytes
     */
    abstract protected function doCommit($bytes);

    /**
     * Flush any buffers/content with immediate effect.
     */
    abstract protected function flush();

    /**
     * Add a StreamFilter to this InputByteStream.
     *
     * @param string $key
     */
    public function addFilter(Swift_StreamFilter $filter, $key)
    {
        $this->filters[$key] = $filter;
    }

    /**
     * Remove an already present StreamFilter based on its $key.
     *
     * @param string $key
     */
    public function removeFilter($key)
    {
        unset($this->filters[$key]);
    }

    /**
     * Writes $bytes to the end of the stream.
     *
     * @param string $bytes
     *
     * @throws Swift_IoException
     *
     * @return int
     */
    public function write($bytes)
    {
        $this->writeBuffer .= $bytes;
        foreach ($this->filters as $filter) {
            if ($filter->shouldBuffer($this->writeBuffer)) {
                return;
            }
        }
        $this->doWrite($this->writeBuffer);

        return ++$this->sequence;
    }

    /**
     * For any bytes that are currently buffered inside the stream, force them
     * off the buffer.
     *
     * @throws Swift_IoException
     */
    public function commit()
    {
        $this->doWrite($this->writeBuffer);
    }

    /**
     * Attach $is to this stream.
     *
     * The stream acts as an observer, receiving all data that is written.
     * All {@link write()} and {@link flushBuffers()} operations will be mirrored.
     */
    public function bind(Swift_InputByteStream $is)
    {
        $this->mirrors[] = $is;
    }

    /**
     * Remove an already bound stream.
     *
     * If $is is not bound, no errors will be raised.
     * If the stream currently has any buffered data it will be written to $is
     * before unbinding occurs.
     */
    public function unbind(Swift_InputByteStream $is)
    {
        foreach ($this->mirrors as $k => $stream) {
            if ($is === $stream) {
                if ('' !== $this->writeBuffer) {
                    $stream->write($this->writeBuffer);
                }
                unset($this->mirrors[$k]);
            }
        }
    }

    /**
     * Flush the contents of the stream (empty it) and set the internal pointer
     * to the beginning.
     *
     * @throws Swift_IoException
     */
    public function flushBuffers()
    {
        if ('' !== $this->writeBuffer) {
            $this->doWrite($this->writeBuffer);
        }
        $this->flush();

        foreach ($this->mirrors as $stream) {
            $stream->flushBuffers();
        }
    }

    /** Run $bytes through all filters */
    private function filter($bytes)
    {
        foreach ($this->filters as $filter) {
            $bytes = $filter->filter($bytes);
        }

        return $bytes;
    }

    /** Just write the bytes to the stream */
    private function doWrite($bytes)
    {
        $this->doCommit($this->filter($bytes));

        foreach ($this->mirrors as $stream) {
            $stream->write($bytes);
        }

        $this->writeBuffer = '';
    }
}
                                                                         <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Allows reading and writing of bytes to and from an array.
 *
 * @author     Chris Corbyn
 */
class Swift_ByteStream_ArrayByteStream implements Swift_InputByteStream, Swift_OutputByteStream
{
    /**
     * The internal stack of bytes.
     *
     * @var string[]
     */
    private $array = [];

    /**
     * The size of the stack.
     *
     * @var int
     */
    private $arraySize = 0;

    /**
     * The internal pointer offset.
     *
     * @var int
     */
    private $offset = 0;

    /**
     * Bound streams.
     *
     * @var Swift_InputByteStream[]
     */
    private $mirrors = [];

    /**
     * Create a new ArrayByteStream.
     *
     * If $stack is given the stream will be populated with the bytes it contains.
     *
     * @param mixed $stack of bytes in string or array form, optional
     */
    public function __construct($stack = null)
    {
        if (is_array($stack)) {
            $this->array = $stack;
            $this->arraySize = count($stack);
        } elseif (is_string($stack)) {
            $this->write($stack);
        } else {
            $this->array = [];
        }
    }

    /**
     * Reads $length bytes from the stream into a string and moves the pointer
     * through the stream by $length.
     *
     * If less bytes exist than are requested the
     * remaining bytes are given instead. If no bytes are remaining at all, boolean
     * false is returned.
     *
     * @param int $length
     *
     * @return string
     */
    public function read($length)
    {
        if ($this->offset == $this->arraySize) {
            return false;
        }

        // Don't use array slice
        $end = $length + $this->offset;
        $end = $this->arraySize < $end ? $this->arraySize : $end;
        $ret = '';
        for (; $this->offset < $end; ++$this->offset) {
            $ret .= $this->array[$this->offset];
        }

        return $ret;
    }

    /**
     * Writes $bytes to the end of the stream.
     *
     * @param string $bytes
     */
    public function write($bytes)
    {
        $to_add = str_split($bytes);
        foreach ($to_add as $value) {
            $this->array[] = $value;
        }
        $this->arraySize = count($this->array);

        foreach ($this->mirrors as $stream) {
            $stream->write($bytes);
        }
    }

    /**
     * Not used.
     */
    public function commit()
    {
    }

    /**
     * Attach $is to this stream.
     *
     * The stream acts as an observer, receiving all data that is written.
     * All {@link write()} and {@link flushBuffers()} operations will be mirrored.
     */
    public function bind(Swift_InputByteStream $is)
    {
        $this->mirrors[] = $is;
    }

    /**
     * Remove an already bound stream.
     *
     * If $is is not bound, no errors will be raised.
     * If the stream currently has any buffered data it will be written to $is
     * before unbinding occurs.
     */
    public function unbind(Swift_InputByteStream $is)
    {
        foreach ($this->mirrors as $k => $stream) {
            if ($is === $stream) {
                unset($this->mirrors[$k]);
            }
        }
    }

    /**
     * Move the internal read pointer to $byteOffset in the stream.
     *
     * @param int $byteOffset
     *
     * @return bool
     */
    public function setReadPointer($byteOffset)
    {
        if ($byteOffset > $this->arraySize) {
            $byteOffset = $this->arraySize;
        } elseif ($byteOffset < 0) {
            $byteOffset = 0;
        }

        $this->offset = $byteOffset;
    }

    /**
     * Flush the contents of the stream (empty it) and set the internal pointer
     * to the beginning.
     */
    public function flushBuffers()
    {
        $this->offset = 0;
        $this->array = [];
        $this->arraySize = 0;

        foreach ($this->mirrors as $stream) {
            $stream->flushBuffers();
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Allows reading and writing of bytes to and from a file.
 *
 * @author     Chris Corbyn
 */
class Swift_ByteStream_FileByteStream extends Swift_ByteStream_AbstractFilterableInputStream implements Swift_FileStream
{
    /** The internal pointer offset */
    private $offset = 0;

    /** The path to the file */
    private $path;

    /** The mode this file is opened in for writing */
    private $mode;

    /** A lazy-loaded resource handle for reading the file */
    private $reader;

    /** A lazy-loaded resource handle for writing the file */
    private $writer;

    /** If stream is seekable true/false, or