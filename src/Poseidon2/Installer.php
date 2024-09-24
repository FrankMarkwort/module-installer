<?php

namespace Composer\Poseidon2;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use \InvalidArgumentException;

class Installer extends LibraryInstaller
{
    public const array SUPPORTED = ['poseidon-assets', 'poseidon-module'];
    public const string MIXED_CASE = 'ssp-mixedcase-module-name';

    public function getInstallPath(PackageInterface $package): string
    {
        return $this->getPackageBasePath($package);
    }

    protected function getPackageBasePath(PackageInterface $package)
    {
        echo $this->composer->getPackage()->getPrettyName() . " prettyName \n";
        if ($this->composer->getPackage()->getPrettyName() === 'poseidon2/poseidon') {
            $ssp_path = ".";
        } else {
            $ssp_path = $this->composer->getConfig()->get('vendor-dir') . '/poseidon2/poseidon';
        }

        echo "# ssp_path:  $ssp_path \n";
        $matches = [];


        $name = $package->getPrettyName();
        if (!preg_match('@^.*/poseidon2-(module|assets)-(cron|realtime)-(.+)$@', $name, $matches)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Unable to install module %s, package name must be on the form "VENDOR/poseidon2-(module|assets)-MODULENAME".',
                    $name,
                )
             );
        }
        if (count($matches) !== 3) {
             throw new InvalidArgumentException();
        }

        echo "# name:  $name \n";
        $moduleType = $matches[1];
        $moduleDir = $matches[2];
         #Assert::regex(
         #   $moduleDir,
         #   '@^[a-z0-9_.-]*$@',
         #   sprintf(
         #       'Unable to install module %s, module name must only contain characters from a-z, 0-9, "_", "." and "-".',
         #       $name
         #   ),
         #   InvalidArgumentException::class
        #);

        if ( ! (0 === \strpos($moduleDir, '.'))) {
            throw new InvalidArgumentException(
                sprintf(
                'Expected a value not to start with %2$s. Got: %s',
                    (string) $moduleDir,
                    '.'
                )
            );
        }
        echo "count(matches): " .count($matches) ."\n";
        echo "## matches \n";
        echo " moduleType: $moduleType \n";
        echo " moduleDir: $moduleDir \n";
        echo "## matches end\n";

        $extraData = $package->getExtra();
        var_dump($extraData);
        if (isset($extraData[self::MIXED_CASE])) {
            $mixedCaseModuleName = $extraData[self::MIXED_CASE];
            if (is_string($mixedCaseModuleName)) {
                throw new InvalidArgumentException(
                    sprintf('Unable to install module %s, "%s" must be a string.', $name, self::MIXED_CASE)
                );
            }

            if ($moduleDir === mb_strtolower($mixedCaseModuleName, 'utf-8')) {
                throw new InvalidArgumentException(
                    'Unable to install module %s, "%s" must match the package name except that it can contain uppercase letters.',
                    $name,
                    self::MIXED_CASE
                );
            }
            $moduleDir = $mixedCaseModuleName;
        }

          switch ($moduleType) {
            case 'assets':
                return $ssp_path . '/public/assets/' . $moduleDir;
            case 'module':
                return $ssp_path . '/modules/' . $moduleDir;
            default:
                throw new InvalidArgumentException(sprintf('Unsupported type: %s', $moduleType));
        }
    }

    public function supports($packageType):bool
    {
        echo "# packageType: $packageType \n";
        echo in_array($packageType, self::SUPPORTED);

        return in_array($packageType, self::SUPPORTED);
    }

}