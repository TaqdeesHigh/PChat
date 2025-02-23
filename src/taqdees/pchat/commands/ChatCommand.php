<?php

declare(strict_types=1);

namespace taqdees\pchat\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use taqdees\pchat\Main;
use taqdees\pchat\forms\ChatSettingsForm;

class ChatCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;
    private Main $plugin;
    
    public function __construct(Main $plugin) {
        parent::__construct("chat", "Open chat settings", "/chat", ["c"]);
        $this->setPermission("pchat.command.chat");
        $this->plugin = $plugin;
        $this->owningPlugin = $plugin;
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if(!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "This command can only be used in-game!");
            return false;
        }
        
        if(!$this->testPermission($sender)) {
            return false;
        }
        
        (new ChatSettingsForm($this->plugin))->send($sender);
        return true;
    }
}