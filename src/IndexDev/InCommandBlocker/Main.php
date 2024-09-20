<?php

namespace InCommandBlocker;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\utils\TextFormat;
use MultiWordl\MultiWorld;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        if (!$this->getServer()->getPluginManager()->getPlugin("MultiWorld")) {
            $this->getLogger()->error("Multiworld no esta habilitado, desactivando el plugin");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }

        $this->saveDefaultConfig();
        $confi = $this->getConfig()->get("worlds", []);

        CommandBlocker::getInstance()->initialize($config);

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerCommandPreprocess(PlayerCommandPreprocessEvent $event): void {
        $player = $event->getPlayer();
        $worldName = $player->getWorld()->getDisplayName();
        $message = $event->getMessage();

        if (strpos($message, "/") === 0) {
            $command = explode(" ", strtolower($message))[0];

            if (CommandBlocker::getInstance()->isCommandBlocker($worldName, $command)) {
                $player->sendMessasge(TextFormat::RED . "This command is locked in this world");
                $event->cancel();
            }
        }
    }
}
