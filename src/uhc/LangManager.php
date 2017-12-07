<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/6/2017
 * Time: 6:23 PM
 */

namespace uhc;


use pocketmine\utils\Config;

class LangManager
{
    //TODO: More languages

    const DEFAULT_LANG = "eng";
    const LANGS_FOLDER = "lang";

    const START_GAME = "start.game";
    const STOP_GAME = "stop.game";
    const END_GAME = "end.game";
    const DEATH = "died";
    const JOIN_GAME = "join.game";
    const QUIT_GAME = "quit.game";

    private $default = self::DEFAULT_LANG;
    private $plugin;

    private static $langs = [];

    /**
     * LangManager constructor.
     * @param UHC $plugin
     */
    public function __construct(UHC $plugin)
    {
        $this->setPlugin($plugin);
        if(!is_dir($plugin->getDataFolder() . self::LANGS_FOLDER)){
            @mkdir($plugin->getDataFolder() . self::LANGS_FOLDER);
        }
        $this->registerDefaultLanguage();
    }

    public function registerDefaultLanguage()
    {
        $messages = [
            self::START_GAME => "{prefix} the game has started!",
            self::STOP_GAME => "{prefix} the game has stopped!",
            self::END_GAME => "{prefix} the game has ended!",
            self::DEATH => "{prefix} {death} died.",
            self::JOIN_GAME => "{prefix} {joined} has joined the game!",
            self::QUIT_GAME => "{prefix} {left} has left the game!"
        ];
        $config = new Config($this->getPlugin()->getDataFolder() . self::LANGS_FOLDER . DIRECTORY_SEPARATOR . self::DEFAULT_LANG . ".yml", Config::YAML, $messages);
        self::$langs["eng"] = $config->getAll(true);
    }

    /**
     * @param string $message
     * @param string $lang
     * @return string
     */
    public static function translate(string $message, string $lang)
    {
        if(isset(self::$langs[$lang][$message])){
            return self::$langs[$lang][$message];
        }
        return $message;
    }

    /**
     * @return string
     */
    public function getDefault() : string
    {
        return $this->default;
    }

    /**
     * @param string $default
     */
    public function setDefault(string $default)
    {
        $this->default = $default;
    }

    /**
     * @return UHC
     */
    public function getPlugin() : UHC
    {
        return $this->plugin;
    }

    /**
     * @param UHC $plugin
     */
    public function setPlugin(UHC $plugin)
    {
        $this->plugin = $plugin;
    }
}