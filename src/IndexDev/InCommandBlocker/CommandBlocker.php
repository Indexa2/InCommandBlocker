<?php

namespace InCommandBlocker;

use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

class CommandBlocker {
    use SingletonTrait;

    private array $blockedCommands;

    public function initialize(array $blockedCommands): void {
        $this->blockedCommands = $blockedCommands;
    }

    /**
     * Verifica si un comando está bloqueado en un mundo específico
     */
    public function isCommandBlocked(string $worldName, string $command): bool {
        if (isset($this->blockedCommands[$worldName])) {
            return in_array($command, $this->blockedCommands[$worldName], true);
        }
        return false;
    }
}
