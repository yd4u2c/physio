INDX( 	 B;�             (   X  �        �p   �  �        g     ` P     O     ��rLpk�㨢Lpk�㨢Lpk���rLpk�                        B u i l d e r P     h X     O     �/%Kpk� C�|��0|Š�<��/%Kpk��       �                B u i l d e r . p h p Q     x f     O     �V,Kpk� C�|��k�Ǡ�<��V,Kpk� 0      �%               B u i l d e r F a c t o r y . p h p   R     x f     O     u1Kpk� C�|��k�Ǡ�<�u1Kpk� 0      �"               B u i l d e r H e l p e r s . p h p   u     ` P     O     㨢Lpk�=�Lpk�=�Lpk�㨢Lpk�                        C o m m e n t S     h X     O     �5Kpk� C�|���@ʠ�<��5Kpk�        �               C o m m e n t . p h p T     � �     O     wB8Kpk� C�|���̠�<�wB8Kpk�X       V                 C o n s t E x p r E v a l u a t i o n E x c e p t i o n . p h p       U     � n     O     H=Kpk� C�|��lϠ�<�H=Kpk� 0      �#               C o n s t E x p r E v a l u a t o r . p h p   V     h T     O     h.DKpk� C�|� lϠ�<�h.DKpk�        �              	 E r r o r . p h p     w     p Z     O     �m�Lpk����Lpk����Lpk��m�Lpk�                        E r r o r H a n d l e r . p h W     x b     O     ѐFKpk� C�|��hѠ�<�ѐFKpk�(      &               E r r o r H a n d l e r . p h p       z     h R     O     
��Lpk��
�Lpk��
�Lpk�
��Lpk�                        I n t e r n a l d e r X     p `     O     ��HKpk� C�|��4�Ӡ�<���HKpk�       �               J s o n D e c o d e r . p h       ` L     O     Fl�Lpk�n��Lpk�n��Lpk�n��Lpk�                        L e x e r . p Y     h T     O     @PKpk� C�|��4�Ӡ�<�@PKpk� @      �9              	 L e x e r . p h p     Z     p `     O     ��TKpk� C�|��},֠�<���TKpk� 0      �&               N a m e C o n t e x t . p h p �     ` J     O     �/�Lpk��ZPpk��ZPpk��ZPpk�                        N o d e . p h [     h R     O     ��YKpk� C�|���ؠ�<���YKpk�       �               N o d e . p h p      \     x b     O     Bh^Kpk� C�|���ؠ�<�Bh^Kpk�        ?               N o d e A b s t r a c t . p h p       ]     p ^     O     ��`Kpk� C�|��:�ڠ�<���`Kpk�        \               N o d e D u m p e r . p h p   ^     p ^     O     >�eKpk� C�|���Tݠ�<�>�eKpk�       �	               N o d e F i n d e r . p h p   _     x d     O     T�lKpk� C�|���ߠ�<�T�lKpk� 0      `)               N o d e T r a v e r s e r . p h p     `     � v     O      {qKpk� C�|���ߠ�<  {qKpk�x      u               N o d e T r a v e r s e r I n t e r f a c e . p h p   3     h X     O     _NTQpk���pQpk���pQpk�_NTQpk�                        N o d e V i s i t o r a     p `     O     �sKpk� C�|��K��<��sKpk�       �               N o d e V i s i t o r . p h p b     � p     O     �?vKpk� C�|���z��<��?vKpk��      �               N o d e V i s i t o r A b s t r a c t . p h p 8     ` N     O     kLsQpk�}��Qpk�}��Qpk�kLsQpk�                       P a r s e r . c     h V     O     A�xKpk� C�|��	���<�A�xKpk�x      t              
 P a r s e r . p h p   d     x f     O     ���Kpk� C�|��	���<����Kpk� �      n�               P a r s e r A b s t r a c t . p h p   e     x d     O     l��Kpk� C�|���?��<�l��Kpk�       N               P a r s e r F a c t o r y . p h p     =     p \     O     �]�Qpk�;�Qpk�;�Qpk��]�Qpk�                        P r e t t y P r i n t e r A b f     � t     O     _�pLpk� C�|� ����<�_�pLpk� �      v�               P r e t t y P r i n t e r A b s t r a c t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php declare(strict_types=1);

namespace PhpParser;

class Error extends \RuntimeException
{
    protected $rawMessage;
    protected $attributes;

    /**
     * Creates an Exception signifying a parse error.
     *
     * @param string    $message    Error message
     * @param array|int $attributes Attributes of node/token where error occurred
     *                              (or start line of error -- deprecated)
     */
    public function __construct(string $message, $attributes = []) {
        $this->rawMessage = $message;
        if (is_array($attributes)) {
            $this->attributes = $attributes;
        } else {
            $this->attributes = ['startLine' => $attributes];
        }
        $this->updateMessage();
    }

    /**
     * Gets the error message
     *
     * @return string Error message
     */
    public function getRawMessage() : string {
        return $this->rawMessage;
    }

    /**
     * Gets the line the error starts in.
     *
     * @return int Error start line
     */
    public function getStartLine() : int {
        return $this->attributes['startLine'] ?? -1;
    }

    /**
     * Gets the line the error ends in.
     *
     * @return int Error end line
     */
    public function getEndLine() : 