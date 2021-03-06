<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2014 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAvatarmuteban
 */

namespace DragonJsonServerAvatarmuteban;

/**
 * Klasse zur Initialisierung des Moduls
 */
class Module
{
    use \DragonJsonServer\ServiceManagerTrait;
	
    /**
     * Gibt die Konfiguration des Moduls zurück
     * @return array
     */
    public function getConfig()
    {
        return require __DIR__ . '/config/module.config.php';
    }

    /**
     * Gibt die Autoloaderkonfiguration des Moduls zurück
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
    
    /**
     * Wird bei der Initialisierung des Moduls aufgerufen
     * @param \Zend\ModuleManager\ModuleManager $moduleManager
     */
    public function init(\Zend\ModuleManager\ModuleManager $moduleManager)
    {
    	$sharedManager = $moduleManager->getEventManager()->getSharedManager();
    	$sharedManager->attach('DragonJsonServerAvatarmessage\Service\Avatarmessage', 'CreateAvatarmessage', 
	    	function (\DragonJsonServerAvatarmessage\Event\CreateAvatarmessage $eventCreateAvatarmessage) {
	    		$from_avatar = $eventCreateAvatarmessage->getAvatarmessage()->getFromAvatar();
	    		if (null === $from_avatar) {
	    			return;
	    		}
	    		$serviceAvatarmuteban = $this->getServiceManager()->get('\DragonJsonServerAvatarmuteban\Service\Avatarmuteban');
	    		$avatarmuteban = $serviceAvatarmuteban->getAvatarmutebanByAvatarId($from_avatar->getAvatarId(), false);
	    		if (null === $avatarmuteban) {
	    			return;
	    		}
	    		throw new \DragonJsonServer\Exception('avatarmuteban', ['avatarmuteban' => $avatarmuteban->toArray()]);
	    	}
    	);
    	$sharedManager->attach('DragonJsonServerAvatar\Service\Avatar', 'RemoveAvatar', 
	    	function (\DragonJsonServerAvatar\Event\RemoveAvatar $eventRemoveAvatar) {
	    		$serviceAvatarmuteban = $this->getServiceManager()->get('\DragonJsonServerAvatarmuteban\Service\Avatarmuteban');
	    		$avatarmuteban = $serviceAvatarmuteban->getAvatarmutebanByAvatarId($eventRemoveAvatar->getAvatar()->getAvatarId(), false);
	    		if (null === $avatarmuteban) {
	    			return;
	    		}
	    		$serviceAvatarmuteban->removeAvatarmuteban($avatarmuteban);
	    	}
    	);
    }
}
