import { resolve } from 'path';

export default ({ command, mode }) => {
  const isDev = command === 'serve' || mode === 'development';

  return {
    root: 'assets',
    base: isDev ? '/' : '/wp-content/themes/tu-tema/dist/',
    build: {
      outDir: '../dist',
      emptyOutDir: true,
      manifest: true,
      rollupOptions: {
        input: {
          main: resolve(__dirname, 'assets/js/main.js'),
          style: resolve(__dirname, 'assets/css/style.css')
        },
        output: {
          entryFileNames: isDev
            ? 'assets/js/[name].js'
            : 'assets/js/[name]-[hash].js',
          chunkFileNames: isDev
            ? 'assets/js/[name].js'
            : 'assets/js/[name]-[hash].js',
          assetFileNames: isDev
            ? 'assets/[ext]/[name].[ext]'
            : 'assets/[ext]/[name]-[hash].[ext]'
        }
      }
    },
    server: {
      watch: {
        usePolling: true
      }
    }
  };
};
