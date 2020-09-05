<?php

declare(strict_types = 1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()->in(__DIR__);

return Config::create()
    ->setUsingCache(false)
    ->setFinder($finder)
    ->setRules([
        "@PSR2" => true,
        "align_multiline_comment" => [
            "comment_type" => "phpdocs_like",
        ],
        "array_indentation" => true,
        "array_syntax" => [
            "syntax" => "short",
        ],
        "blank_line_after_opening_tag" => true,
        "blank_line_before_statement" => true,
        "cast_spaces" => [
            "space" => "single",
        ],
        "class_attributes_separation" => [
            "elements" => ["const", "method", "property"],
        ],
        "combine_consecutive_issets" => true,
        "combine_consecutive_unsets" => true,
        "compact_nullable_typehint" => true,
        "concat_space" => [
            "spacing" => "one",
        ],
        "declare_equal_normalize" => [
            "space" => "single",
        ],
        "declare_strict_types" => true,
        "dir_constant" => true,
        "ereg_to_preg" => true,
        "explicit_indirect_variable" => true,
        "fopen_flag_order" => true,
        "function_to_constant" => [
            "functions" => ["get_class", "php_sapi_name", "phpversion", "pi"],
        ],
        "function_typehint_space" => true,
        "global_namespace_import" => [
            "import_classes" => true,
            "import_constants" => true,
            "import_functions" => true,
        ],
        "implode_call" => true,
        "include" => true,
        "increment_style" => [
            "style" => "post",
        ],
        "is_null" => [
            "use_yoda_style" => false,
        ],
        "linebreak_after_opening_tag" => true,
        "list_syntax" => [
            "syntax" => "short",
        ],
        "logical_operators" => true,
        "lowercase_cast" => true,
        "lowercase_static_reference" => true,
        "magic_constant_casing" => true,
        "magic_method_casing" => true,
        "mb_str_functions" => true,
        "method_chaining_indentation" => true,
        "modernize_types_casting" => true,
        "modernize_types_casting" => true,
        "multiline_whitespace_before_semicolons" => [
            "strategy" => "no_multi_line",
        ],
        "native_function_casing" => true,
        "native_function_type_declaration_casing" => true,
        "new_with_braces" => true,
        "no_alternative_syntax" => true,
        "no_binary_string" => true,
        "no_blank_lines_after_class_opening" => true,
        "no_blank_lines_after_phpdoc" => true,
        "no_empty_comment" => true,
        "no_empty_phpdoc" => true,
        "no_empty_statement" => true,
        "no_extra_blank_lines" => [
            "tokens" => ["break", "case", "continue", "curly_brace_block", "default", "extra", "parenthesis_brace_block", "return", "square_brace_block", "switch", "throw", "use", "useTrait", "use_trait"],
        ],
        "no_homoglyph_names" => true,
        "no_leading_import_slash" => true,
        "no_leading_namespace_whitespace" => true,
        "no_mixed_echo_print" => [
            "use" => "echo",
        ],
        "no_multiline_whitespace_around_double_arrow" => true,
        "no_null_property_initialization" => true,
        "no_php4_constructor" => true,
        "no_short_bool_cast" => true,
        "no_short_echo_tag" => true,
        "no_singleline_whitespace_before_semicolons" => true,
        "no_spaces_around_offset" => true,
        "no_superfluous_elseif" => true,
        "no_superfluous_phpdoc_tags" => [
            "allow_mixed" => false,
            "allow_unused_params" => false,
            "remove_inheritdoc" => false,
        ],
        "no_trailing_comma_in_list_call" => true,
        "no_trailing_comma_in_singleline_array" => true,
        "no_unneeded_control_parentheses" => [
            "statements" => ['break', 'clone', 'continue', 'echo_print', 'return', 'switch_case', 'yield'],
        ],
        "no_unneeded_curly_braces" => [
            "namespaces" => true,
        ],
        "no_unneeded_final_method" => true,
        "no_unreachable_default_argument_value" => true,
        "no_unset_cast" => true,
        "no_unset_on_property" => true,
        "no_unused_imports" => true,
        "no_useless_else" => true,
        "no_useless_return" => true,
        "no_whitespace_before_comma_in_array" => [
            "after_heredoc" => false,
        ],
        "no_whitespace_in_blank_line" => true,
        "non_printable_character" => [
            "use_escape_sequences_in_strings" => false,
        ],
        "normalize_index_brace" => true,
        "object_operator_without_whitespace" => true,
        "ordered_class_elements" => [
            "order" => ['use_trait', 'constant_public', 'constant_protected', 'constant_private', 'property_public', 'property_protected', 'property_private', 'construct', 'destruct', 'magic', 'phpunit', 'method_public', 'method_protected', 'method_private'],
            "sortAlgorithm" => "alpha",
        ],
        "ordered_interfaces" => [
            "direction" => "ascend",
            "order" => "alpha",
        ],
        "phpdoc_add_missing_param_annotation" => [
            "only_untyped" => true,
        ],
        "phpdoc_align" => [
            "align" => "vertical",
            "tags" => ['param', 'return', 'throws', 'type', 'var'],
        ],
        "phpdoc_indent" => true,
        "phpdoc_no_empty_return" => true,
        "phpdoc_order" => true,
        "phpdoc_scalar" => [
            "types" => ['boolean', 'double', 'integer', 'real', 'str'],
        ],
        "phpdoc_separation" => true,
        "phpdoc_single_line_var_spacing" => true,
        "phpdoc_to_comment" => true,
        "phpdoc_trim" => true,
        "phpdoc_trim_consecutive_blank_line_separation" => true,
        "phpdoc_types" => [
            "groups" => ['simple', 'alias', 'meta'],
        ],
        "phpdoc_types_order" => [
            "null_adjustment" => "always_first",
            "sort_algorithm" => "alpha",
        ],
        "phpdoc_var_annotation_correct_order" => true,
        "phpdoc_var_without_name" => true,
        "pow_to_exponentiation" => true,
        "protected_to_private" => true,
        "psr4" => true,
        "random_api_migration" => [
            "replacements" => ['getrandmax' => 'mt_getrandmax', 'rand' => 'mt_rand', 'srand' => 'mt_srand'],
        ],
        "return_assignment" => true,
        "return_type_declaration" => [
            "space_before" => "none",
        ],
        "self_accessor" => true,
        "self_static_accessor" => true,
        "semicolon_after_instruction" => true,
        "set_type_to_cast" => true,
        "short_scalar_cast" => true,
        "simple_to_complex_string_variable" => true,
        "simplified_null_return" => true,
        "single_blank_line_before_namespace" => true,
        "single_class_element_per_statement" => [
            "elements" => ['const', 'property'],
        ],
        "single_line_comment_style" => [
            "comment_types" => ['asterisk', 'hash'],
        ],
        "single_line_throw" => true,
        "single_trait_insert_per_statement" => true,
        "space_after_semicolon" => [
            "remove_in_empty_for_expressions" => false,
        ],
        "standardize_increment" => true,
        "standardize_not_equals" => true,
        "strict_param" => true,
        "switch_case_semicolon_to_colon" => true,
        "switch_case_space" => true,
        "ternary_operator_spaces" => true,
        "ternary_to_null_coalescing" => true,
        "trailing_comma_in_multiline_array" => [
            "after_heredoc" => false,
        ],
        "trim_array_spaces" => true,
        "unary_operator_spaces" => true,
        "visibility_required" => [
            "elements" => ['property', 'method'],
        ],
        "void_return" => true,
        "whitespace_after_comma_in_array" => true,
    ]);
