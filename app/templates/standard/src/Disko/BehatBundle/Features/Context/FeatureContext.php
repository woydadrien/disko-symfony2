<?php

/**
 * Context
 *
 * @author Adrien Jerphagnon <adrien.j@disko.fr>
 */

namespace Disko\BehatBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Disko\BehatBundle\Features\Context\Subcontext\DatabaseContext;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext //MinkContext if you want to test web
                  implements KernelAwareInterface
{
    /**
     * Kernel
     */
    private $kernel;

    /**
     * Parameters
     */
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        ini_set('xdebug.profiler_enable', 0);
        ini_set('xdebug.profiler_enable_trigger', 0);
        ini_set('xdebug.max_nesting_level', 100000000);

        $this->parameters = $parameters;
        //$this->useContext('database', new DatabaseContext($parameters));
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Get Kernel
     *
     * @return Kernel
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * Repository
     *
     * @param string $repo
     *
     * @return Repository
     */
    public function getRepository($repo)
    {
        return $this->kernel->getContainer()->get('doctrine')->getManager()->getRepository($repo);
    }

    /**
     * Debuging
     *
     * @param string $selector
     */
    public function debugElementCss($selector)
    {
        $elements = $this->getMainContext()->getSession()->getPage()->findAll('css', $selector);
        foreach ($elements as $element) {
            echo $element->getText();
        }die;
    }

    /**
     * Find all Text in css
     *
     * @param string $selector
     * @param string $text
     *
     * @return boolean
     */
    public function findAllText($selector, $text)
    {
        $elements = $this->getMainContext()->getSession()->getPage()->findAll('css', $selector);
        foreach ($elements as $element) {
            if ($element->getText() == $text) {
                return true;
            }
        }

        return false;
    }

    /**
     * Find one Text in css
     *
     * @param string $selector
     * @param string $text
     *
     * @return mixed
     */
    public function findOneText($selector, $text)
    {
        return $this->findAllText($selector.'*', $text);
    }

    /**
     * Get Container
     *
     * @return mixed
     */
    public function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * Entity Manager
     *
     * @return EntityManager
     */
    public function getManager()
    {
        return $this->kernel->getContainer()->get('doctrine')->getManager();
    }
}
