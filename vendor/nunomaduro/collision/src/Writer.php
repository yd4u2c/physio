<?php
/*
 * This file is part of PharIo\Manifest.
 *
 * (c) Arne Blankerts <arne@blankerts.de>, Sebastian Heuer <sebastian@phpeople.de>, Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PharIo\Manifest;

class AuthorCollectionIterator implements \Iterator {
    /**
     * @var Author[]
     */
    private $authors = [];

    /**
     * @var int
     */
    private $position;

    public function __construct(AuthorCollection $authors) {
        $this->authors = $authors->getAuthors();
    }

    public function rewind() {
        $this->position = 0;
    }

    /**
     * @return bool
     */
    public function valid() {
        return $this->position < count($this->authors);
    }

    /**
     * @return int
     */
    public function key() {
        return $this->position;
    }

    /**
     * @return Author
     */
    public function current() {
        return $this->authors[$this->position];
    }

    public function next() {
        $this->position++;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               INDX( 	 �`�             (   P
  �       o                    �     p `     �     �K�]pk� �N/4�]r��<��K�]pk��      �               A p p l i c a t i o n . p h p �     x h     �     ���]pk� �N/4�u�t��<����]pk�       c               A p p l i c a t i o n N a m e . p h p �     h V     �     ��
^pk� �N/4��!w��<���
^pk�       %              
 A u t h o r . p h p   �     � j     �     [#^pk� �N/4��!w��<�[#^pk�       �               A u t h o r C o l l e c t i  n . p h p       �     � z     �     9K^pk� �N/4�#�y��<�9K^pk�       a               A u t h o r C o l l e c t i o n I t e r a t o r . p h p       �     � j     �     �^pk� �N/4���{��<��^pk�       �               B u n d l e d C o m p o n e n t . p h p       �     � ~     �     ��^pk� �N/4��H~��<���^pk�       (               B u n d l e d C o m p o n e n t C o l l e c t i o n . p h p   �     � �     �     ��"^pk� �N/4��H~��<���"^pk�       �             & B u n d l e d C o m p o n e n t C o l l e c t i o n I t e r a t o r . p h p   �     � r     �     ^'^pk� �N/4�9����<�^'^pk�       x               C o p y r i g h t I n f o r m a t i o n . p h p       �     h T     �     �!,^pk� �N/4�����<��!,^pk�       �              	 E m a i l . p h p     �     p \     �     ��0^pk� �N/4�3o���<���0^pk�       �               E x t e n s i o n . p h p     �     h X     �     H�5^pk� �N/4�3o���<�H�5^pk��      �              L i b r a r y . p h p �     h X     �     #p:^pk� �N/4��ч��<�#p:^pk�                      L i c e n s e . p h p �     p Z     �     �4?^pk� �N/4��3���<��4?^pk�       �               M a n i f e s t . p h p       �     � x     �     �[F^pk� �N/4�����<��[F^pk�       �               P h p E x t e n s i o n R e q u i r e m e n t . p h p �     � t     �     ߾H^pk� �N/4������<�߾H^pk�                      P h p V e r s i o n R e q u i r e m e n t . p h p    �     p `     �     y�O^pk� �N/4������<�y�O^pk�p      p               R e q u i r e m e n t . p h p �     � t     �     �GR^pk� �N/4��Z���<��GR^pk�       �               R e q u i r e m e n t C o l l e c t i o n . p h p     �     � �     �     #�[^pk� �N/4�2����<�#�[^pk�       �              ! R e q u i r e m e n t C o l l e c t i o n I t e r a t o r . p h p     �     h R     �     N�b^pk� �N/4�2����<�N�b^pk�       �               T y p e . p h p       �     ` P     �     �j^pk� �N/4�����<��j^pk�       �               U r l . p h p                                                                                                                                                                                                                                                                                                                                                              