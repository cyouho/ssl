<?php
return [
    'error_message' => [
        'api' => [
            404 => 'Not found',
            40401 => 'User id not found',
            40402 => 'User password incorrect',
            40403 => 'User session delete failed',
            40404 => 'Server sign in failed, already sign in',
            40405 => 'Update user server status failed',
        ],
    ],
    'success_message' => [
        'api' => [
            201 => 'Create new user account successfully',
            20001 => 'Create new user seesion successfully',
            20002 => 'Delete user session successfully',
            20003 => 'Insert user server successfully',
            20004 => 'Update user server status successfully',
        ],
    ],
];
