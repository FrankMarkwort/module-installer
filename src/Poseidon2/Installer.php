<?php

namespace Composer\Poseidon2;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class Installer extends LibraryInstaller
{
    public function getInstallPath(PackageInterface $package): string
    {
        return $this->getPackageBasePath($package);
    }

    protected function getPackageBasePath(PackageInterface $package)
    {
        var_dump($this->composer->getPackage());
        if ($this->composer->getPackage()->getPrettyName() === 'poseidon/poseidon') {
            $ssp_path = ".";
        } else {
            $ssp_path = $this->composer->getConfig()->get('vendor-dir') . '/poseidon/poseidon';
        }

        var_dump($ssp_path);

        $matches = [];
        $name = $package->getPrettyName();
        var_dump($name);
        if (!preg_match('@^.*/poseidon-(module|assets)-(.+)$@', $name, $matches)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Unable to install module %s, package name must be on the form "VENDOR/poseidon-(module|assets)-MODULENAME".',
                    $name,
                )
            );
        }

        var_dump($matches);

        return "Hallo";
    }

}