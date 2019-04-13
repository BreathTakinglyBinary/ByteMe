<?php

declare(strict_types=1);

namespace BreathTakinglyBinary\ByteMe;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\level\ChunkLoadEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerEditBookEvent;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\plugin\PluginBase;
use pocketmine\tile\Sign;
use pocketmine\utils\TextFormat;

class ByteMe extends PluginBase implements Listener{

    /** @var bool */
    private $banViolators = true;

    /** @var bool */
    private $checkBookUpdates = true;

    /** @var int */
    private $maxCharacterLimit;

    /** @var bool */
    private $removeSigns = true;

    public function onEnable() : void{
        $this->banViolators = $this->getConfig()->get("ban-violators", true);
        $this->maxCharacterLimit = $this->getConfig()->get("max-character-limit", 1000);
        $this->removeSigns = $this->getConfig()->get("remove-bad-signs", true);
        $this->checkBookUpdates = $this->getConfig()->get("check-book-updates", true);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onChunkLoad(ChunkLoadEvent $event){
        $chunk = $event->getChunk();
        foreach($chunk->getTiles() as $tile){
            if($tile instanceof Sign){
                $text = "";
                foreach($tile->getText() as $entry){
                    $text .= (string) $entry;
                }
                if($this->isTextInvalid($text)){

                    if($this->removeSigns){
                        $this->removeSign($tile->getLevel(), $tile);
                    } else {
                        $this->getLogger()->info("Clearing sign text at location x:" . $tile->x . " Y: " . $tile->y . " Z: " . $tile->z);
                        $tile->setText("","","","");
                    }
                    $this->getLogger()->info("Sign text was: $text");
                }
            }
        }
    }

    /**
     * @param SignChangeEvent $event
     *
     * @throws \InvalidArgumentException
     *
     * @priority LOWEST
     */
    public function onSignUpdate(SignChangeEvent $event){
        $text = "";
        foreach($event->getLines() as $line){
            $text .= (string) $line;
        }
        if($this->isTextInvalid($text)){
            if($this->banViolators){
                $this->getLogger()->info(TextFormat::BOLD . TextFormat::LIGHT_PURPLE . "Banning " . $event->getPlayer()->getName() . " for creating a bad sign.");
                $this->getLogger()->info("Sign text was: $text");
                $event->getPlayer()->setBanned(true);
            }
            $event->setCancelled();
            if($this->removeSigns){
                $this->removeSign($event->getBlock()->getLevel(), $event->getBlock());
            } else {
                $event->setLines(["","","",""]);
            }
        }
    }

    /**
     * @param PlayerEditBookEvent $event
     *
     * @priority LOWEST
     */
    public function onBookUpdate(PlayerEditBookEvent $event){
        if(!$this->checkBookUpdates){
            return;
        }
        foreach($event->getNewBook()->getPages() as $page) {
            $text = $page->getString("text", "");
            if($this->isTextInvalid($text)){
                $event->setCancelled();
                if($this->banViolators){
                    $this->getLogger()->info(TextFormat::BOLD . TextFormat::LIGHT_PURPLE . "Banning " . $event->getPlayer()->getName() . " for trying to create a bad book.");
                    $this->getLogger()->info("Book text was: $text");
                }
            }
        }
    }

    /**
     * Returns true if the character count exceeds $this->maxCharacterLimit or
     * if the size of the string in bytes is more than 32767.
     *
     * @param string $text
     *
     * @return bool
     */
    private function isTextInvalid(string $text): bool {
        if(mb_strlen($text) > $this->maxCharacterLimit or strlen($text) > 32767){
            return true;
        }
        return false;
    }

    /**
     * @param Level    $level
     * @param Position $position
     */
    private function removeSign(Level $level, Position $position): void{
        $this->getLogger()->info("Removing sign at location x:" . $position->x . " Y: " . $position->y . " Z: " . $position->z);
        $level->removeTile($level->getTile($position));
        $level->setBlock($position, BlockFactory::get(Block::AIR));
    }
}
