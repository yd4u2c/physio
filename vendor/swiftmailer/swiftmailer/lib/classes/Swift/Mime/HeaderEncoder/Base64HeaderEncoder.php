 {
                        $last_found = $search_pos[-1];
                        $last_size = $search_pos[-2];
                    }
                }
                // We got a complete pattern
                elseif (PHP_INT_MAX !== $last_found) {
                    // Adding replacement datas to output buffer
                    $rep_size = $this->repSize[$last_found];
                    for ($j = 0; $j < $rep_size; ++$j) {
                        $newBuffer[] = $this->replace[$last_found][$j];
                    }
                    // We Move cursor forward
                    $i += $last_size - 1;
                    // Edge Case, last position in buffer
                    if ($i >= $buf_size) {
                        $newBuffer[] = $buffer[$i];
                    }

                    // We start the next loop
                    continue 2;
                } else {
                    // this byte is not in a pattern and we haven't found another pattern
                    break;
                }
            }
            // Normal byte, move it to output buffer
            $newBuffer[] = $buffer[$i];
        }

        return $newBuffer;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                             