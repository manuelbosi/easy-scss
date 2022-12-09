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
    loader: {
      ".ttf": "dataurl",
    },
    plugins: [
      sassPlugin(),
      cleanBuildFolder()
    ]
  })
  
  await esbuild.build({
    entryPoints: {
      'monaco/json.worker': 'node_modules/monaco-editor/esm/vs/language/json/json.worker.js',
      'monaco/css.worker': 'node_modules/monaco-editor/esm/vs/language/css/css.worker.js',
      'monaco/html.worker': 'node_modules/monaco-editor/esm/vs/language/html/html.worker.js',
      'monaco/ts.worker': 'node_modules/monaco-editor/esm/vs/language/typescript/ts.worker.js',
      'monaco/editor.worker': 'node_modules/monaco-editor/esm/vs/editor/editor.worker.js',
    },
    outdir: './dist/admin',
    bundle: true,
    sourcemap: true,
    minify: true,
    color: true,
  })
  
})()
