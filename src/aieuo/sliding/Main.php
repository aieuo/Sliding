<?php

namespace aieuo\sliding;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\event\player\PlayerToggleSprintEvent;
use pocketmine\math\Vector3;

class Main extends PluginBase implements Listener  {

    /** @var int[] */
    private $sprintTicks = [];
    
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
    public function onSneak(PlayerToggleSneakEvent $event) {
        $player = $event->getPlayer();
        if ($event->isSneaking() and $this->getServer()->getTick() - ($this->sprintTicks[$player->getName()] ?? 0) === 0) {
            $deg = $player->yaw / 180 * M_PI;
            $player->setMotion(new Vector3((-sin($deg)) * 2.5, -0.5, (cos($deg)) * 2.5));
        }
    }
    
    public function onSprint(PlayerToggleSprintEvent $event) {
        $player = $event->getPlayer();
        $this->sprintTicks[$player->getName()] = $this->getServer()->getTick();
    }
}