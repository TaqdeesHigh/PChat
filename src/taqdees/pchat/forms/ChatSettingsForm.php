<?php

declare(strict_types=1);

namespace taqdees\pchat\forms;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use taqdees\pchat\Main;
use taqdees\pchat\lib\jojoe77777\FormAPI\CustomForm;

class ChatSettingsForm {
    private Main $plugin;
    
    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
    
    public function send(Player $player): void {
        $availableColors = $this->plugin->getColorManager()->getAvailableColors($player);

        $availableChannels = ["Global Chat"]; // Everyone can see Global Chat

        if($player->hasPermission("pchat.channel.ranked.view")) {
            $availableChannels[] = "Ranked Chat";
        }

        if($player->hasPermission("pchat.channel.staff.view")) {
            $availableChannels[] = "Staff Chat";
        }
        
        if(empty($availableColors["names"])) {
            $player->sendMessage(TextFormat::RED . "You don't have permission to use any chat colors!");
            return;
        }
        
        $form = new CustomForm(function(Player $player, ?array $data) use ($availableColors, $availableChannels) {
            if($data === null) return;
            
            if(isset($data[0])) {
                $selectedChannel = $availableChannels[$data[0]];
                $this->plugin->getChannelManager()->setPlayerChannel($player, $selectedChannel);
                $player->sendMessage(TextFormat::GREEN . "Your chat channel has been set to " . $selectedChannel . "!");
            }
            
            if(isset($data[1])) {
                $colorCode = $availableColors["codes"][$data[1]];
                $this->plugin->getColorManager()->setPlayerColor($player, $colorCode);
                $player->sendMessage(TextFormat::GREEN . "Your chat color has been set!");
            }
        });
        
        $form->setTitle("Chat Settings");

        $currentChannel = $this->plugin->getChannelManager()->getPlayerChannel($player);
        $channelIndex = array_search($currentChannel, $availableChannels);
        $form->addDropdown("Chat Channel", $availableChannels, $channelIndex !== false ? $channelIndex : 0);

        $currentColor = $this->plugin->getColorManager()->getPlayerColor($player);
        $colorIndex = array_search($currentColor, $availableColors["codes"]);
        $form->addDropdown("Chat Color", $availableColors["names"], $colorIndex !== false ? $colorIndex : 0);
        
        $player->sendForm($form);
    }
}