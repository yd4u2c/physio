-40%'  => 0,
                '40-50%'  => 0,
                '50-60%'  => 0,
                '60-70%'  => 0,
                '70-80%'  => 0,
                '80-90%'  => 0,
                '90-100%' => 0,
                '100%'    => 0,
            ],
        ];

        foreach ($classes as $class) {
            foreach ($class['methods'] as $methodName => $method) {
                if ($method['coverage'] === 0) {
                    $result['method']['0%']++;
                } elseif ($method['coverage'] === 100) {
                    $result['method']['100%']++;
                } else {
                    $key = \floor($method['coverage'] / 10) * 10;
                    $key = $key . '-' . ($key + 10) . '%';
                    $result['method'][$key]++;
                }
            }

            if ($class['coverage'] === 0) {
                $result['class']['0%']++;
            } elseif ($class['coverage'] === 100) {
                $result['class']['100%']++;
            } else {
                $key = \floor($class['coverage'] / 10) * 10;
                $key = $key . '-' . ($key + 10) . '%';
                $result['class'][$key]++;
            }
        }

        return [
            'class'  => \json_encode(\array_values($result['class'])),
            'method' => \json_encode(\array_values($result['method'])),
        ];
    }

    /**
     * Returns the classes / methods with insufficient coverage.
     */
    protected function insufficientCoverage(array $classes, string $baseLink): array
    {
        $leastTestedClasses = [];
        $leastTestedMethods = [];
        $result             = ['class' => '', 'method' => ''];

        foreach ($classes as $className => $class) {
            foreach ($class['methods'] as $methodName => $method) {
                if ($method['coverage'] < $this->highLowerBound) {
                    $key = $methodName;

                    if ($className !== '*') {
                        $key = $className . '::' . $methodName;
                    }

                    $leastTestedMethods[$key] = $method['coverage'];
                }
            }

            if ($class['coverage'] < $this->highLowerBound) {
                $leastTestedClasses[$className] = $class['coverage'];
            }
        }

        \asort($leastTestedClasses);
        \asort($leastTestedMethods);

        foreach ($leastTestedClasses as $className => $coverage) {
            $result['class'] .= \sprintf(
                '       <tr><td><a href="%s">%s</a></td><td class="text-right">%d%%</td></tr>' . "\n",
                \str_replace($baseLink, '', $classes[$className]['link']),
                $className,
                $coverage
            );
        }

        foreach ($leastTestedMethods as $methodName => $coverage) {
            [$class, $method] = \explode('::', $methodName);

            $result['method'] .= \sprintf(
                '       <tr><td><a href="%s"><abbr title="%s">%s</abbr></a></td><td class="text-right">%d%%</td></tr>' . "\n",
                \str_replace($baseLink, '', $classes[$class]['methods'][$method]['link']),
                $methodName,
                $method,
                $coverage
            );
        }

        return $result;
    }

    /**
     * Returns the project risks according to the CRAP index.
     */
    protected function projectRisks(array $classes, string $baseLink): array
    {
        $classRisks  = [];
        $methodRisks = [];
        $result      = ['class' => '', 'method' => ''];

        foreach ($classes as $className => $class) {
            foreach ($class['methods'] as $methodName => $method) {
                if ($method['coverage'] < $this->highLowerBound && $method['ccn'] > 1) {
                    $key = $methodName;

                    if ($className !== '*') {
                        $key = $className . '::' . $methodName;
                    }

                    $methodRisks[$key] = $method['crap'];
                }
            }

            if ($class['coverage'] < $this->highLowerBound &&
                $class['ccn'] > \count($class['methods'])) {
                $classRisks[$className] = $class['crap'];
            }
        }

        \arsort($classRisks);
        \arsort($methodRisks);

        foreach ($classRisks as $className => $crap) {
            $result['class'] .= \sprintf(
                '       <tr><td><a href="%s">%s</a></td><td class="text-right">%d</td></tr>' . "\n",
                \str_replace($baseLink, '', $classes[$className]['link']),
                $className,
                $crap
            );
        }

        foreach ($methodRisks as $methodName => $crap) {
            [$class, $method] = \explode('::', $methodName);

            $result['method'] .= \sprintf(
                '       <tr><td><a href="%s"><abbr title="%s">%s</abbr></a></td><td class="text-right">%d</td></tr>' . "\n",
                \str_replace($baseLink, '', $classes[$class]['methods'][$method]['link']),
                $methodName,
                $method,
                $crap
            );
        }

        return $result;
    }

    protected function getActiveBreadcrumb(AbstractNode $node): string
    {
        return \sprintf(
            '         <li class="breadcrumb-item"><a href="index.html">%s</a></li>' . "\n" .
            '         <li class="breadcrumb-item active">(Dashboard)</li>' . "\n",
            $node->getName()
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         