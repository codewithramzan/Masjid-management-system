<?php

function addLog(
    $conn,
    $user_id,
    $action,
    $module,
    $description = ''
)
{
    $ip_address =
    $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

    $action =
    mysqli_real_escape_string(
        $conn,
        $action
    );

    $module =
    mysqli_real_escape_string(
        $conn,
        $module
    );

    $description =
    mysqli_real_escape_string(
        $conn,
        $description
    );

    mysqli_query(

        $conn,

        "

        INSERT INTO activity_logs
        (
            user_id,
            action,
            module,
            description,
            ip_address
        )

        VALUES
        (
            '$user_id',
            '$action',
            '$module',
            '$description',
            '$ip_address'
        )

        "

    );
}