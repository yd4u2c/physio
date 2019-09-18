<?xml version="1.0"?>
<phpunit xmlns="https://schema.phpunit.de/coverage/1.0">
  <file name="BankAccount.php" path="%e">
    <totals>
      <lines total="33" comments="0" code="33" executable="10" executed="5" percent="50.00"/>
      <methods count="4" tested="3" percent="75.00"/>
      <functions count="0" tested="0" percent="0"/>
      <classes count="1" tested="0" percent="0.00"/>
      <traits count="0" tested="0" percent="0"/>
    </totals>
    <class name="BankAccount" start="2" executable="10" executed="5" crap="8.12">
      <package full="" name="" sub="" category=""/>
      <namespace name=""/>
      <method name="getBalance" signature="getBalance()" start="6" end="9" crap="1" executable="1" executed="1" coverage="100"/>
      <method name="setBalance" signature="setBalance($balance)" start="11" end="18" crap="6.00" executable="5" executed="0" coverage="0"/>
      <method name="depositMoney" signature="depositMoney($balance)" start="20" end="25" crap="1" executable="2" executed="2" coverage="100"/>
      <method name="withdrawMoney" signature="withdrawMoney($balance)" start="27" end="32" crap="1" executable="2" executed="2" coverage="100"/>
    </class>
    <coverage>
      <line nr="8">
        <covered by="BankAccountTest::testBalanceIsInitiallyZero"/>
        <covered by="BankAccountTest::testDepositWithdrawMoney"/>
      </line>
      <line nr="22">
        <covered by="BankAccountTest::testBalanceCannotBecomeNegative2"/>
        <covered by="BankAccountTest::testDepositWithdrawMoney"/>
      </line>
      <line nr="24">
        <covered by="BankAccountTest::testDepositWithdrawMoney"/>
      </line>
      <line nr="29">
        <covered by="BankAccountTest::testBalanceCannotBecomeNegative"/>
        <covered by="BankAccountTest::testDepositWithdrawMoney"/>
      </line>
      <line nr="31">
        <covered by="BankAccountTest::testDepositWithdrawMoney"/>
      </line>
    </coverage>
    <source>
      <line no="1">
        <token name="T_OPEN_TAG">&lt;?php</token>
      </line>
      <line no="2">
        <token name="T_CLASS">class</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STRING">BankAccount</token>
      </line>
      <line no="3">
        <token name="T_OPEN_CURLY">{</token>
      </line>
      <line no="4">
        <token name="T_WHITESPACE">    </token>
        <token name="T_PROTECTED">protected</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_VARIABLE">$bala