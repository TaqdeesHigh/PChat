<?php

declare(strict_types=1);

namespace taqdees\pchat\managers;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use taqdees\pchat\Main;

class ColorManager {
    private array $playerColors = [];
    private Config $colorData;
    private array $colorPermissions = [
        "white" => TextFormat::WHITE,
        "black" => TextFormat::BLACK,
        "darkblue" => TextFormat::DARK_BLUE,
        "darkgreen" => TextFormat::DARK_GREEN,
        "darkaqua" => TextFormat::DARK_AQUA,
        "darkred" => TextFormat::DARK_RED,
        "darkpurple" => TextFormat::DARK_PURPLE,
        "gold" => TextFormat::GOLD,
        "gray" => TextFormat::GRAY,
        "darkgray" => TextFormat::DARK_GRAY,
        "blue" => TextFormat::BLUE,
        "green" => TextFormat::GREEN,
        "aqua" => TextFormat::AQUA,
        "red" => TextFormat::RED,
        "lightpurple" => TextFormat::LIGHT_PURPLE,
        "yellow" => TextFormat::YELLOW
    ];
    
    public function __construct(Main $plugin) {
        $this->colorData = new Config($plugin->getDataFolder() . "colors.yml", Config::YAML);
        $this->playerColors = $this->colorData->getAll();
    }
    
    public function getAvailableColors(Player $player): array {
        $colors = [];
        $colorCodes = [];
        
        foreach($this->colorPermissions as $name => $code) {
            if($player->hasPermission("pchat.color." . $name)) {
                $colors[] = ucwords(str_replace([
                    "darkblue", "darkgreen", "darkaqua", "darkred", "darkpurple", "darkgray", "lightpurple"
                ], [
                    "Dark Blue", "Dark Green", "Dark Aqua", "Dark Red", "Dark Purple", "Dark Gray", "Light Purple"
                ], $name));
                $colorCodes[] = $code;
            }
        }
        
        return ["names" => $colors, "codes" => $colorCodes];
    }
    
    public function setPlayerColor(Player $player, string $color): void {
        $this->playerColors[$player->getName()] = $color;
        $this->saveAll();
    }
    
    public function getPlayerColor(Player $player): string {
        return $this->playerColors[$player->getName()] ?? TextFormat::WHITE;
    }
    
    public function saveAll(): void {
        foreach($this->playerColors as $player => $color) {
            $this->colorData->set($player, $color);
        }
        $this->colorData->save();
    }
}