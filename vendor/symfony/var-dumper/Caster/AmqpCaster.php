 $j = -1;
                foreach ($queue[$i] as $k => $v) {
                    foreach ([$k => true] as $gk => $gv) {
                    }
                    if ($gk !== $k) {
                        $vals = (object) $vals;
                        $vals->{$k} = $refs[++$j];
                        $vals = (array) $vals;
                    } else {
                        $vals[$k] = $refs[++$j];
                    }
                }
            }

            $queue[$i] = $vals;
        }

        foreach ($values as $h => $v) {
            $hardRefs[$h] = $v;
        }

        return $queue;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        INDX( 	 �ޮ             (   H  �                             64     x f     54     ��)qk� ��9` �4�6��<���)qk� P      mA               A b s t r a c t C l o n e r . p h p   74     x h     54     �B*qk� ��9` �UX��<��B*qk�@      <               C l o n e r I n t e r f a c e . p h p 84     h V     54     }��*qk� ��9` ���Z��<�}��*qk�                     
 C u r s o r . p h p   94     h R     54     M�*qk� ��9` ���Z��<�M�*qk� @      5               D a t a . p h p      :4     x h     54     @t�*qk� ��9` ��]��<�@t�*qk�                      D u m p e r I n t e r f a c e . p h p ;4     h R     54     ���*qk� ��9` �"}_��<����*qk�       �               S t u b . p h p       <4     p \     54     �8�*qk� ��9` �"}_��<��8�*qk� @      h2               V a r C l o n e r . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               