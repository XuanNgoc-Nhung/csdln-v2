<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */protected $except = [
         'build-excel',
        'submit-data-sso',
        'api-post-chinh-sua-template-bao-cao',
        'api-post-them-tieu-chi',
        'api-lay-danh-sach-tieu-chi',
        'api-post-chinh-sua-tieu-chi',
        'nhap-lieu-du-lieu-nam-hoc-cu',
        'upload-file-bieu-mau',
        'save_code_verifyer',
        'get_code_sso',
    ];
}
