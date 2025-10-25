import { resolve } from 'path';

export default {
  root: 'assets',
  build: {
    outDir: '../dist',
    manifest: true,
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'assets/js/main.js'),
        style: resolve(__dirname, 'assets/css/style.css')
      }
    }
  },
  server: {
    watch: {
      usePolling: true
    }
  }
};
