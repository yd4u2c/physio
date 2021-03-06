utput, $this->listDirectoryContentsRecursive($item['path']));
        }

        return $output;
    }

    /**
     * Check if the connection is open.
     *
     * @return bool
     * @throws ErrorException
     */
    public function isConnected()
    {
        try {
            return is_resource($this->connection) && ftp_rawlist($this->connection, $this->getRoot()) !== false;
        } catch (ErrorException $e) {
            if (strpos($e->getMessage(), 'ftp_rawlist') === false) {
                throw $e;
            }

            return false;
        }
    }

    /**
     * @return bool
     */
    protected function isPureFtpdServer()
    {
        $response = ftp_raw($this->connection, 'HELP');

        return stripos(implode(' ', $response), 'Pure-FTPd') !== false;
    }

    /**
     * The ftp_rawlist function with optional escaping.
     *
     * @param string $options
     * @param string $path
     *
     * @return array
     */
    protected function ftpRawlist($options, $path)
    {
        $connection = $this->getConnection();

        if ($this->isPureFtpd) {
            $path = str_replace(' ', '\ ', $path);
        }
        return ftp_rawlist($connection, $options . ' ' . $path);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   