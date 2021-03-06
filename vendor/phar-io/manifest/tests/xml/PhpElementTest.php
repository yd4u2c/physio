if ($wrapLength !== null) {
            $text = wordwrap($text, $wrapLength);
            return $text;
        }

        return $text;
    }

    /**
     * @param DocBlock $docblock
     * @param $wrapLength
     * @param $indent
     * @param $comment
     * @return string
     */
    private function addTagBlock(DocBlock $docblock, $wrapLength, $indent, $comment)
    {
        foreach ($docblock->getTags() as $tag) {
            $tagText = $this->tagFormatter->format($tag);
            if ($wrapLength !== null) {
                $tagText = wordwrap($tagText, $wrapLength);
            }

            $tagText = str_replace("\n", "\n{$indent} * ", $tagText);

            $comment .= "{$indent} * {$tagText}\n";
        }

        return $comment;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            