<?php

namespace Composer\Poseidon2;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface
{
#    private $installer;

    public function activate(Composer $composer, IOInterface $io): void
    {
        echo "akrivate \n";
        //$this->installer = new Installer($io, $composer);
        //$composer->getInstallationManager()->addInstaller($this->installer);
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
        echo "deactivate\n";
        #$composer->getInstallationManager()->removeInstaller($this->installer);
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
        echo "uninstall\n";
    }
}

