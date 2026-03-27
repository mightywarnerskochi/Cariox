import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const projectRoot = path.resolve(__dirname, '..');
const source = path.join(projectRoot, 'node_modules', 'tinymce');
const destination = path.join(projectRoot, 'public', 'vendor', 'tinymce');

try {
    if (!fs.existsSync(source)) {
        throw new Error('tinymce package not found in node_modules. Run npm install first.');
    }

    fs.mkdirSync(path.dirname(destination), { recursive: true });
    fs.cpSync(source, destination, { recursive: true, force: true });
    console.log('TinyMCE copied to public/vendor/tinymce');
} catch (error) {
    console.warn(`[tinymce:copy] ${error.message}`);
}
