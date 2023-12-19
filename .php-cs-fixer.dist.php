<?php

$finder = (new PhpCsFixer\Finder())
    ->in([__DIR__ . '/src', __DIR__ . '/tests', __DIR__ . '/public']);

/**
 * Here we're defining our own ruleset for code standard.
 */

return (new PhpCsFixer\Config())
    ->registerCustomFixers(new PhpCsFixerCustomFixers\Fixers())
    ->setRules([
        # Alias for the latest revision of PER-CS rules.
        '@PER-CS' => true,
        # Rules to improve code for PHP 8.3 compatibility.
        '@PHP83Migration' => true,
        # Unused use statements must be removed.
        'no_unused_imports' => true,
        # Each element of an array must be indented exactly once.
        'array_indentation' => true,
        # There should not be useless else cases.
        'no_useless_else' => true,
        # There should not be an empty return statement at the end of a function.
        'no_useless_return' => true,
        # Removes @param, @return and @var tags that don’t provide any useful information.
        'no_superfluous_phpdoc_tags' => true,
        # Comparisons should be strict.
        'strict_comparison' => true,
        # Replace strpos() calls with str_starts_with() or str_contains() if possible.
        'modernize_strpos' => true,
        # Converts simple usages of array_push($x, $y); to $x[] = $y;.
        'array_push' => true,
        # Shorthand notation for operators should be used if possible.
        'long_to_shorthand_operator' => true,
        # Replaces intval, floatval, doubleval, strval and boolval function calls with according type casting operator.
        'modernize_types_casting' => true,
        # There must be no sprintf calls with only the first argument.
        'no_useless_sprintf' => true,
        # Functions should be used with $strict param set to true.
        'strict_param' => true,
        # Multi-line arrays, arguments list, parameters list and match expressions must have a trailing comma.
        'trailing_comma_in_multiline' => ['elements' => ['arguments', 'arrays', 'match', 'parameters']],
        # Removes unneeded braces that are superfluous and aren't part of a control structure's body.
        'no_unneeded_braces' => ['namespaces' => true],
        # Force strict types declaration in all files.
        'declare_strict_types' => true,
        # Class DateTimeImmutable should be used instead of DateTime.
        'date_time_immutable' => true,
        # Method chaining MUST be properly indented.
        'method_chaining_indentation' => true,
        # Ensure single space between a variable and its type declaration in function arguments and properties.
        'type_declaration_spaces' => ['elements' => ['function', 'property']],
        # A single space should be around union type and intersection type operators.
        'types_spaces' => ['space' => 'single'],
        # Convert double quotes to single quotes for simple strings.
        'single_quote' => true,
        # There should not be any empty comments.
        'no_empty_comment' => true,
        # Single-line comments and multi-line comments with only one line of actual content should use the // syntax.
        'single_line_comment_style' => true,
        # There MUST be one blank line after the namespace declaration.
        'blank_line_after_namespace' => true,
        # Controls blank lines before a namespace declaration.
        'blank_lines_before_namespace' => true,
        # Either language construct print or echo should be used.
        'no_mixed_echo_print' => ['use' => 'print'],
        # Remove extra spaces in a nullable typehint.
        'compact_nullable_type_declaration' => true,
        # Class, trait and interface elements must be separated with one or none blank line.
        'class_attributes_separation' => true,
        # An empty line feed must precede any configured statement.
        'blank_line_before_statement' => ['statements' => ['break', 'case', 'continue', 'declare', 'default', 'exit', 'goto', 'include', 'include_once', 'phpdoc', 'require', 'require_once', 'return', 'switch', 'throw', 'try', 'yield', 'yield_from']],
        # Constructor's empty braces must be on a single line.
        PhpCsFixerCustomFixers\Fixer\ConstructorEmptyBracesFixer::name() => true,
        # Function array_key_exists must be used instead of isset when possible.
        PhpCsFixerCustomFixers\Fixer\IssetToArrayKeyExistsFixer::name() => true,
        # Promoted properties must be on separate lines.
        PhpCsFixerCustomFixers\Fixer\MultilinePromotedPropertiesFixer::name() => true,
        # There must be no duplicate array keys.
        PhpCsFixerCustomFixers\Fixer\NoDuplicatedArrayKeyFixer::name() => true,
        # There must be no useless comments.
        PhpCsFixerCustomFixers\Fixer\NoUselessCommentFixer::name() => true,
        # Converts @var annotations to assert calls when used in assignments.
        PhpCsFixerCustomFixers\Fixer\PhpdocVarAnnotationToAssertFixer::name() => true,
        # Constructor properties must be promoted if possible.
        PhpCsFixerCustomFixers\Fixer\PromotedConstructorPropertyFixer::name() => true,
    ])
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
    ->setFinder($finder);