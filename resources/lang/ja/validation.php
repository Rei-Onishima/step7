<?php

return [

    'accepted' => ' :attribute が未承認です。',
    'active_url' => ' :attribute は有効なURLではありません。',
    'after' => ' :attribute には :date より後の日付を指定してください。',
    'after_or_equal' => ' :attribute には :date 以降の日付を指定してください。',
    'alpha' => ' :attribute には英字のみ使用できます。',
    'alpha_dash' => ' :attribute には英字、数字、ハイフン、アンダースコアのみ使用できます。',
    'alpha_num' => ' :attribute には英字と数字のみ使用できます。',
    'array' => ' :attribute には配列を指定してください。',
    'before' => ' :attribute には :date より前の日付を指定してください。',
    'before_or_equal' => ' :attribute には :date 以前の日付を指定してください。',
    'between' => [
        'numeric' => ' :attribute には :min から :max までの数字を指定してください。',
        'file' => ' :attribute には :min KBから :max KBまでのサイズのファイルを指定してください。',
        'string' => ' :attribute には :min 文字から :max 文字までの文字列を指定してください。',
        'array' => ' :attribute の項目は :min 個から :max 個にしてください。',
    ],
    'boolean' => ' :attribute には真偽値を指定してください。',
    'confirmed' => ' :attribute と確認フィールドとが一致していません。',
    'date' => ' :attribute は有効な日付ではありません。',
    'date_equals' => ' :attribute には :date と同じ日付を指定してください。',
    'date_format' => ' :attribute の形式は :format と一致していません。',
    'different' => ' :attribute と :other には異なる内容を指定してください。',
    'digits' => ' :attribute は :digits 桁でなければなりません。',
    'digits_between' => ' :attribute は :min 桁から :max 桁の間でなければなりません。',
    'dimensions' => ' :attribute の画像サイズが無効です。',
    'distinct' => ' :attribute には異なる値を指定してください。',
    'email' => ' :attribute には有効なメールアドレスを指定してください。',
    'ends_with' => ' :attribute には :values のいずれかで終わる値を指定してください。',
    'exists' => ' 選択された :attribute は存在しません。',
    'file' => ' :attribute にはファイルを指定してください。',
    'filled' => ' :attribute には値を指定してください。',
    'gt' => [
        'numeric' => ' :attribute には :value より大きな値を指定してください。',
        'file' => ' :attribute には :value KBより大きなファイルを指定してください。',
        'string' => ' :attribute には :value 文字より長い文字列を指定してください。',
        'array' => ' :attribute の項目は :value 個より多くしてください。',
    ],
    'gte' => [
        'numeric' => ' :attribute には :value 以上の値を指定してください。',
        'file' => ' :attribute には :value KB以上のファイルを指定してください。',
        'string' => ' :attribute には :value 文字以上の文字列を指定してください。',
        'array' => ' :attribute の項目は :value 個以上にしてください。',
    ],
    'image' => ' :attribute には画像ファイルを指定してください。',
    'in' => ' 選択された :attribute は無効です。',
    'in_array' => ' :attribute は :other に存在しません。',
    'integer' => ' :attribute には整数を指定してください。',
    'ip' => ' :attribute には有効なIPアドレスを指定してください。',
    'ipv4' => ' :attribute には有効なIPv4アドレスを指定してください。',
    'ipv6' => ' :attribute には有効なIPv6アドレスを指定してください。',
    'json' => ' :attribute には有効なJSON文字列を指定してください。',
    'lt' => [
        'numeric' => ' :attribute には :value より小さな値を指定してください。',
        'file' => ' :attribute には :value KBより小さなファイルを指定してください。',
        'string' => ' :attribute には :value 文字より短い文字列を指定してください。',
        'array' => ' :attribute の項目は :value 個より少なくしてください。',
    ],
    'lte' => [
        'numeric' => ' :attribute には :value 以下の値を指定してください。',
        'file' => ' :attribute には :value KB以下のファイルを指定してください。',
        'string' => ' :attribute には :value 文字以下の文字列を指定してください。',
        'array' => ' :attribute の項目は :value 個以下にしてください。',
    ],
    'max' => [
        'numeric' => ' :attribute には :max 以下の数字を指定してください。',
        'file' => ' :attribute には :max KB以下のファイルを指定してください。',
        'string' => ' :attribute には :max 文字以下の文字列を指定してください。',
        'array' => ' :attribute の項目は :max 個以下にしてください。',
    ],
    'mimes' => ' :attribute には :values のいずれかの形式のファイルを指定してください。',
    'mimetypes' => ' :attribute には :values のいずれかの形式のファイルを指定してください。',
    'min' => [
        'numeric' => ' :attribute には :min 以上の数字を指定してください。',
        'file' => ' :attribute には :min KB以上のファイルを指定してください。',
        'string' => ' :attribute には :min 文字以上の文字列を指定してください。',
        'array' => ' :attribute の項目は :min 個以上にしてください。',
    ],
    'not_in' => ' 選択された :attribute は無効です。',
    'not_regex' => ' :attribute の形式が無効です。',
    'numeric' => ' :attribute には数字を指定してください。',
    'password' => ' パスワードが正しくありません。',
    'present' => ' :attribute が存在していなければなりません。',
    'regex' => ' :attribute の形式が無効です。',
    'required' => ' :attribute は必須です。',
    'required_if' => ' :attribute は :other が :value の場合に必須です。',
    'required_unless' => ' :attribute は :other が :values でない限り必須です。',
    'required_with' => ' :attribute は :values が存在する場合に必須です。',
    'required_with_all' => ' :attribute は :values が全て存在する場合に必須です。',
    'required_without' => ' :attribute は :values が存在しない場合に必須です。',
    'required_without_all' => ' :attribute は :values が全て存在しない場合に必須です。',
    'same' => ' :attribute と :other には同じ値を指定してください。',
    'size' => [
        'numeric' => ' :attribute には :size を指定してください。',
        'file' => ' :attribute には :size KBのファイルを指定してください。',
        'string' => ' :attribute には :size 文字の文字列を指定してください。',
        'array' => ' :attribute の項目は :size 個にしてください。',
    ],
    'starts_with' => ' :attribute には :values のいずれかで始まる値を指定してください。',
    'string' => ' :attribute には文字を指定してください。',
    'timezone' => ' :attribute には有効なタイムゾーンを指定してください。',
    'unique' => ' :attribute の値は既に存在しています。',
    'uploaded' => ' :attribute のアップロードに失敗しました。',
    'url' => ' :attribute は無効なURLです。',
    'uuid' => ' :attribute には有効なUUIDを指定してください。',

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション属性名
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は "属性名.ルール" の規約で記述され、指定された
    | カスタムバリデーション属性名を使用するために使用します。
    | この規約を使用することで、属性の特定のルールにカスタム
    | 言語行を指定できます。
    |
    */

    'custom' => [
        'user_name' => [
            'required' => 'ユーザー名は必須です。',
            'unique' => 'ユーザー名は既に使用されています。',
        ],
        'email' => [
            'required' => 'メールアドレスは必須です。',
            'email' => '有効なメールアドレスを指定してください。',
        ],
        'password' => [
            'required' => 'パスワードは必須です。',
            'confirmed' => 'パスワードと確認用パスワードが一致しません。',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション属性名
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は例として、例えば「email」属性を
    | より読みやすくするために "E-Mail Address" のように置き換えます。
    | これはメッセージの表現をよりクリーンに保つためです。
    |
    */

    'attributes' => [
        'user_name' => 'ユーザー名',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード(確認用)',
    ],

];
