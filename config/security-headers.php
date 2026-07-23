<?php
/**
 * Content-Security-Policy con nonce por request. Va en PHP (no en
 * .htaccess) porque el nonce cambia en cada respuesta y debe coincidir
 * con los atributos nonce="" de los <style>/<script> inline permitidos
 * (ver components/head.php, sections/contact/form.php).
 *
 * @return string El nonce generado, para usar en las etiquetas inline.
 */
function send_security_headers(bool $isHttps, bool $isAdmin = false): string
{
    $nonce = base64_encode(random_bytes(16));

    // El admin no carga Google Fonts (usa las tipografías del sistema vía
    // admin.css), así que no necesita esos orígenes en su CSP.
    $googleFontsStyle = $isAdmin ? '' : ' https://fonts.googleapis.com';
    $googleFontsFont   = $isAdmin ? '' : ' https://fonts.gstatic.com';

    $directives = [
        "default-src 'self'",
        "script-src 'self' 'nonce-{$nonce}'",
        "style-src 'self' 'nonce-{$nonce}'{$googleFontsStyle}",
        "font-src 'self'{$googleFontsFont}",
        "img-src 'self' data:",
        "connect-src 'self'" . ($isAdmin ? '' : ' https://api.web3forms.com'),
        "frame-src " . ($isAdmin ? "'none'" : 'https://www.google.com'),
        "object-src 'none'",
        "base-uri 'self'",
        "form-action 'self'" . ($isAdmin ? '' : ' https://api.web3forms.com'),
        "frame-ancestors 'self'",
    ];

    // upgrade-insecure-requests solo tiene sentido detrás de TLS real;
    // en desarrollo local (http://localhost) rompería la carga de subrecursos.
    if ($isHttps) {
        $directives[] = 'upgrade-insecure-requests';
    }

    header('Content-Security-Policy: ' . implode('; ', $directives));

    return $nonce;
}
