<?php

function admin_flash_set(string $message, string $type = 'success'): void
{
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function admin_flash_get(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function admin_redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

/** Marca el link de nav activo comparando contra el script actual. */
function admin_nav_active(string ...$files): string
{
    $current = basename($_SERVER['SCRIPT_NAME']);
    return in_array($current, $files, true) ? ' admin-nav__link--active' : '';
}
