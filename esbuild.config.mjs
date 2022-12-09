import esbuild from 'esbuild'
import {sassPlugin} from "esbuild-sass-plugin";
import * as fs from "fs";
import path from "path";

const cleanBuildFolder = () => {
  return {
    name: 'cleanupBuildFolder',
    setup: (build) => {
      const outdir = build.initialOptions.outdir
      build.onStart(() => {
        const buildFolder = path.resolve(outdir)
        fs.rmSync(buildFolder, {recursive: true, force: true})
      })
    }
  }
}

(async () => {
  
  await esbuild.build({
    entryPoints: {
      'admin/app.js': './admin/assets/js/app.js',
      'admin/app.css': './admin/assets/scss/app.scss',
      'public/app.js': './public/assets/js/app.js',
      'public/app.css': './public/assets/scss/app.scss'
    },
    entryNames: '[dir]/app.[hash]',
    outdir: './dist',
    bundle: true,
    sourcemap: true,
    minify: true,
    plugins: [
      sassPlugin(),
      cleanBuildFolder()
    ]
  })
  
})()
