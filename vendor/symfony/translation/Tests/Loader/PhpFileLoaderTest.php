) {
                $a['error'][$k] = pg_result_error_field($result, $v);
            }
        }

        $a['affected rows'] = pg_affected_rows($result);
        $a['last OID'] = pg_last_oid($result);

        $fields = pg_num_fields($result);

        for ($i = 0; $i < $fields; ++$i) {
            $field = [
                'name' => pg_field_name($result, $i),
                'table' => sprintf('%s (OID: %s)', pg_field_table($result, $i), pg_field_table($result, $i, true)),
                'type' => sprintf('%s (OID: %s)', pg_field_type($result, $i), pg_field_type_oid($result, $i)),
                'nullable' => (bool) pg_field_is_null($result, $i),
                'storage' => pg_field_size($result, $i).' bytes',
                'display' => pg_field_prtlen($result, $i).' chars',
            ];
            if (' (OID: )' === $field['table']) {
                $field['table'] = null;
            }
            if ('-1 bytes' === $field['storage']) {
                $field['storage'] = 'variable size';
            } elseif ('1 bytes' === $field['storage']) {
                $field['storage'] = '1 byte';
            }
            if ('1 chars' === $field['display']) {
                $field['display'] = '1 char';
            }
            $a['fields'][] = new EnumStub($field);
        }

        return $a;
    }
}
                                                                                                                                                                                                                              