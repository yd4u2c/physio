    *
     * @param string $nsKey
     * @param string $itemKey
     *
     * @throws Swift_IoException
     *
     * @return string
     */
    public function getString($nsKey, $itemKey)
    {
        $this->prepareCache($nsKey);
        if ($this->hasKey($nsKey, $itemKey)) {
            $fp = $this->getHandle($nsKey, $itemKey, self::POSITION_START);
            $str = '';
            while (!feof($fp) && false !== $bytes = fread($fp, 8192)) {
                $str .= $bytes;
            }
            $this->freeHandle($nsKey, $itemKey);

            return $str;
        }
    }

    /**
     * Get data back out of the cache as a ByteStream.
     *
     * @param string                $nsKey
     * @param string                $itemKey
     * @param Swift_InputByteStream $is      to write the data to
     */
    public function exportToByteStream($nsKey, $itemKey, Swift_InputByteStream $is)
    {
        if ($this->hasKey($nsKey, $itemKey)) {
            $fp = $this->getHandle($nsKey, $itemKey, self::POSITION_START);
            while (!feof($fp) && false !== $bytes = fread($fp, 8192)) {
                $is->write($bytes);
            }
            $this->freeHandle($nsKey, $itemKey);
        }
    }

    /**
     * Check if the given $itemKey exists in the namespace $nsKey.
     *
     * @param string $nsKey
     * @param string $itemKey
     *
     * @return bool
     */
    public function hasKey($nsKey, $itemKey)
    {
        return is_file($this->path.'/'.$nsKey.'/'.$itemKey);
    }

    /**
     * Clear data for $itemKey in the namespace $nsKey if it exists.
     *
     * @param string $nsKey
     * @param string $itemKey
     */
    public function clearKey($nsKey, $itemKey)
    {
        if ($this->hasKey($nsKey, $itemKey)) {
            $this->freeHandle($nsKey, $itemKey);
            unlink($this->path.'/'.$nsKey.'/'.$itemKey);
        }
    }

    /**
     * Clear all data in the namespace $nsKey if it exists.
     *
     * @param string $nsKey
     */
    public function clearAll($nsKey)
    {
        if (array_key_exists($nsKey, $this->keys)) {
            foreach ($this->keys[$nsKey] as $itemKey => $null) {
                $this->clearKey($nsKey, $itemKey);
            }
            if (is_dir($this->path.'/'.$nsKey)) {
                rmdir($this->path.'/'.$nsKey);
            }
            unset($this->keys[$nsKey]);
        }
    }

    /**
     * Initialize the namespace of $nsKey if needed.
     *
     * @param string $nsKey
     */
    private function prepareCache($nsKey)
    {
        $cacheDir = $this->path.'/'.$nsKey;
        if (!is_dir($cacheDir)) {
            if (!mkdir($cacheDir)) {
                throw new Swift_IoException('Failed to create cache directory '.$cacheDir);
            }
            $this->keys[$nsKey] = [];
        }
    }

    /**
     * Get a file handle on the cache item.
     *
     * @param string $nsKey
     * @param string $itemKey
     * @param int    $position
     *
     * @return resource
     */
    private function getHandle($nsKey, $itemKey, $position)
    {
        if (!isset($this->keys[$nsKey][$itemKey])) {
            $openMode = $this->hasKey($nsKey, $itemKey) ? 'r+b' : 'w+b';
            $fp = fopen($this->path.'/'.$nsKey.'/'.$itemKey, $openMode);
            $this->keys[$nsKey][$itemKey] = $fp;
        }
        if (self::POSITION_START == $position) {
            fseek($this->keys[$nsKey][$itemKey], 0, SEEK_SET);
        } elseif (self::POSITION_END == $position) {
            fseek($this->keys[$nsKey][$itemKey], 0, SEEK_END);
        }

        return $this->keys[$nsKey][$itemKey];
    }

    private function freeHandle($nsKey, $itemKey)
    {
        $fp = $this->getHandle($nsKey, $itemKey, self::POSITION_CURRENT);
        fclose($fp);
        $this->keys[$nsKey][$itemKey] = null;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        foreach ($this->keys as $nsKey => $null) {
            $this->clearAll($nsKey);
        }
    }
}
                                                                                        <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Writes data to a KeyCache using a stream.
 *
 * @author Chris Corbyn
 */
interface Swift_KeyCache_KeyCacheInputStream extends Swift_InputByteStream
{
    /**
     * Set the KeyCache to wrap.
     *
     * @param Swift_KeyCache $keyCache
     */
    public function setKeyCache(Swift_KeyCache $keyCache);

    /**
     * Set the nsKey which will be written to.
     *
     * @param string $nsKey
     */
    public function setNsKey($nsKey);

    /**
     * Set the itemKey which will be written to.
     *
     * @param string $itemKey
     */
    public function setItemKey($itemKey);

    /**
     * Specify a stream to write through for each write().
     *
     * @param Swift_InputByteStream $is
     */
    public function setWriteThroughStream(Swift_InputByteStream $is);

    /**
     * Any implementation should be cloneable, allowing the clone to access a
     * separate $nsKey and $itemKey.
     */
    public function __clone();
}
                                                                                                                                                                                                                                                                                                                                                                        