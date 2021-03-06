# Configuration for probot-stale - https://github.com/probot/stale

# Number of days of inactivity before an Issue or Pull Request becomes stale
daysUntilStale: 60

# Number of days of inactivity before a stale Issue or Pull Request is closed.
# Set to false to disable. If disabled, issues still need to be closed manually, but will remain marked as stale.
daysUntilClose: 7

# Issues or Pull Requests with these labels will never be considered stale. Set to `[]` to disable
exemptLabels:
  - enhancement

# Set to true to ignore issues in a project (defaults to false)
exemptProjects: false

# Set to true to ignore issues in a milestone (defaults to false)
exemptMilestones: false

# Label to use when marking as stale
staleLabel: stale

# Comment to post when marking as stale. Set to `false` to disable
markComment: >
  This issue has been automatically marked as stale because it has not had activity within the last 60 days. It will be closed after 7 days if no further activity occurs. Thank you for your contributions.

# Comment to post when removing the stale label.
# unmarkComment: >
#   Your comment here.

# Comment to post when closing a stale Issue or Pull Request.
closeComment: >
  This issue has been automatically closed because it has not had activity since it was marked as stale. Thank you for your contributions.

# Limit the number of actions per hour, from 1-30. Default is 30
limitPerRun: 30

# Limit to only `issues` or `pulls`
only: issues

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php
/*
 * This file is part of php-file-iterator.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianBergmann\FileIterator;

class Facade
{
    /**
     * @param array|string $paths
     * @param array|string $suffixes
     * @param array|string $prefixes
     * @param array        $exclude
     * @param bool         $commonPath
     *
     * @return array
     */
    public function getFilesAsArray($paths, $suffixes = '', $prefixes = '', array $exclude = [], bool $commonPath = false): array
    {
        if (\is_string($paths)) {
            $paths = [$paths];
        }

        $factory = new Factory;

        $iterator = $factory->getFileIterator($paths, $suffixes, $prefixes, $exclude);

        $files = [];

        foreach ($iterator as $file) {
            $file = $file->getRealPath();

            if ($file) {
                $files[] = $file;
            }
        }

        foreach ($paths as $path) {
            if (\is_file($path)) {
                $files[] = \realpath($path);
            }
        }

        $files = \array_unique($files);
        \sort($files);

        if ($commonPath) {
            return [
              'commonPath' => $this->getCommonPath($files),
              'files'      => $files
            ];
        }

        return $files;
    }

    protected function getCommonPath(array $files): string
    {
        $count = \count($files);

        if ($count === 0) {
            return '';
        }

        if ($count === 1) {
            return \dirname($files[0]) . DIRECTORY_SEPARATOR;
        }

        $_files = [];

        foreach ($files as $file) {
            $_files[] = $_fileParts = \explode(DIRECTORY_SEPARATOR, $file);

            if (empty($_fileParts[0])) {
                $_fileParts[0] = DIRECTORY_SEPARATOR;
            }
        }

        $common = '';
        $done   = false;
        $j      = 0;
        $count--;

        while (!$done) {
            for ($i = 0; $i < $count; $i++) {
                if ($_files[$i][$j] != $_files[$i + 1][$j]) {
                    $done = true;

                    break;
                }
            }

            if (!$done) {
                $common .= $_files[0][$j];

                if ($j > 0) {
                    $common .= DIRECTORY_SEPARATOR;
                }
            }

            $j++;
        }

        return DIRECTORY_SEPARATOR . $common;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    