rts[] = $this->createDataPart($attachment);
        }
        if (null !== $htmlPart) {
            $htmlPart = new TextPart($html, $this->htmlCharset, 'html');
        }

        return [$htmlPart, $attachmentParts, array_values($inlineParts)];
    }

    private function createDataPart(array $attachment): DataPart
    {
        if (isset($attachment['part'])) {
            return $attachment['part'];
        }

        if (isset($attachment['body'])) {
            $part = new DataPart($attachment['body'], $attachment['name'] ?? null, $attachment['content-type'] ?? null);
        } else {
            $part = DataPart::fromPath($attachment['path'] ?? '', $attachment['name'] ?? null, $attachment['content-type'] ?? null);
        }
        if ($attachment['inline']) {
            $part->asInline();
        }

        return $part;
    }

    /**
     * @return $this
     */
    private function setHeaderBody(string $type, string $name, $body)
    {
        $this->getHeaders()->setHeaderBody($type, $name, $body);

        return $this;
    }

    private function addListAddressHeaderBody($name, array $addresses)
    {
        if (!$to = $this->getHeaders()->get($name)) {
            return $this->setListAddressHeaderBody($name, $addresses);
        }
        $to->addAddresses(Address::createArray($addresses));

        return $this;
    }

    private function setListAddressHeaderBody($name, array $addresses)
    {
        $addresses = Address::createArray($addresses);
        $headers = $this->getHeaders();
        if ($to = $headers->get($name)) {
            $to->setAddresses($addresses);
        } else {
            $headers->addMailboxListHeader($name, $addresses);
        }

        return $this;
    }

    /**
     * @internal
     */
    public function __serialize(): array
    {
        if (\is_resource($this->text)) {
            if (stream_get_meta_data($this->text)['seekable'] ?? false) {
                rewind($this->text);
            }

            $this->text = stream_get_contents($this->text);
        }

        if (\is_resource($this->html)) {
            if (stream_get_meta_data($this->html)['seekable'] ?? false) {
                rewind($this->html);
            }

            $this->html = stream_get_contents($this->html);
        }

        foreach ($this->attachments as $i => $attachment) {
            if (isset($attachment['body']) && \is_resource($attachment['body'])) {
                if (stream_get_meta_data($attachment['body'])['seekable'] ?? false) {
                    rewind($attachment['body']);
                }

                $this->attachments[$i]['body'] = stream_get_contents($attachment['body']);
            }
        }

        return [$this->text, $this->textCharset, $this->html, $this->htmlCharset, $this->attachments, parent::__serialize()];
    }

    /**
     * @internal
     */
    public function __unserialize(array $data): void
    {
        [$this->text, $this->textCharset, $this->html, $this->htmlCharset, $this->attachments, $parentData] = $data;

        parent::__unserialize($parentData);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    INDX( 	 �ʪ             (   P  �       t   E                �0     h V     �0     �`1	qk��w]� %�kSݤ %��`1	qk�(       "               
 . g i t i g n o r e   �0     h X     �0     _�8	qk�]<b� %�kSݤ %�_�8	qk�       N
               A d d r e s s . p h p �0     � t     �0     �L=	qk���d� %�kSݤ %��L=	qk��      �               B o d y R e n d e r e r I n t e r f a c e . p h p     �0     x h     �0     k�F	qk�g� %�kSݤ %�k�F	qk� 0      �%               C h a r a c t e r S  r e a m . p h p �0     p \     �0     ��M	qk���ڤ %�kSݤ %���M	qk�       �               c o m p o s e r . j s o n     �0     x h     �0     M4�	qk�g� %�M4�	qk�M4�	q