<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2014 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAvatarmuteban
 */

namespace DragonJsonServerAvatarmuteban\Event;

/**
 * Eventklasse für die Entfernung eines Avatarmutebanns
 */
class RemoveAvatarmuteban extends \Zend\EventManager\Event
{
	/**
	 * @var string
	 */
	protected $name = 'RemoveAvatarmuteban';

    /**
     * Setzt den Avatarmutebann der entfernt wird
     * @param \DragonJsonServerAvatarmuteban\Entity\Avatarmuteban $avatarmuteban
     * @return RemoveAvatarmuteban
     */
    public function setAvatarmuteban(\DragonJsonServerAvatarmuteban\Entity\Avatarmuteban $avatarmuteban)
    {
        $this->setParam('avatarmuteban', $avatarmuteban);
        return $this;
    }

    /**
     * Gibt den Avatarmutebann der entfernt wird zurück
     * @return \DragonJsonServerAvatarmuteban\Entity\Avatarmuteban
     */
    public function getAvatarmuteban()
    {
        return $this->getParam('avatarmuteban');
    }
}
