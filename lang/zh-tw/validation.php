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

    'between' => [
        'string' => ':attribute必須介於:min~:max個字',
    ],
    'confirmed' => '確認:attribute與:attribute不符',
    'digits_between' => ':attribute必須是介於:min~:max個字的數字',
    'email' => ':attribute必須符合電子信箱格式',
    'exists' => '此:attribute不存在',
    'min' => [
        'string' => ':attribute不能少於:min個字',
    ],
    'max' => [
        'string' => ':attribute不能超過:max個字',
    ],
    'numeric' => ':attribute只能有數字',
    'required' => ':attribute不能為空',
    'unique' => '此:attribute已被使用',
    'regex' => ':attribute只能有數字格式錯誤',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'lockerNo' => '置物櫃編號',
        'description' => '開鎖原因',
        'cardId' => '卡號',
        'mail' => '電子信箱',
        'name' => '姓名',
        'password' => '密碼',
        'confirm' => '確認密碼',
        'phone' => '電話號碼',
    ],
];
