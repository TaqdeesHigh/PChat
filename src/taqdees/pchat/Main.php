<?php

declare(strict_types=1);

namespace taqdees\pchat;

use pocketmine\plugin\PluginBase;
use taqdees\pchat\commands\ChatCommand;
use taqdees\pchat\commands\PChat;
use taqdees\pchat\events\ChatEventHandler;
use taqdees\pchat\managers\ColorManager;
use taqdees\pchat\managers\ChannelManager;
use taqdees\pchat\managers\CoolDownManager;

class Main extends PluginBase {
    private static Main $instance;
    private ColorManager $colorManager;
    private ChannelManager $channelManager;
    private CooldownManager $cooldownManager;
    
    public function onEnable(): void {
        self::$instance = $this;
        
        @mkdir($this->getDataFolder());
        
        $this->colorManager = new ColorManager($this);
        $this->channelManager = new ChannelManager();
        $this->cooldownManager = new CooldownManager($this);
        
        $this->getServer()->getCommandMap()->register("pchat", new ChatCommand($this));
        $this->getServer()->getCommandMap()->register("pchat", new PChat($this));
        $this->getServer()->getPluginManager()->registerEvents(new ChatEventHandler($this), $this);
    }
    
    public function getCooldownManager(): CooldownManager {
        return $this->cooldownManager;
    }
    
    public function onDisable(): void {
        $this->colorManager->saveAll();
    }
    
    public static function getInstance(): Main {
        return self::$instance;
    }
    
    public function getColorManager(): ColorManager {
        return $this->colorManager;
    }
    
    public function getChannelManager(): ChannelManager {
        return $this->channelManager;
    }
}