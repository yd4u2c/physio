<?php

namespace Illuminate\Queue\Events;

class JobFailed
{
    /**
     * The connection name.
     *
     * @var string
     */
    public $connectionName;

    /**
     * The job instance.
     *
     * @var \Illuminate\Contracts\Queue\Job
     */
    public $job;

    /**
     * The exception that caused the job to fail.
     *
     * @var \Exception
     */
    public $exception;

    /**
     * Create a new event instance.
     *
     * @param  string  $connectionName
     * @param  \Illuminate\Contracts\Queue\Job  $job
     * @param  \Exception  $exception
     * @return void
     */
    public function __construct($connectionName, $job, $exception)
    {
        $this->job = $job;
        $this->exception = $exception;
        $this->connectionName = $connectionName;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     INDX( 	 3v             (      �                             H     � r     G     2�,pk� �H ���D
��<�2�,pk�                      J o b E x c e p t i o n O c c u r r e d . p h p       I     p \     G     $4pk� �H ��0���<�$4pk�                      J o b F a i l e d . p h p     J     x b     G     ��8pk� �H ��0���<���8pk�P      M               J o b P r o c e s s e d . p h p       K     x d     G     �@pk� �H ���	��<��@pk�P      N              J o b P r o c e s s i n g . p h p     L     h X     G     �iBpk� �H ���k��<��iBpk�                      L o o p i n g . p h p M     x f     G     ��Dpk� �H ��F���<���Dpk�`      ]               W o r k e r S t o p p i n g . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           