const { rmSync } = require('fs');
const { resolve } = require('path');
const { defineConfig } = require('vite');
const esLintPlugin = require('vite-plugin-eslint').default;
const styleLintPlugin = require('vite-plugin-stylelint').default;
const generateIndexPlugin = require('./front/config/generate-index-plugin').default;

export default defineConfig(({ command, mode }) => {
  console.log(`Compilation command: '${command}', mode: '${mode}'`);

  const config = {
    root: resolve(__dirname, 'front/'),
    build: {
      outDir: '../dist', // Relative to root
      assetsDir: '', // Relative to outDir
      manifest: true,
      emptyOutDir: true
    },
    plugins: [
      esLintPlugin({
        include: ['front/**/*.js', 'front/**/*.jsx', 'front/**/*.ts', 'front/**/*.tsx', 'front/**/*.vue']
      }),
      styleLintPlugin(),
      generateIndexPlugin(resolve(__dirname))
    ],
    server: {
      port: 3500
    }
  };

  if(mode === 'development') {
    config.build.sourcemap = true;

    if(command === 'build') {
      config.build.minify = false;
    }
  }

  if(command === 'serve') {
    rmSync(resolve(__dirname, 'dist'), { force: true, recursive: true });
  }

  return config;
});
