<?php

declare(strict_types=1);

namespace taqdees\pchat\forms;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use taqdees\pchat\Main;
use taqdees\pchat\lib\jojoe77777\FormAPI\CustomForm;

class CooldownSettingsForm {
    private Main $plugin;
    
    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
    
    public function send(Player $player): void {
        $form = new CustomForm(function(Player $player, ?array $data): void {
            if($data === null) return;
            
            if(isset($data[1])) {
                $cooldown = (float) $data[1];
                if($cooldown < 0) {
                    $player->sendMessage(TextFormat::RED . "Cooldown cannot be negative!");
                    return;
                }
                
                $this->plugin->getCooldownManager()->setCooldownTime($cooldown);
                $player->sendMessage(TextFormat::GREEN . "Chat cooldown has been set to " . $cooldown . " seconds!");
            }
        });
        
        $currentCooldown = $this->plugin->getCooldownManager()->getCooldownTime();
        
        $form->setTitle("Chat Cooldown Settings");
        $form->addLabel("Current cooldown: " . $currentCooldown . " seconds");
        $form->addInput("New cooldown (in seconds)", "2.5", (string)$currentCooldown);
        
        $player->sendForm($form);
    }
}