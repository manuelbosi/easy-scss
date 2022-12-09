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
      'admin/bundle': './admin/assets/index.js',
      'public/bundle': './public/assets/index.js',
    },
    entryNames: '[dir]/[name].[hash]',
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
