y_filter($comments, function ($c) use ($filter) {
                return $c['context'] == $filter;
            });
        }

        return $comments;
    }

    /**
     * Returns the array containing the raw frame data from which
     * this Frame object was built
     *
     * @return array
     */
    public function getRawFrame()
    {
        return $this->frame;
    }

    /**
     * Returns the contents of the file for this frame as an
     * array of lines, and optionally as a clamped range of lines.
     *
     * NOTE: lines are 0-indexed
     *
     * @example
     *     Get all lines for this file
     *     $frame->getFileLines(); // => array( 0 => '<?php', 1 => '...', ...)
     * @example
     *     Get one line for this file, starting at line 10 (zero-indexed, remember!)
     *     $frame->getFileLines(9, 1); // array( 10 => '...', 11 => '...')
     *
     * @throws InvalidArgumentException if $length is less than or equal to 0
     * @param  int                      $start
     * @param  int                      $length
     * @return string[]|null
     */
    public function getFileLines($start = 0, $length = null)
    {
        if (null !== ($contents = $this->getFileContents())) {
            $lines = explode("\n", $contents);

            // Get a subset of lines from $start to $end
            if ($length !== null) {
                $start  = (int) $start;
                $length = (int) $length;
                if ($start < 0) {
                    $start = 0;
                }

                if ($length <= 0) {
                    throw new InvalidArgumentException(
                        "\$length($length) cannot be lower or equal to 0"
                    );
                }

                $lines = array_slice($lines, $start, $length, true);
            }

            return $lines;
        }
    }

    /**
     * Implements the Serializable interface, with special
     * steps to also save the existing comments.
     *
     * @see Serializable::serialize
     * @return string
     */
    public function serialize()
    {
        $frame = $this->frame;
        if (!empty($this->comments)) {
            $frame['_comments'] = $this->comments;
        }

        return serialize($frame);
    }

    /**
     * Unserializes the frame data, while also preserving
     * any existing comment data.
     *
     * @see Serializable::unserialize
     * @param string $serializedFrame
     */
    public function unserialize($serializedFrame)
    {
        $frame = unserialize($serializedFrame);

        if (!empty($frame['_comments'])) {
            $this->comments = $frame['_comments'];
            unset($frame['_comments']);
        }

        $this->frame = $frame;
    }

    /**
     * Compares Frame against one another
     * @param  Frame $frame
     * @return bool
     */
    public function equals(Frame $frame)
    {
        if (!$this->getFile() || $this->getFile() === 'Unknown' || !$this->getLine()) {
            return false;
        }
        return $frame->getFile() === $this->getFile() && $frame->getLine() === $this->getLine();
    }

    /**
     * Returns whether this frame belongs to the application or not.
     *
     * @return boolean
     */
    public function isApplication()
    {
        return $this->application;
    }

    /**
     * Mark as an frame belonging to the application.
     *
     * @param boolean $application
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php
/**
 * Whoops - php errors for cool kids
 * @author Filipe Dobreira <http://github.com/filp>
 */

namespace Whoops\Exception;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Serializable;
use UnexpectedValueException;

/**
 * Exposes a fluent interface for dealing with an ordered list
 * of stack-trace frames.
 */
class FrameCollection implements ArrayAccess, IteratorAggregate, Serializable, Countable
{
    /**
     * @var array[]
     */
    private $frames;

    /**
     * @param array $frames
     */
    public function __construct(array $frames)
    {
        $this->frames = array_map(function ($frame) {
            return new Frame($frame);
        }, $frames);
    }

    /**
     * Filters frames using a callable, returns the same FrameCollection
     *
     * @param  callable        $callable
     * @return FrameCollection
     */
    public function filter($callable)
    {
        $this->frames = array_values(array_filter($this->frames, $callable));
        return $this;
    }

    /**
     * Map the collection of frames
     *
     * @param  callable        $callable
     * @retur