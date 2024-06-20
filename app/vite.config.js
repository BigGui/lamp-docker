import { defineConfig } from 'vite';

export default defineConfig({
    build: {
        manifest: true,
        outDir: 'build',
        rollupOptions: {
          input: '/js/main.js', // par exemple: 'src/main.js'
        },
    },

    
})