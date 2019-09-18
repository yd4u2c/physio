
                ' ['.$errstr.' #'.$errno.']'
                );
        }
        if (!empty($this->params['blocking'])) {
            stream_set_blocking($this->stream, 1);
        } else {
            stream_set_blocking($this->stream, 0);
        }
        stream_set_timeout($this->stream, $timeout);
        $this->in = &$this->stream;
        $this->out = &$this->stream;
    }

    /**
     * Opens a process for input/output.
     */
    private function establishProcessConnection()
    {
        $command = $this->params['command'];
        $descriptorSpec = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
            ];
        $pipes = [];
        $this->stream = proc_open($command, $descriptorSpec, $pipes);
        stream_set_blocking($pipes[2], 0);
        if ($err = stream_get_contents($pipes[2])) {
            throw new Swift_TransportException(
                'Process could not be started ['.$err.']'
                );
        }
        $this->in = &$pipes[0];
        $this->out = &$pipes[1];
    }

    private function getReadConnectionDescription()
    {
        switch ($this->params['type']) {
            case self::TYPE_PROCESS:
                return 'Process '.$this->params['command'];
                break;

            case self::TYPE_SOCKET:
            default:
                $host = $this->params['host'];
                if (!empty($this->params['protocol'])) {
                    $host = $this->params['protocol'].'://'.$host;
                }
                $host .= ':'.$this->params['port'];

                return $host;
                break;
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     