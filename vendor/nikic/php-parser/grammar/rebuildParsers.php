            'Stmt_ClassMethod->returnType' => [')', false, ' : ', null],
            'Stmt_Class->extends' => [null, false, ' extends ', null],
            'Expr_PrintableNewAnonClass->extends' => [null, ' extends ', null],
            'Stmt_Continue->num' => [\T_CONTINUE, false, ' ', null],
            'Stmt_Foreach->keyVar' => [\T_AS, false, null, ' => '],
            'Stmt_Function->returnType' => [')', false, ' : ', null],
            'Stmt_If->else' => [null, false, ' ', null],
            'Stmt_Namespace->name' => [\T_NAMESPACE, false, ' ', null],
            'Stmt_Property->type' => [\T_VARIABLE, true, null, ' '],
            'Stmt_PropertyProperty->default' => [null, false, ' = ', null],
            'Stmt_Return->expr' => [\T_RETURN, false, ' ', null],
            'Stmt_StaticVar->default' => [null, false, ' = ', null],
            //'Stmt_TraitUseAdaptation_Alias->newName' => [T_AS, false, ' ', null], // TODO
            'Stmt_TryCatch->finally' => [null, false, ' ', null],

            // 'Expr_Exit->expr': Complicated due to optional ()
            // 'Stmt_Case->cond': Conversion from default to case
            // 'Stmt_Class->name': Unclear
            // 'Stmt_Declare->stmts': Not a proper node
            // 'Stmt_TraitUseAdaptation_Alias->newModifier': Not a proper node
        ];
    }

    protected function initializeListInsertionMap() {
        if ($this->listInsertionMap) return;

        $this->listInsertionMap = [
            // special
            //'Expr_ShellExec->parts' => '', // TODO These need to be treated more carefully
            //'Scalar_Encapsed->parts' => '',
            'Stmt_Catch->types' => '|',
            'Stmt_If->elseifs' => ' ',
            'Stmt_TryCatch->catches' => ' ',

            // comma-separated lists
            'Expr_Array->items' => ', ',
            'Expr_Closure->params' => ', ',
            'Expr_Closure->uses' => ', ',
            'Expr_FuncCall->args' => ', ',
            'Expr_Isset->vars' => ', ',
            'Expr_List->items' => ', ',
            'Expr_MethodCall->args' => ', ',
            'Expr_New->args' => ', ',
            'Expr_PrintableNewAnonClass->args' => ', ',
            'Expr_StaticCall->args' => ', ',
            'Stmt_ClassConst->consts' => ', ',
            'Stmt_ClassMethod->params' => ', ',
            'Stmt_Class->implements' => ', ',
            'Expr_PrintableNewAnonClass->implements' => ', ',
            'Stmt_Const->consts' => ', ',
            'Stmt_Declare->declares' => ', ',
            'Stmt_Echo->exprs' => ', ',
            'Stmt_For->init' => ', ',
            'Stmt_For->cond' => ', ',
            'Stmt_For->loop' => ', ',
            'Stmt_Function->params' => ', ',
            'Stmt_Global->vars' => ', ',
            'Stmt_GroupUse->uses' => ', ',
            'Stmt_Interface->extends' => ', ',
            'Stmt_Property->props' => ', ',
            'Stmt_StaticVar->vars' => ', ',
            'Stmt_TraitUse->traits' => ', ',
            'Stmt_TraitUseAdaptation_Precedence->insteadof' => ', ',
            'Stmt_Unset->vars' => ', ',
            'Stmt_Use->uses' => ', ',

            // statement lists
            'Expr_Closure->stmts' => "\n",
            'Stmt_Case->stmts' => "\n",
            'Stmt_Catch->stmts' => "\n",
            'Stmt_Class->stmts' => "\n",
            'Expr_PrintableNewAnonClass->stmts' => "\n",
            'Stmt_Interface->stmts' => "\n",
            'Stmt_Trait->stmts' => "\n",
            'Stmt_ClassMethod->stmts' => "\n",
            'Stmt_Declare->stmts' => "\n",
            'Stmt_Do->stmts' => "\n",
            'Stmt_ElseIf->stmts' => "\n",
            'Stmt_Else->stmts' => "\n",
            'Stmt_Finally->stmts' => "\n",
            'Stmt_Foreach->stmts' => "\n",
            'Stmt_For->stmts' => "\n",
            'Stmt_Function->stmts' => "\n",
            'Stmt_If->stmts' => "\n",
            'Stmt_Namespace->stmts' => "\n",
            'Stmt_Switch->cases' => "\n",
            'Stmt_TraitUse->adaptations' => "\n",
            'Stmt_TryCatch->stmts' => "\n",
            'Stmt_While->stmts' => "\n",
        ];
    }

    protected function initializeModifierChangeMap() {
        if ($this->modifierChangeMap) return;

        $this->modifierChangeMap = [
            'Stmt_ClassConst->flags' => \T_CONST,
            'Stmt_ClassMethod->flags' => \T_FUNCTION,
            'Stmt_Class->flags' => \T_CLASS,
            'Stmt_Property->flags' => \T_VARIABLE,
            //'Stmt_TraitUseAdaptation_Alias->newModifier' => 0, // TODO
        ];

        // List of integer subnodes that are not modifiers:
        // Expr_Include->type
        // Stmt_GroupUse->type
        // Stmt_Use->type
        // Stmt_UseUse->type
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    