---------------+
| hello world     | Lorem ipsum dolor sit amet, co    |
|                 | nsectetur adipiscing elit         |
+-----------------+-----------------+-----------------+
| hello           | world           | Lorem ipsum dol |
|                 |                 | or sit amet, co |
|                 |                 | nsectetur       |
+-----------------+-----------------+-----------------+
| Symfony         | Test            | Lorem ipsum dol |
|                 |                 | or sit amet, co |
|                 |                 | nsectetur       |
+-----------------+-----------------+-----------------+

TABLE;

        $this->assertSame($expected, $this->getOutputContent($output));
    }
}
                                                                                                                                   