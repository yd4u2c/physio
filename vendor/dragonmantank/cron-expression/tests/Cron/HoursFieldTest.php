eturns an iterator for the inspected exception's
     * frames.
     * @return \Whoops\Exception\FrameCollection
     */
    public function getFrames()
    {
        if ($this->frames === null) {
            $frames = $this->getTrace($this->exception);

            // Fill empty line/file info for call_user_func_array usages (PHP Bug #44428)
            foreach ($frames as $k => $frame) {
                if (empty($frame['file'])) {
                    // Default values when file and line are missing
                    $file = '[internal]';
                    $line = 0;

                    $next_frame = !empty($frames[$k + 1]) ? $frames[$k + 1] : [];

                    if ($this->isValidNextFrame($next_frame)) {
                        $file = $next_frame['file'];
                        $line = $next_frame['line'];
                    }

                    $frames[$k]['file'] = $file;
                    $frames[$k]['line'] = $line;
                }
            }

            // Find latest non-error handling frame index ($i) used to remove error handling frames
            $i = 0;
            foreach ($frames as $k => $frame) {
                if ($frame['file'] == $this->exception->getFile() && $frame['line'] == $this->exception->getLine()) {
                    $i = $k;
                }
            }

            // Remove error handling frames
            if ($i > 0) {
                array_splice($frames, 0, $i);
            }

            $firstFrame = $this->getFrameFromException($this->exception);
            array_unshift($frames, $firstFrame);

            $this->frames = new FrameCollection($frames);

            if ($previousInspector = $this->getPreviousExceptionInspector()) {
                // Keep outer frame on top of the inner one
                $outerFrames = $this->frames;
                $newFrames = clone $previousInspector->getFrames();
                // I assume it will always be set, but let's be safe
                if (isset($newFrames[0])) {
                    $newFrames[0]->addComment(
                        $previousInspector->getExceptionMessage(),
                        'Exception message:'
                    );
                }
                $newFrames->prependFrames($outerFrames->topDiff($newFrames));
                $this->frames = $newFrames;
            }
        }

        return $this->frames;
    }

    /**
     * Gets the backtrace from an exception.
     *
     * If xdebug is installed
     *
     * @param \Throwable $e
     * @return array
     */
    protected function getTrace($e)
    {
        $traces = $e->getTrace();

        // Get trace from xdebug if enabled, failure exceptions only trace to the shutdown handler by default
        if (!$e instanceof \ErrorException) {
            return $traces;
        }

        if (!Misc::isLevelFatal($e->getSeverity()