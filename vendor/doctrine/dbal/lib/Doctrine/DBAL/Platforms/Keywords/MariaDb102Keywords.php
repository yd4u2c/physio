s2['length'] ?: 255;
            if ($length1 !== $length2) {
                $changedProperties[] = 'length';
            }

            if ($properties1['fixed'] !== $properties2['fixed']) {
                $changedProperties[] = 'fixed';
            }
        } elseif ($properties1['type'] instanceof Types\DecimalType) {
            if (($properties1['precision'] ?: 10) !== ($properties2['precision'] ?: 10)) {
                $changedProperties[] = 'precision';
            }
            if ($properties1['scale'] !== $properties2['scale']) {
                $changedProperties[] = 'scale';
            }
        }

        // A null value and an empty string are actually equal for a comment so they should not trigger a change.
        if ($properties1['comment'] !== $properties2['comment'] &&
            ! ($properties1['comment'] === null && $properties2['comment'] === '') &&
            ! ($properties2['comment'] === null && $properties1['comment'] === '')
        ) {
            $changedProperties[] = 'comment';
        }

        $customOptions1 = $column1->getCustomSchemaOptions();
        $customOptions2 = $column2->getCustomSchemaOptions();

        foreach (array_merge(array_keys($customOptions1), array_keys($customOptions2)) as $key) {
            if (! array_key_exists($key, $properties1) || ! array_key_exists($key, $properties2)) {
                $changedProperties[] = $key;
            } elseif ($properties1[$key] !== $properties2[$key]) {
                $changedProperties[] = $key;
            }
        }

        $platformOptions1 = $column1->getPlatformOptions();
        $platformOptions2 = $column2->getPlatformOptions();

        foreach (array_keys(array_intersect_key($platformOptions1, $platformOptions2)) as $key) {
            if ($properties1[$key] === $properties2[$key]) {
                continue;
            }

            $changedProperties[] = $key;
        }

        return array_unique($changedProperties);
    }

    /**
     * TODO: kill with fire on v3.0
     *
     * @deprecated
     */
    private function isALegacyJsonComparison(Types\Type $one, Types\Type $other) : bool
    {
        if (! $one instanceof Types\JsonType || ! $other instanceof Types\JsonType) {
            return false;
        }

        return ( ! $one instanceof Types\JsonArrayType && $other instanceof Types\JsonArrayType)
            || ( ! $other instanceof Types\JsonArrayType && $one instanceof Types\JsonArrayType);
    }

    /**
     * Finds the difference between the indexes $index1 and $index2.
     *
     * Compares $index1 with $index2 and returns $index2 if there are any
     * differences or false in case there are no differences.
     *
     * @return bool
     */
    public function diffIndex(Index $index1, Index $index2)
    {
        return ! ($index1->isFullfilledBy($index2) && $index2->isFullfilledBy($index1));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     INDX( 	 G(i             (   �  �       l   ��              �	     x d     �	     ����ok� ��������}�<�����ok�        @               A b s t r a c t A s s e t . p h p     �	     � t     �	     P���ok� ������v�}�<�P���ok� �      fs               A b s t r a c t S c h e m a M a n a g e r . p h p     �	     h V     �	     
���ok� ������v�}�<�
���ok� 0      !              
 C o l u m n . p h p   �	     p ^     �	     ����ok� ������rׅ}�<�����ok�       �               C o  u m n D i f f . p h p   �	     p ^     �	     ����ok� �������:�}�<�����ok� P      KK               C o m p a r a t o r . p h p   �	     p ^     �	     �$��ok� ������/��}�<��$��ok�       �               C o n s t r a i n t . p h p   �	     � j     �	     ����ok� ���������}�<�����ok�                       D B 2 S c h e m a M a n a g e r . p h p       �	     � r     �	     !���ok� ���������}�<�!���ok�       1               D r i z z l e S c h e m a M a n a g e r . p h p      �	     � r     �	     {7��ok� �������`�}�<�{7��ok� 0      �)               F o r e i g n K e y C o n s t r a i n t . p h p       �	     p ^     �	     ����ok� ������Eđ}�<�����ok��      �               I d e n t i f i e r . p h p   �	     h T     �	     ���ok� ������Eđ}�<����ok� 0      s"              	 I n d e x . p h p     �	     � n     �	     ���ok� �������&�}�<����ok� 0      H*               M y S q l S c h e m a M a n a g e r . p h p   �	     � p     �	     �%�ok  ���������}�<��%�ok� 0      d-               O r a c l e S c h e m a M a n a g e r . p h p �	     � x     �	     E�W�ok� ������Q�}�<�E�W�ok� @      `;               P o s t g r e S q l S c h e m a M a n a g e r . p h p �	     h V     �	     ��h�ok� ������Q�}�<���h�ok� 0      �/              
 S c h e m a . p h p   �	     x b     �	     @�s�ok� �������M�}�<�@�s�ok�       p               S c h e m a C o n f i g . p h p       �	     p ^     �	     W}�ok� ������<��}�<�W}�ok 