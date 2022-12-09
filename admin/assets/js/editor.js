import * as monaco from 'monaco-editor';

self.MonacoEnvironment = {
  getWorkerUrl: function (moduleId, label) {
    if (['css', 'scss', 'less'].includes(label)) {
      return '/wp-content/plugins/easy-scss/dist/admin/monaco/css.worker.js';
    }
    return '/wp-content/plugins/easy-scss/dist/admin/monaco/editor.worker.js';
  }
};

// Options
monaco.languages.css.scssDefaults.options.validate = true

const editorContainer = document.getElementById('editor-container')
if (editorContainer) {
  
  const editor = monaco.editor.create(editorContainer, {
    // renderLineHighlight: 'none',
    showDeprecated: true,
    showUnused: true,
    language: 'scss',
    theme: 'vs-dark',
    cursorStyle: 'line',
    fontSize: 14,
    contextmenu: false,
    formatOnPaste: true,
    formatOnType: true,
  });
  
}



