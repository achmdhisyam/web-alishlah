<?php
function currentRole()
{
    return session()->get('akses_level');
}

function isAdmin()
{
    return currentRole() === 'Admin';
}

function isUser()
{
    return currentRole() === 'User';
}

function isSpmb()
{
    return currentRole() === 'spmb';
}

function isBerita()
{
    return currentRole() === 'berita';
}
