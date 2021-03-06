<?php

namespace Illuminate\View;

interface ViewFinderInterface
{
    /**
     * Hint path delimiter value.
     *
     * @var string
     */
    const HINT_PATH_DELIMITER = '::';

    /**
     * Get the fully qualified location of the view.
     *
     * @param  string  $view
     * @return string
     */
    public function find($view);

    /**
     * Add a location to the finder.
     *
     * @param  string  $location
     * @return void
     */
    public function addLocation($location);

    /**
     * Add a namespace hint to the finder.
     *
     * @param  string  $namespace
     * @param  string|array  $hints
     * @return void
     */
    public function addNamespace($namespace, $hints);

    /**
     * Prepend a namespace hint to the finder.
     *
     * @param  string  $namespace
     * @param  string|array  $hints
     * @return void
     */
    public function prependNamespace($namespace, $hints);

    /**
     * Replace the namespace hints for the given namespace.
     *
     * @param  string  $namespace
     * @param  string|array  $hints
     * @return void
     */
    public function replaceNamespace($namespace, $hints);

    /**
     * Add a valid view extension to the finder.
     *
     * @param  string  $extension
     * @return void
     */
    public function addExtension($extension);

    /**
     * Flush the cache of located views.
     *
     * @return void
     */
    public function flush();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     INDX( 	 {�w             (   `  �       �                   :     h T     1     Ƕ�pk��݊pk��݊pk��݊pk�                       	 C o m p i l e r s j s 2     p \     1     ��ppk� �H ���j���<���ppk�       �               c o m p o s e r . j s o n     N     h R     1     o�pk�Ϡ�pk�Ϡ�pk�o�pk�                        C o n c e r n s p h p U     ` P     1     2�pk����pk����pk�2�pk�                        E n g i n e s 3     h X     1     spk  �H ��U����<�spk� @      �5               F a c t o r y . p h p 4     x f     1     Nhupk� �H ��U����<�Nhupk�        �               F i l e V i e w F i n d e r . p h p   5     h V     1     ��wpk� �H ��l/���<���wpk�       3              
 L I C E N S E . m d   [     h V     1     #�pk�#�pk�#�pk�#�pk�                       
 M i d d l e w a r e   6     h R     1     .zpk� �H ������<�.zpk� 0      *%               V i e w . p h p       7     � p     1     d�|pk� �H ��)����<�d�|pk�       �               V i e w F i n d e r I n t e r f a c e . p h p 8     p Z     1     ��~pk� �H ��)����<���~pk�                     V i e w N a m e . p h p       9     � p     1     T�pk� �H ���U��<�T�pk�        �               V i e w S e r v i c e P r o v i d e r . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  