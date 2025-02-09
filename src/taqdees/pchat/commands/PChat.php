<?php

declare(strict_types=1);

namespace taqdees\pchat\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use taqdees\pchat\Main;
use taqdees\pchat\forms\CooldownSettingsForm;

class PChat extends Command {
    private Main $plugin;
    
    public function __construct(Main $plugin) {
        parent::__construct("pchat", "PChat admin commands", "/pchat cooldown", ["pchatadmin"]);
        $this->setPermission("pchat.admin.cooldown");
        $this->plugin = $plugin;
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if(!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "This command can only be used in-game!");
            return false;
        }
        
        if(!$this->testPermission($sender)) {
            return false;
        }
        
        if(!isset($args[0]) || $args[0] !== "cooldown") {
            return false;
        }
        
        $form = new CooldownSettingsForm($this->plugin);
        $form->send($sender);
        return true;
    }
}