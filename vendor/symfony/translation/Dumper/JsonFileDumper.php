 for the attribute 'priority'.</xsd:documentation>
    </xsd:annotation>
    <xsd:restriction base="xsd:positiveInteger">
      <xsd:enumeration value="1">
        <xsd:annotation>
          <xsd:documentation>Highest priority.</xsd:documentation>
        </xsd:annotation>
      </xsd:enumeration>
      <xsd:enumeration value="2">
        <xsd:annotation>
          <xsd:documentation>High priority.</xsd:documentation>
        </xsd:annotation>
      </xsd:enumeration>
      <xsd:enumeration value="3">
        <xsd:annotation>
          <xsd:documentation>High priority, but not as important as 2.</xsd:documentation>
        </xsd:annotation>
      </xsd:enumeration>
      <xsd:enumeration value="4">
        <xsd:annotation>
          <xsd:documentation>High priority, but not as important as 3.</xsd:documentation>
        </xsd:annotation>
      </xsd:enumeration>
      <xsd:e