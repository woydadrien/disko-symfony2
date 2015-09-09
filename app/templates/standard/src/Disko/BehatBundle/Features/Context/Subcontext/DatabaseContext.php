<?php

/**
 * Context
 *
 * @author Adrien Jerphagnon <adrien.j@disko.fr>
 */

namespace Disko\BehatBundle\Features\Context\Subcontext;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Stardown\ShowcaseBundle\Entity\Comment,
    Stardown\ShowcaseBundle\Entity\Article,
    Stardown\ShowcaseBundle\Entity\Blog,
    Stardown\ShowcaseBundle\Entity\Media,
    Stardown\ShowcaseBundle\Entity\News,
    Stardown\ShowcaseBundle\Entity\Newsletter,
    Stardown\ShowcaseBundle\Entity\Tag;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\Annotations\AnnotationRegistry;
//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class DatabaseContext extends BehatContext
{
   /**
    * Build schema
    *
    * @param \Behat\Behat\Event\ScenarioEvent|\Behat\Behat\Event\OutlineExampleEvent $event
    *
    * @BeforeScenario
    *
    * @return null
    */
    public function buildSchema($event)
    {
        AnnotationRegistry::registerFile($this->getMainContext()->getKernel()->getContainer()->get('kernel')->getRootDir() . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');
        AnnotationRegistry::registerAutoloadNamespace('Gedmo\Mapping\Annotation', $this->getMainContext()->getKernel()->getContainer()->get('kernel')->getRootDir() . '/../vendor/gedmo/doctrine-extensions/lib');

        $purger = new ORMPurger($this->getMainContext()->getManager());
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);
        $executor = new ORMExecutor($this->getMainContext()->getManager(), $purger);
        $executor->execute(array());

        foreach ($this->getConnections() as $connection) {

            if ($connection->getDatabasePlatform()->getName() == 'postgres' or $connection->getDatabasePlatform()->getName() == 'postgresql') {
                $sm = $connection->getSchemaManager();
                $sequences = $sm->listSequences();

                if (count($sequences) > 0) {
                    $txt = '';
                    foreach ($sequences as $sequence) {
                        $txt .= "ALTER SEQUENCE ".$sequence->getName()." RESTART WITH 1;";
                    }
                    $connection->exec($txt);

                }

                $txt = "
                SELECT
                    pg_terminate_backend(procpid)
                FROM
                    pg_stat_activity
                WHERE
                    procpid <> pg_backend_pid()
                ;";
                $connection->exec($txt);
            } else {
                $threads = $connection->query('SHOW FULL PROCESSLIST');

                while ($thread = $threads->fetch()) {
                    if ($thread['db'] == $connection->getDatabase() && $thread['Command'] == 'Sleep') {
                        $connection->query(sprintf('KILL %d', $thread['Id']));
                    }
                }
            }

            $connection->close();
        }

    }

    /**
     * Close all
     *
     * @param \Behat\Behat\Event\ScenarioEvent|\Behat\Behat\Event\OutlineExampleEvent $event
     *
     * @AfterScenario
     *
     * @return null
     */
    public function closeAll($event)
    {
        foreach ($this->getConnections() as $connection) {
            $connection->close();
        }
    }
   /**
    * Get connections
    *
    * @return array
    */
    protected function getConnections()
    {
        return $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getConnections();
    }
}
