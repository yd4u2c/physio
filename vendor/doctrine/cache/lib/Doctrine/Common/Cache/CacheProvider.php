a Doctrine Type. Use ' .
            'AbstractPlatform#registerDoctrineTypeMapping() or have your custom types implement ' .
            'Type#getMappedDatabaseTypes(). If the type name is empty you might ' .
            'have a problem with the cache or forgot some mapping information.');
    }

    /**
     * @param string $name
     *
     * @return \Doctrine\DBAL\DBALException
     */
    public static function typeNotFound($name)
    {
        return new self('Type to be overwritten ' . $name . ' does not exist.');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          INDX( 	 �Ri             (   �  �          ���c           3	     ` L     !	     ��s�ok�����ok�����ok���s�ok�                        C a c h e n C "	     p ^     !	     Ն��ok� ������8|�<�Ն��ok�       �               C o l u m n C a s e . p h p   #	     x d     !	     ~���ok� ������X�|�<�~���ok�        p               C o n f i g u r a t i o n . p h p     $	     p ^     !	     3��ok� ������X�|�<�3��ok� �      �               C o n n e c t i o n . p h p   %	     � p     !	     DG3�ok� ��������|�<�DG3�ok�       �               C o n n e c t i o n E x c e p t i o n . p h p 8	     h X     !	     ����ok�O͙�ok�O͙�ok�����ok�                        C o n n e c t i o n s &	     x d     !	     Tn:�ok� ������^|�<�Tn:�ok� 0      "               D B A L E x c e p t i o n . p h p     :	     ` N     !	     �.��ok��o��ok��o��ok��o��ok�                        D r i v e r . '	     h V     !	     ��<�ok� ��������
|�<���<�ok�       ~             
 D r i v e r . p h p   (	     x d     !	     ��C�ok� ��������
|�<���C�ok� @      0:               D r i v e r M a n a g e r . p h p     {	     ` L     !	     ��ok��j\�ok��j\�ok��j\�ok�                        E v e n t s . )	     h V     !	     �H�ok� �������#|�<��H�ok�       H              
 E v e n t s . p h p   �	     h T     !	     3�j�ok�����ok�����ok�3�j�ok�                       	 E x c e p t i o n . p *	     p \     !	     �K�ok� ������&�|�<��K�ok        �               F e t c h M o d e . p h p     �	     X F     !	     ����ok�����ok�����ok�����ok�                        I d c +	     p Z     !	     =�M�ok� ������&�|�<�=�M�ok��      �               L o c k M o d e . p h p       �	     ` P     !	     $��ok��1��ok��1��ok�$��ok�                        L o g g i n g ,	     x d     !	     ��O�ok� ������k�|�<���O�ok�                      P a r a m e t e r T y p e . p h p     �	     h T     !	     �1��ok����ok ���ok����ok�                       	 P l a t f o r m s U t �	     h X     !	     :)��ok��O��ok��O��ok�:)��ok�                        P o r t a b i l i t y �	     ` L     !	     .���ok��c��ok��c��ok��c��ok�                        Q u e r y r s �	     ` N     !	     �׵�ok�2���ok�2���ok�2���ok�                        S c h e m a s �     h R     !	     �P��ok�w(�ok�w(�ok�w(�ok�                        S h a r d i n g r U t -	     x f     !	     �
W�ok� �������J|�< �
W�ok� 0      O!               S Q L P a r s e r U t i l s . p h p   .	     � x     !	     ��`�ok� ������=�|�<���`�ok�       �               S Q L P a r s e r U t i l s E x c e p t i o n . p h p /	     p \     !	     �Xe�ok� ������=�|�<��Xe�ok�        �               S t a t e m e n t . p h p     �     ` L     !	     �1��ok����ok����ok����ok�                        T o o l s a c 0	     � |     !	     &�g�ok� �������|�<�&�g�ok�@      :               T r a n s a  t i o n I s o l a t i o n L e v e l . p h p     �     ` L     !	     V(�ok�����ok�����ok�V(�ok�                        T y p e s o n 1	     h X     !	     }�l�ok� �������q|�<�}�l�ok�                      V e r s i o n . p h p 2	     � ~     !	     ��s�ok� ��������|�<���s�ok�       �               V e r s i o n A w a r e P l a t f o r m D r i v e r . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Doctrine\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\AbstractSchemaManager;

/**
 * Driver interface.
 * Interface that all DBAL drivers must implement.
 */
interface Driver
{
    /**
     * Attempts to create a con