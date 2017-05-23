<?php
namespace jasonwynn10\murder;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\Listener;

class MurderListener implements Listener {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function onDamage(EntityDamageEvent $ev) {
		if($ev instanceof EntityDamageByEntityEvent) {
			/** @var Player $player */
			if(($player = $ev->getEntity()) instanceof Player and $this->plugin->inSession($player) != false) {
				$player->kill(); //kill the player in one hit if they are in the session and attacked by the murderer
			}
		}
	}
	public function onDeath(PlayerDeathEvent $ev) {
		if(($session = $this->plugin->inSession($event->getPlayer())) != false and $session->getRole($ev->getPlayer()) == "detective") {
			$event->setDrops([Item::get(Item::BOW), Item::get(Item::ARROW)]); // only drop bow if in session and a detective
		}elseif(($session = $this->plugin->inSession($event->getPlayer())) != false) {
			$event->setDrops([]); // no drops if in session and not a detective
		}
	}
}
