place(sprintf('#,\s*content="%s/1.0"#', $upperName), '', $value));
        } elseif (preg_match(sprintf('#content="%s/1.0",\s*#', $upperName), $value)) {
            $response->headers->set('Surrogate-Control', preg_replace(sprintf('#content="%s/1.0",\s*#', $upperName), '', $value));
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 