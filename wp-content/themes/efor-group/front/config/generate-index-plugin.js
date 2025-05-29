const { existsSync, mkdirSync, rmSync, writeFileSync } = require('fs');
const { basename, dirname, relative, resolve } = require('path');
const glob = require('glob');

export default function (rootPath) {
  console.log(rootPath);

  function generate ({
    parentDir, // Required
    fileName, // Required
    filter,
    importTemplate,
    exportTemplate,
    fileTemplate,
    importLinesGlue,
    exportLinesGlue,
    generatedFile // Required
  }) {
    const parentPath = resolve(rootPath, parentDir);
    const parentName = parentDir.replace('/', '-').toLowerCase();
    const parentBasename = basename(dirname(parentDir)).toLowerCase();

    let data = glob.sync(`${parentPath}/**/${fileName}`);
    let importLines = [];
    let exportLines = [];

    if(fileTemplate === undefined) {
      fileTemplate = '%IMPORTS%\n%EXPORTS%';
    }

    if(importLinesGlue === undefined) {
      importLinesGlue = '\n';
    }

    if(exportLinesGlue === undefined) {
      exportLinesGlue = '\n';
    }

    generatedFile = insertVariables(generatedFile, { parentName, parentBasename });

    if(filter && filter.length > 0) {
      for(const func of filter) {
        data = data.filter(func);
      }
    }

    if(importTemplate) {
      importLines = data.map(entry => {
        const moduleName = entry.replace('/', '-').toLowerCase();
        const moduleBasename = basename(dirname(entry)).toLowerCase();
        const relativePath = relative(dirname(generatedFile), entry);

        return insertVariables(importTemplate, { path: relativePath, parentName, parentBasename, moduleName, moduleBasename });
      });
    }

    if(exportTemplate) {
      exportLines = data.map(entry => {
        const moduleName = entry.replace('/', '-').toLowerCase();
        const moduleBasename = basename(dirname(entry)).toLowerCase();
        const relativePath = relative(dirname(generatedFile), entry);

        return insertVariables(exportTemplate, { path: relativePath, parentName, parentBasename, moduleName, moduleBasename });
      });
    }

    if(importTemplate || exportTemplate) {
      console.log('Generating asset index:', generatedFile);
      writeFileSync(
        resolve(rootPath, generatedFile),
        fileTemplate
          .replace('%IMPORTS%', importLines.join(importLinesGlue))
          .replace('%EXPORTS%', exportLines.join(exportLinesGlue))
      );
    }
  }

  function camelCase (str) {
    const rest = str.replace(/[\W_]/g, '|')
      .split('|')
      .map(part => `${part.charAt(0).toUpperCase()}${part.slice(1)}`)
      .join('')
      .slice(1);

    return `${str.charAt(0).toLowerCase()}${rest}`;
  }

  function insertVariables (string, { path, parentName, parentBasename, moduleName, moduleBasename }) {
    if(path) {
      string = string.replace('%PATH%', path);
    }

    if(parentName) {
      string = string.replace('%PARENT_NAME%', parentName).replace('%CAMEL_PARENT_NAME%', camelCase(parentName));
    }

    if(parentBasename) {
      string = string.replace('%PARENT_BASENAME%', parentBasename).replace('%CAMEL_PARENT_BASENAME%', camelCase(parentBasename));
    }

    if(moduleName) {
      string = string.replace('%MODULE_NAME%', moduleName).replace('%CAMEL_MODULE_NAME%', camelCase(moduleName));
    }

    if(moduleBasename) {
      string = string.replace('%MODULE_BASENAME%', moduleBasename).replace('%CAMEL_MODULE_BASENAME%', camelCase(moduleBasename));
    }

    return string;
  }

  function excludeNoAutoIndexModules (entry) {
    return !existsSync(resolve(dirname(entry), 'do-not-include-in-generated-index'));
  }

  function excludeAutoIndexJsOnlyModules (entry) {
    return !existsSync(resolve(dirname(entry), 'only-include-js-in-generated-index'));
  }

  function excludeAutoIndexScssOnlyModules (entry) {
    return !existsSync(resolve(dirname(entry), 'only-include-scss-in-generated-index'));
  }

  function fileBasenameIsModuleBasename (prefix = '', suffix = '') {
    return entry => basename(entry) === `${prefix}${basename(dirname(entry))}${suffix}`;
  }

  function doYourThing () {
    const where = 'front/_generated-indexes';

    if(!existsSync(resolve(rootPath, where))) {
      mkdirSync(resolve(rootPath, where));
    }

    const scssImportTemplate = '@use \'%PATH%\' as %PARENT_BASENAME%-%MODULE_BASENAME%;';
    const jsImportTemplate = 'import \'%PATH%\';';

    generate({
      parentDir: 'app/Components',
      fileName: '_style.scss',
      filter: [excludeNoAutoIndexModules, excludeAutoIndexJsOnlyModules],
      importTemplate: scssImportTemplate,
      generatedFile: `${where}/_for-%PARENT_NAME%.scss`
    });

    generate({
      parentDir: 'app/Components',
      fileName: 'script.js',
      filter: [excludeNoAutoIndexModules, excludeAutoIndexScssOnlyModules],
      importTemplate: jsImportTemplate,
      generatedFile: `${where}/for-%PARENT_NAME%.js`
    });

    generate({
      parentDir: 'front/components',
      fileName: '_*.scss',
      filter: [fileBasenameIsModuleBasename('_', '.scss'), excludeNoAutoIndexModules, excludeAutoIndexJsOnlyModules],
      importTemplate: scssImportTemplate,
      generatedFile: `${where}/_for-%PARENT_NAME%.scss`
    });

    generate({
      parentDir: 'front/components',
      fileName: '*.js',
      filter: [fileBasenameIsModuleBasename('', '.js'), excludeNoAutoIndexModules, excludeAutoIndexScssOnlyModules],
      importTemplate: jsImportTemplate,
      generatedFile: `${where}/for-%PARENT_NAME%.js`
    });

    generate({
      parentDir: 'front/routes',
      fileName: '_*.scss',
      filter: [fileBasenameIsModuleBasename('_', '.scss'), excludeNoAutoIndexModules, excludeAutoIndexJsOnlyModules],
      importTemplate: scssImportTemplate,
      generatedFile: `${where}/_for-%PARENT_NAME%.scss`
    });

    generate({
      parentDir: 'front/routes',
      fileName: '*.js',
      filter: [fileBasenameIsModuleBasename('', '.js'), excludeNoAutoIndexModules, excludeAutoIndexScssOnlyModules],
      importTemplate: 'import %CAMEL_MODULE_BASENAME% from \'%PATH%\';',
      exportTemplate: '%CAMEL_MODULE_BASENAME%',
      fileTemplate: '%IMPORTS%\nexport default { %EXPORTS% };',
      exportLinesGlue: ', ',
      generatedFile: `${where}/for-%PARENT_NAME%.js`
    });
  }

  return {
    name: 'generate-index-plugin',

    buildStart: () => {
      console.log('Generate asset index files (buildStart)');
      doYourThing();
    },

    configureServer: (server) => {
      server.httpServer?.once('listening',()=>{
        writeFileSync(resolve(rootPath, 'front/config/dev-server-port'), `${server.config.server.port}`);
      });
    }
  }
}
