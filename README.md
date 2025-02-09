# PChat

A feature-rich chat management plugin for PocketMine-MP servers with channels, colors, and cooldown control.

## Features
- Multiple chat channels (Global, Ranked, Staff)
- 16 customizable chat colors
- Configurable chat cooldown
- Form-based settings

## Commands
- `/chat` (alias: `/c`) - Chat settings
- `/pchat cooldown` - Cooldown settings (admin)

## Permissions
```yaml
Commands and other perms: 

  pchat.admin.cooldown:
    description: "Allows changing the chat cooldown"
    default: op

  pchat.command.chat:
    description: "Allows using the chat command"
    default: true
    
  pchat.channel.ranked:
    description: "Allows using ranked chat"
    default: false
    
  pchat.channel.staff:
    description: "Allows using staff chat"
    default: false

  pchat.channel.ranked.view:
    description: "Allows viewing ranked chat messages"
    default: false
    
  pchat.channel.staff.view:
    description: "Allows viewing staff chat messages"
    default: false

# Color Perms:

  pchat.color.white:
    description: "Allows using white color in chat"
    default: true
  pchat.color.black:
    description: "Allows using black color in chat"
    default: false
  pchat.color.darkblue:
    description: "Allows using dark blue color in chat"
    default: false
  pchat.color.darkgreen:
    description: "Allows using dark green color in chat"
    default: false
  pchat.color.darkaqua:
    description: "Allows using dark aqua color in chat"
    default: false
  pchat.color.darkred:
    description: "Allows using dark red color in chat"
    default: false
  pchat.color.darkpurple:
    description: "Allows using dark purple color in chat"
    default: false
  pchat.color.gold:
    description: "Allows using gold color in chat"
    default: false
  pchat.color.gray:
    description: "Allows using gray color in chat"
    default: false
  pchat.color.darkgray:
    description: "Allows using dark gray color in chat"
    default: false
  pchat.color.blue:
    description: "Allows using blue color in chat"
    default: false
  pchat.color.green:
    description: "Allows using green color in chat"
    default: false
  pchat.color.aqua:
    description: "Allows using aqua color in chat"
    default: false
  pchat.color.red:
    description: "Allows using red color in chat"
    default: false
  pchat.color.lightpurple:
    description: "Allows using light purple color in chat"
    default: false
  pchat.color.yellow:
    description: "Allows using yellow color in chat"
    default: false
```
## Support
If you encounter any issues or have suggestions, please create an issue.

## Library Used
FormAPI
