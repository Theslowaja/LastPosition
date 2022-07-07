<?php

namespace Theslowaja\LastPosition;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\command\{CommandSender, Command};
use pocketmine\event\Listener;
use pocketmine\event\player\{PlayerJoinEvent, PlayerQuitEvent};
use pocketmine\world\{World,Position};
use pocketmine\utils\Config;

class Loader extends PluginBase implements Listener{
 
   public function onEnable():void{
       $this->getServer()->getPluginManager()->registerEvents($this, $this);
       $this->data = new Config($this->getDataFolder() . "data.yml", Config::YAML);
   }
  
  public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
      if($cmd->getName() == "lp"){
          if($sender instanceof Player){
              $sender->teleport(new Position($this->data->get($sender->getName().".x"), $this->data->get($sender->getName().".y"), $this->data->get($sender->getName().".z"), $this->data->get($sender->getName().".world")));
              $this->data->remove($player->getName().".x");
              $this->data->remove($player->getName().".y");
              $this->data->remove($player->getName().".z");
              $this->data->remove($player->getName().".world");
          } else {
              $sender->sendMessage("You must be player!");
          }
      }
    return true;
  }
  
  public function onQuit(PlayerQuitEvent $ev){
      $player = $ev->getPlayer();
      $this->data->set($player->getName().".x", floor($player->getPosition()->x));
      $this->data->set($player->getName().".y", floor($player->getPosition()->y));
      $this->data->set($player->getName().".z", floor($player->getPosition()->z));
      $this->data->set($player->getName().".world", $player->getWorld()->getFolderName());
      $this->data->save();
  }
}
