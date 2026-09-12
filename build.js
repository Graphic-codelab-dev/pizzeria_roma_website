const fs = require('fs');
const path = require('path');
const esbuild = require('esbuild');

const ROOT = __dirname;
const DIST = path.join(ROOT, 'dist');

// Carpetas y archivos de código/fuente que sí van a producción.
const INCLUDE = [
  'admin',
  'assets',
  'components',
  'config',
  'css',
  'handlers',
  'js',
  'lang',
  'pages',
  'sections',
  'index.php',
  'sitemap.php',
  'robots.txt',
  'llms.txt',
  '.htaccess',
];

// Archivos que nunca deben copiarse aunque vivan dentro de una carpeta incluida.
function skipFilter(src) {
  const base = path.basename(src);
  return base !== '.DS_Store';
}

function log(msg) {
  console.log(`[build] ${msg}`);
}

function rmDist() {
  fs.rmSync(DIST, { recursive: true, force: true });
  fs.mkdirSync(DIST, { recursive: true });
}

function copyIncluded() {
  for (const entry of INCLUDE) {
    const src = path.join(ROOT, entry);
    if (!fs.existsSync(src)) continue;
    const dest = path.join(DIST, entry);
    fs.cpSync(src, dest, { recursive: true, filter: skipFilter });
  }
}

// uploads/ se maneja aparte: solo estructura y .htaccess, nunca las fotos
// ya subidas por el admin en producción (para no pisarlas en cada deploy).
function copyUploadsSkeleton() {
  const uploadsSrc = path.join(ROOT, 'uploads');
  if (!fs.existsSync(uploadsSrc)) return;
  const uploadsDest = path.join(DIST, 'uploads');
  fs.mkdirSync(path.join(uploadsDest, 'products'), { recursive: true });

  const htaccess = path.join(uploadsSrc, '.htaccess');
  if (fs.existsSync(htaccess)) {
    fs.copyFileSync(htaccess, path.join(uploadsDest, '.htaccess'));
  }
  const gitkeep = path.join(uploadsSrc, 'products', '.gitkeep');
  if (fs.existsSync(gitkeep)) {
    fs.copyFileSync(gitkeep, path.join(uploadsDest, 'products', '.gitkeep'));
  }
}

function walk(dir, ext) {
  const out = [];
  for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
    const full = path.join(dir, entry.name);
    if (entry.isDirectory()) out.push(...walk(full, ext));
    else if (entry.name.endsWith(ext)) out.push(full);
  }
  return out;
}

function minify(dir, ext, loader) {
  const files = walk(path.join(DIST, dir), ext);
  let before = 0;
  let after = 0;
  for (const file of files) {
    const code = fs.readFileSync(file, 'utf8');
    before += Buffer.byteLength(code);
    const result = esbuild.transformSync(code, { loader, minify: true });
    after += Buffer.byteLength(result.code);
    fs.writeFileSync(file, result.code);
  }
  return { count: files.length, before, after };
}

function kb(bytes) {
  return (bytes / 1024).toFixed(1) + ' KB';
}

rmDist();
log('dist/ limpio');

copyIncluded();
copyUploadsSkeleton();
log('archivos copiados a dist/');

const css = minify('css', '.css', 'css');
log(`css: ${css.count} archivos, ${kb(css.before)} -> ${kb(css.after)}`);

const js = minify('js', '.js', 'js');
log(`js: ${js.count} archivos, ${kb(js.before)} -> ${kb(js.after)}`);

log('listo. uploads/products (fotos reales) no se incluyeron a propósito: se gestionan en el servidor via el panel de admin.');
log(`build completo en ${DIST}`);
