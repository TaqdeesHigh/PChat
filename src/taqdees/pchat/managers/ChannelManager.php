<?php

declare(strict_types=1);

namespace taqdees\pchat\managers;

use pocketmine\player\Player;

class ChannelManager {
    private array $playerChannels = [];
    private array $channels = [
        "Global Chat",
        "Ranked Chat",
        "Staff Chat"
    ];
    
    public function getAvailableChannels(Player $player): array {
        $available = ["Global Chat"];
        
        if($player->hasPermission("pchat.channel.ranked")) {
            $available[] = "Ranked Chat";
        }
        
        if($player->hasPermission("pchat.channel.staff")) {
            $available[] = "Staff Chat";
        }
        
        return $available;
    }
    
    public function setPlayerChannel(Player $player, string $channel): void {
        if(in_array($channel, $this->channels)) {
            $this->playerChannels[$player->getName()] = $channel;
        }
    }
    
    public function getPlayerChannel(Player $player): string {
        return $this->playerChannels[$player->getName()] ?? "Global Chat";
    }
}