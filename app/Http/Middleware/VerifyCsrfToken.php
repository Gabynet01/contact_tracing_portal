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
     */
    protected $except = [
        //
        'loginApi',
        'deleteGlobalApi',
        'getAdminUsersDataApi',
        'getMobileAppUsersDataApi',
        'autoTracingUsersDataApi',
        'isolatedPersonsDataApi',
        'updateBookingInfoApi',
        'bookingListDataApi',
        'updateTestResultInfoApi',
        '/getSymptomsListDataApi',
        '/addSymptomApi',
        '/editSymptomApi',
        '/deleteSymptomApi',
        'addAdminUserApi',
        'editAdminUserApi',
        'deleteAdminUserApi',
        'addArticlesApi',
        'getArticlesDataApi',
        'addTestimonyApi'
        
    ];
}
