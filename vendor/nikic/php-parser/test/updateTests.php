Shell execution
-----
<?php
``;
`test`;
`test $A`;
`test \``;
`test \"`;
-----
array(
    0: Stmt_Expression(
        expr: Expr_ShellExec(
            parts: array(
            )
        )
    )
    1: Stmt_Expression(
        expr: Expr_ShellExec(
            parts: array(
                0: Scalar_EncapsedStringPart(
                    value: test
                )
            )
        )
    )
    2: Stmt_Expression(
        expr: Expr_ShellExec(
            parts: array(
                0: Scalar_EncapsedStringPart(
                    value: test
                )
                1: Expr_Variable(
                    name: A
                )
            )
        )
    )
    3: Stmt_Expression(
        expr: Expr_ShellExec(
            parts: array(
                0: Scalar_EncapsedStringPart(
                    value: test `
                )
            )
        )
    )
    4: Stmt_Expression(
        expr: Expr_ShellExec(
            parts: array(
                0: Scalar_EncapsedStringPart(
                    value: test \"
                )
            )
        )
    )
)                     