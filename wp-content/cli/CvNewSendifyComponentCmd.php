<?php

/**
 * @property string $themePath
 */
class CvNewSendifyComponentCmd
{
    protected $bar;
    private string $componentsPath;

    public function __construct()
    {
        $this->themePath = dirname(get_template_directory());
        $this->componentsPath = $this->themePath . '/app/Sendify/Components';
        $this->cptStub = WP_CONTENT_DIR . '/cli/stubs/StubSendifyComponent';
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
        $this->generateComponent($name_response);
    }

    private function dashesToCamelCase($string, $capitalizeFirstCharacter = false, $delimiter = '-')
    {
        $str = str_replace($delimiter, '', ucwords($string, $delimiter));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }

    private function generateComponent($name_response): void
    {
        $componentName = $this->dashesToCamelCase($name_response, true, ' ') . 'Component';
        $componentNameDashed = strtolower(str_replace(' ', '-', $name_response)) . '-component';
        if (is_dir($this->componentsPath)) {
            $newFolder = $this->componentsPath . '/' . $componentName;

            if (!mkdir($concurrentDirectory = $newFolder, 0755) && !is_dir($concurrentDirectory)) {
                WP_CLI::error('Front files was not created');
            } else {
                $this->generateFiles($newFolder, $componentName, $componentNameDashed, ['%ComponentName%-noacf.php.stub']);
                WP_CLI::log(WP_CLI::colorize("%Success: Component succesfully created \n"));
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
    $instance = new CvNewSendifyComponentCmd();
    WP_CLI::add_command('component:create:sendify', $instance);
}
