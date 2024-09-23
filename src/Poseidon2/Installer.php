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
        if ($this->composer->getPackage()->getPrettyName() === 'poseidon2/poseidon') {
            $ssp_path = ".";
        } else {
            $ssp_path = $this->composer->getConfig()->get('vendor-dir') . '/poseidon/poseidon';
        }

        echo "# ssp_path:  $ssp_path \n";

        $matches = [];
        $name = $package->getPrettyName();
        echo "# name:  $name \n";
        if (!preg_match('@^.*/poseidon-(module|assets)-(.+)$@', $name, $matches)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unable to install module %s, package name must be on the form "VENDOR/poseidon-(module|assets)-MODULENAME".',
                    $name,
                )
            );
        }
        echo "## matches \n";
        var_dump($matches);
        echo "## matches end\n";

        return "Hallo";
    }

}