# Pizzeria Roma — Website

Wood-fired pizza restaurant website for Sudbury, Ontario. PHP puro + MySQL + JS/CSS vanilla, sin frameworks. Bilingüe (EN/FR) con panel de administración propio.

## Requisitos

- PHP 8.1 o superior, con extensiones: `pdo_mysql`, `gd`, `fileinfo`
- MySQL 5.7+ o MariaDB 10.3+
- Apache con `mod_rewrite` (producción) — o el servidor integrado de PHP (desarrollo local)

## Instalación local

1. **Clonar/copiar el proyecto** y entrar a la carpeta.

2. **Configurar variables de entorno.** Copiar `.env.example` a `.env` y completar:

   ```
   cp .env.example .env
   ```

   | Variable | Descripción |
   |---|---|
   | `DB_HOST` | Host de MySQL (ej. `127.0.0.1`) |
   | `DB_NAME` | Nombre de la base de datos |
   | `DB_USER` | Usuario de MySQL |
   | `DB_PASS` | Contraseña de MySQL |
   | `SITE_URL` | URL pública del sitio, sin barra final (usada en canonical, hreflang, sitemap, schema.org) |
   | `WEB3FORMS_ACCESS_KEY` | Access Key del formulario de contacto — ver sección Web3Forms abajo |
   | `ADMIN_SESSION_NAME` | Nombre de la cookie de sesión del admin (cualquier valor único) |

3. **Crear la base de datos e importar el esquema:**

   ```
   mysql -u root -e "CREATE DATABASE pizzeria_roma CHARACTER SET utf8mb4;"
   mysql -u root pizzeria_roma < sql/schema.sql
   ```

   `schema.sql` incluye datos de ejemplo (categorías, productos, promoción activa) para poder ver el sitio funcionando de inmediato. Reemplázalos por los datos reales desde el panel de admin.

4. **Levantar el servidor de desarrollo:**

   ```
   php -S localhost:8060 router.php
   ```

   Visitar `http://localhost:8060/en/` (o `/fr/`).

5. **Crear el usuario administrador:**

   Visitar `http://localhost:8060/admin/setup.php` una sola vez y crear el email/contraseña del dueño. Esa página se desactiva sola en cuanto existe un admin — **elimínala del servidor en producción** después de usarla (`admin/setup.php`).

6. **Iniciar sesión en el panel:** `http://localhost:8000/admin/login.php`

## Configuración de Web3Forms (formulario de contacto)

El formulario de contacto (`/contact`) envía directamente al API de [Web3Forms](https://web3forms.com) desde el navegador — no hay backend de correo propio.

1. Crear una cuenta gratuita en https://web3forms.com
2. Registrar el dominio del sitio y obtener el **Access Key**
3. Pegar ese Access Key en `.env` como `WEB3FORMS_ACCESS_KEY`

El formulario incluye protección honeypot anti-spam y validación client-side. Los estados de envío (cargando / éxito / error) están en `js/contact.js`.

## Despliegue en producción (hosting compartido tipo cPanel/Hostinger)

1. Subir todo el contenido del proyecto al `public_html/` (o la carpeta raíz del dominio).
2. Crear la base de datos MySQL en el panel del hosting e importar `sql/schema.sql`.
3. Crear `.env` en el servidor (nunca subir el `.env` real al repositorio) con las credenciales reales de producción y el `SITE_URL` con el dominio final.
4. Confirmar que `mod_rewrite` está activo — `.htaccess` maneja las rutas limpias (`/en/menu`, `/fr/about`, etc.), la redirección a HTTPS y el bloqueo de `config/`, `sql/`, `lang/`, `handlers/`, `admin/includes/`.
5. Verificar permisos de escritura en `uploads/products/` (el admin sube fotos de productos ahí).
6. Visitar `/admin/setup.php`, crear el admin, y **eliminar ese archivo** del servidor.
7. Confirmar `https://tudominio.com/sitemap.xml`, `/robots.txt` y `/llms.txt`.

## Estructura del proyecto

```
admin/              Panel de administración (productos, categorías, promociones)
assets/images/      Fotos del sitio, organizadas por página/sección
components/         Partials compartidos entre páginas (head, header, footer, scripts)
config/             Conexión a BD, carga de .env, sistema de idiomas
css/                tokens (variables) · base (reset) · utilities · animations · components · una hoja por página
handlers/           Reservado para endpoints propios si se necesitan a futuro
js/                 main.js (global) + scroll-reveal.js (IntersectionObserver) + un archivo por página
lang/               Diccionarios de traducción en.php / fr.php
pages/              Un archivo PHP por ruta pública (home, menu, about, contact, 404)
sections/           Partials específicos de cada página, en subcarpetas
sql/                schema.sql con datos de ejemplo
uploads/products/   Fotos de productos subidas desde el admin
```

Las rutas públicas siguen el patrón `/en/...` y `/fr/...`, resueltas por `.htaccess` (producción) y `router.php` (desarrollo) — ambos deben mantenerse sincronizados si se agregan páginas nuevas.

## Contenido pendiente del cliente

Antes de publicar, reemplazar estos placeholders (marcados en el código con `[PLACEHOLDER]` o comentarios `TODO`):

- **Fotos reales:** hero de home (`assets/images/home/hero-wood-oven.webp`), fotos de productos del menú, foto del dueño/equipo en About.
- **Historia real del restaurante** — `lang/en.php` y `lang/fr.php`, sección `about.intro_body` y `about.team_body`.
- **Dirección completa** — `lang/en.php`/`lang/fr.php` (`footer.address`) y `components/schema-restaurant.php` (`streetAddress`).
- **Horario confirmado** — actualmente son horarios de ejemplo en `lang/en.php`/`lang/fr.php` y `components/schema-restaurant.php`.
- **URLs reales de delivery** (Uber Eats, Skip The Dishes, DoorDash) — `sections/home/delivery.php` y `components/footer.php`.
- **URLs reales de perfiles de reseñas** (Google Business, TripAdvisor) — `sections/home/reviews.php`.

Estos datos también se pueden gestionar día a día desde el panel de admin una vez publicado: **productos, categorías y la promoción del banner** no requieren tocar código.

## SEO / GEO

- Meta tags, Open Graph, Twitter Cards y `hreflang` únicos por página e idioma (`components/head.php`).
- Schema.org: `Restaurant` en todas las páginas, `BreadcrumbList` en páginas internas, `FAQPage` en home, `Menu`/`MenuItem` generado dinámicamente desde la base de datos en `/menu`.
- `sitemap.xml` generado dinámicamente (`sitemap.php`) con las 8 URLs (4 páginas × 2 idiomas) y sus alternates.
- `robots.txt` bloquea `/admin`, `/config`, `/sql`, `/handlers`, `/lang`, `/uploads`.
- `llms.txt` con ficha estructurada del negocio para motores generativos (ChatGPT, Perplexity, etc.).
