                  ];
                }

                $sql  = 'UPDATE ' . $this->generatorTableName . ' ' .
                       'SET sequence_value = sequence_value + sequence_increment_by ' .
                       'WHERE sequence_name = ? AND sequence_value = ?';
                $rows = $this->conn->executeUpdate($sql, [$sequenceName, $row['sequence_value']]);

                if ($rows !== 1) {
                    throw new DBALException('Race-condition detected while updating sequence. Aborting generation');
                }
            } else {
                $this->conn->insert(
                    $this->generatorTableName,
                    ['sequence_name' => $sequenceName, 'sequence_value' => 1, 'sequence_increment_by' => 1]
                );
                $value = 1;
            }

            $this->conn->commit();
        } catch (Throwable $e) {
            $this->conn->rollBack();
            throw new DBALException('Error occurred while generating ID with TableGenerator, aborted generation: ' . $e->getMessage(), 0, $e);
        }

        return $value;
    }
}
                                    