/
    private function assertValidId($id)
    {
        if (!$this->emailValidator->isValid($id, new RFCValidation())) {
            throw new Swift_RfcComplianceException('Invalid ID given <'.$id.'>');
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       