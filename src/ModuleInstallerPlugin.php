<?php

namespace Poseidon2\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

use function file_exists;
use function sprintf;

class ModuleInstallerPlugin implements PluginInterface
{
    private ModuleInstaller $installer;

    private IOInterface $io;

    public function activate(Composer $composer, IOInterface $io):void
    {
        $this->io = $io;
        $this->installer = new ModuleInstaller($io, $composer);
        var_dump($this->installer);
        $composer->getInstallationManager()->addInstaller($this->installer);
    }


    /**
     * Remove any hooks from Composer
     *
     * This will be called when a plugin is deactivated before being
     * uninstalled, but also before it gets upgraded to a new version
     * so the old one can be deactivated and the new one activated.
     *
     * @param \Composer\Composer $composer
     * @param \Composer\IO\IOInterface $io
     */
    public function deactivate(Composer $composer, IOInterface $io)
    {
        // Not implemented
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        // Not implemented
    }
}