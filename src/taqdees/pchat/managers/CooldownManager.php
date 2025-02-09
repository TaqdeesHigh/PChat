<?php

declare(strict_types=1);

namespace taqdees\pchat\managers;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use taqdees\pchat\Main;

class CooldownManager {
    private array $cooldowns = [];
    private float $cooldownTime;
    private Config $config;
    
    public function __construct(Main $plugin) {
        $this->config = new Config($plugin->getDataFolder() . "config.yml", Config::YAML, [
            "chat-cooldown" => 2.5
        ]);
        $this->cooldownTime = (float) $this->config->get("chat-cooldown");
    }
    
    public function setCooldownTime(float $time): void {
        $this->cooldownTime = $time;
        $this->config->set("chat-cooldown", $time);
        $this->config->save();
    }
    
    public function getCooldownTime(): float {
        return $this->cooldownTime;
    }
    
    public function isOnCooldown(Player $player): bool {
        if(!isset($this->cooldowns[$player->getName()])) {
            return false;
        }
        
        return (microtime(true) - $this->cooldowns[$player->getName()]) < $this->cooldownTime;
    }
    
    public function getRemainingCooldown(Player $player): float {
        if(!$this->isOnCooldown($player)) {
            return 0.0;
        }
        
        return round($this->cooldownTime - (microtime(true) - $this->cooldowns[$player->getName()]), 1);
    }
    
    public function setCooldown(Player $player): void {
        $this->cooldowns[$player->getName()] = microtime(true);
    }
}