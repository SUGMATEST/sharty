import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    proxy: {
      '^/[a-zA-Z0-9_-]+/catalog\\.json$': {
        target: 'https://soyjak.st',
        changeOrigin: true,
        secure: false,
        xfwd: true,
      },
      '^/[a-zA-Z0-9_-]+/thread/.*\\.json$': {
        target: 'https://soyjak.st',
        changeOrigin: true,
        secure: false,
        xfwd: true,
      },
      '^/[a-zA-Z0-9_-]+/res/.*\\.json$': {
        target: 'https://soyjak.st',
        changeOrigin: true,
        secure: false,
        xfwd: true,
      },
      '^/[a-zA-Z0-9_-]+/thumb/.*': {
        target: 'https://soyjak.st',
        changeOrigin: true,
        secure: false,
        xfwd: true,
      },
      '^/[a-zA-Z0-9_-]+/src/.*': {
        target: 'https://soyjak.st',
        changeOrigin: true,
        secure: false,
        xfwd: true,
      },
      '^/js/integrity/20/integrity.*$': {
        target: 'https://soyjak.st',
        changeOrigin: true,
        secure: false,
        xfwd: true,
      },
      '^/.*\\.php': {
        target: 'https://soyjak.st',
        changeOrigin: true,
        secure: false,
        xfwd: true,
      },
      '^/static/.*': {
        target: 'https://soyjak.st',
        changeOrigin: true,
        secure: false,
        xfwd: true,
      }
    }
  }
})

