ly be a *.dot file.
     *
     * You have to convert the output into a viewable format. For example use "neato" on linux systems
     * and execute:
     *
     *  neato -Tpng -o er.png er.dot
     *
     * @param string $filename
     *
     * @return void
     */
    public function write($filename)
    {
        file_put_contents($filename, $this->getOutput());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 