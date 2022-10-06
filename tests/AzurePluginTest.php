<?php declare(strict_types=1);

use Composer\Composer;
use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\Script\ScriptEvents;
use MarvinCaspar\Composer\AzurePlugin;
use MarvinCaspar\Composer\CommandExecutor;
use PHPUnit\Framework\TestCase;

final class AzurePluginTest extends TestCase
{
    protected AzurePlugin $azurePlugin;
    protected CommandExecutor $commandExecutor;
    protected IOInterface $ioMock;
    protected Composer $composerWithAzureRepos;
    protected Composer $composerWithoutAzureRepos;
    protected string $cacheDir;
    protected string $azureCacheDir;

    public function setUp(): void
    {
        $this->commandExecutor = $this->createMock(CommandExecutor::class);
        $this->commandExecutor->method('executeShellCmd')
            ->willReturn((object)['Version' => '*']);

        $this->azurePlugin = new AzurePlugin();
        $this->azurePlugin->commandExecutor = $this->commandExecutor;

        $this->ioMock = $this->getMockBuilder(IOInterface::class)->getMock();
        $factory = new Factory();
        $this->composerWithAzureRepos = $factory->createComposer($this->ioMock, implode(DIRECTORY_SEPARATOR, ['./tests', 'composer-with-azure-repo.json']));
        $this->composerWithoutAzureRepos = $factory->createComposer($this->ioMock, implode(DIRECTORY_SEPARATOR, ['./tests', 'composer-without-azure-repo.json']));

        $this->cacheDir = (string)$this->composerWithAzureRepos->getConfig()->get('cache-dir') . DIRECTORY_SEPARATOR . 'azure';
    }

    public function testGetCapabilities(): void
    {
        $this->assertEquals(
            ['Composer\Plugin\Capability\CommandProvider' => 'MarvinCaspar\Composer\CommandProvider'],
            $this->azurePlugin->getCapabilities()
        );
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertEquals(
            [
                ScriptEvents::PRE_INSTALL_CMD => [['executeInstall', 50000]],
                ScriptEvents::PRE_UPDATE_CMD => [['execute', 50000]],

                ScriptEvents::POST_INSTALL_CMD => [['modifyComposerLockPostInstall', 50000]],
                ScriptEvents::POST_UPDATE_CMD => [['modifyComposerLockPostInstall', 50000]],
            ],
            AzurePlugin::getSubscribedEvents()
        );
    }

    public function testExecuteWithoutAzureRepos()
    {
        $this->markTestSkipped('Nothing to test because of void return and no mock');

        $azurePlugin = new AzurePlugin();
        $azurePlugin->commandExecutor = $this->commandExecutor;

        $azurePlugin->activate($this->composerWithoutAzureRepos, $this->ioMock);
        $azurePlugin->execute();
        $this->assertTrue(true);
    }

    public function testExecuteWithAzureRepos()
    {
        $this->markTestSkipped('Nothing to test because of void return and no mock');

        $azurePlugin = new AzurePlugin();
        $azurePlugin->commandExecutor = $this->commandExecutor;

        $azurePlugin->activate($this->composerWithAzureRepos, $this->ioMock);
        $azurePlugin->execute();
        $this->assertTrue(true);
    }
}
