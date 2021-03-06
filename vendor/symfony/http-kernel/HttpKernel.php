        $s = $this->style('meta', '%s');
                        $f = strip_tags($this->style('', $file));
                        $name = strip_tags($this->style('', $name));
                        if ($fmt && $link = \is_string($fmt) ? strtr($fmt, ['%f' => $file, '%l' => $line]) : $fmt->format($file, $line)) {
                            $name = sprintf('<a href="%s" title="%s">'.$s.'</a>', strip_tags($this->style('', $link)), $f, $name);
                        } else {
                            $name = sprintf('<abbr title="%s">'.$s.'</abbr>', $f, $name);
                        }
                    } else {
                        $name = $this->style('meta', $name);
                    }
                    $this->line = $name.' on line '.$this->style('meta', $line).':';
                } else {
                    $this->line = $this->style('meta', $name).' on line '.$this->style('meta', $line).':';
                }
                $this->dumpLine(0);
            };
            $contextDumper = $contextDumper->bindTo($dumper, $dumper);
            $contextDumper($name, $file, $line, $this->fileLinkFormat);
        } else {
            $cloner = new VarCloner();
            $dumper->dump($cloner->cloneVar($name.' on line '.$line.':'));
        }
        $dumper->dump($data);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             INDX( 	 (��             (   �  �         ��                �/     � l     �/     4PB�pk� �V0e ��R���<�4PB�pk�       7               A j a x D a t a C o l l e c t o r . p h p     �/     � p     �/     ��P�pk� �V0e �$����<���P�pk� 0      �$               C o n f i g D a t a C o l l e c t o r . p h p �/     x d     �/     ��W�pk� �V0e �$����<���W�pk�                      D a t a C o l l e c t o r . p h p     �/     � v     �/     7�\�pk� �V0e �i���<�7�\�pk�       x              D a t a C o l l e c t o r I n t e r f a c e . p h p   �/     � l     �/     �f�pk� �V0e ��x���<��f�pk� 0      #%               D u m p D a t a C o l l e c t o r . p h p     �/     � n     �/     ~9m�pk� �V0e �mۋ��<�~9m�pk�       -               E v e n t D a t a C o l l e c t o r . p h p   �/     � v     �/     P%y�pk� �V0e �mۋ��<�P%y�pk�       �               E x c e p t i o n D a t a C o l l e c t o r . p h p   �/     � ~     �/     ��{�pk� �V0e ��=���<���{�pk                      L a t e D a t a C o l l e c t o r I n t e r f a c e . p h p   �/     � p     �/     
M��pk� �V0e �矐��<�
M��pk� 0      �!               L o g g e r D a t a C o l l e c t o r . p h p �/     � p     �/     �8��pk� �V0e �F���<��8��pk�       �	               M e m o r y D a t a C o l l e c t o r . p h p �/     � r     �/     ����pk� �V0e �F���<�����pk� @      6               R e q u e s t D a t a C o l l e c t o r . p h p       �/     � p     �/     #���pk  �V0e ��e���<�#���pk�       �	               R o u t e r D a t a C o l l e c t o r . p h p �/     � l     �/     �6��pk� �V0e ��Ɨ��<��6��pk�       h               T i m e D a t a C o l l e c t o r . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\DataCollector;

use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Service\ResetInterface;

/**
 * EventDataCollector.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class EventDataCollector extends DataCollector implements LateDataCollectorInterface
{
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher = null)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = [
            'called_listeners' => [],
            'not_called_listeners' => [],
            'orphaned_events' => [],
        ];
    }

    public function reset()
    {
        $this->data = [];

        if ($this->dispatcher instanceof ResetInterface) {
            $this->dispatcher->reset();
        }
    }

    public function lateCollect()
    {
        if ($this->dispatcher instanceof TraceableEventDispatcherInterface) {
            $this->setCalledListeners($this->dispatcher->getCalledListeners());
            $this->setNotCalledListeners($this->dispatcher->getNotCalledListeners());
        }

        if ($this->dispatcher instanceof TraceableEventDispatcher) {
            $this->setOrphanedEvents($this->dispatcher->getOrphanedEvents());
        }

        $this->data = $this->cloneVar($this->data);
    }

    /**
     * Sets the called listeners.
     *
     * @param array $listeners An array of called listeners
     *
     * @see TraceableEventDispatcher
     */
    public function setCalledListeners(array $listeners)
    {
        $this->data['called_listeners'] = $listeners;
    }

    /**
     * Gets the called listeners.
     *
     * @return array An array of called listeners
     *
     * @see TraceableEventDispatcher
     */
    public function getCalledListeners()
    {
        return $this->data['called_listeners'];
    }

    /**
     * Sets the not called listeners.