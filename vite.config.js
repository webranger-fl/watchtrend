import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

let config = {
  plugins: [
      laravel({
          input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/graph.js',],
          refresh: true,
      }),
  ],
  build: {
    assetsDir: '',
  }
}

//export default defineConfig();

export default defineConfig(({command, mode, ssrBuild}) => {
  if (command === 'serve') {
      config.publicDir = 'public';
      config.build = {
          assetsDir: '',
          copyPublicDir: false,
          emptyOutDir: true,
      };
  }

  return config;
});
