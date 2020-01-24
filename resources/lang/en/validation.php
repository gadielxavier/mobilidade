<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'O :attribute deve ser aceito.',
    'active_url'           => 'O :attribute não é uma URL válida.',
    'after'                => 'O :attribute deve ser uma data após :date.',
    'after_or_equal'       => 'O :attribute deve ser uma data após ou igual :date.',
    'alpha'                => 'O :attribute deve conter somente letras.',
    'alpha_dash'           => 'O :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'O :attribute deve conter somente letras e números.',
    'array'                => 'O :attribute deve ser um array.',
    'before'               => 'O :attribute deve ser uma data antes de :date.',
    'before_or_equal'      => 'O :attributeeve ser uma data antes ou igual a :date.',
    'between'              => [
        'numeric' => 'O :attribute deve ser entre :min e :max.',
        'file'    => 'O :attribute deve ser entre :min e :max kilobytes.',
        'string'  => 'O :attribute deve ser entre :min e :max characters.',
        'array'   => 'O :attribute deve ser entre :min e :max itens.',
    ],
    'boolean'              => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed'            => 'O :attribute de confirmação não são iguais.',
    'date'                 => 'O :attribute não é uma data válida.',
    'date_format'          => 'O :attribute não corresponde ao :format.',
    'different'            => 'O :attribute e :oOr devem ser diferentes.',
    'digits'               => 'O :attribute dever ter :digits dígitos.',
    'digits_between'       => 'O :attribute dever ser entre :min e :max dígitos.',
    'dimensions'           => 'O :attribute tem uma dimensão de imagem diferente.',
    'distinct'             => 'O campo :attribute tem um valor duplicado.',
    'email'                => 'O :attribute dever ser um email válido.',
    'exists'               => 'O :attribute selecionado é inválido.',
    'file'                 => 'O :attribute dever ser um arquivo.',
    'filled'               => 'O campo :attribute deve ter um valor.',
    'image'                => 'O :attribute dever ser uma imagem.',
    'in'                   => 'O :attribute selecionado é inválido.',
    'in_array'             => 'O campo :attribute não existe em :oOr.',
    'integer'              => 'O :attribute dever ser um inteiror.',
    'ip'                   => 'O :attribute dever ser um endereço de ip válido.',
    'ipv4'                 => 'O :attribute dever ser a valid IPv4 address.',
    'ipv6'                 => 'O :attribute dever ser a valid IPv6 address.',
    'json'                 => 'O :attribute dever ser a valid JSON string.',
    'max'                  => [
        'numeric' => 'O :attribute não pode ser maior do que :max.',
        'file'    => 'O :attribute não pode ser maior do que :max kilobytes.',
        'string'  => 'O :attribute não pode ser maior do que :max characters.',
        'array'   => 'O :attribute não pode ter mais do que :max items.',
    ],
    'mimes'                => 'O :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes'            => 'O :attribute deve ser um arquivo do tipo: :values.',
    'min'                  => [
        'numeric' => 'O :attribute deve ter pelo menos :min.',
        'file'    => 'O :attribute deve ter pelo menos :min kilobytes.',
        'string'  => 'O :attribute deve ter pelo menos :min characteres.',
        'array'   => 'O :attribute deve ter pelo menos :min itens.',
    ],
    'not_in'               => 'O selected :attribute is invalid.',
    'numeric'              => 'O :attribute must be a number.',
    'present'              => 'O :attribute field must be present.',
    'regex'                => 'O :attribute format is invalid.',
    'required'             => 'O :attribute field is required.',
    'required_if'          => 'O :attribute field is required when :oOr is :value.',
    'required_unless'      => 'O :attribute field is required unless :oOr is in :values.',
    'required_with'        => 'O :attribute field is required when :values is present.',
    'required_with_all'    => 'O :attribute field is required when :values is present.',
    'required_without'     => 'O :attribute field is required when :values is not present.',
    'required_without_all' => 'O :attribute field is required when none of :values are present.',
    'same'                 => 'O :attribute and :oOr must match.',
    'size'                 => [
        'numeric' => 'O :attribute dever ser :size.',
        'file'    => 'O :attribute dever ser :size kilobytes.',
        'string'  => 'O :attribute dever ser :size characters.',
        'array'   => 'O :attribute deve conter :size items.',
    ],
    'string'               => 'O :attribute deve ser uma string.',
    'timezone'             => 'O :attribute deve ser uma zona  válida.',
    'unique'               => 'O :attribute já foi usado.',
    'uploaded'             => 'O :attribute falhou no envio.',
    'url'                  => 'O formato do :attribute é inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
