evaluate($r);
            case '+':   return $this->evaluate($l) +   $this->evaluate($r);
            case '**':  return $this->evaluate($l) **  $this->evaluate($r);
            case '<<':  return $this->evaluate($l) <<  $this->evaluate($r);
            case '>>':  return $this->evaluate($l) >>  $this->evaluate($r);
            case '<':   return $this->evaluate($l) <   $this->evaluate($r);
            case '<=':  return $this->evaluate($l) <=  $this->evaluate($r);
            case '<=>': return $this->evaluate($l) <=> $this->evaluate($r);
        }

        throw new \Exception('Should not happen');
    }

    private function evaluateConstFetch(Expr\ConstFetch $expr) {
        $name = $expr->name->toLowerString();
        switch ($name) {
            case 'null': return null;
            case 'false': return false;
            case 'true': return true;
        }

        return ($this->fallbackEvaluator)($expr);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         