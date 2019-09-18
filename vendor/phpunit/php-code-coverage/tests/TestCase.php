<?xml version="1.0"?>
<phpunit xmlns="https://schema.phpunit.de/coverage/1.0">
  <file name="source_with_class_and_anonymous_function.php" path="%e">
    <totals>
      <lines total="19" comments="2" code="17" executable="8" executed="7" percent="87.50"/>
      <methods count="1" tested="0" percent="0.00"/>
      <functions count="0" tested="0" percent="0"/>
      <classes count="1" tested="0" percent="0.00"/>
      <traits count="0" tested="0" percent="0"/>
    </totals>
    <class name="CoveredClassWithAnonymousFunctionInStaticMethod" start="3" executable="8" executed="7" crap="1">
      <package full="" name="" sub="" category=""/>
      <namespace name=""/>
      <method name="runAnonymous" signature="runAnonymous()" start="5" end="18" crap="1.00" executable="8" executed="7" coverage="87.5"/>
    </class>
    <coverage>
      <line nr="7">
        <covered by="ClassWithAnonymousFunction"/>
      </line>
      <line nr="9">
        <covered by="ClassWithAnonymousFunction"/>
      </line>
      <line nr="12">
        <covered by="ClassWithAnonymousFunction"/>
      </line>
      <line nr="13">
        <covered by="ClassWithAnonymousFunction"/>
      </line>
      <line nr="14">
        <covered by="ClassWithAnonymousFunction"/>
      </line>
      <line nr="17">
        <covered by="ClassWithAnonymousFunction"/>
      </line>
      <line nr="18">
        <covered by="ClassWithAnonymousFunction"/>
      </line>
    </coverage>
    <source>
      <line no="1">
        <token name="T_OPEN_TAG">&lt;?php</token>
      </line>
      <line no="2"/>
      <line no="3">
        <token name="T_CLASS">class</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STRING">CoveredClassWithAnonymousFunctionInStaticMethod</token>
      </line>
      <line no="4">
        <token name="T_OPEN_CURLY">{</token>
      </line>
      <line no="5">
        <token name="T_WHITESPACE">    </token>
        <token name="T_PUBLIC">public</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STATIC">static</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_FUNCTION">function</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STRING">runAnonymous</token>
        <token name="T_OPEN_BRACKET">(</token>
        <token name="T_CLOSE_BRACKET">)</token>
      </line>
      <line no="6">
        <token name="T_WHITESPACE">    </token>
        <token name="T_OPEN_CURLY">{</token>
      </line>
      <line no="7">
        <token name="T_WHITESPACE">        </token>
        <token name="T_VARIABLE">$filter</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_EQUAL">=</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_OPEN_SQUARE">[</token>
        <token name="T_CONSTANT_ENCAPSED_STRING">'abc124'</token>
        <token name="T_COMMA">,</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_CONSTANT_ENCAPSED_STRING">'abc123'</token>
        <token name="T_COMMA">,</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_CONSTANT_ENCAPSED_STRING">'123'</token>
        <token name="T_CLOSE_SQUARE">]</token>
        <token name="T_SEMICOLON">;</token>
      </line>
      <line no="8"/>
      <line no="9">
        <token name="T_WHITESPACE">        </token>
        <token name="T_STRING">array_walk</token>
        <token name="T_OPEN_BRACKET">(</token>
      </line>
      <line no="10">
        <token name="T_WHITESPACE">            </token>
        <token name="T_VARIABLE">$filter</token>
        <token name="T_COMMA">,</token>
      </line>
      <line no="11">
        <token name="T_WHITESPACE">            </token>
        <token name="T_FUNCTION">function</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_OPEN_BRACKET">(</token>
        <token name="T_AMPERSAND">&amp;</token>
        <token name="T_VARIABLE">$val</token>
        <token name="T_COMMA">,</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_VARIABLE">$key</token>
        <token name="T_CLOSE_BRACKET">)</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_OPEN_CURLY">{</token>
      </line>
      <line no="12">
        <token name="T_WHITESPACE">                </token>
        <token name="T_VARIABLE">$val</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_EQUAL">=</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STRING">preg_replace</token>
        <token name="T_OPEN_BRACKET">(</token>
        <token name="T_CONSTANT_ENCAPSED_STRING">'|[^0-9]|'</token>
        <token name="T_COMMA">,</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_CONSTANT_ENCAPSED_STRING">''</token>
        <token name="T_COMMA">,</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_VARIABLE">$val</token>
        <token name="T_CLOSE_BRACKET">)</token>
        <token name="T_SEMICOLON">;</token>
      </line>
      <line no="13">
        <token name="T_WHITESPACE">            </token>
        <token name="T_CLOSE_CURLY">}</token>
      </line>
      <line no="14">
        <token name="T_WHITESPACE">        </token>
        <token name="T_CLOSE_BRACKET">)</token>
        <token name="T_SEMICOLON">;</token>
      </line>
      <line no="15"/>
      <line no="16">
        <token name="T_WHITESPACE">        </token>
        <token name="T_COMMENT">// Should be covered</token>
      </line>
      <line no="17">
        <token name="T_WHITESPACE">        </token>
        <token name="T_VARIABLE">$extravar</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_EQUAL">=</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STRING">true</token>
        <token name="T_SEMICOLON">;</token>
      </line>
      <line no="18">
        <token name="T_WHITESPACE">    </token>
        <token name="T_CLOSE_CURLY">}</token>
      </line>
      <line no="19">
        <token name="T_CLOSE_CURLY">}</token>
      </line>
      <line no="20"/>
    </source>
  </file>
</phpunit>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?xml version="1.0"?>
<phpunit xmlns="https://schema.phpunit.de/coverage/1.0">
  <build time="%s" phpunit="%s" coverage="%s">
    <runtime name="%s" version="%s" url="%s"/>
    <driver name="%s" version="%s"/>
  </build>
  <project source="%s">
    <tests>
      <test name="FileWithIgnoredLines" size="unknown" result="-1" status="UNKNOWN"/>
    </tests>
    <directory name="%s">
      <totals>
        <lines total="37" comments="12" code="25" executable="2" executed="1" percent="50.00"/>
        <methods count="0" tested="0" percent="0"/>
        <functions count="1" tested="1" percent="100.00"/>
        <classes count="0" tested="0" percent="0"/>
        <traits count="0" tested="0" percent="0"/>
      </totals>
      <file name="source_with_ignore.php" href="source_with_ignore.php.xml">
        <totals>
          <lines total="37" comments="12" code="25" executable="2" executed="1" percent="50.00"/>
          <methods count="0" tested="0" percent="0"/>
          <functions count="1" tested="1" percent="100.00"/>
          <classes count="0" tested="0" percent="0"/>
          <traits count="0" tested="0" percent="0"/>
        </totals>
      </file>
    </directory>
  </project>
</phpunit>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 