dvi;q=0.8, */*;q=0.3', '*', 0.3];
        yield ['text/plain;q=0.5, text/html, text/x-dvi;q=0.8, */*', '*', 1.0];
        yield ['text/plain;q=0.5, text/html, text/x-dvi;q=0.8, */*', 'text/xml', 1.0];
        yield ['text/plain;q=0.5, text/html, text/x-dvi;q=0.8, */*', 'text/*', 1.0];
        yield ['text/plain;q=0.5, text/html, text/*;q=0.8, */*', 'text/*', 0.8];
        yield ['text/plain;q=0.5, text/html, text/*;q=0.8, */*', 'text/html', 1.0];
        yield ['text/plain;q=0.5, text/html, text/*;q=0.8, */*', 'text/x-dvi', 0.8];
        yield ['*;q=0.3, ISO-8859-1;q=0.7, utf-8;q=0.7', '*', 0.3];
        yield ['*;q=0.3, ISO-8859-1;q=0.7, utf-8;q=0.7', 'utf-8', 0.7];
        yield ['*;q=0.3, ISO-8859-1;q=0.7, utf-8;q=0.7', 'SHIFT_JIS', 0.3];
    }
}
                                                                                                                                                                                                               