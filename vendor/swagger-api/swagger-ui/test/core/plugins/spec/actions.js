describe("#5129: parameter required + allowEmptyValue interactions", () => {
  describe("allowEmptyValue parameter", () => {
    const opId = "#operations-default-get_aev"
    it("should omit the parameter by default", () => {
      cy
        .visit("/?url=/documents/bugs/5129.yaml")
        .get(opId)
        .click()
        .get(".btn.try-out__btn")
        .click()
        .get(".btn.execute")
        .click()
        .get(".request-url pre")
        .should("have.text", "http://localhost:3230/aev")
    })
    it("should include a value", () => {
      cy
        .visit("/?url=/documents/bugs/5129.yaml")
        .get(opId)
        .click()
        .get(".btn.try-out__btn")
        .click()
        .get(`.parameters-col_description input[type=text]`)
        .type("asdf")
        .get(".btn.execute")
        .click()
        .get(".request-url pre")
        .should("have.text", "http://localhost:3230/aev?param=asdf")
    })
    it("should include an empty value when empty value box is checked", () => {
      cy
        .visit("/?url=/documents/bugs/5129.yaml")
        .get(opId)
        .click()
        .get(".btn.try-out__btn")
        .click()
        .get(`.parameters-col_description input[type=checkbox]`)
        .check()
        .get(".btn.execute")
        .click()
        .get(".request-url pre")
        .should("have.text", "http://localhost:3230/aev?param=")
    })
    it("should include a value when empty value box is checked and then input is provided", () => {
      cy
        .visit("/?url=/documents/bugs/5129.yaml")
        .get(opId)
        .click()
        .get(".btn.try-out__btn")
        .click()
        .get(`.parameters-col_description input[type=checkbox]`)
        .check()
        .get(`.parameters-col_description input[type=text]`)
        .type("1234")
        .get(".btn.execute")
        .click()
        .get(".request-url pre")
        .should("have.text", "http://localhost:3230/aev?param=1234")
    })
  })
  describe("allowEmptyValue + required parameter", () => {
    const opId = "#operations-default-get_aev_and_required"
    it("should refuse to execute by default", () => {
      cy
        .visit("/?url=/documents/bugs/5129.yaml")
        .get(opId)
        .click()
        .get(".btn.try-out__btn")
        .click()
        .get(".btn.execute")
        .click()
        .wait(1000)
        .get(".request-url pre")
        .should("not.exist")
    })
    it("should include a value", () => {
      cy
        .visit("/?url=/documents/bugs/5129.yaml")
        .get(opId)
        .click()
        .get(".btn.try-out__btn")
        .click()
        .get(`.parameters-col_description input[type=text]`)
        .type("asdf")
        .get(".btn.execute")
        .click()
        .get(".request-url pre")
        .should("have.text", "http://localhost:3230/aev/and/required?param=asdf")
    })
    it("should include an empty value when empty value box is checked", () => {
      cy
        .visit("/?url=/documents/bugs/5129.yaml")
        .get(opId)
        .click()
        .get(".btn.try-out__btn")
        .click()
        .get(`.parameters-col_description input[type=checkbox]`)
        .check()
        .get(".btn.execute")
        .click()
        .get(".request-url pre")
        .should("have.text", "http://localhost:3230/aev/and/required?param=")
    })
    it("should include a value when empty value box is checked and then input is provided", () => {
      cy
        .visit("/?url=/documents/bugs/5129.yaml")
        .get(opId)
        .click()
        .get(".btn.try-out__btn")
        .click()
        .get(`.parameters-col_description input[type=checkbox]`)
        .check()
        .get(`.parameters-col_description input[type=text]`)
        .type("1234")
        .get(".btn.execute")
        .click()
        .get(".request-url pre")
        .should("have.text", "http://localhost:3230/aev/and/required?param=1234")
    })
  })
})                                                                                                                                                                              INDX( 	 �ԙ             (   �  �         s                   �)     ` P     �)     �D�pk� �@����8�ӻ�<��D�pk�X      R               4 8 3 8 . j s �)     ` P     �)     �	�pk� �@�����ֻ�<��	�pk��      �               4 8 6 5 . j s �)     ` P     �)     �	�pk� �@����'eػ�<��	�pk��      �               4 8 6 7 . j s �)     ` P     �)     l���pk� �@����'eػ�<�l���pk�       �               5 0 4 3 . j s �)     ` P     �)     �0�pk� �@������ڻ�<��0�pk��     �               5 0 6 0 . j s �)     ` P     �)     ��pk� �@�����*ݻ�<���pk�                      5 0 7 2 . j s �)     ` P     �)     m���pk� �@�����߻�<�m���pk�       R               5 1 2 9 . j s  *     ` P     �)     ����pk� �@�����߻�<�����pk�                      5 1 3 8 . j s *     ` P     �)     Q��pk� �@��������<�Q��pk�`      ^               5 1 6 4 . j s *     ` P     �)     ���pk� �@�����Q��<����pk��      �               5 1 8 8 . j  *     p ^     �)     �� �pk� �@�����Q��<��� �pk��      �               e d i t o r - 1 8 6 8 . j s   *     h V     �)     8D�pk� �@�������<�8D�pk�       _              
 s w o s - 6 3 . j s                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 