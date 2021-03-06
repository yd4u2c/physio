onal"/>
      <xsd:attributeGroup ref="xlf:AttrGroup_TextContent"/>
    </xsd:complexType>
  </xsd:element>
  <xsd:element name="sub">
    <xsd:complexType mixed="true">
      <xsd:group maxOccurs="unbounded" minOccurs="0" ref="xlf:ElemGroup_TextContent"/>
      <xsd:attribute name="datatype" type="xlf:AttrType_datatype" use="optional"/>
      <xsd:attribute name="ctype" type="xlf:AttrType_InlineDelimiters" use="optional"/>
      <xsd:attribute name="xid" type="xsd:string" use="optional"/>
    </xsd:complexType>
  </xsd:element>
  <xsd:element name="mrk">
    <xsd:complexType mixed="true">
      <xsd:group maxOccurs="unbounded" minOccurs="0" ref="xlf:ElemGroup_TextContent"/>
      <xsd:attribute name="mtype" type="xlf:AttrType_mtype" use="required"/>
      <xsd:attribute name="mid" type="xsd:NMTOKEN" use="optional"/>
      <xsd:attribute name="comment" type="xsd:string" use="optional"/>
      <xsd:anyAttribute namespace="##other" processContents="strict"/>
    </xsd:complexType>
  </xsd:element>
</xsd:schema>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              