<?php

namespace Illuminate\Queue\Console;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;

class ListFailedCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'queue:failed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all of the failed queue jobs';

    /**
     * The table headers for the command.
     *
     * @var array
     */
    protected $headers = ['ID', 'Connection', 'Queue', 'Class', 'Failed At'];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (count($jobs = $this->getFailedJobs()) === 0) {
            return $this->info('No failed jobs!');
        }

        $this->displayFailedJobs($jobs);
    }

    /**
     * Compile the failed jobs into a displayable format.
     *
     * @return array
     */
    protected function getFailedJobs()
    {
        $failed = $this->laravel['queue.failer']->all();

        return collect($failed)->map(function ($failed) {
            return $this->parseFailedJob((array) $failed);
        })->filter()->all();
    }

    /**
     * Parse the failed job row.
     *
     * @param  array  $failed
     * @return array
     */
    protected function parseFailedJob(array $failed)
    {
        $row = array_values(Arr::except($failed, ['payload', 'exception']));

        array_splice($row, 3, 0, $this->extractJobName($failed['payload']));

        return $row;
    }

    /**
     * Extract the failed job name from payload.
     *
     * @param  string  $payload
     * @return string|null
     */
    private function extractJobName($payload)
    {
        $payload = json_decode($payload, true);

        if ($payload && (! isset($payload['data']['command']))) {
            return $payload['job'] ?? null;
        } elseif ($payload && isset($payload['data']['command'])) {
            return $this->matchJobName($payload);
        }
    }

    /**
     * Match the job name from the payload.
     *
     * @param  array  $payload
     * @return string
     */
    protected function matchJobName($payload)
    {
        preg_match('/"([^"]+)"/', $payload['data']['command'], $matches);

        return $matches[1] ?? $payload['job'] ?? null;
    }

    /**
     * Display the failed jobs in the console.
     *
     * @param  array  $jobs
     * @return void
     */
    protected function displayFailedJobs(array $jobs)
    {
        $this->table($this->headers, $jobs);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            INDX( 	 1v             (   �  �         u                   ;     � n     :     =��pk� �H ���0���<�=��pk�       y	               F a i l e d T a b l e C o m m a n d . p h p   <     � n     :     q��pk� �H ��Q����<�q��pk�p      i               F l u s h F a i l e d C o m m a n d . p h p   =     � p     :     3m�pk� �H ��Q����<�3m�pk�                      F o r g e t F a i l e d C o m m a n d . p h p >     x d     :     I��pk� �H �������<�I��pk�      �               L i s t e n C o m m a n d . p h p     ?     � l     :     ��pk� �H ��X���<���pk�       
               L i s t F a i l e d C o m m a n d . p h p     @     x f     :     ��pk� �H ��]� ��<���pk�       �               R e s t a r t C o m m a n d . p h p   A     x b     :     �	pk� �H ��]� ��<��	pk�       =               R e t r y C o m m a n d . p h p       D     ` L     :     ,pk�K	!pk�K	!pk�,pk�                        s t  b s C o B     x b     :     �1	pk� �H �����<��1	pk�       V	               T a b l e C o m m a n d . p h p       C     p `     :     /�pk� �H ��W��<�/�pk�        �               W o r k C o m m a n d . p h p                                                                                                                                                                                                                                    