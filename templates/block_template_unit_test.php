<?php
/**
 * @author Nathaniel Rogers <nathaniel.s.rogers+dev@gmail.com>
 */

namespace ${NAMESPACE} ;

/**
 * Class ${CLASS}
 * @package ${NAMESPACE}
 */
class ${CLASS} extends \PHPUnit\Framework\TestCase {
    /**
     * @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager
     */
    private ${DS}objectManager;

    /**
     * @var ${BLOCK_CLASS}
     */
    private ${DS}_block;

    private ${DS}_template = '${MODULE}::${TEMPLATE_PATH}';

    private ${DS}moduleName = '${MODULE}';

    /**
     * Do basic setup stuff
     */
    protected function setUp(): void {
        ${DS}this->objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager(${DS}this);

        /** Block Rendering Stuff */
        ${DS}fileResolverStub = ${DS}this->getMockBuilder(\Magento\Framework\View\Element\Template\File\Resolver::class)->disableOriginalConstructor()->getMock();
        ${DS}fileResolverStub->expects(${DS}this->any())->method('getTemplateFileName')->willReturn(${DS}this->getTemplateFilename());

        ${DS}readerStub = ${DS}this->getMockBuilder(\Magento\Framework\Filesystem\Directory\Read::class)->disableOriginalConstructor()->getMock();
        ${DS}readerStub->expects(${DS}this->any())->method('getRelativePath')->willReturn('phpunit');

        ${DS}filesystemStub = ${DS}this->getMockBuilder(\Magento\Framework\Filesystem::class)->disableOriginalConstructor()->getMock();
        ${DS}filesystemStub->expects(${DS}this->any())->method('getDirectoryRead')->willReturn(${DS}readerStub);

        ${DS}eventManagerStub = ${DS}this->createPartialMock(\Magento\Framework\Event\Manager::class, ['dispatch']);
        ${DS}eventManagerStub->expects(${DS}this->any())->method('dispatch')->willReturnSelf();

        ${DS}configStub = ${DS}this->getMockBuilder(\Magento\Framework\App\Config::class)->disableOriginalConstructor()->getMock();
        ${DS}configStub->expects(${DS}this->any())->method('getValue')->willReturn('');

        ${DS}appStateStub = ${DS}this->getMockBuilder(\Magento\Framework\App\State::class)->disableOriginalConstructor()->getMock();
        ${DS}appStateStub->expects(${DS}this->any())->method('getAreaCode')->willReturn(1);

        ${DS}validatorStub = ${DS}this->getMockBuilder(\Magento\Framework\View\Element\Template\File\Validator::class)->disableOriginalConstructor()->getMock();
        ${DS}validatorStub->expects(${DS}this->any())->method('isValid')->willReturn(true);

        // Intentionally use actual PHP Template engine
        ${DS}phpEngine = ${DS}this->objectManager->getObject(\Magento\Framework\View\TemplateEngine\Php::class);

        ${DS}enginePoolStub = ${DS}this->getMockBuilder(\Magento\Framework\View\TemplateEnginePool::class)->disableOriginalConstructor()->getMock();
        ${DS}enginePoolStub->expects(${DS}this->any())->method('get')->willReturn(${DS}phpEngine);

        ${DS}contextStub = ${DS}this->getMockBuilder(\Magento\Backend\Block\Template\Context::class)->disableOriginalConstructor()->getMock();
        ${DS}contextStub->expects(${DS}this->any())->method('getResolver')->willReturn(${DS}fileResolverStub);
        ${DS}contextStub->expects(${DS}this->any())->method('getFilesystem')->willReturn(${DS}filesystemStub);
        ${DS}contextStub->expects(${DS}this->any())->method('getEventManager')->willReturn(${DS}eventManagerStub);
        ${DS}contextStub->expects(${DS}this->any())->method('getScopeConfig')->willReturn(${DS}configStub);
        ${DS}contextStub->expects(${DS}this->any())->method('getAppState')->willReturn(${DS}appStateStub);
        ${DS}contextStub->expects(${DS}this->any())->method('getValidator')->willReturn(${DS}validatorStub);
        ${DS}contextStub->expects(${DS}this->any())->method('getEnginePool')->willReturn(${DS}enginePoolStub);
        /** Block Rendering Stuff End */

        ${DS}args = [
            'context' => ${DS}contextStub,
            // Add any block specific args here
        ];

        ${DS}this->_block = ${DS}this->objectManager->getObject(
            ${BLOCK_CLASS}::class,
            ${DS}args
        );

    }

    /**
     * @param string ${DS}area
     */
    private function getTemplateFilename(${DS}area = 'frontend') {
        /** @var \Magento\Framework\Component\ComponentRegistrar ${DS}componentRegistrar */
        ${DS}componentRegistrar = ${DS}this->objectManager->getObject(\Magento\Framework\Component\ComponentRegistrar::class);
        ${DS}modulePath = ${DS}componentRegistrar->getPath(\Magento\Framework\Component\ComponentRegistrar::MODULE, ${DS}this->moduleName);
        ${DS}templatePath = str_replace(${DS}this->moduleName.'::', '', ${DS}this->_template);
        ${DS}filePath = ${DS}modulePath . '/view/'.${DS}area.'/templates/' . ${DS}templatePath;
        return ${DS}filePath;
    }

    /**
     * Test to html
     */
    public function testToHtml() {
        ${DS}this->_block->setTemplate(${DS}this->_template);
        ${DS}this->assertEquals($END$, ${DS}this->_block->toHtml(), 'block testing output failed');
    }

}
