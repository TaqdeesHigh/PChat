<?php

declare(strict_types=1);

namespace taqdees\pchat\events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use taqdees\pchat\Main;

class ChatEventHandler implements Listener {
    private Main $plugin;
    
    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
    
    public function onChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();

        if($this->plugin->getCooldownManager()->isOnCooldown($player)) {
            $remaining = $this->plugin->getCooldownManager()->getRemainingCooldown($player);
            $player->sendMessage(TextFormat::RED . "Please wait " . $remaining . " seconds before chatting again!");
            $event->cancel();
            return;
        }
        
        $message = $event->getMessage();
        $channel = $this->plugin->getChannelManager()->getPlayerChannel($player);
        $color = $this->plugin->getColorManager()->getPlayerColor($player);
        
        $event->cancel();
        
        $this->handleChat($player, $message, $channel, $color);

        $this->plugin->getCooldownManager()->setCooldown($player);
    }
    
    private function handleChat(Player $player, string $message, string $channel, string $color): void {
        $prefix = "";
        $recipients = $this->plugin->getServer()->getOnlinePlayers();
        
        switch($channel) {
            case "Ranked Chat":
                if(!$player->hasPermission("pchat.channel.ranked")) {
                    $player->sendMessage(TextFormat::RED . "You don't have permission to use Ranked Chat!");
                    return;
                }
                $prefix = TextFormat::GOLD . "[Ranked] ";
                $recipients = array_filter($recipients, fn($p) => $p->hasPermission("pchat.channel.ranked.view"));
                break;
                
            case "Staff Chat":
                if(!$player->hasPermission("pchat.channel.staff")) {
                    $player->sendMessage(TextFormat::RED . "You don't have permission to use Staff Chat!");
                    return;
                }
                $prefix = TextFormat::RED . "[Staff] ";
                $recipients = array_filter($recipients, fn($p) => $p->hasPermission("pchat.channel.staff.view"));
                break;
        }
        
        $chatMessage = $prefix . TextFormat::GRAY . $player->getName() . " " . 
                      TextFormat::DARK_GRAY . "»" . TextFormat::WHITE . " " . $color . $message;
        
        foreach($recipients as $recipient) {
            $recipient->sendMessage($chatMessage);
        }
    }
}