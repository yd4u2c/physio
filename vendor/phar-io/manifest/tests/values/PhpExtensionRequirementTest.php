includes:
    - temp/ecs/config/clean-code.neon
    - temp/ecs/config/psr2-checkers.neon
    - temp/ecs/config/spaces.neon
    - temp/ecs/config/common.neon

checkers:
    PhpCsFixer\Fixer\Operator\ConcatSpaceFixer:
        spacing: one

parameters:
    exclude_checkers:
        # from temp/ecs/config/common.neon
        - PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer
        - PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer
        - PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer
        # from temp/ecs/config/spaces.neon
        - PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer

    skip:
        SlevomatCodingStandard\Sniffs\Classes\UnusedPrivateElementsSniff:
            # WIP code
            - src/DocBlock/StandardTagFactory