agic.
     *
     * @return bool
     */
    public function isMagic() : bool {
        return isset(self::$magicNames[$this->name->toLowerString()]);
    }
    
    public function getType() : string {
        return 'Stmt_ClassMethod';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        