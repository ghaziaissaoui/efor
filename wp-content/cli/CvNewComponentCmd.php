<?php

/**
 * @property string $themePath
 */
class CvNewComponentCmd
{
    protected $bar;
    private string $componentsPath;

    public function __construct()
    {
        $this->themePath = dirname(get_template_directory());
        $this->componentsPath = $this->themePath . '/app/Components';
        $this->cptStub = WP_CONTENT_DIR . '/cli/stubs/StubComponent';
        $this->frontCssGenerated = $this->themePath . '/front/_generated-indexes/_for-app-components.scss';
        $this->frontJsGenerated = $this->themePath . '/front/_generated-indexes/for-app-components.js';
    }

    public function __invoke()
    {
        fwrite(STDOUT, 'Nom du componsant: ');
        $name_response = strtolower(trim(fgets(STDIN)));
        $componentName = $this->dashesToCamelCase($name_response, true, ' ') . 'Component';
        $newFolder = $this->componentsPath . '/' . $componentName;
        if (is_dir($newFolder)) {
            WP_CLI::error('Components folder name already exist');
        }

        fwrite(STDOUT, 'Avez vous besoin de créer des champs ACF? [y/n] : ');
        $acf_response = strtolower(trim(fgets(STDIN)));
        fwrite(STDOUT, 'Voulez vous générer les fichier SCSS et JS ? [y/n] : ');
        $type_response = strtolower(trim(fgets(STDIN)));
        $this->generateComponent($name_response, $acf_response, $type_response);
    }

    private function dashesToCamelCase($string, $capitalizeFirstCharacter = false, $delimiter = '-')
    {
        $str = str_replace($delimiter, '', ucwords($string, $delimiter));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }

    private function generateComponent($name_response, $acf_response, $type_response): void
    {
        $componentName = $this->dashesToCamelCase($name_response, true, ' ') . 'Component';
        $componentNameTolower = strtolower($componentName);
        $componentNameDashed = strtolower(str_replace(' ', '-', $name_response)) . '-component';
        if (is_dir($this->componentsPath)) {
            $newFolder = $this->componentsPath . '/' . $componentName;

            if (!mkdir($concurrentDirectory = $newFolder, 0755) && !is_dir($concurrentDirectory)) {
                WP_CLI::error('Front files was not created');
            } else {
                if ($acf_response === 'y' && $type_response === 'y') {
                    // Generate  component w/ ACF and front files
                    $this->generateFiles($newFolder, $componentName, $componentNameDashed, ['%ComponentName%-noacf.php.stub']);
                    if (file_exists($this->frontCssGenerated) && file_exists($this->frontJsGenerated)) {
                        file_put_contents($this->frontCssGenerated, "@use '../../app/Components/$componentName/_style.scss' as app-$componentNameTolower;". "\n", FILE_APPEND);
                        file_put_contents($this->frontJsGenerated, "import '../../app/Components/$componentName/script.js';" . "\n", FILE_APPEND);
                    }
                } elseif ($acf_response === 'y' && $type_response === 'n') {
                    // Generate component w/ ACF and w| front files
                    $this->generateFiles($newFolder, $componentName, $componentNameDashed, ['%ComponentName%-noacf.php.stub', '_style.scss.stub', 'script.js.stub']);
                } elseif ($acf_response === 'n' && $type_response === 'y') {
                    // Generate component w| ACF and w/ front files
                    $this->generateFiles($newFolder, $componentName, $componentNameDashed, ['%ComponentName%.php.stub']);
                    if (file_exists($this->frontCssGenerated) && file_exists($this->frontJsGenerated)) {
                        file_put_contents($this->frontCssGenerated, "@use '../../app/Components/$componentName/_style.scss' as app-$componentNameTolower;". "\n", FILE_APPEND);
                        file_put_contents($this->frontJsGenerated, "import '../../app/Components/$componentName/script.js';" . "\n", FILE_APPEND);
                    }
                } else {
                    $this->generateFiles($newFolder, $componentName, $componentNameDashed, ['%ComponentName%.php.stub', '_style.scss.stub', 'script.js.stub']);
                }

                WP_CLI::log(WP_CLI::colorize("%gSuccess: Component succesfully created \n"));
                WP_CLI::log(WP_CLI::colorize("%rWarning: N\'oubliez pas de relancer les commandes yarn build && yarn dev \n"));
                WP_CLI::log(WP_CLI::colorize("%yVotre nouveau component sera automatiquement intégré aux indexes SCSS et JS générés à la compilation (dans front/_generated-indexes).

Si vous ne voulez intégrer que le SCSS aux indexes générés,
créez un fichier nommé 'only-include-scss-in-generated-index' dans le dossier du composant.
Vous devrez inclure manuellement le JS (avec 'import').

Si vous ne voulez intégrer que le JS aux indexes générés,
créez un fichier nommé 'only-include-js-in-generated-index' dans le dossier du composant.
Vous devez inclure manuellement le SCSS (avec '@use').

Si vous ne voulez pas intégrér du tout votre composant aux indexes générés,
créez un fichier nommé 'do-not-include-in-generated-index' dans le dossier du composant.
Vous devrez inclure manuellement le JS (avec 'import') et le SCSS (avec '@use').
                "));
            }
        }
    }

    private function generateFiles($folder, $componentName, $componentNameDashed, $exclude = [])
    {
        foreach ($this->scanDirCustom($this->cptStub, $exclude) as $file) {
            $newPath = $folder . '/' . str_replace('%ComponentName%', $componentName, $file);

            $this->moveFile(
                $this->cptStub . '/' . $file,
                $newPath,
            );

            $this->replace_in_file(
                str_replace(array('.stub', '-noacf'), '', $newPath),
                '%ComponentName%',
                $componentName
            );

            $this->replace_in_file(
                str_replace(array('.stub', '-noacf'), '', $newPath),
                '%ComponentHumanName%',
                ltrim(preg_replace('/[A-Z]/', ' $0', $componentName))
            );

            $this->replace_in_file(
                str_replace(array('.stub', '-noacf'), '', $newPath),
                '%ComponentNameDashed%',
                $componentNameDashed
            );
        }
    }

    private function scanDirCustom($dir, $exclude = []): array
    {
        return array_values(array_diff(scandir($dir), array_merge($exclude, array('..', '.'))));
    }

    private function moveFile($currentFilePath, $newFilePath): void
    {
        $newFilePath = str_replace(array('.stub', '-noacf'), '', $newFilePath);
        copy($currentFilePath, $newFilePath);
    }

    private function replace_in_file($FilePath, $OldText, $NewText): array
    {
        $Result = array('status' => 'error', 'message' => '');
        if (file_exists($FilePath) === true) {
            if (is_writeable($FilePath)) {
                try {
                    $FileContent = file_get_contents($FilePath);
                    $FileContent = str_replace($OldText, $NewText, $FileContent);
                    if (file_put_contents($FilePath, $FileContent) > 0) {
                        $Result["status"] = 'success';
                    } else {
                        $Result["message"] = 'Error while writing file';
                    }
                } catch (Exception $e) {
                    $Result["message"] = 'Error : ' . $e;
                }
            } else {
                $Result["message"] = 'File ' . $FilePath . ' is not writable !';
            }
        } else {
            $Result["message"] = 'File ' . $FilePath . ' does not exist !';
        }
        return $Result;
    }
}

if (class_exists('WP_CLI')) {
    $instance = new CvNewComponentCmd();
    WP_CLI::add_command('component:create', $instance);
}
