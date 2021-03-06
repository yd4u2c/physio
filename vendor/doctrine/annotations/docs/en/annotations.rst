<?php

namespace Doctrine\Common\Cache;

use function array_values;
use function count;
use function iterator_to_array;

/**
 * Cache provider that allows to easily chain multiple cache providers
 */
class ChainCache extends CacheProvider
{
    /** @var CacheProvider[] */
    private $cacheProviders = [];

    /**
     * @param CacheProvider[] $cacheProviders
     */
    public function __construct($cacheProviders = [])
    {
        $this->cacheProviders = $cacheProviders instanceof \Traversable
            ? iterator_to_array($cacheProviders, false)
            : array_values($cacheProviders);
    }

    /**
     * {@inheritDoc}
     */
    public function setNamespace($namespace)
    {
        parent::setNamespace($namespace);

        foreach ($this->cacheProviders as $cacheProvider) {
            $cacheProvider->setNamespace($namespace);
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function doFetch($id)
    {
        foreach ($this->cacheProviders as $key => $cacheProvider) {
            if ($cacheProvider->doContains($id)) {
                $value = $cacheProvider->doFetch($id);

                // We populate all the previous cache layers (that are assumed to be faster)
                for ($subKey = $key - 1; $subKey >= 0; $subKey--) {
                    $this->cacheProviders[$subKey]->doSave($id, $value);
                }

                return $value;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetchMultiple(array $keys)
    {
        /** @var CacheProvider[] $traversedProviders */
        $traversedProviders = [];
        $keysCount          = count($keys);
        $fetchedValues      = [];

        foreach ($this->cacheProviders as $key => $cacheProvider) {
            $fetchedValues = $cacheProvider->doFetchMultiple($keys);

            // We populate all the previous cache layers (that are assumed to be faster)
            if (count($fetchedValues) === $keysCount) {
                foreach ($traversedProviders as $previousCacheProvider) {
                    $previousCacheProvider->doSaveMultiple($fetchedValues);
                }

                return $fetchedValues;
            }

            $traversedProviders[] = $cacheProvider;
        }

        return $fetchedValues;
    }

    /**
     * {@inheritDoc}
     */
    protected function doContains($id)
    {
        foreach ($this->cacheProviders as $cacheProvider) {
            if ($cacheProvider->doContains($id)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        $stored = true;

        foreach ($this->cacheProviders as $cacheProvider) {
            $stored = $cacheProvider->doSave($id, $data, $lifeTime) && $stored;
        }

        return $stored;
    }

    /**
     * {@inheritdoc}
     */
    protected function doSaveMultiple(array $keysAndValues, $lifetime = 0)
    {
        $stored = true;

        foreach ($this->cacheProviders as $cacheProvider) {
            $stored = $cacheProvider->doSaveMultiple($keysAndValues, $lifetime) && $stored;
        }

        return $stored;
    }

    /**
     * {@inheritDoc}
     */
    protected function doDelete($id)
    {
        $deleted = true;

        foreach ($this->cacheProviders as $cacheProvider) {
            $deleted = $cacheProvider->doDelete($id) && $deleted;
        }

        return $deleted;
    }

    /**
     * {@inheritdoc}
     */
    protected function doDeleteMultiple(array $keys)
    {
        $deleted = true;

        foreach ($this->cacheProviders as $cacheProvider) {
            $deleted = $cacheProvider->doDeleteMultiple($keys) && $deleted;
        }

        return $deleted;
    }

    /**
     * {@inheritDoc}
     */
    protected function doFlush()
    {
        $flushed = true;

        foreach ($this->cacheProviders as $cacheProvider) {
            $flushed = $cacheProvider->doFlush() && $flushed;
        }

        return $flushed;
    }

    /**
     * {@inheritDoc}
     */
    protected function doGetStats()
    {
        // We return all the stats from all adapters
        $stats = [];

        foreach ($this->cacheProviders as $cacheProvider) {
            $stats[] = $cacheProvider->doGetStats();
        }

        return $stats;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         INDX( 	 /�g             (   x  �        �  B p �e         �     p Z     �     ��ok� �9�N�{�<���ok�       M	               A p c C a c h e . p h p       �     p \     �     =d��ok� �9�尹{�<�=d��ok�       x               A p c u C a c h e . p h p     �     p ^     �     X���ok� �9�尹{�<�X���ok�                      A r r a y C a c h e . p h p   �     h T     �     ���ok� �9�I�{�<����ok�       �
              	 C a c h e . p h p     �     x d     �     �;�ok� �9�I�{�<��;�ok� 0      
!               C a c h e P r o v i d e r . p h p     �     p ^     �     ��ok� �9��u�{�<���ok�        7               C h a i n C a c h e . p h p   �     x f     �     ���ok� �9��u�{�<����ok��      �               C l e a r a b l e C a c h e . p h p   �     � r     �     o:"�ok� �9�8��{�<�o:"�ok�        '               C o u c h b a s e B u c k e t C a c h e . p h p       �     x f     �     ��&�ok  �9��:�{�<���&�ok�       	               C o u c h b a s e C a c h e . p h p   �     x h     �     F&.�ok� �9���{�<�F&.�ok�        �               E x t M o n g o D B C a c h e . p h p  	     p \     �     ��7�ok� �9���{�<���7�ok�        �               F i l e C a c h e . p h p     	     x h     �     ��>�ok� �9�T��{�<���>�ok�                      F i l e s y s t e m C a c h e . p h p 	     x f     �     9A�ok� �9��a�{�<�9A�ok�`      ^              F l u s h a b l e C a c h e . p h p   	     � n     �     ��E�ok� �9� ��{�<���E�ok�        �               L e g a c y M o n g o D B C a c h e . p h p   	     x d     �     �$M�ok� �9� ��{�<��$M�ok�       F               M e m c a c h e C a c h e . p h p     	     x f     �     ��1�ok� �9�o&�{�<���1�ok�       6               M e m c a c h e d C a c h e . p h p   	     x b     �     �@�ok� �9���{�<��@�ok�       Z               M o n g o D  C a c h e . p h p       	     � j     �     C�D�ok� �9�