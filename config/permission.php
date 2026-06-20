<?php

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

function allowRoles($roles)
{
    if(!isset($_SESSION['role']))
    {
        die("Role Session Missing");
    }

    $currentRole = trim($_SESSION['role']);

    if(!in_array($currentRole, $roles))
    {
        die("Access Denied");
    }
}

function superAdminOnly()
{
    allowRoles([
        'Super Admin'
    ]);
}

function memberManageAccess()
{
    allowRoles([
        'Super Admin',
        'Admin'
    ]);
}

function financeOnly()
{
    allowRoles([
        'Super Admin',
        'Admin',
        'Accountant'
    ]);
}

function imamAccess()
{
    allowRoles([
        'Super Admin',
        'Admin',
        'Imam'
    ]);
}

function memberViewAccess()
{
    allowRoles([
        'Super Admin',
        'Admin',
        'Accountant',
        'Imam',
        'Viewer'
    ]);
}